@extends('layout.template')
@section('content')
    <style>
        .card-clickable {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-clickable:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
    <div class="content">
        <div class="container-fluid py-2">
            {{-- HEADER SUMMARY CARDS --}}
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card shadow-sm card-clickable" id="btn-filter-semua">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold text-secondary">Total Mapel
                                            Diujikan</p>
                                        <h5 class="font-weight-bolder mb-0 text-success">
                                            {{ $summary['total_mapel'] }} <span
                                                class="text-sm font-weight-normal text-secondary">Mapel</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-book-open text-lg opacity-10" aria-hidden="true"
                                            style="color: white;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card shadow-sm card-clickable" id="btn-filter-selesai">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold text-secondary">Selesai
                                            Dinilai</p>
                                        <h5 class="font-weight-bolder mb-0 text-success">
                                            {{ $summary['selesai'] }} <span
                                                class="text-sm font-weight-normal text-secondary">Mapel</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-check-double text-lg opacity-10" aria-hidden="true"
                                            style="color: white;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card shadow-sm card-clickable" id="btn-filter-belum">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold text-secondary">Belum / Draft
                                        </p>
                                        <h5 class="font-weight-bolder mb-0 text-danger">
                                            {{ $summary['belum'] }} <span
                                                class="text-sm font-weight-normal text-secondary">Mapel</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="fa-solid fa-clock-rotate-left text-lg opacity-10" aria-hidden="true"
                                            style="color: white;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FILTER FORM --}}
                <div class="col-xl-3 col-sm-6">
                    <div class="card shadow-sm">
                        <div class="card-body p-3">
                            <form action="{{ route('nilai-ujian') }}" method="GET" class="row align-items-center">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group input-group-static">
                                            <select class="form-control text-sm font-weight-bold" name="tahun_ajaran">
                                                <option value="">-- Tahun --</option>
                                                <option value="2024/2025"
                                                    {{ $tahunAjaran == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                                <option value="2025/2026"
                                                    {{ $tahunAjaran == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                                                <option value="2026/2027"
                                                    {{ $tahunAjaran == '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <div class="input-group input-group-static">
                                            <select class="form-control text-sm font-weight-bold" name="semester">
                                                <option value="">-- Smt --</option>
                                                <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                                </option>
                                                <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-2 p-0 text-end">
                                        <div id="btnSubmitFilter"
                                            class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle"
                                            style="cursor: pointer">
                                            <i class="fa-solid fa-filter text-lg opacity-10" aria-hidden="true"
                                                style="color: white;"></i>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BODY: TAB & DATA KELAS --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header pb-2 bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0 py-2"><i class="fa-solid fa-layer-group text-success me-2"></i> Monitoring
                                    Nilai Ujian</h6>

                                {{-- TABS HEADER --}}
                                <ul class="nav nav-tabs nav-tabs-arab border-bottom-0 justify-content-end" id="kelasTabs"
                                    role="tablist">
                                    @foreach ($dataKelas as $index => $kelas)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                id="tab-{{ $kelas['kelas_id'] }}" data-bs-toggle="tab"
                                                data-bs-target="#content-{{ $kelas['kelas_id'] }}" type="button"
                                                role="tab">
                                                <span
                                                    style="font-size: 1.2rem; font-family: 'Amiri', serif;">{{ getKelasArab($kelas['kelas_id']) }}</span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="tab-content mt-3 px-3" id="kelasTabsContent">
                                @foreach ($dataKelas as $index => $kelas)
                                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                        id="content-{{ $kelas['kelas_id'] }}" role="tabpanel">
                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0 table-hover">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Mata Pelajaran</th>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                            Guru Pengampu</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Progress Nilai</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Status</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($kelas['list_mapel']) > 0)
                                                        @foreach ($kelas['list_mapel'] as $mapel)
                                                            @php
                                                                $statusNilai =
                                                                    $mapel['status'] == 'Selesai' ? 'selesai' : 'belum';
                                                            @endphp
                                                            <tr class="item-mapel" data-status="{{ $statusNilai }}"">
                                                                <td>
                                                                    <div class="d-flex px-3 py-1">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center">
                                                                            <h6 class="mb-0 text-sm font-weight-bold"
                                                                                dir="rtl">{{ $mapel['nama_mapel'] }}
                                                                            </h6>
                                                                            <span
                                                                                class="text-xs text-secondary">{{ $mapel['kode_mapel'] }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">
                                                                        {{ $mapel['guru_nama'] }}</p>
                                                                </td>

                                                                <td class="align-middle text-center text-sm">
                                                                    <p class="text-sm font-weight-bold mb-0">
                                                                        {{ $mapel['jumlah_dinilai'] }} /
                                                                        {{ $mapel['total_santri'] }}
                                                                    </p>
                                                                    <span class="text-xs text-secondary">Santri
                                                                        Dinilai</span>
                                                                </td>

                                                                <td class="align-middle text-center text-sm">
                                                                    @if ($mapel['status'] == 'Selesai')
                                                                        <span class="badge badge-sm bg-success"><i
                                                                                class="fa fa-check-circle me-1"></i>
                                                                            Selesai</span>
                                                                    @elseif ($mapel['status'] == 'Draft')
                                                                        <span
                                                                            class="badge badge-sm bg-warning text-dark"><i
                                                                                class="fa fa-pencil-alt me-1"></i>
                                                                            Draft</span>
                                                                    @else
                                                                        <span class="badge badge-sm bg-danger"><i
                                                                                class="fa fa-times-circle me-1"></i>
                                                                            Belum</span>
                                                                    @endif
                                                                </td>

                                                                <td class="align-middle text-center">
                                                                    <button type="button"
                                                                        class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center rounded-circle btn-lihat-nilai"
                                                                        data-bs-toggle="tooltip" title="Lihat Nilai"
                                                                        data-kelas-id="{{ $kelas['kelas_id'] }}"
                                                                        data-mapel-id="{{ $mapel['mapel_id'] }}"
                                                                        data-mapel-nama="{{ $mapel['nama_mapel'] }}"
                                                                        style="width: 32px; height: 32px;">
                                                                        <i class="fa fa-eye" style="font-size: 12px;"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5"
                                                                class="text-center py-4 text-secondary text-sm">
                                                                Belum ada mata pelajaran yang diatur untuk kelas ini.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Nilai -->
    <div class="modal fade" id="modalLihatNilai" tabindex="-1" aria-labelledby="modalLihatNilaiLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="modalLihatNilaiLabel">
                        <i class="fa-solid fa-clipboard-list me-2"></i> Detail Nilai: <span
                            id="judulMapelModal">Loading...</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 table-hover table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                        style="width: 10%">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        style="width: 25%">NIS</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        style="width: 45%">Nama Santri</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        style="width: 20%">Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDataNilai">
                                <tr>
                                    <td colspan="4" class="text-center py-4">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#btnSubmitFilter').on('click', function() {
                $(this).closest('form').submit();
            });

            $('.btn-lihat-nilai').on('click', function() {
                let kelasId = $(this).data('kelas-id');
                let mapelId = $(this).data('mapel-id');
                let namaMapel = $(this).data('mapel-nama');
                let tahunAjaran = $('select[name="tahun_ajaran"]').val();
                let semester = $('select[name="semester"]').val();

                $('#judulMapelModal').text(namaMapel);
                $('#tbodyDataNilai').html(
                    '<tr><td colspan="4" class="text-center py-4"><i class="fa fa-spinner fa-spin text-success text-2xl"></i><br>Memuat data santri...</td></tr>'
                );
                $('#modalLihatNilai').modal('show');

                $.ajax({
                    url: "{{ route('nilai-ujian.ajax') }}",
                    type: "GET",
                    data: {
                        kelas_id: kelasId,
                        mapel_id: mapelId,
                        tahun_ajaran: tahunAjaran,
                        semester: semester
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            let html = '';
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, item) {
                                    let badgeNilai = '';
                                    if (item.nilai === null) {
                                        badgeNilai =
                                            '<span class="badge bg-danger">Belum</span>';
                                    } else {
                                        badgeNilai =
                                            '<span class="text-dark font-weight-bold text-md">' +
                                            item.nilai + '</span>';
                                    }

                                    html += '<tr>';
                                    html +=
                                        '<td class="align-middle text-center text-sm">' +
                                        (index + 1) + '</td>';
                                    html +=
                                        '<td class="align-middle text-sm"><span class="text-secondary text-xs">' +
                                        item.nis + '</span></td>';
                                    html +=
                                        '<td class="align-middle text-sm"><h6 class="mb-0 text-sm">' +
                                        item.nama + '</h6></td>';
                                    html += '<td class="align-middle text-center">' +
                                        badgeNilai + '</td>';
                                    html += '</tr>';
                                });
                            } else {
                                html =
                                    '<tr><td colspan="4" class="text-center py-4 text-secondary">Tidak ada santri di kelas ini.</td></tr>';
                            }

                            $('#tbodyDataNilai').html(html);
                        }
                    },
                    error: function(xhr) {
                        $('#tbodyDataNilai').html(
                            '<tr><td colspan="4" class="text-center py-4 text-danger">Terjadi kesalahan saat memuat data.</td></tr>'
                        );
                    }
                });
            });

            let currentFilter = 'semua';


            $('#btn-filter-semua').on('click', function() {
                if (currentFilter !== 'semua') {
                    currentFilter = 'semua';
                    $('.item-mapel').fadeIn();

                    $('#btn-filter-selesai').removeClass('border border-success border-1');
                    $('#btn-filter-belum').removeClass('border border-danger border-1');
                }
            });

            $('#btn-filter-selesai').on('click', function() {
                if (currentFilter !== 'selesai') {
                    currentFilter = 'selesai';

                    $('.item-mapel').hide();
                    $('.item-mapel[data-status="selesai"]').fadeIn();

                    $(this).addClass('border border-success border-1');
                    $('#btn-filter-semua').removeClass('border border-success border-1');
                    $('#btn-filter-belum').removeClass('border border-danger border-1');
                }
            });

            $('#btn-filter-belum').on('click', function() {
                if (currentFilter !== 'belum') {
                    currentFilter = 'belum';

                    $('.item-mapel').hide();
                    $('.item-mapel[data-status="belum"]').fadeIn();

                    $(this).addClass('border border-danger border-1');
                    $('#btn-filter-semua').removeClass('border border-success border-1');
                    $('#btn-filter-selesai').removeClass('border border-success border-2');
                }
            });
        });
    </script>
@endsection
