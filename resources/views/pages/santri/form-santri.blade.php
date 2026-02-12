@extends('layout.template')

@section('content')
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="mb-0">Tambah Data Santri</h5>
                        <p class="text-sm mb-0 text-muted">
                            Lengkapi data santri sesuai identitas dan akademik
                        </p>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('santri.store') }}" id="form-santri" method="POST">
                            @csrf

                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1 mb-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#tab-santri"
                                            role="tab">
                                            <span class="material-symbols-rounded align-middle mb-1">
                                                people
                                            </span>
                                            Data Santri
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#tab-ortu"
                                            role="tab">
                                            <span class="material-symbols-rounded align-middle mb-1">
                                                family_restroom
                                            </span>
                                            Orang Tua & Kontak
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#tab-akademik"
                                            role="tab">
                                            <span class="material-symbols-rounded align-middle mb-1">
                                                school
                                            </span>
                                            Akademik
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-santri" role="tabpanel">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Nama Santri</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        id="nama">

                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">NIS</label>
                                                    <input type="text" name="nis" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">NIK</label>
                                                    <input type="text" name="nik" class="form-control"
                                                    id="nik">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" class="form-control" id="">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control p-2" >
                                                    <option value="">-- Pilih --</option>
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>



                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control p-2">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab-ortu" role="tabpanel">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Nama Ayah</label>
                                                    <input type="text" name="ayah" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Nama Ibu</label>
                                                    <input type="text" name="ibu" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">No. Telepon</label>
                                                    <input type="tel" name="no_telp" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Alamat Lengkap</label>
                                                <textarea name="alamat" class="form-control p-2" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="tab-akademik" role="tabpanel">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <div class="input-group input-group-outline">
                                                    <label class="form-label">Tahun Angkatan</label>
                                                    <input type="text" name="thn_angkatan" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Kelas</label>
                                                <select name="kelas_id" class="form-control p-2">
                                                    <option value="">-- Pilih Kelas --</option>
                                                    @foreach ($kelas as $k)
                                                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- ACTION --}}
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="{{ route('santri') }}" class="btn ml-auto btn-secondary me-2">
                                    Kembali
                                </a>
                                <button type="submit" class="btn bg-gradient-success btn-simpan" id="btnSave">
                                    Simpan Data
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $("#nama").on("input", function() {
                let nama = $(this).val().trim();
                let parent = $(this).closest(".input-group-outline");

                if (nama === "") {
                    parent.addClass("is-invalid").removeClass("is-valid");
                } else {
                    parent.removeClass("is-invalid").addClass("is-valid");
                }
            });


            $('#form-santri').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let form = $(this);
                let formAction = form.attr('action');
                let formData = form.serialize();

                if ($("#nama").val().trim() === "") {

                    let parent = $("#nama").closest(".input-group-outline");

                    parent.addClass("is-invalid").removeClass("is-valid");
                    parent.addClass("is-focused");

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nama Santri tidak boleh kosong'
                    });

                    isValid = false;
                }
                
                if (isValid) {
                    $("#btnSave").attr("disabled", true);

                    $.ajax({
                        type: "POST",
                        url: formAction,
                        data: formData,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                confirmButtonColor: '#4CAF50'
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        },
                        error: function(xhr) {
                            $("#btnSave").attr("disabled", false);

                            let message = 'Terjadi kesalahan';

                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                message = Object.values(errors)[0][0];
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: message
                            });
                        }
                    });
                }
            });

        });
    </script>
@endsection
