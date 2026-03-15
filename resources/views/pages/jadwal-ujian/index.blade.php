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
                                <i class="fa-solid fa-book-open text-sm me-2 text-success"></i> Jadwal Mapel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-0 py-2 d-flex align-items-center justify-content-center font-weight-bold"
                                data-bs-toggle="tab" href="#tab-pengawas" role="tab" aria-selected="false">
                                <i class="fa-solid fa-user-tie text-sm me-2 text-success"></i> Jadwal Pengawas
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content">
                    {{-- mapel --}}
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
                                    <button class="btn btn-link  text-dark mb-0 px-0 btn-hover-outline"
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
                                                                <div class="cell-jadwal filled rounded-3 p-2 text-center h-100 d-flex flex-column justify-content-center btn-atur-mapel-ujian"
                                                                    style="cursor: pointer; min-height: 55px;"
                                                                    data-jadwal-id="{{ $jadwalCell->id }}"
                                                                    data-kelas-id="{{ $kelas->id }}"
                                                                    data-kelas-nama="{{ getKelasArab($kelas->id) }}"
                                                                    data-hari-ke="{{ $hari }}"
                                                                    data-mapel-kelas-id="{{ $jadwalCell->mapel_kelas_id }}">
                                                                    <div class="mb-0 text-wrap lh-sm">
                                                                        <span
                                                                            class="text-xs font-weight-bold text-secondary me-1">
                                                                            {{ $jadwalCell->mapel_kelas->mapel->kode_mapel }}
                                                                            -
                                                                        </span>
                                                                        <span class="text-sm font-weight-bold text-dark">
                                                                            {{ $jadwalCell->mapel_kelas->mapel->nama_mapel ?? 'Error' }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="cell-jadwal rounded-3 p-2 text-center h-100 d-flex flex-column justify-content-center btn-atur-mapel-ujian"
                                                                    style="cursor: pointer; min-height: 55px;"
                                                                    data-jadwal-id="{{ $jadwalCell ? $jadwalCell->id : '' }}"
                                                                    data-kelas-id="{{ $kelas->id }}"
                                                                    data-kelas-nama="{{ getKelasArab($kelas->id) }}"
                                                                    data-hari-ke="{{ $hari }}"
                                                                    data-mapel-kelas-id="">
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

                    {{-- pengawas --}}
                    <div class="tab-pane fade" id="tab-pengawas" role="tabpanel">

                        @foreach (range(1, 6) as $hari)
                            <div class="card mb-4 shadow-sm border border-light">

                                <div class="card-header pb-2 pt-3 bg-transparent border-bottom">
                                    <h6 class="mb-0 text-dark font-weight-bolder text-sm d-flex align-items-center">
                                        <span class="text-secondary me-2">HARI KE-{{ $hari }}</span>
                                        <span class="text-secondary font-weight-normal mx-1">|</span>
                                        <span class="ms-2 text-uppercase tanggal-display-{{ $hari }}">
                                            {{ $tanggalPerHari[$hari] ? \Carbon\Carbon::parse($tanggalPerHari[$hari])->locale('id')->isoFormat('dddd, D MMMM YYYY') : 'TANGGAL BELUM DIATUR' }}
                                        </span>
                                    </h6>
                                </div>

                                <div class="card-body px-2 py-3">
                                    <div class="table-responsive">
                                        <table class="table table-borderless align-items-center mb-0"
                                            style="table-layout: fixed; width: 100%; min-width: 800px;">
                                            <thead>
                                                <tr>
                                                    @foreach ($ruangList as $ruang)
                                                        <th
                                                            class="text-center text-uppercase text-dark text-sm font-weight-bolder w-10 p-1">
                                                            {{ $ruang->nama_ruang }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach ($ruangList as $ruang)
                                                        @php
                                                            $pengawasCell = $pengawasPerHari[$hari][$ruang->id] ?? null;
                                                        @endphp

                                                        <td class="p-1">
                                                            @if ($pengawasCell && $pengawasCell->guru_id)
                                                                <div class="cell-jadwal filled rounded-3 p-2 text-center h-100 d-flex flex-column justify-content-center btn-atur-pengawas"
                                                                    style="cursor: pointer; min-height: 55px;"
                                                                    data-pengawas-jadwal-id="{{ $pengawasCell->id }}"
                                                                    data-ruang-id="{{ $ruang->id }}"
                                                                    data-ruang-nama="{{ $ruang->nama_ruang }}"
                                                                    data-hari-ke="{{ $hari }}"
                                                                    data-pengawas-id="{{ $pengawasCell->guru_id }}">
                                                                    <div class="mb-0 text-wrap lh-sm">
                                                                        <span
                                                                            class="text-xs font-weight-bold text-secondary d-block">Ust/Ustzh.</span>
                                                                        <span class="text-sm font-weight-bold text-dark">
                                                                            {{ $pengawasCell->guru->name ?? 'Error' }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="cell-jadwal rounded-3 p-2 text-center h-100 d-flex flex-column justify-content-center btn-atur-pengawas"
                                                                    style="cursor: pointer; min-height: 55px;"
                                                                    data-pengawas-jadwal-id="{{ $pengawasCell ? $pengawasCell->id : '' }}"
                                                                    data-ruang-id="{{ $ruang->id }}"
                                                                    data-ruang-nama="{{ $ruang->nama_ruang }}"
                                                                    data-hari-ke="{{ $hari }}" data-pengawas-id="">
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

                </div>
            </div>
        </div>
    </div>

    {{-- modal set mapel ujian --}}
    <div class="modal fade" id="modal-atur-mapel-ujian" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <h6 class="modal-title font-weight-normal text-white">
                        <i class="fa-solid fa-book me-2"></i> Atur Mapel Ujian
                    </h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="form-atur-mapel-ujian">
                    @csrf
                    <input type="hidden" name="jadwal_id" id="hidden_ujian_jadwal_id">

                    <div class="modal-body">
                        <div class="alert alert-light border text-center mb-4" role="alert">
                            <span class="text-sm">Menjadwalkan Ujian untuk:</span><br>
                            <strong class="text-dark" id="info-jadwal-ujian-teks">Kelas - Hari</strong>
                        </div>

                        <div class="form-group my-3">
                            <label for="select-ujian-mapel" class="text-dark font-weight-bold d-block mb-2">Pilih Mata
                                Pelajaran</label>
                            <select class="form-control" name="mapel_kelas_id" id="select-ujian-mapel"
                                style="width: 100%;">
                                <option value="">-- Loading Data... --</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn bg-gradient-success btn-simpan-mapel-ujian">Simpan
                            Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal set pengawas ujian --}}
    <div class="modal fade" id="modal-atur-pengawas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <h6 class="modal-title font-weight-normal text-white">
                        <i class="fa-solid fa-user-tie me-2"></i> Atur Pengawas Ruang
                    </h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form id="form-atur-pengawas">
                    @csrf
                    <input type="hidden" name="jadwal_pengawas_id" id="hidden_pengawas_jadwal_id">

                    <div class="modal-body">
                        <div class="alert alert-light border text-center mb-4" role="alert">
                            <span class="text-sm">Menjadwalkan Pengawas untuk:</span><br>
                            <strong class="text-dark" id="info-pengawas-teks">Ruang - Hari</strong>
                        </div>

                        <div class="form-group my-3">
                            <label for="select-pengawas-ujian" class="text-dark font-weight-bold d-block mb-2">Pilih
                                Ustadz/Ustadzah</label>
                            <select class="form-control" name="guru_id" id="select-pengawas-ujian" style="width: 100%;">
                                <option value="">-- Loading Data... --</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn bg-gradient-success btn-simpan-pengawas">Simpan
                            Pengawas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editTanggal(hariKe) {
            Swal.fire({
                title: 'Set Tanggal Hari Ke-' + hariKe,
                input: 'date',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: '<i class="fa-solid fa-save me-1"></i> Simpan',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success ms-2',
                    cancelButton: 'btn btn-secondary',
                },
                didOpen: () => {
                    const input = Swal.getInput();
                    input.style.border = '1px solid #d2d6da';
                    input.style.borderRadius = '8px';
                    input.style.boxShadow = 'none';
                    input.style.height = '43px';
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    if (result.isConfirmed && result.value) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $.ajax({
                            url: '{{ route('jadwal-ujian.update-tanggal') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                hari_ke: hariKe,
                                tanggal: result.value
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('.tanggal-display-' + hariKe).text(result.value);
                                });
                            },
                            error: function(xhr) {
                                let message = 'Terjadi kesalahan saat menyimpan data.';

                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    message = Object.values(errors)[0][0];
                                }
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: message
                                });
                                // Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
                            }
                        });
                    }
                }
            });
        }

        $(document).ready(function() {

            $('#select-ujian-mapel').select2({
                dropdownParent: $('#modal-atur-mapel-ujian'),
                placeholder: '-- Pilih Mata Pelajaran --',
                allowClear: true,
                dropdownCssClass: "arab-dropdown",
                selectionCssClass: "arab-selection"
            });

            let kotakUjianTerpilih = null;

            $('body').on('click', '.btn-atur-mapel-ujian', function() {
                kotakUjianTerpilih = $(this);
                let jadwalId = $(this).attr('data-jadwal-id');
                let kelasId = $(this).attr('data-kelas-id');
                let kelasNama = $(this).attr('data-kelas-nama');
                let hariKe = $(this).attr('data-hari-ke');
                let mapelKelasId = $(this).attr('data-mapel-kelas-id');

                $('#info-jadwal-ujian-teks').text(`Kelas ${kelasNama} - Hari Ke-${hariKe}`);
                $('#hidden_ujian_jadwal_id').val(jadwalId);

                $('#select-ujian-mapel').html('<option value="">Mencari data mapel...</option>').prop(
                    'disabled', true);
                $('.btn-simpan-mapel-ujian').prop('disabled', false).text('Simpan Jadwal');

                $('#modal-atur-mapel-ujian').modal('show');

                $.ajax({
                    url: `/mapel-kelas/kelas/${kelasId}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let options = '<option value="">-- Kosongkan Jadwal --</option>';
                        if (data.length > 0) {
                            $.each(data, function(key, item) {
                                options +=
                                    `<option value="${item.id}">${item.mapel.kode_mapel} - ${item.mapel.nama_mapel}</option>`;
                            });
                        } else {
                            options =
                                '<option value="" disabled>Belum ada mapel di kelas ini</option>';
                        }

                        $('#select-ujian-mapel').html(options).prop('disabled', false);

                        if (mapelKelasId) {
                            $('#select-ujian-mapel').val(mapelKelasId).trigger('change');
                        }
                    },
                    error: function() {
                        $('#select-ujian-mapel').html(
                            '<option value="">Gagal memuat data</option>');
                        Swal.fire('Error', 'Gagal mengambil data mapel dari server.', 'error');
                    }
                });
            });

            $('body').on('click', '.btn-simpan-mapel-ujian', function(e) {
                e.preventDefault();

                let jadwalId = $('#hidden_ujian_jadwal_id').val();
                let mapelKelasId = $('#select-ujian-mapel').val();

                let mapelNama = $('#select-ujian-mapel option:selected').text();

                $('.btn-simpan-mapel-ujian').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                $.ajax({
                    url: "{{ route('jadwal-ujian.update-mapel') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        jadwal_id: jadwalId,
                        mapel_kelas_id: mapelKelasId ? mapelKelasId : ''
                    },
                    success: function(response) {
                        $('#modal-atur-mapel-ujian').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: 'Jadwal ujian berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        if (kotakUjianTerpilih) {
                            if (mapelKelasId) {
                                kotakUjianTerpilih.addClass('filled');
                                kotakUjianTerpilih.html(`
                                    <div class="mb-0 text-wrap lh-sm">
                                        <span class="text-xs font-weight-bold text-dark">
                                            ${mapelNama}
                                        </span>
                                    </div>
                                `);
                            } else {
                                kotakUjianTerpilih.removeClass('filled');
                                kotakUjianTerpilih.html(`
                                    <span class="text-xs font-weight-bold text-secondary mb-0">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                `);
                            }

                            kotakUjianTerpilih.attr('data-mapel-kelas-id', mapelKelasId);
                            kotakUjianTerpilih.hide().fadeIn(400);
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menyimpan data.';
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    },
                    complete: function() {
                        $('.btn-simpan-mapel-ujian').prop('disabled', false).text(
                            'Simpan Jadwal');
                    }
                });
            });


            $('#select-pengawas-ujian').select2({
                dropdownParent: $('#modal-atur-pengawas .modal-content'),
                placeholder: '-- Pilih Ustadz/Ustadzah --',
                allowClear: true,
                width: '100%'
            });

            let kotakPengawasTerpilih = null;

            $('body').on('click', '.btn-atur-pengawas', function() {
                kotakPengawasTerpilih = $(this);

                let jadwalPengawasId = $(this).attr('data-pengawas-jadwal-id');
                let ruangNama = $(this).attr('data-ruang-nama');
                let hariKe = $(this).attr('data-hari-ke');
                let pengawasId = $(this).attr('data-pengawas-id');

                $('#info-pengawas-teks').text(`Ruang ${ruangNama} - Hari Ke-${hariKe}`);
                $('#hidden_pengawas_jadwal_id').val(jadwalPengawasId);

                $('#select-pengawas-ujian').html('<option value="">Mencari data ustadz...</option>').prop(
                    'disabled', true);
                $('.btn-simpan-pengawas').prop('disabled', false).text('Simpan Pengawas');

                $('#modal-atur-pengawas').modal('show');

                $.ajax({
                    url: "{{ route('guru.getGuru') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        let options = '<option value="">-- Kosongkan Pengawas --</option>';

                        if (response.data.length > 0) {
                            $.each(response.data, function(key, item) {
                                options +=
                                    `<option value="${item.id}">${item.name}</option>`;
                            });
                        } else {
                            options =
                                '<option value="" disabled>Data Ustadz/Guru kosong</option>';
                        }

                        $('#select-pengawas-ujian').html(options).prop('disabled', false);

                        if (pengawasId) {
                            $('#select-pengawas-ujian').val(pengawasId).trigger('change');
                        }
                    },
                    error: function() {
                        $('#select-pengawas-ujian').html(
                            '<option value="">Gagal memuat data</option>');
                        Swal.fire('Error', 'Gagal mengambil data guru dari server.', 'error');
                    }
                });
            });

            $('body').on('click', '.btn-simpan-pengawas', function(e) {
                e.preventDefault();

                let jadwalPengawasId = $('#hidden_pengawas_jadwal_id').val();
                let pengawasId = $('#select-pengawas-ujian').val();
                let pengawasNama = $('#select-pengawas-ujian option:selected').text();

                $('.btn-simpan-pengawas').prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

                $.ajax({
                    url: "{{ route('jadwal-ujian.update-pengawas') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        jadwal_pengawas_id: jadwalPengawasId,
                        guru_id: pengawasId ? pengawasId : ''
                    },
                    success: function(response) {
                        $('#modal-atur-pengawas').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        if (kotakPengawasTerpilih) {
                            if (pengawasId) {
                                kotakPengawasTerpilih.addClass('filled');
                                kotakPengawasTerpilih.html(`
                                <div class="mb-0 text-wrap lh-sm">
                                    <span class="text-xs font-weight-bold text-secondary d-block">Ust/Ustzh.</span>
                                    <span class="text-sm font-weight-bold text-dark">
                                        ${pengawasNama}
                                    </span>
                                </div>
                            `);
                            } else {
                                kotakPengawasTerpilih.removeClass('filled');
                                kotakPengawasTerpilih.html(`
                                <span class="text-xs font-weight-bold text-secondary mb-0">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            `);
                            }

                            kotakPengawasTerpilih.attr('data-pengawas-id', pengawasId);
                            kotakPengawasTerpilih.hide().fadeIn(400);
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat menyimpan data.';
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message
                        });
                    },
                    complete: function() {
                        $('.btn-simpan-pengawas').prop('disabled', false).text(
                            'Simpan Pengawas');
                    }
                });
            });
        });
    </script>
@endsection
