@extends('layout.template')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="mb-0">Edit Data Santri</h5>
                        <p class="text-sm text-muted mb-0">Perbarui data santri sesuai identitas dan akademik</p>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('santri.update', $santri->id) }}" id="form-edit-santri" method="POST">
                            @csrf
                            @method('PUT')
                            <ul class="nav nav-pills nav-fill p-1 mb-4" role="tablist"
                                style="background: #f0f2f5; border-radius: 0.5rem;">
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-3 py-2 active" data-bs-toggle="tab" href="#tab-santri"
                                        role="tab">
                                        <span class="material-symbols-rounded align-middle me-1">person</span>
                                        Data Santri
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-3 py-2" data-bs-toggle="tab" href="#tab-ortu" role="tab">
                                        <span class="material-symbols-rounded align-middle me-1">family_restroom</span>
                                        Orang Tua & Kontak
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-0 px-3 py-2" data-bs-toggle="tab" href="#tab-akademik"
                                        role="tab">
                                        <span class="material-symbols-rounded align-middle me-1">school</span>
                                        Akademik
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-santri" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded-3 p-3 h-100" style="background: #fafafa;">
                                                <h6 class="text-uppercase text-xs text-muted fw-bold mb-3">
                                                    <span class="material-symbols-rounded align-middle me-1"
                                                        style="font-size: 16px;">badge</span>
                                                    Identitas
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">Nama Santri</label>
                                                        <input type="text" name="nama" class="form-control"
                                                            id="nama" value="{{ old('nama', $santri->nama) }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">NIS</label>
                                                        <input type="text" name="nis" class="form-control"
                                                            value="{{ old('nis', $santri->nis) }}" readonly>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">NIK (16 Digit)</label>
                                                        <input type="text" name="nik" class="form-control"
                                                            id="nik" maxlength="16"
                                                            value="{{ old('nik', $santri->nik) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded-3 p-3 h-100" style="background: #fafafa;">
                                                <h6 class="text-uppercase text-xs text-muted fw-bold mb-3">
                                                    <span class="material-symbols-rounded align-middle me-1"
                                                        style="font-size: 16px;">cake</span>
                                                    Kelahiran
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">Tempat Lahir</label>
                                                        <input type="text" name="tempat_lahir" class="form-control"
                                                            id="tempat_lahir"
                                                            value="{{ old('tempat_lahir', $santri->tempat_lahir) }}">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-xs mb-1">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir"
                                                        class="form-control border px-3" id="tanggal_lahir"
                                                        value="{{ old('tanggal_lahir', $santri->tanggal_lahir) }}">
                                                </div>
                                                <div>
                                                    <label class="form-label text-xs mb-1">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" class="form-control border px-3"
                                                        id="jenis_kelamin">
                                                        <option value="">-- Pilih --</option>
                                                        <option value="L"
                                                            {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                                            Laki-laki
                                                        </option>
                                                        <option value="P"
                                                            {{ old('jenis_kelamin', $santri->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                                            Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-ortu" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded-3 p-3 h-100" style="background: #fafafa;">
                                                <h6 class="text-uppercase text-xs text-muted fw-bold mb-3">
                                                    <span class="material-symbols-rounded align-middle me-1"
                                                        style="font-size: 16px;">group</span>
                                                    Data Orang Tua
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">Nama Ayah</label>
                                                        <input type="text" name="ayah" class="form-control"
                                                            id="ayah" value="{{ old('ayah', $santri->ayah) }}">
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">Nama Ibu</label>
                                                        <input type="text" name="ibu" class="form-control"
                                                            id="ibu" value="{{ old('ibu', $santri->ibu) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded-3 p-3 h-100" style="background: #fafafa;">
                                                <h6 class="text-uppercase text-xs text-muted fw-bold mb-3">
                                                    <span class="material-symbols-rounded align-middle me-1"
                                                        style="font-size: 16px;">contact_phone</span>
                                                    Kontak & Alamat
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">No. Telepon</label>
                                                        <input type="tel" name="no_telp" class="form-control"
                                                            id="no_telp"
                                                            value="{{ old('no_telp', $santri->no_telp) }}">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="form-label text-xs mb-1">Alamat Lengkap</label>
                                                    <textarea name="alamat" class="form-control border px-3" rows="3" id="alamat">{{ old('alamat', $santri->alamat) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-akademik" role="tabpanel">
                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded-3 p-3 h-100" style="background: #fafafa;">
                                                <h6 class="text-uppercase text-xs text-muted fw-bold mb-3">
                                                    <span class="material-symbols-rounded align-middle me-1"
                                                        style="font-size: 16px;">calendar_month</span>
                                                    Tahun & Kelas
                                                </h6>
                                                <div class="mb-3">
                                                    <div class="input-group input-group-outline is-filled">
                                                        <label class="form-label">Tahun Angkatan</label>
                                                        <input type="text" name="thn_angkatan" class="form-control"
                                                            id="thn_angkatan"
                                                            value="{{ old('thn_angkatan', $santri->thn_angkatan) }}">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="form-label text-xs mb-1">Kelas</label>
                                                    <select name="kelas_id" class="form-control border px-3">
                                                        <option value="">-- Pilih Kelas --</option>
                                                        @foreach ($kelas as $k)
                                                            <option value="{{ $k->id }}"
                                                                {{ old('kelas_id', $santri->kelas_id) == $k->id ? 'selected' : '' }}>
                                                                {{ $k->nama_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <div class="border rounded-3 p-3 h-100"
                                                style="background: linear-gradient(135deg, #667eea11 0%, #764ba211 100%);">
                                                <h6 class="text-uppercase text-xs text-muted fw-bold mb-3">
                                                    <span class="material-symbols-rounded align-middle me-1"
                                                        style="font-size: 16px;">info</span>
                                                    Informasi
                                                </h6>
                                                <p class="text-sm text-muted mb-0">
                                                    Perbarui data akademik sesuai kebutuhan.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('santri') }}" class="btn btn-outline-secondary mb-0">
                                    <span class="material-symbols-rounded align-middle me-1">arrow_back</span>
                                    Kembali
                                </a>
                                <button type="submit" class="btn bg-gradient-success mb-0" id="btnUpdate">
                                    <span class="material-symbols-rounded align-middle me-1">update</span>
                                    Update Data
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
            function setInvalid(id) {
                let parent = $("#" + id).closest(".input-group-outline");
                parent.addClass("is-invalid")
                    .removeClass("is-valid")
                    .addClass("is-focused");
            }

            function setValid(id) {
                let parent = $("#" + id).closest(".input-group-outline");
                parent.removeClass("is-invalid")
                    .addClass("is-valid");
            }

            $("#nama, #nik, #tempat_lahir, #thn_angkatan, #ayah, #ibu, #no_telp").on("input", function() {
                let id = $(this).attr("id");
                let value = $(this).val().trim();

                if (value === "") {
                    setInvalid(id);
                } else {
                    setValid(id);
                }
            });

            $("#alamat").on("input", function() {
                if ($(this).val().trim() === "") {
                    $(this).addClass("is-invalid").removeClass("is-valid");
                } else {
                    $(this).removeClass("is-invalid").addClass("is-valid");
                }
            });

            $("#jenis_kelamin").on("change", function() {
                if ($(this).val() === "") {
                    $(this).addClass("is-invalid").removeClass("is-valid");
                } else {
                    $(this).removeClass("is-invalid").addClass("is-valid");
                }
            });

            $("#tanggal_lahir").on("change", function() {
                if ($(this).val() === "") {
                    $(this).addClass("is-invalid").removeClass("is-valid");
                } else {
                    $(this).removeClass("is-invalid").addClass("is-valid");
                }
            });

            $('#form-edit-santri').on('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                let form = $(this);
                let formAction = form.attr('action');
                let formData = form.serialize();


                if ($("#nama").val().trim() === "") {
                    setInvalid("nama");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nama Santri tidak boleh kosong'
                    });
                    isValid = false;
                } else {
                    setValid("nama");
                }


                let nik = $("#nik").val().trim();
                if (isValid && nik === "") {
                    setInvalid("nik");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'NIK tidak boleh kosong'
                    });
                    isValid = false;
                } else if (isValid && (!/^\d+$/.test(nik) || nik.length !== 16)) {
                    setInvalid("nik");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'NIK harus 16 digit angka'
                    });
                    isValid = false;
                } else if (isValid) {
                    setValid("nik");
                }


                if (isValid && $("#tempat_lahir").val().trim() === "") {
                    setInvalid("tempat_lahir");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tempat lahir tidak boleh kosong'
                    });
                    isValid = false;
                } else if (isValid) {
                    setValid("tempat_lahir");
                }


                if (isValid && $("#jenis_kelamin").val() === "") {
                    $("#jenis_kelamin").addClass("is-invalid").removeClass("is-valid");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Jenis kelamin wajib dipilih'
                    });
                    isValid = false;
                } else if (isValid) {
                    $("#jenis_kelamin").removeClass("is-invalid").addClass("is-valid");
                }


                if (isValid && $("#tanggal_lahir").val() === "") {
                    $("#tanggal_lahir").addClass("is-invalid").removeClass("is-valid");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tanggal lahir wajib diisi'
                    });
                    isValid = false;
                } else if (isValid) {
                    $("#tanggal_lahir").removeClass("is-invalid").addClass("is-valid");
                }


                if (isValid && $("#ayah").val().trim() === "") {
                    setInvalid("ayah");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nama Ayah wajib diisi'
                    });
                    isValid = false;
                } else if (isValid) {
                    setValid("ayah");
                }


                if (isValid && $("#ibu").val().trim() === "") {
                    setInvalid("ibu");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nama Ibu wajib diisi'
                    });
                    isValid = false;
                } else if (isValid) {
                    setValid("ibu");
                }


                let telp = $("#no_telp").val().trim();
                if (isValid && telp === "") {
                    setInvalid("no_telp");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nomor telepon wajib diisi'
                    });
                    isValid = false;
                } else if (isValid && (!/^\d+$/.test(telp) || telp.length < 10 || telp.length > 13)) {
                    setInvalid("no_telp");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nomor telepon harus angka (10-13 digit)'
                    });
                    isValid = false;
                } else if (isValid) {
                    setValid("no_telp");
                }

                if (isValid && $("#alamat").val().trim() === "") {
                    $("#alamat").addClass("is-invalid").removeClass("is-valid");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Alamat wajib diisi'
                    });
                    isValid = false;
                } else if (isValid) {
                    $("#alamat").removeClass("is-invalid").addClass("is-valid");
                }


                if (isValid && $("#thn_angkatan").val().trim() === "") {
                    setInvalid("thn_angkatan");
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tahun angkatan wajib diisi'
                    });
                    isValid = false;
                } else if (isValid) {
                    setValid("thn_angkatan");
                }


                if (isValid) {

                    $("#btnUpdate").attr("disabled", true);

                    $.ajax({
                        type: "PUT",
                        url: formAction,
                        data: formData,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        },
                        error: function(xhr) {
                            $("#btnUpdate").attr("disabled", false);

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
