@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-4 h4 font-weight-bolder">Mapel Kelas</h3>
                </div>
                @foreach ($kelas as $index => $k)
                    @php
                        $textArab = $k->nama_kelas;
                        $iconArab = '0';

                        $cleanName = strtolower(trim($k->nama_kelas));

                        if ($cleanName == 'sifir' || $cleanName == '0' || $index == 0) {
                            $textArab = 'صفر';
                            $iconArab = '٠';
                        } elseif ($cleanName == '1') {
                            $textArab = 'الأول';
                            $iconArab = '١';
                        } elseif ($cleanName == '2') {
                            $textArab = 'الثاني';
                            $iconArab = '٢';
                        } elseif ($cleanName == '3') {
                            $textArab = 'الثالث';
                            $iconArab = '٣';
                        } elseif ($cleanName == '4') {
                            $textArab = 'الرابع';
                            $iconArab = '٤';
                        } elseif ($cleanName == '5') {
                            $textArab = 'الخامس';
                            $iconArab = '٥';
                        } elseif ($cleanName == '6') {
                            $textArab = 'السادس';
                            $iconArab = '٦';
                        }
                    @endphp

                    <div class="col-xl-3 col-sm-6 mb-4 cursor-pointer btn-filter-mepel-kelas" data-id="{{ $k->id }}"
                        data-nama="{{ $textArab }}">
                        <div class="card h-100">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-sm mb-0 text-capitalize text-secondary">Kelas / الفَصْلُ</p>

                                        <h4 class="mb-0 text-dark font-weight-bold"> {{ $textArab }}</h4>
                                        {{-- <p class="text-xs text-success font-weight-bold mb-0 mt-1"
                                            style="font-family: 'Amiri', serif; font-size: 1.2rem !important;">
                                          
                                        </p> --}}
                                    </div>

                                    <div
                                        class="icon icon-md icon-shape bg-gradient-success shadow-dark shadow text-center border-radius-lg d-flex align-items-center justify-content-center">
                                        <span class="text-white opacity-10"
                                            style="font-family: 'Amiri', serif; font-size: 1.8rem; font-weight: bold; line-height: 1;">
                                            {{ $iconArab }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm">
                                    <span class="text-success font-weight-bolder"
                                        id="count-mapel-{{ $k->id }}">{{ $k->mapel_kelas_count }} </span> Mapel
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row mt-4" id="mapel-kelas-container" style="display: none;">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div
                                    class="bg-gradient-success shadow-info border-radius-lg pt-3 pb-3 d-flex justify-content-between align-items-center px-3">

                                    <h6 class="text-white text-capitalize ps-3 mb-0">
                                        Data Mata Pelajaran Kelas <span id="judul-kelas-terpilih"
                                            class="font-weight-bold">...</span>
                                    </h6>

                                    <div class="d-flex align-items-center">

                                        <button type="button" id="btn-add-mapel-kelas"
                                            class="btn btn-white btn-sm mb-0 text-info me-3">
                                            <i class="fa-solid fa-plus"></i> Tambah Mapel Kelas
                                        </button>

                                        <button type="button" id="btn-close-mapel-kelas"
                                            class="btn btn-link text-white mb-0 p-0" data-bs-toggle="tooltip"
                                            title="Tutup Tabel">
                                            <i class="fa-solid fa-x" style="font-size: 12px"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr class="align-middle">
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No
                                                </th>

                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                    Nama Mapel
                                                </th>

                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                    Guru Pengampu
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-mapel-kelas-body">
                                        </tbody>
                                    </table>

                                    <div id="loading-mapel-kelas" class="text-center p-3" style="display: none;">
                                        <div class="spinner-border text-success" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <p id="empty-mapel-kelas" class="text-center text-sm text-secondary p-3 mb-0"
                                        style="display: none;">
                                        Tidak ada data mapel kelas di kelas ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-mapel-kelas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success">
                    <h6 class="modal-title font-weight-normal text-white" id="modal-title-default">Tambah Mapel Kelas</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <form role="form text-left" id="form-mapel-kelas">
                    @csrf
                    <input type="hidden" name="kelas_id" id="hidden_kelas_id" value="">
                    <input type="hidden" id="hidden_mapel_kelas_id">
                    <div class="modal-body">

                        <div class="input-group input-group-static">
                            <label for="select-mapel" class="ms-0 mb-2">Mata Pelajaran</label>
                            <select class="form-control" name="mapel_id" id="select-mapel" style="width: 100%;">
                                <option value="">-- Cari Mapel --</option>
                            </select>
                        </div>

                        <div class="input-group input-group-static my-3">
                            <label for="select-guru" class="ms-0 mb-2">Guru Pengampu</label>
                            <select class="form-control" name="guru_id" id="select-guru" style="width: 100%;">
                                <option value="">-- Cari Guru --</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-success btn-simpan-mapel">Simpan</button>
                        <button type="button" class="btn ml-auto btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            let selectedKelasId = null;
            $('.btn-filter-mepel-kelas').on('click', function() {
                let kelasId = $(this).data('id');
                let namaKelas = $(this).data('nama');
                selectedKelasId = kelasId;
                $('#judul-kelas-terpilih').text(namaKelas);
                $('#hidden_kelas_id').val(kelasId);
                $('#mapel-kelas-container').fadeIn();

                $('#tabel-mapel-kelas-body').html('');
                $('#loading-mapel-kelas').show();
                $('#empty-mapel-kelas').hide();

                $.ajax({
                    url: "/mapel-kelas/kelas/" + kelasId,
                    type: "GET",
                    success: function(data) {

                        $('#loading-mapel-kelas').hide();

                        if (data.length > 0) {
                            let html = '';
                            $.each(data, function(index, mapelKelas) {
                                html += `
                                   <tr>
                                        <td class="align-middle ps-4">
                                            <p class="text-xs font-weight-bold mb-0">${index + 1}</p>
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">${mapelKelas.mapel.nama_mapel}</h6>
                                                    <p class="text-xs text-secondary mb-0">${mapelKelas.mapel.kode_mapel || '-'}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">${mapelKelas.guru.name}</h6>
                                                    <p class="text-xs text-secondary mb-0">${mapelKelas.guru.kode_guru || '-'}</p>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="align-middle text-center">
                                            <button class="btn btn-outline-warning btn-sm btn-icon-round btn-edit-mapelKelas me-1"
                                                data-bs-toggle="tooltip" title="Edit"
                                                data-id="${mapelKelas.id}"
                                                data-mapel-id="${mapelKelas.mapel_id}" 
                                                data-guru-id="${mapelKelas.guru_id}"> 
                                                <i class="fa-regular fa-pen-to-square" style="font-size: 12px;"></i>
                                            </button>

                                            <button class="btn btn-outline-danger btn-sm btn-icon-round btn-hapus-mapelKelas"
                                                data-bs-toggle="tooltip" title="Hapus"
                                                data-id="${mapelKelas.id}" data-name="${mapelKelas.mapel.nama_mapel}" data-kelas="${namaKelas}">
                                                <i class="fa-regular fa-trash-can" style="font-size: 12px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#tabel-mapel-kelas-body').html(html);
                        } else {
                            $('#empty-mapel-kelas').show();
                        }
                    },
                    error: function(xhr) {
                        $('#loading-mapel-kelas').hide();
                        let message = "Terjadi kesalahan saat menghapus data.";

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: message,
                        });
                        // Swal.fire({
                        //     icon: "error",
                        //     title: "Error",
                        //     text: "Gagal memuat data mapel kelas.",
                        // });
                    }
                });
            });

            $('#btn-close-mapel-kelas').on('click', function() {
                $('#mapel-kelas-container').slideUp();
            });

            $('#select-mapel').select2({
                dropdownParent: $('#modal-mapel-kelas'),
                placeholder: '-- Pilih Mata Pelajaran --',
                allowClear: true
            });

            $('#select-guru').select2({
                dropdownParent: $('#modal-mapel-kelas'),
                placeholder: '-- Pilih Guru --',
                allowClear: true
            });

            $('body').on('click', '#btn-add-mapel-kelas', function() {
                $('#form-mapel-kelas')[0].reset();
                $('#select-mapel').val(null).trigger('change');
                $('#select-guru').val(null).trigger('change');
                $('#hidden_kelas_id').val(selectedKelasId);
                $('#modal-title-default').text('Tambah Mapel Kelas');
                $('#hidden_mapel_kelas_id').val('');
                $('#modal-mapel-kelas').modal('show');
                $.ajax({
                    url: "{{ route('mapel-kelas.getAllMapel') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let options = '<option value="">-- Pilih Mapel --</option>';
                        $.each(data, function(key, item) {
                            options +=
                                `<option value="${item.id}">${item.kode_mapel} - ${item.nama_mapel}</option>`;
                        });
                        $('#select-mapel').html(options);
                    },
                    error: function() {
                        console.log("Gagal load mapel");
                    }
                });

                $.ajax({
                    url: "{{ route('mapel-kelas.getAllGuru') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let options = '<option value="">-- Pilih Guru --</option>';
                        $.each(data, function(key, item) {
                            options +=
                                `<option value="${item.id}">${item.kode_guru} - ${item.name}</option>`;
                        });
                        $('#select-guru').html(options);
                    },
                    error: function() {
                        console.log("Gagal load guru");
                    }
                });
            });

            $('body').on('click', '.btn-simpan-mapel', function(e) {
                e.preventDefault();

                let mapelVal = $('#select-mapel').val();
                let guruVal = $('#select-guru').val();
                let kelasId = $('#hidden_kelas_id').val();
                let mapelKelasId = $('#hidden_mapel_kelas_id').val();

                let urlAction = mapelKelasId ? `/mapel-kelas/${mapelKelasId}/update` :
                    "{{ route('mapel-kelas.store') }}";
                let methodAction = mapelKelasId ? "PUT" : "POST";

                if (!mapelVal || !guruVal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap pilih Mata Pelajaran dan Guru Pengampu!',
                    });
                    return;
                }

                let mapelTextFull = $('#select-mapel').select2('data')[0].text;
                let mapelParts = mapelTextFull.split(' - ');
                let mapelKode = mapelParts[0];
                let mapelNama = mapelParts.length > 1 ? mapelParts[1] : mapelParts[0];

                let guruTextFull = $('#select-guru').select2('data')[0].text;
                let guruParts = guruTextFull.split(' - ');
                let guruKode = guruParts[0];
                let guruNama = guruParts.length > 1 ? guruParts[1] : guruParts[0];

                let namaKelasDisplay = $('#judul-kelas-terpilih').text();

                let btn = $(this);
                let originalContent = btn.html();
                btn.prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span class="ms-1">Menyimpan...</span>
                `);

                let formData = $('#form-mapel-kelas').serialize();
                if (!formData.includes('kelas_id')) {
                    formData += '&kelas_id=' + kelasId;
                }

                $.ajax({
                    url: urlAction,
                    type: methodAction,
                    data: formData,
                    success: function(response) {
                        $('#modal-mapel-kelas').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        if (mapelKelasId) {

                            let row = $(`.btn-edit-mapelKelas[data-id="${mapelKelasId}"]`)
                                .closest('tr');

                            row.find('td:eq(1) h6').text(mapelNama);
                            row.find('td:eq(1) p').text(mapelKode);
                            row.find('td:eq(2) h6').text(guruNama);
                            row.find('td:eq(2) p').text(guruKode);

                            row.find('.btn-edit-mapelKelas').data('mapel-id', mapelVal).data(
                                'guru-id', guruVal);
                            row.find('.btn-hapus-mapelKelas').data('name', mapelNama);

                        } else {

                            $('#empty-mapel-kelas').hide();

                            let rowCount = $('#tabel-mapel-kelas-body tr').length;
                            let newNo = rowCount + 1;
                            let newId = response.data_id;

                            let newRowHtml = `
                            <tr class="animasi-masuk">
                                <td class="align-middle ps-4">
                                    <p class="text-xs font-weight-bold mb-0">${newNo}</p>
                                </td>
                                
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${mapelNama}</h6>
                                            <p class="text-xs text-secondary mb-0">${mapelKode}</p>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${guruNama}</h6>
                                            <p class="text-xs text-secondary mb-0">${guruKode}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="align-middle text-center">
                                    <button class="btn btn-outline-warning btn-sm btn-icon-round btn-edit-mapelKelas me-1"
                                        data-bs-toggle="tooltip" title="Edit"
                                        data-id="${newId}"
                                        data-mapel-id="${mapelVal}" 
                                        data-guru-id="${guruVal}">
                                        <i class="fa-regular fa-pen-to-square" style="font-size: 12px;"></i>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm btn-icon-round btn-hapus-mapelKelas"
                                        data-bs-toggle="tooltip" title="Hapus"
                                        data-id="${newId}" data-name="${mapelNama}" data-kelas="${namaKelasDisplay}">
                                        <i class="fa-regular fa-trash-can" style="font-size: 12px;"></i>
                                    </button>
                                </td>
                            </tr>
                            `;

                            $('#tabel-mapel-kelas-body').append(newRowHtml);

                            let currentCount = parseInt($('#count-mapel-' + kelasId).text());
                            $('#count-mapel-' + kelasId).text(currentCount + 1);
                        }

                        $('#form-mapel-kelas')[0].reset();
                        $('#select-mapel').val(null).trigger('change');
                        $('#select-guru').val(null).trigger('change');
                        $('#hidden_mapel_kelas_id').val('');

                    },
                    error: function(xhr) {
                        let message = "Terjadi kesalahan sistem.";
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][0];
                        }
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', message, 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalContent);
                    }
                });
            });

            $('body').on('click', '.btn-hapus-mapelKelas', function() {
                let tombolHapus = $(this);
                let id = $(this).data('id');
                let nama = $(this).data('name');
                let kelas = $(this).data('kelas');
                let url = "{{ url('/mapel-kelas') }}/" + id + "/delete"
                Swal.fire({
                    title: 'Yakin Hapus?',
                    html: `Data Mapel Kelas ${nama} Dari Kelas ${kelas} dan Jadwal KBM yang terkait`,
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr("content"),
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                }).then(() => {
                                    tombolHapus.closest('tr').remove();
                                    $('#tabel-mapel-kelas-body tr').each(
                                        function(
                                            index) {
                                            $(this).find('td:eq(0) p').text(
                                                index + 1);
                                        });
                                    let currentCount = parseInt($(
                                        '#count-mapel-' +
                                        selectedKelasId).text());
                                    $('#count-mapel-' + selectedKelasId).text(
                                        currentCount - 1);
                                });

                            },
                            error: function(xhr) {
                                let message = "Terjadi kesalahan saat menghapus data.";

                                if (xhr.status === 422) {
                                    let errors = xhr.responseJSON.errors;
                                    message = Object.values(errors)[0][0];
                                }
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                }

                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: message,
                                });
                            },
                        });

                    }
                });
            });

            $('body').on('click', '.btn-edit-mapelKelas', function() {
                let id = $(this).data('id');
                let mapelId = $(this).data('mapel-id');
                let guruId = $(this).data('guru-id');

                $('#modal-title-default').text('Edit Mapel Kelas');
                $('#hidden_mapel_kelas_id').val(id);
                $('#hidden_kelas_id').val(selectedKelasId);

                $('#modal-mapel-kelas').modal('show');

                $.ajax({
                    url: "{{ route('mapel-kelas.getAllMapel') }}",
                    type: "GET",
                    success: function(data) {
                        let options = '<option value="">-- Pilih Mapel --</option>';
                        $.each(data, function(key, item) {
                            options +=
                                `<option value="${item.id}">${item.kode_mapel} - ${item.nama_mapel}</option>`;
                        });
                        $('#select-mapel').html(options);
                        $('#select-mapel').val(mapelId).trigger('change');
                    }
                });

                $.ajax({
                    url: "{{ route('mapel-kelas.getAllGuru') }}",
                    type: "GET",
                    success: function(data) {
                        let options = '<option value="">-- Pilih Guru --</option>';
                        $.each(data, function(key, item) {
                            options +=
                                `<option value="${item.id}">${item.kode_guru} - ${item.name}</option>`;
                        });
                        $('#select-guru').html(options);
                        $('#select-guru').val(guruId).trigger('change');
                    }
                });
            });

        });
    </script>
@endsection
