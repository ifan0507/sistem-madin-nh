@extends('layout.template')
@section('content')
    <div class="container-fluid py-2">

        <div class="card shadow-sm border-radius-xl">

            <div class="card-header p-4">
                <h5 class="mb-0">Manajemen Jadwal Ujian</h5>
                <p class="text-sm text-muted mb-0">Atur jadwal mata pelajaran dan pengawas ujian</p>
            </div>

            <div class="card-body p-4 pt-0">

                <div class="nav-wrapper position-relative end-0 mb-4">
                    <ul class="nav nav-pills nav-fill p-1 bg-gray-100 border-radius-lg" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-2 active d-flex align-items-center justify-content-center font-weight-bold"
                                data-bs-toggle="tab" href="#tab-mapel" role="tab" aria-selected="true">
                                <i class="fa-solid fa-book-open text-sm me-2"></i> Jadwal Mapel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-2 d-flex align-items-center justify-content-center font-weight-bold"
                                data-bs-toggle="tab" href="#tab-pengawas" role="tab" aria-selected="false">
                                <i class="fa-solid fa-user-tie text-sm me-2"></i> Jadwal Pengawas
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">

                    <div class="tab-pane fade show active" id="tab-mapel" role="tabpanel">

                        @foreach (range(1, 6) as $hari)
                            <div class="card mb-4 shadow-sm border border-light">
                                <div
                                    class="card-header pb-2 pt-3 d-flex justify-content-between align-items-center bg-transparent border-bottom">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 text-dark font-weight-bolder text-sm d-flex align-items-center">
                                            <span class="text-secondary me-2">HARI KE-{{ $hari }}</span>

                                            <span class="text-secondary font-weight-normal mx-1">|</span>

                                            <span id="text-tanggal-{{ $hari }}" class="ms-2 text-uppercase">
                                                {{ $tanggalPerHari[$hari] ? \Carbon\Carbon::parse($tanggalPerHari[$hari])->isoFormat('dddd, D MMMM YYYY') : 'TANGGAL BELUM DIATUR' }}
                                            </span>
                                        </h6>
                                    </div>
                                    <button class="btn btn-link  text-dark mb-0 px-0"
                                        onclick="editTanggal({{ $hari }}, '{{ $tanggalPerHari[$hari] }}')">
                                        <i class="fa-solid fa-calendar-day me-1 text-success"></i> Set Tanggal
                                    </button>
                                </div>

                                <div class="card-body px-2 py-3">
                                    <div class="table-responsive">
                                        <table class="table table-borderless align-items-center mb-0"
                                            style="table-layout: fixed; width: 100%; min-width: 800px;">
                                            <thead>
                                                <tr>
                                                    @foreach ($kelasList as $kelas)
                                                        <th
                                                            class="text-center text-uppercase text-dark text-sm font-weight-bolder w-14 p-1">
                                                            {{ getKelasArab($kelas->id) }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($kelasList as $kelas)
                                                        @php
                                                            $jadwalCell = $jadwalPerHari[$hari][$kelas->id] ?? null;
                                                        @endphp

                                                        <td class="p-1">
                                                            @if ($jadwalCell && $jadwalCell->mapel_kelas_id)
                                                                <div class="cell-jadwal filled rounded-3 p-2 text-center h-100 d-flex flex-column justify-content-center"
                                                                    style="cursor: pointer; min-height: 55px;"
                                                                    onclick="editMapel({{ $jadwalCell->id }}, '{{ getKelasArab($kelas->id) }}', {{ $hari }})">
                                                                    <span
                                                                        class="text-xs font-weight-bold text-dark mb-0 text-wrap lh-sm">
                                                                        {{ $jadwalCell->mapel_kelas->mapel->nama_mapel ?? 'Error' }}
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <div class="cell-jadwal rounded-3 p-2 text-center h-100 d-flex flex-column justify-content-center"
                                                                    style="cursor: pointer; min-height: 55px;"
                                                                    onclick="editMapel({{ $jadwalCell ? $jadwalCell->id : 0 }}, '{{ getKelasArab($kelas->id) }}', {{ $hari }})">
                                                                    <span
                                                                        class="text-xs font-weight-bold text-secondary mb-0">
                                                                        <i class="fa-solid fa-plus"></i>
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                    <div class="tab-pane fade" id="tab-pengawas" role="tabpanel">
                        <div class="text-center py-5">
                            <i class="fa-solid fa-person-chalkboard text-muted mb-3" style="font-size: 3rem;"></i>
                            <h5 class="text-secondary">UI Jadwal Pengawas</h5>
                            <p class="text-sm text-muted">Akan kita bangun format grid-nya setelah Mapel selesai.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi simulasi klik Edit Tanggal
        function editTanggal(hariKe) {
            Swal.fire({
                title: 'Set Tanggal Hari Ke-' + hariKe,
                input: 'date',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2e7d32'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    Swal.fire('Berhasil!', 'Nanti logic AJAX update tanggal ditaruh sini.', 'success');
                }
            });
        }

        // Fungsi simulasi klik Edit Mapel
        function editMapel(namaKelas, hariKe) {
            Swal.fire({
                title: 'Pilih Mapel',
                html: '<p class="text-sm">Kelas: <b>' + namaKelas + '</b> <br> Hari Ke: <b>' + hariKe + '</b></p>',
                input: 'select',
                inputOptions: {
                    '1': 'Mabadi\'ul Fiqh',
                    '2': 'Sulam Taufiq',
                    '3': 'Fathul Qorib',
                    '4': 'Kosongkan (Hapus Mapel)'
                },
                inputPlaceholder: '-- Pilih Mapel --',
                showCancelButton: true,
                confirmButtonText: 'Simpan Mapel',
                confirmButtonColor: '#ffeb3b',
                customClass: {
                    confirmButton: 'text-dark font-weight-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Tersimpan!', 'Nanti logic AJAX update Mapel ditaruh sini.', 'success');
                }
            });
        }
    </script>
@endsection
