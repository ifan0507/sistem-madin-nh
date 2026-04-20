@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <style>
                .custom-outline-input {
                    border: 1px solid #dee2e6;
                    border-radius: 6px;
                    font-size: 0.875rem;
                    padding: 0.5rem 0.75rem;
                    color: #495057;
                    background-color: #fff;
                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                    height: 38px;
                }

                .custom-outline-input:focus {
                    border-color: #28a745;
                    outline: 0;
                    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
                }

                select.custom-outline-input optgroup {
                    font-weight: 700;
                    color: #343a40;
                }

                .form-label {
                    color: #344767;
                    letter-spacing: 0.3px;
                }

                #btnTerapkanFilter {
                    border-radius: 6px;
                    font-weight: 600;
                    text-transform: uppercase;
                    font-size: 0.75rem;
                    letter-spacing: 0.5px;
                }

                #input-range span {
                    color: #6c757d;
                }

                .table-attendance-wrapper {
                    border-radius: 0.5rem;
                    border: 1px solid #dee2e6;
                    overflow: hidden;
                }

                .table-absen-guru {
                    margin-bottom: 0;
                    white-space: nowrap;
                    border-collapse: collapse;
                }

                .table-absen-guru th,
                .table-absen-guru td {
                    vertical-align: middle;
                    text-align: center;
                    padding: 4px !important;
                    border: 1px solid #dee2e6 !important;
                    min-width: 32px;
                    height: 38px;
                    font-size: 0.85rem;
                }

                .table-absen-guru thead th {
                    background-color: #f8f9fa;
                    color: #344767;
                    font-weight: 600;
                }

                .table-absen-guru thead tr:first-child th:first-child,
                .table-absen-guru tbody tr td:first-child {
                    padding-left: 24px !important;
                    text-align: left !important;
                }
            </style>

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body p-4">
                    <form id="formFilterAbsenGuru" method="GET" action="">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-3">
                                <label class="form-label text-xs font-weight-bold mb-1">Pilih Filter Waktu</label>
                                <select id="filterWaktu" class="form-control custom-outline-input w-100">
                                    <option value="thismonth" selected>Bulan Ini</option>
                                    <optgroup label="Statik Filter">
                                        <option value="today">Hari Ini</option>
                                        <option value="yesterday">Kemarin</option>
                                        <option value="lastmonth">Bulan Lalu</option>
                                        <option value="last7days">7 Hari Terakhir</option>
                                        <option value="last30days">30 Hari Terakhir</option>
                                    </optgroup>
                                    <optgroup label="Custom Filter">
                                        <option value="daily">Per Hari</option>
                                        <option value="weekly">Per Minggu</option>
                                        <option value="monthly">Per Bulan</option>
                                        <option value="range">Rentang Tanggal</option>
                                        <option value="tahun_ajaran">Tahun Ajaran & Semester</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="col-md-3" id="custom-inputs-wrapper" style="display: none;">
                                <label class="form-label text-xs font-weight-bold mb-1 text-secondary">Atur Custom:</label>

                                <div id="input-daily" class="custom-filter-input" style="display: none;">
                                    <input type="date" class="form-control custom-outline-input" id="daily_date"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                                <div id="input-weekly" class="custom-filter-input" style="display: none;">
                                    <input type="week" class="form-control custom-outline-input" id="weekly_date">
                                </div>

                                <div id="input-monthly" class="custom-filter-input" style="display: none;">
                                    <input type="month" class="form-control custom-outline-input" id="monthly_date"
                                        value="{{ date('Y-m') }}">
                                </div>

                                <div id="input-range" class="custom-filter-input" style="display: none;">
                                    <div class="d-flex align-items-center gap-1">
                                        <input type="date" class="form-control custom-outline-input px-2"
                                            id="range_start" value="{{ date('Y-m-01') }}">
                                        <span class="font-weight-bold">-</span>
                                        <input type="date" class="form-control custom-outline-input px-2" id="range_end"
                                            value="{{ date('Y-m-t') }}">
                                    </div>
                                </div>

                                <div id="custom-tahun-ajaran" class="custom-filter-input" style="display: none;">
                                    <div class="d-flex align-items-center gap-1">
                                        <select id="ta_tahun" class="form-control custom-outline-input">
                                            <option value="">-- Tahun --</option>
                                            <option value="2024/2025">2024/2025</option>
                                            <option value="2025/2026">2025/2026</option>
                                        </select>
                                        <select id="ta_semester" class="form-control custom-outline-input">
                                            <option value="">-- Smt --</option>
                                            <option value="Ganjil">Ganjil</option>
                                            <option value="Genap">Genap</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-xs font-weight-bold mb-1">Pilih Guru <span
                                        class="text-danger">*</span></label>
                                <select name="guru_id" id="filterGuru" class="form-control select2 custom-outline-input"
                                    required>
                                    <option value="" disabled selected>-- Pilih Guru --</option>
                                    @foreach ($guruList as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->kode_guru }} - {{ $guru->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-success mb-0 px-3" id="btnTerapkanFilter"
                                    style="height: 38px;">
                                    Filter
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div id="rekapAbsensiContainer" class="mt-4">
                <div class="d-flex flex-column align-items-center justify-content-center p-4 mt-3"
                    style="border: 1px dashed #cbd5e1; border-radius: 12px; background-color: #f8fafc; min-height: 200px;">

                    <div class="mb-3 d-flex align-items-center justify-content-center"
                        style="width: 56px; height: 56px; background-color: #d1fae5; border-radius: 50%; color: #10b981;">
                        <i class="far fa-calendar-check" style="font-size: 1.5rem;"></i>
                    </div>

                    <h6 class="text-dark font-weight-bold mb-1" style="font-size: 0.95rem;">Area Rekap Masih Kosong</h6>

                    <p class="text-muted text-center mb-0" style="font-size: 0.85rem; max-width: 320px;">
                        Silahkan pilih nama guru dan rentang waktunya di atas untuk memunculkan tabel absensinya di sini.
                    </p>

                </div>
            </div>
        </div>
    </div>

    {{-- modal detail absensi --}}
    <div class="modal fade" id="modalDetailAbsen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom  bg-gradient-success">
                    <h6 class="modal-title text-white" id="detailModalTitle">Detail Absensi</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <span class="text-xs text-muted font-weight-bold text-uppercase">Mata Pelajaran</span>
                        <h6 class="mb-0" id="detailMapel">-</h6>
                    </div>
                    <div class="mb-3">
                        <span class="text-xs text-muted font-weight-bold text-uppercase">Kelas</span>
                        <h6 class="mb-0 text-arab" id="detailKelas">-</h6>
                    </div>
                    <div class="mb-3">
                        <span class="text-xs text-muted font-weight-bold text-uppercase">Tanggal Pertemuan</span>
                        <h6 class="mb-0" id="detailTanggal">-</h6>
                    </div>
                    <div class="mb-3">
                        <span class="text-xs text-muted font-weight-bold text-uppercase">Status Kehadiran</span>
                        <div><span class="badge" id="detailStatus">-</span></div>
                    </div>

                    <div id="boxMateri" class="mb-0" style="display: none;">
                        <span class="text-xs text-muted font-weight-bold text-uppercase">Materi Pembelajaran</span>
                        <p class="mb-0 text-sm p-3 bg-light rounded mt-1" id="detailMateri">-</p>
                    </div>

                    <div id="boxKetIzin" class="mb-0" style="display: none;">
                        <span class="text-xs text-muted font-weight-bold text-uppercase">Keterangan Izin</span>
                        <p class="mb-0 text-sm p-3 bg-warning-light rounded mt-1" id="detailKet">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const staticFilters = ['thismonth', 'today', 'yesterday', 'lastmonth', 'last7days', 'last30days'];

            $('#filterWaktu').on('change', function() {
                let val = $(this).val();

                if (staticFilters.includes(val)) {
                    $('#custom-inputs-wrapper').hide();

                    $('#col-filter-waktu').removeClass('col-md-5').addClass('col-md-12');

                    let kelasAktif = $('.btn-kelas.active');
                    if (kelasAktif.length > 0) {
                        kelasAktif.trigger('click');
                    }
                } else {
                    $('#col-filter-waktu').removeClass('col-md-12').addClass('col-md-5');

                    $('#custom-inputs-wrapper').fadeIn();
                    $('.custom-filter-input').hide();

                    if (val === 'daily') $('#input-daily').show();
                    if (val === 'weekly') $('#input-weekly').show();
                    if (val === 'monthly') $('#input-monthly').show();
                    if (val === 'range') $('#input-range').show();
                    if (val === 'tahun_ajaran') $('#custom-tahun-ajaran').show();
                }
            });

            $('#filterGuru').select2({
                width: '100%',
                placeholder: '-- Cari & Pilih Guru --',
            });


            $('#btnTerapkanFilter').on('click', function() {
                const guruId = $('#filterGuru').val();
                const filterWaktu = $('#filterWaktu').val();

                if (!guruId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Silahkan pilih guru terlebih dahulu.',
                        confirmButtonColor: '#d33',
                    });
                    return;
                }

                let requestData = {
                    guru_id: guruId,
                    filter_waktu: filterWaktu,
                    daily_date: $('#daily_date').val(),
                    weekly_date: $('#weekly_date').val(),
                    monthly_date: $('#monthly_date').val(),
                    range_start: $('#range_start').val(),
                    range_end: $('#range_end').val(),
                    ta_tahun: $('#ta_tahun').val(),
                    ta_semester: $('#ta_semester').val()
                };

                $('#rekapAbsensiContainer').html(`
                    <div class="d-flex justify-content-center p-5">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('absensi-guru.ajax') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: requestData,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#rekapAbsensiContainer').html(response.html);
                            $('[data-bs-toggle="tooltip"]').tooltip();
                        } else {
                            $('#rekapAbsensiContainer').html(
                                '<div class="alert alert-warning m-3 text-white">Data tidak ditemukan.</div>'
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#rekapAbsensiContainer').html(
                            '<div class="alert alert-danger m-3 text-white">Terjadi kesalahan sistem saat mengambil data.</div>'
                        );
                    }
                });
            });


            $(document).on('click', '.detail-absen-btn', function() {
                let status = $(this).data('status');
                let tanggal = $(this).data('tanggal');
                let mapel = $(this).data('mapel');
                let materi = $(this).data('materi');
                let ket = $(this).data('ket');
                let kelas = $(this).data('kelas');

                $('#detailMapel').text(mapel);
                $('#detailKelas').text(kelas);
                $('#detailTanggal').text(tanggal);

                $('#boxMateri').hide();
                $('#boxKetIzin').hide();

                if (status == 1) {
                    $('#detailStatus').text('HADIR').removeClass('bg-warning').addClass('bg-success');
                    $('#detailMateri').text(materi !== '' && materi !== 'null' ? materi :
                        'Tidak ada materi yang dicatat.');
                    $('#boxMateri').show();
                } else if (status == 2) {
                    $('#detailStatus').text('IZIN').removeClass('bg-success').addClass(
                        'bg-warning');
                    $('#detailKet').text(ket !== '' && ket !== 'null' ? ket : 'Tidak ada keterangan izin.');
                    $('#boxKetIzin').show();
                } else if (status == 4) {
                    $('#detailStatus').text('SAKIT').removeClass('bg-success').addClass(
                        'bg-warning');
                    $('#detailKet').text(ket !== '' && ket !== 'null' ? ket :
                    'Tidak ada keterangan sakit.');
                    $('#boxKetIzin').show();
                }

                $(this).tooltip('hide');

                $('#modalDetailAbsen').modal('show');
            });
        });
    </script>
@endsection
