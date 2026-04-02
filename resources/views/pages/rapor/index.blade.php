@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">

            {{-- HEADER TITLE & FILTER --}}
            <div class="row align-items-center mb-4">
                <div class="col-md-6 ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Manajemen Rapor Santri</h3>
                    <p class="text-sm text-secondary mb-0">Pilih kelas untuk membuat atau mencetak rapor.</p>
                </div>
            </div>

            {{-- LIST CARD KELAS --}}
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-4">
                    <form action="{{ route('rapor') }}" method="GET" id="form-filter" class="m-0 p-0 h-100">
                        <div class="card h-100 hover-shadow transition-all">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-sm mb-0 text-capitalize text-secondary">Filter Data / تَصْفِيَة</p>
                                        <h6 class="mb-0 text-dark font-weight-bold">Tahun & Semester</h6>
                                    </div>
                                    <div
                                        class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg align-items-center justify-content-center">
                                        <i class="fa-solid fa-filter text-white text-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <div class="d-flex gap-2">
                                    <select
                                        class="form-select form-select-sm text-sm font-weight-bold cursor-pointer border-0"
                                        name="tahun_ajaran" id="filter_tahun">
                                        <option value="2024/2025" {{ $tahunAjaran == '2024/2025' ? 'selected' : '' }}>
                                            2024/2025</option>
                                        <option value="2025/2026" {{ $tahunAjaran == '2025/2026' ? 'selected' : '' }}>
                                            2025/2026</option>
                                    </select>

                                    <select
                                        class="form-select form-select-sm text-sm font-weight-bold cursor-pointer border-0"
                                        name="semester" id="filter_semester">
                                        <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @foreach ($kelas as $k)
                    <div class="col-xl-3 col-sm-6 mb-4 cursor-pointer btn-filter-kelas" data-id="{{ $k->id }}"
                        data-nama="{{ getKelasArab($k->id) }}">
                        <div class="card h-100 hover-shadow transition-all">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-sm mb-0 text-capitalize text-secondary">Kelas / الفَصْلُ</p>
                                        <h4 class="mb-0 text-dark font-weight-bold">{{ getKelasArab($k->id) }}</h4>
                                    </div>
                                    <div
                                        class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg d-flex align-items-center justify-content-center">
                                        <span class="text-white opacity-10"
                                            style="font-family: 'Amiri', serif; font-size: 1.8rem; font-weight: bold; line-height: 1;">
                                            {{ getKelasIconArab($k->id) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm">
                                    <span class="text-success font-weight-bolder">{{ $k->santri_count }} </span> Santri /
                                    طَالِب
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CONTAINER TABEL SANTRI --}}
            <div class="row mt-4" id="santri-container" style="display: none;">
                <div class="col-12">
                    <div class="card my-4 border-0 shadow-sm">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div
                                class="bg-gradient-success shadow-success border-radius-lg pt-3 pb-3 d-flex justify-content-between align-items-center px-3">
                                <h6 class="text-white text-capitalize ps-3 mb-0">
                                    Data Santri Kelas <span id="judul-kelas-terpilih" class="font-weight-bold">...</span>
                                </h6>

                                <div class="d-flex align-items-center gap-3">
                                    <div id="container-bulk-action" style="display: none;">
                                        <button type="button" id="btn-bulk-buat"
                                            class="btn btn-sm bg-white text-success mb-0 me-2 shadow-sm">
                                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Buat Rapor Sekelas
                                        </button>

                                        <button type="button" id="btn-juara-kelas"
                                            class="btn btn-sm bg-white mb-0 shadow-sm me-2 ">
                                            <i class="fa-solid fa-trophy me-1"></i> Peringkat Kelas
                                        </button>

                                        <a href="#" id="btn-bulk-cetak" target="_blank"
                                            class="btn btn-sm bg-white mb-0 shadow-sm">
                                            <i class="fa-solid fa-print me-1"></i> Cetak Semua Rapor
                                        </a>
                                    </div>

                                    <button type="button" id="btn-close-santri" class="btn btn-link text-white mb-0 p-0"
                                        data-bs-toggle="tooltip" title="Tutup Tabel">
                                        <i class="fa-solid fa-xmark" style="font-size: 18px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0 table-hover">
                                    <thead>
                                        <tr class="align-middle">
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                                width="5%">No</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                NIS & Nama Santri</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                width="20%">Status Rapor</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                width="20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-santri-body">
                                    </tbody>
                                </table>

                                <div id="loading-santri" class="text-center p-4" style="display: none;">
                                    <div class="spinner-border text-success" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-sm text-secondary mt-2 mb-0">Memuat data santri...</p>
                                </div>

                                <p id="empty-santri" class="text-center text-sm text-secondary p-4 mb-0"
                                    style="display: none;">
                                    Tidak ada data santri di kelas ini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- MODAL PIALA --}}
    <div class="modal fade" id="modal-juara-kelas" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success p-3">
                    <h5 class="modal-title text-white m-0"><i class="fa-solid fa-trophy me-2"></i> Peringkat Kelas <span
                            id="title-modal-juara"></span></h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="10%"
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Juara</th>
                                    <th width="40%"
                                        class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama Santri</th>
                                    <th width="20%"
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Total Nilai</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-juara-body">
                            </tbody>
                        </table>
                    </div>
                    <div id="loading-juara" class="text-center py-4">
                        <div class="spinner-border text-success" role="status"></div>
                        <p class="text-sm mt-2 mb-0">Menghitung peringkat...</p>
                    </div>
                </div>
                <div class="modal-footer p-2 bg-light border-0">
                    <button type="button" class="btn btn-sm btn-secondary mb-0" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="btn-cetak-daftar-juara" target="_blank" class="btn btn-sm btn-success mb-0">
                        <i class="fa-solid fa-print me-1"></i> Cetak Daftar Juara
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#filter_tahun, #filter_semester').on('change', function() {
                $(this).closest('form').submit();
            });

            $('.btn-filter-kelas').on('click', function() {
                let kelasId = $(this).data('id');
                let namaKelas = $(this).data('nama');
                let tahunAjaran = $('#filter_tahun').val();
                let semester = $('#filter_semester').val();

                $('#judul-kelas-terpilih').text(namaKelas);
                $('#santri-container').slideDown();
                $('#tabel-santri-body').empty();
                $('#empty-santri').hide();
                $('#loading-santri').show();
                $('#container-bulk-action').hide();

                $('html, body').animate({
                    scrollTop: $("#santri-container").offset().top - 50
                }, 500);

                $.ajax({
                    url: "{{ route('rapor.getSantriKelasFromRapor') }}",
                    type: "GET",
                    data: {
                        kelas_id: kelasId,
                        tahun_ajaran: tahunAjaran,
                        semester: semester
                    },
                    success: function(res) {
                        $('#loading-santri').hide();

                        if (res.data.length > 0) {
                            let html = '';

                            let semuaSudahPunyaRapor = true;

                            $.each(res.data, function(index, santri) {

                                if (!santri.has_rapor) {
                                    semuaSudahPunyaRapor = false;
                                }

                                let badgeStatus = santri.has_rapor ?
                                    '<span class="badge bg-success"><i class="fa fa-check-circle me-1"></i> Sudah Dibuat</span>' :
                                    '<span class="badge bg-danger"><i class="fa fa-times-circle me-1"></i> Belum Dibuat</span>';

                                let urlDetail =
                                    `/rapor/kelas/${kelasId}/santri/${santri.id}?tahun_ajaran=${tahunAjaran}&semester=${semester}`;
                                let urlCetak =
                                    `/rapor/kelas/${kelasId}/santri/${santri.id}/cetak?tahun_ajaran=${tahunAjaran}&semester=${semester}`;

                                let btnAksi = santri.has_rapor ?
                                    `<a href="${urlDetail}" target="_blank"
                                        class="btn btn-outline-info btn-sm btn-icon-round d-inline-flex align-items-center justify-content-center"
                                        data-bs-toggle="tooltip" title="Lihat Rapor">
                                        <i class="fa-solid fa-eye" style="font-size: 12px;"></i></a>
                                    <a href="${urlCetak}" target="_blank"
                                        class="btn btn-outline-success btn-sm btn-icon-round d-inline-flex align-items-center justify-content-center"
                                        title="Cetak Rapor" data-bs-toggle="tooltip">
                                        <i class="fa-solid fa-print" style="font-size: 12px;"></i></a>` :
                                    `<span class="text-secondary text-sm font-weight-bold">...</span>`;

                                html += `<tr class="align-middle">
                                        <td class="text-center text-sm">${index + 1}</td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-bold">${santri.nama}</h6>
                                                <span class="text-xs text-secondary">${santri.nis}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">${badgeStatus}</td>
                                        <td class="text-center">${btnAksi}</td>
                                     </tr>`;
                            });

                            $('#tabel-santri-body').html(html);

                            let urlBulkCetak =
                                `/rapor/kelas/${kelasId}/cetak-massal?tahun_ajaran=${tahunAjaran}&semester=${semester}`;
                            $('#btn-bulk-cetak').attr('href', urlBulkCetak);

                            $('#btn-bulk-buat').data('kelas-id', kelasId);
                            $('#btn-bulk-buat').data('tahun', tahunAjaran);
                            $('#btn-bulk-buat').data('semester', semester);

                            if (semuaSudahPunyaRapor) {
                                $('#btn-bulk-buat').hide();
                                $('#btn-bulk-cetak').show();
                                $('#btn-juara-kelas').show();
                            } else {
                                $('#btn-bulk-buat').show();
                                $('#btn-bulk-cetak').hide();
                                $('#btn-juara-kelas').hide();
                            }

                            $('#container-bulk-action').fadeIn();

                        } else {
                            $('#empty-santri').show();
                        }
                    },
                    error: function() {
                        $('#loading-santri').hide();
                        $('#tabel-santri-body').html(
                            '<tr><td colspan="4" class="text-center text-danger py-3">Gagal memuat data.</td></tr>'
                        );
                    }
                });
            });

            $('#btn-close-santri').on('click', function() {
                $('#santri-container').slideUp();
            });

            $('#btn-bulk-buat').on('click', function() {
                let kelasId = $(this).data('kelas-id');
                let tahun = $(this).data('tahun');
                let semester = $(this).data('semester');

                Swal.fire({
                    title: 'Buat Rapor Sekelas?',
                    text: `Sistem akan meng-generate rapor untuk semua santri di kelas ini pada semester ${semester} tahun ${tahun}.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4caf50',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Buat Sekarang!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire({
                            title: 'Memproses...',
                            html: 'Mohon tunggu, sedang membuat data rapor...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ route('rapor.bulk-create') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                kelas_id: kelasId,
                                tahun_ajaran: tahun,
                                semester: semester
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Selesai!',
                                    text: res.message
                                }).then(() => {
                                    $(`.btn-filter-kelas[data-id="${kelasId}"]`)
                                        .trigger('click');
                                });
                            },
                            error: function(xhr) {
                                let msg = 'Gagal memproses rapor massal.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    msg = xhr.responseJSON.message;
                                }
                                Swal.fire('Error', msg, 'error');
                            }
                        });
                    }
                });
            });

            // Event Buka Modal Juara
            $('#btn-juara-kelas').on('click', function() {
                let kelasId = $('#btn-bulk-buat').data('kelas-id');
                let tahunAjaran = $('#btn-bulk-buat').data('tahun');
                let semester = $('#btn-bulk-buat').data('semester');
                let namaKelas = $('#judul-kelas-terpilih').text();

                $('#title-modal-juara').text(namaKelas);
                $('#tabel-juara-body').empty();
                $('#loading-juara').show();

                $('#btn-cetak-daftar-juara').attr('href',
                    `/rapor/kelas/${kelasId}/cetak-juara?tahun_ajaran=${tahunAjaran}&semester=${semester}`
                );

                $('#modal-juara-kelas').modal('show');

                $.ajax({
                    url: `/rapor/kelas/${kelasId}/ranking`,
                    type: "GET",
                    data: {
                        tahun_ajaran: tahunAjaran,
                        semester: semester
                    },
                    success: function(res) {
                        $('#loading-juara').hide();
                        let html = '';

                        $.each(res.data, function(index, santri) {
                            let ikonJuara = santri.peringkat;
                            html += `
                            <tr>
                                <td class="font-weight-bold text-dark">${santri.peringkat}</td>
                                <td class="text-start">
                                    <h6 class="mb-0 text-sm">${santri.nama}</h6>
                                    <span class="text-xs text-secondary">${santri.nis}</span>
                                </td>
                                <td> <h6 class="mb-0 text-sm">${santri.total_nilai}</h6></td>
                            </tr>
                        `;
                        });
                        $('#tabel-juara-body').html(html);
                    },
                    error: function(xhr) {
                        let msg = 'Gagal memproses rapor massal.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });
    </script>
@endsection
