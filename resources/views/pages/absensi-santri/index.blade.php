@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <style>
                .custom-outline-input {
                    padding: 8px 12px !important;
                    border: 1px solid #d2d6da !important;
                    border-radius: 0.375rem !important;
                    height: 38px;
                }

                .custom-outline-input:focus {
                    border-color: #4CAF50 !important;
                    outline: none;
                }

                .table-attendance-wrapper {
                    border-radius: 0.5rem;
                    border: 1px solid #dee2e6;
                    overflow: hidden;
                }

                .table-absensi {
                    margin-bottom: 0;
                    white-space: nowrap;
                    border-collapse: collapse;
                }

                .table-absensi th,
                .table-absensi td {
                    vertical-align: middle;
                    text-align: center;
                    padding: 4px !important;
                    border: 1px solid #dee2e6 !important;
                    min-width: 32px;
                    height: 38px;
                    font-size: 0.85rem;
                }

                .table-absensi thead th {
                    background-color: #f8f9fa;
                    color: #344767;
                    font-weight: 600;
                }

                .sticky-no {
                    position: sticky;
                    left: 0;
                    background-color: #fff;
                    z-index: 2;
                    min-width: 40px !important;
                }

                .sticky-nama {
                    position: sticky;
                    left: 40px;
                    background-color: #fff;
                    z-index: 2;
                    min-width: 180px !important;
                    text-align: left !important;
                    box-shadow: 3px 0 5px -2px rgba(0, 0, 0, 0.1);
                }

                .table-absensi thead th.sticky-no,
                .table-absensi thead th.sticky-nama {
                    z-index: 3;
                    background-color: #f8f9fa;
                }

                .table-absensi tbody tr:hover td {
                    background-color: #f8f9fa;
                }

                .table-absensi tbody tr:hover td.sticky-no,
                .table-absensi tbody tr:hover td.sticky-nama {
                    background-color: #f8f9fa;
                }

                .bg-jumat {
                    background-color: #fff0f0 !important;
                }

                .text-jumat {
                    color: #ea0606 !important;
                }

                .icon-hadir {
                    color: #4CAF50;
                    font-size: 0.9rem;
                }

                .icon-absen {
                    color: #F44336;
                    font-size: 0.9rem;
                }

                @media print {

                    .sidenav,
                    .navbar,
                    footer,
                    .no-print,
                    .btn {
                        display: none !important;
                    }

                    html,
                    body,
                    .main-content,
                    .container-fluid,
                    #area-tabel-absensi,
                    #area-tabel-absensi .card,
                    #area-tabel-absensi .card-body,
                    .table-attendance-wrapper,
                    .table-responsive {
                        display: block !important;
                        position: static !important;
                        overflow: visible !important;
                        height: auto !important;
                        max-height: none !important;
                        margin: 0 !important;
                        padding: 0 !important;
                        background-color: #fff !important;
                    }

                    @page {
                        size: landscape;
                        margin: 10mm 15mm;
                    }

                    .card {
                        border: none !important;
                        box-shadow: none !important;
                    }

                    .card-header {
                        padding-left: 0 !important;
                    }

                    .table-attendance-wrapper {
                        border: 1.5px solid #000 !important;
                    }

                    .table-absensi {
                        border-collapse: collapse !important;
                        width: 100% !important;
                        page-break-inside: auto !important;
                    }

                    .table-absensi th,
                    .table-absensi td {
                        border: 1px solid #000 !important;
                        color: #000 !important;
                        padding: 4px !important;
                    }

                    .table-absensi tr {
                        page-break-inside: avoid !important;
                        page-break-after: auto !important;
                    }

                    .sticky-no,
                    .sticky-nama {
                        position: static !important;
                        box-shadow: none !important;
                    }

                    .bg-jumat {
                        background-color: #fff0f0 !important;
                        -webkit-print-color-adjust: exact !important;
                        print-color-adjust: exact !important;
                        color-adjust: exact !important;
                    }

                    .text-jumat {
                        color: #ea0606 !important;
                    }

                    .no-print {
                        display: none !important;
                    }

                    body.print-detail-only #area-tabel-absensi #card-rekap {
                        display: none !important;
                    }

                    body.print-rekap-only #area-tabel-absensi .card-detail {
                        display: none !important;
                    }
                }
            </style>

            <div class="card mb-4 shadow-sm no-print">
                <div class="card-header pb-2 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fa-solid fa-calendar-check text-success me-2"></i> Filter & Data Absensi Santri
                    </h6>

                    <div class="d-flex gap-2">
                        <button id="btn-cetak" class="btn btn-sm btn-dark mb-0 d-flex align-items-center gap-1">
                            <i class="fa-solid fa-print text-sm"></i> Cetak
                        </button>
                        <button id="btn-excel" class="btn btn-sm btn-success mb-0 d-flex align-items-center gap-1">
                            <i class="fa-solid fa-file-excel text-sm"></i> Excel
                        </button>
                    </div>
                </div>

                <div class="card-body py-3 p-5">
                    <div class="row g-4 align-items-start">

                        <div class="col-lg-7 border-end pe-lg-4">
                            <div class="row g-2 align-items-end">

                                <div class="col-md-12" id="col-filter-waktu">
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

                                <div class="col-md-7" id="custom-inputs-wrapper" style="display: none;">
                                    <label class="form-label text-xs font-weight-bold mb-1 text-secondary">Atur
                                        Custom:</label>
                                    <div class="d-flex align-items-center gap-2">

                                        <div id="input-daily" class="custom-filter-input" style="display: none;">
                                            <input type="date" class="form-control custom-outline-input" id="daily_date"
                                                value="{{ date('Y-m-d') }}">
                                        </div>

                                        <div id="input-weekly" class="custom-filter-input" style="display: none;">
                                            <input type="week" class="form-control custom-outline-input"
                                                id="weekly_date">
                                        </div>

                                        <div id="input-monthly" class="custom-filter-input" style="display: none;">
                                            <input type="month" class="form-control custom-outline-input"
                                                id="monthly_date" value="{{ date('Y-m') }}">
                                        </div>

                                        <div id="input-range" class="custom-filter-input" style="display: none;">
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="date" class="form-control custom-outline-input px-2"
                                                    id="range_start" value="{{ date('Y-m-01') }}">
                                                <span class="font-weight-bold">-</span>
                                                <input type="date" class="form-control custom-outline-input px-2"
                                                    id="range_end" value="{{ date('Y-m-t') }}">
                                            </div>
                                        </div>
                                        <div id="custom-tahun-ajaran" class="custom-filter-input" style="display: none;">
                                            <div class="d-flex align-items-center gap-2">
                                                <select id="ta_tahun" class="form-control custom-outline-input">
                                                    <option value="">-- Tahun Ajaran --</option>
                                                    <option value="2024/2025">2024/2025</option>
                                                    <option value="2025/2026">2025/2026</option>
                                                    <option value="2026/2027">2026/2027</option>
                                                </select>
                                                <select id="ta_semester" class="form-control custom-outline-input">
                                                    <option value="">-- Semester --</option>
                                                    <option value="Ganjil">Ganjil</option>
                                                    <option value="Genap">Genap</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success mb-0 px-3" id="btnTerapkanFilter"
                                            style="height: 38px;">
                                            Filter
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-5 ps-lg-4">
                            <label class="form-label text-xs font-weight-bold mb-2">Pilih Kelas</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($kelasList as $kelas)
                                    @php $isActive = ($kelas->id == $defaultKelasId) ? 'btn-success text-white active' : 'btn-outline-success'; @endphp
                                    <button type="button" class="btn {{ $isActive }} mb-0 btn-kelas"
                                        data-id="{{ $kelas->id }}">
                                        <span
                                            class="text-arab text-sm font-weight-bold">{{ getKelasArab($kelas->id) ?? $kelas->nama_kelas }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- AREA TABEL ABSENSI --}}
            <div id="area-tabel-absensi" class="mt-4">
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

            $('.btn-kelas').on('click', function() {
                $('.btn-kelas').removeClass('btn-success text-white active').addClass(
                    'btn-outline-success');
                $(this).removeClass('btn-outline-success').addClass('btn-success text-white active');

                let kelasId = $(this).data('id');
                let filterWaktu = $('#filterWaktu').val();

                let dataPayload = {
                    kelas_id: kelasId,
                    filter_waktu: filterWaktu,
                    daily_date: $('#daily_date').val(),
                    weekly_date: $('#weekly_date').val(),
                    monthly_date: $('#monthly_date').val(),
                    range_start: $('#range_start').val(),
                    range_end: $('#range_end').val(),
                    ta_tahun: $('#ta_tahun').val(),
                    ta_semester: $('#ta_semester').val(),
                    _token: '{{ csrf_token() }}'
                };

                $('#area-tabel-absensi').html(
                    '<div class="text-center py-5"><div class="spinner-border text-success" role="status"></div><p class="mt-2 text-sm text-secondary">Sedang memuat data absensi...</p></div>'
                );

                $.ajax({
                    url: '{{ route('absensi.ajax') }}',
                    type: 'POST',
                    data: dataPayload,
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#area-tabel-absensi').html(response.html);
                            $('[data-bs-toggle="tooltip"]').tooltip();
                        } else {
                            $('#area-tabel-absensi').html(
                                '<div class="alert alert-danger text-white">Gagal memuat data.</div>'
                            );
                        }
                    },
                    error: function(xhr) {
                        $('#area-tabel-absensi').html(
                            '<div class="alert alert-danger text-white">Terjadi kesalahan server (Error ' +
                            xhr.status + ').</div>');
                    }
                });
            });

            if ($('.btn-kelas.active').length > 0) {
                $('.btn-kelas.active').trigger('click');
            }

            $('#btnTerapkanFilter').on('click', function() {
                let kelasAktif = $('.btn-kelas.active');
                if (kelasAktif.length > 0) {
                    kelasAktif.trigger('click');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih kelas terlebih dahulu!'
                    });
                }
            });


            $('#btn-cetak').on('click', function(e) {
                e.preventDefault();

                if ($('#area-tabel-absensi').is(':empty') || $('#area-tabel-absensi').text().trim() ===
                    '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tabel absensi masih kosong! Pilih kelas terlebih dahulu.'
                    });
                    return;
                }
                $('body').addClass('print-detail-only');
                window.print();
                $('body').removeClass('print-detail-only');
            });

            $(document).on('click', '#btn-cetak-rekap', function(e) {
                e.preventDefault();

                $('body').addClass('print-rekap-only');
                window.print();
                $('body').removeClass('print-rekap-only');
            });

            $('#btn-excel').on('click', function(e) {
                e.preventDefault();

                let kelasId = $('.btn-kelas.active').data('id');
                if (!kelasId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Pilih kelas terlebih dahulu!'
                    });
                    return;
                }

                let filterWaktu = $('#filterWaktu').val() || '';
                let dailyDate = $('#daily_date').val() || '';
                let weeklyDate = $('#weekly_date').val() || '';
                let monthlyDate = $('#monthly_date').val() || '';
                let rangeStart = $('#range_start').val() || '';
                let rangeEnd = $('#range_end').val() || '';

                let url =
                    `{{ route('absensi.export_excel') }}?kelas_id=${kelasId}&filter_waktu=${filterWaktu}&daily_date=${dailyDate}&weekly_date=${weeklyDate}&monthly_date=${monthlyDate}&range_start=${rangeStart}&range_end=${rangeEnd}`;
                window.location.href = url;
            });

            $(document).on('click', '#btn-excel-rekap', function(e) {
                e.preventDefault();
                let kelasId = $('.btn-kelas.active').data('id');
                let filterWaktu = $('#filterWaktu').val() || '';
                let dailyDate = $('#daily_date').val() || '';
                let weeklyDate = $('#weekly_date').val() || '';
                let monthlyDate = $('#monthly_date').val() || '';
                let rangeStart = $('#range_start').val() || '';
                let rangeEnd = $('#range_end').val() || '';

                let url =
                    `{{ route('absensi.export_rekap') }}?kelas_id=${kelasId}&filter_waktu=${filterWaktu}&daily_date=${dailyDate}&weekly_date=${weeklyDate}&monthly_date=${monthlyDate}&range_start=${rangeStart}&range_end=${rangeEnd}`;
                window.location.href = url;
            });
        });
    </script>
@endsection
