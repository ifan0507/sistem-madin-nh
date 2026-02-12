@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-4 h4 font-weight-bolder">Kelas Madin</h3>
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

                    <div class="col-xl-3 col-sm-6 mb-4 cursor-pointer btn-filter-kelas" data-id="{{ $k->id }}"
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
                                    <span class="text-success font-weight-bolder">{{ $k->santri_count }} </span> Santri /
                                    طَالِب
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="row mt-4" id="santri-container" style="display: none;">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div
                                    class="bg-gradient-success shadow-info border-radius-lg pt-3 pb-3 d-flex justify-content-between align-items-center px-3">

                                    <h6 class="text-white text-capitalize ps-3 mb-0">
                                        Data Santri Kelas <span id="judul-kelas-terpilih"
                                            class="font-weight-bold">...</span>
                                    </h6>

                                    <div class="d-flex align-items-center">

                                        <button type="button" id="btn-bulk-update"
                                            class="btn btn-white btn-sm mb-0 text-info me-3" style="display: none;">
                                            <i class="fa-solid fa-pencil"></i> Update Terpilih
                                        </button>

                                        <button type="button" id="btn-close-santri"
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
                                                <th class="text-center" width="7%">
                                                    <div
                                                        class="form-check d-flex justify-content-center align-items-center p-0">
                                                        <input class="form-check-input" type="checkbox" id="check-all">
                                                    </div>
                                                </th>

                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                                    width="5%">
                                                    No
                                                </th>

                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                                    Nama Santri
                                                </th>

                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                    width="15%">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-santri-body">
                                        </tbody>
                                    </table>

                                    <div id="loading-santri" class="text-center p-3" style="display: none;">
                                        <div class="spinner-border text-success" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <p id="empty-santri" class="text-center text-sm text-secondary p-3 mb-0"
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
    </div>
    <script>
        $(document).ready(function() {

            $('.btn-filter-kelas').on('click', function() {
                let kelasId = $(this).data('id');
                let namaKelas = $(this).data('nama');

                $('#judul-kelas-terpilih').text(namaKelas);
                $('#santri-container').fadeIn();

                $('#tabel-santri-body').html('');
                $('#loading-santri').show();
                $('#empty-santri').hide();
                $('#btn-bulk-update').hide();
                $('#check-all').prop('checked', false);

                $.ajax({
                    url: "/kelas/santri-kelas/" + kelasId,
                    type: "GET",
                    success: function(data) {
                        $('#loading-santri').hide();

                        if (data.length > 0) {
                            let html = '';
                            $.each(data, function(index, santri) {
                                html += `
                            <tr>
                                <td class="align-middle text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input check-item" type="checkbox" value="${santri.id}">
                                    </div>
                                </td>
                                
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">${index + 1}</p>
                                </td>
                                
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">${santri.nama}</h6>
                                            <p class="text-xs text-secondary mb-0">${santri.nis || '-'}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="align-middle text-center">
                                    <button class="btn btn-outline-danger btn-sm btn-icon-round btn-hapus-santri"
                                        data-bs-toggle="tooltip" title="Hapus"
                                        data-id="${santri.id}" data-name="${santri.nama}" data-kelas="${namaKelas}">
                                        <i class="fa-regular fa-trash-can" style="font-size: 12px;"></i>
                                    </button>
                                   
                                </td>
                            </tr>
                        `;
                            });
                            $('#tabel-santri-body').html(html);
                        } else {
                            $('#empty-santri').show();
                        }
                    },
                    error: function() {
                        $('#loading-santri').hide();
                        alert('Gagal mengambil data santri.');
                    }
                });
            });

            $('#btn-close-santri').on('click', function() {
                $('#santri-container').slideUp();
                $('#check-all').prop('checked', false);
                $('.check-item').prop('checked', false);
                $('#btn-bulk-update').hide();
            });

            $(document).on('change', '.check-item', function() {
                cekTombolUpdate();
            });

            $('#check-all').on('change', function() {
                let isChecked = $(this).is(':checked');
                $('.check-item').prop('checked', isChecked);
                cekTombolUpdate();
            });

            function cekTombolUpdate() {
                let jumlahChecked = $('.check-item:checked').length;

                if (jumlahChecked > 0) {
                    $('#btn-bulk-update').fadeIn();
                    $('#btn-bulk-update').html(
                        `<i class="fa-solid fa-pencil" style="font-size:12px"></i> Update (${jumlahChecked}) Data`
                    );
                } else {
                    $('#btn-bulk-update').fadeOut();
                }
            }

            $(document).on('click', '.btn-hapus-santri', function() {
                let tombolHapus = $(this);
                let id = $(this).data('id');
                let nama = $(this).data('name');
                let kelas = $(this).data('kelas');
                let url = "{{ url('/santri') }}/" + id + "/delete-kelas"
                Swal.fire({
                    title: 'Yakin Hapus?',
                    html: `Data Santri ${nama} Dari Kelas ${kelas}`,
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
                                    $('#tabel-santri-body tr').each(function(
                                        index) {
                                        $(this).find('td:eq(1) p').text(
                                            index + 1);
                                    });
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

            const daftarKelas = {
                @foreach ($kelas as $k)
                    "{{ $k->id }}": "Kelas {{ $k->nama_kelas }}",
                @endforeach
            };

            $('#btn-bulk-update').on('click', function() {
                let selectedIds = [];
                $('.check-item:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) return;
                let optionsHtml =
                    '<option value="" disabled selected class="text-center">--- Pilih Kelas Tujuan ---</option>';
                for (const [id, nama] of Object.entries(daftarKelas)) {
                    optionsHtml += `<option value="${id}">${nama}</option>`;
                }

                Swal.fire({
                    title: 'Pindah Kelas Santri',
                    html: `
                            <p class="text-sm mb-4">Memindahkan <b>${selectedIds.length}</b> santri ke kelas baru.</p>
                            <div style="width: 70%; margin: 0 auto;">
                                <div class="input-group input-group-static mb-2 text-left">
                                    <select id="swal-kelas-tujuan" class="form-control px-2 border" style="cursor: pointer;">
                                        ${optionsHtml}
                                    </select>
                                </div>
                            </div>
                        `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#28a745',
                    reverseButtons: true,
                    preConfirm: () => {
                        const kelasTujuanId = document.getElementById('swal-kelas-tujuan')
                            .value;
                        if (!kelasTujuanId) {
                            Swal.showValidationMessage(
                                'Silakan pilih kelas tujuan terlebih dahulu!');
                            return false;
                        }
                        return kelasTujuanId;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let kelasBaruId = result.value;

                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Sedang memindahkan data santri.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ route('santri.updateKelasBulk') }}",
                            type: "PUT",
                            data: {
                                _token: $('meta[name="csrf-token"]').attr("content"),
                                santri_id: selectedIds,
                                kelas_id: kelasBaruId
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil!",
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('.check-item:checked').closest('tr')
                                        .fadeOut(400, function() {
                                            $(this).remove();
                                            $('#tabel-santri-body tr').each(
                                                function(index) {
                                                    $(this).find(
                                                        'td:eq(1) p'
                                                    ).text(
                                                        index + 1);
                                                });
                                        });
                                    $('#btn-bulk-update').fadeOut();
                                    $('#check-all').prop('checked', false);
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
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
