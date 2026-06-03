@extends('layout.template')
@section('content')
    <style>
        .flatpickr-calendar .flatpickr-day.today:not(.selected) {
            background: transparent !important;
            color: #333 !important;
            border: 1px solid #e9ecef;
        }
    </style>
    <div class="content">
        <div class="container-fluid py-2">
            <div class="row">
                <div class="ms-3 mb-3">
                    <h3 class="mb-1 h4 font-weight-bolder">Pengaturan Sistem</h3>
                    <p class="text-sm text-secondary">Kelola konfigurasi akademik dan jadwal operasional sistem di sini.</p>
                </div>

                {{-- CARD 1: Tahun Ajaran & Semester --}}
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-bolder mb-0">Tahun Ajaran & Semester</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.update') }}" method="POST" class="form-ajax">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tipe_update" value="tahun_ajaran">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="input-group-static input-group">
                                            <label class="form-control-label">Tahun Ajaran</label>
                                            <select name="tahun_ajaran" class="form-control" required>
                                                <option value="2024/2025"
                                                    {{ $data->tahun_ajaran == '2024/2025' ? 'selected' : '' }}>2024/2025
                                                </option>
                                                <option value="2025/2026"
                                                    {{ $data->tahun_ajaran == '2025/2026' ? 'selected' : '' }}>2025/2026
                                                </option>
                                                <option value="2026/2027"
                                                    {{ $data->tahun_ajaran == '2026/2027' ? 'selected' : '' }}>2026/2027
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-static input-group">
                                            <label class="form-control-label">Semester</label>
                                            <select name="semester" class="form-control" required>
                                                <option value="Ganjil" {{ $data->semester == 'Ganjil' ? 'selected' : '' }}>
                                                    Ganjil</option>
                                                <option value="Genap" {{ $data->semester == 'Genap' ? 'selected' : '' }}>
                                                    Genap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-auto pt-3">
                                    <button type="submit" class="btn bg-gradient-success mb-0 btn-submit">Update
                                        Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: Tanggal Awal Semester --}}
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-bolder mb-0">Tanggal Awal Semester</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.update') }}" method="POST" class="form-ajax">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tipe_update" value="awal_semester">

                                <div class="input-group-static input-group mb-4">
                                    <label class="form-control-label">Tanggal Mulai Efektif</label>
                                    <input type="text" name="tgl_awal_semester" class="form-control datepicker"
                                        value="{{ $data->tgl_awal_semester ?? '' }}" required>
                                </div>

                                <div class="d-flex justify-content-end mt-auto pt-3">
                                    <button type="submit" class="btn bg-gradient-success mb-0 btn-submit">Update
                                        Tanggal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: Rentang Pengumpulan Soal Ujian --}}
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-bolder mb-0">Tanggal Pengumpulan Soal Ujian</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.update') }}" method="POST" class="form-ajax">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tipe_update" value="kumpul_soal">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="input-group-static input-group">
                                            <label class="form-control-label">Tanggal Dibuka</label>
                                            <input type="text" name="tgl_mulai_kumpul_soal"
                                                class="form-control datepicker"
                                                value="{{ $data->tgl_mulai_kumpul_soal ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-static input-group">
                                            <label class="form-control-label">Batas Akhir</label>
                                            <input type="text" name="tgl_akhir_kumpul_soal"
                                                class="form-control datepicker"
                                                value="{{ $data->tgl_akhir_kumpul_soal ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-auto">
                                    <button type="submit" class="btn bg-gradient-success text-white mb-0 btn-submit">Update
                                        Tanggal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- CARD 4: Rentang Pengumpulan Nilai --}}
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-bolder mb-0">Tanggal Pengumpulan Nilai Rapot</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('setting.update') }}" method="POST" class="form-ajax">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="tipe_update" value="kumpul_nilai">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="input-group-static input-group">
                                            <label class="form-control-label">Tanggal Dibuka</label>
                                            <input type="text" name="tgl_mulai_kumpul_nilai"
                                                class="form-control datepicker"
                                                value="{{ $data->tgl_mulai_kumpul_nilai ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group-static input-group">
                                            <label class="form-control-label">Batas Akhir</label>
                                            <input type="text" name="tgl_akhir_kumpul_nilai"
                                                class="form-control datepicker"
                                                value="{{ $data->tgl_akhir_kumpul_nilai ?? '' }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-auto">
                                    <button type="submit"
                                        class="btn bg-gradient-success text-white mb-0 btn-submit">Update Tanggal</button>
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

            $('.form-ajax').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let url = form.attr('action');
                let btnSubmit = form.find('.btn-submit');
                let originalText = btnSubmit.html();
                let formData = form.serialize();

                btnSubmit.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                ).prop('disabled', true);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        btnSubmit.html(originalText).prop('disabled', false);

                        if (response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        btnSubmit.html(originalText).prop('disabled', false);

                        let res = xhr.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res && res.message ? res.message :
                                'Terjadi kesalahan sistem.'
                        });
                    }
                });
            });
            flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                defaultDate: null,
                allowInput: true
            });
        });
    </script>
@endsection
