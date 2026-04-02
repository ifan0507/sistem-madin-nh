@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">

            {{-- HEADER TITLE & FILTER --}}
            <div class="row align-items-center mb-4">
                <div class="col-md-6 ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Manajemen Nilai Ujian Praktek Santri</h3>
                </div>
            </div>

            {{-- LIST CARD KELAS --}}
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-4">
                    <form action="{{ route('nilai-ujian-praktek') }}" method="GET" id="form-filter" class="m-0 p-0 h-100">
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
                                <div class="d-flex align-items-center">
                                    <button type="button" id="btn-close-santri" class="btn btn-link text-white mb-0 p-0"
                                        data-bs-toggle="tooltip" title="Tutup Tabel">
                                        <i class="fa-solid fa-xmark" style="font-size: 16px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            {{-- Form Bulk Submit --}}
                            <form action="{{ route('nilai-ujian-praktek.store-bulk') }}" method="POST"
                                id="form-bulk-nilai">
                                @csrf
                                <input type="hidden" name="tahun_ajaran" id="hidden_tahun_ajaran">
                                <input type="hidden" name="semester" id="hidden_semester">

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
                                                    width="15%">Al-Qur'an</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                    width="15%">Kitab</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                    width="15%">Muhafadloh</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabel-santri-body">
                                            {{-- Akan diisi oleh JavaScript --}}
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

                                {{-- Tombol Simpan --}}
                                <div class="p-3 text-end" id="container-btn-simpan" style="display: none;">
                                    <button type="submit" class="btn bg-gradient-success mb-0">
                                        <i class="fa-solid fa-save me-1"></i> Simpan Nilai Kelas
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#filter_tahun, #filter_semester').on('change', function() {
                $(this).closest('form').submit();
            });

            $('#btn-close-santri').on('click', function() {
                $('#santri-container').slideUp();
            });

            $('.btn-filter-kelas').on('click', function() {
                let kelasId = $(this).data('id');
                let namaKelas = $(this).data('nama');

                let tahunAjaran = $('#filter_tahun').val();
                let semester = $('#filter_semester').val();

                $('#judul-kelas-terpilih').text(namaKelas);
                $('#santri-container').slideDown();
                $('#tabel-santri-body').empty();
                $('#loading-santri').show();
                $('#empty-santri').hide();
                $('#container-btn-simpan').hide();

                $('#hidden_tahun_ajaran').val(tahunAjaran);
                $('#hidden_semester').val(semester);

                $.ajax({
                    url: `/nilai-praktek/get-santri/${kelasId}`,
                    type: 'GET',
                    data: {
                        tahun_ajaran: tahunAjaran,
                        semester: semester
                    },
                    success: function(response) {
                        $('#loading-santri').hide();
                        let santris = response.data;

                        if (santris.length === 0) {
                            $('#empty-santri').show();
                        } else {
                            let rows = '';

                            $.each(santris, function(index, santri) {
                                let nilai = santri.nilai_praktek.length > 0 ? santri
                                    .nilai_praktek[0] : null;

                                let valQuran = nilai && nilai.al_quran !== null ? nilai
                                    .al_quran : '';
                                let valKitab = nilai && nilai.kitab !== null ? nilai
                                    .kitab : '';
                                let valMuhafadloh = nilai && nilai.muhafadloh !== null ?
                                    nilai.muhafadloh : '';

                                rows += `
                            <tr>
                                <td class="text-center text-sm font-weight-bold">${index + 1}</td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">${santri.nama}</p>
                                    <p class="text-xs text-secondary mb-0">${santri.nis}</p>
                                    
                                    <input type="hidden" name="nilai[${index}][santri_id]" value="${santri.id}">
                                </td>
                                <td class="text-center">
                                    <input type="number" name="nilai[${index}][al_quran]" value="${valQuran}" 
                                        class="form-control form-control-sm text-center mx-auto" 
                                        style="width: 80px; border: 1px solid #d2d6da;" min="0" max="100">
                                </td>
                                <td class="text-center">
                                    <input type="number" name="nilai[${index}][kitab]" value="${valKitab}" 
                                        class="form-control form-control-sm text-center mx-auto" 
                                        style="width: 80px; border: 1px solid #d2d6da;" min="0" max="100">
                                </td>
                                <td class="text-center">
                                    <input type="number" name="nilai[${index}][muhafadloh]" value="${valMuhafadloh}" 
                                        class="form-control form-control-sm text-center mx-auto" 
                                        style="width: 80px; border: 1px solid #d2d6da;" min="0" max="100">
                                </td>
                            </tr>
                        `;
                            });

                            $('#tabel-santri-body').html(rows);
                            $('#container-btn-simpan').show();
                        }
                    },
                    error: function(xhr) {
                        $('#loading-santri').hide();
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
                    // error: function() {
                    //     $('#loading-santri').hide();
                    //     Swal.fire('Error', 'Gagal memuat data santri dari server.', 'error');
                    // }
                });
            });

            $('#form-bulk-nilai').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let btnSubmit = form.find('button[type="submit"]');
                let originalText = btnSubmit.html();

                btnSubmit.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                );

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form
                        .serialize(),
                    success: function(response) {
                        btnSubmit.prop('disabled', false).html(originalText);

                        Swal.fire({
                            icon: 'success',
                            title: 'Tersimpan!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                    },
                    error: function(xhr) {
                        btnSubmit.prop('disabled', false).html(originalText);

                        let message = 'Terjadi kesalahan saat menyimpan data.';

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            message = Object.values(errors)[0][
                                0
                            ];
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Disimpan',
                            text: message
                        });
                    }
                });
            });
        });
    </script>
@endsection
