@extends('layout.template')
@section('content')
    <div class="container-fluid py-3">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 1rem; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            {{-- <div class="col-auto">
                                <div class="avatar avatar-2xl rounded-circle border border-3 border-white shadow-sm"
                                    style="width: 100px; height: 100px; background: linear-gradient(135deg, #2dce89 0%);">
                                    <span class="text-white fw-bold" style="font-size: 2.5rem; line-height: 100px;">
                                        {{ strtoupper(substr($santri->nama, 0, 1)) }}
                                    </span>
                                </div>
                            </div> --}}
                            <div class="col-12 col-md">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <h4 class="mb-0 fw-bold">{{ $santri->nama }}</h4>

                                </div>
                                <div class="d-flex flex-wrap gap-2 gap-md-4 text-sm text-muted">
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">badge</span>
                                        <span>NIS: <strong>{{ $santri->nis }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">badge</span>
                                        <span>NIK: <strong>{{ $santri->nik }}</strong></span>
                                    </div>
                                    @if ($santri->kelas)
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="material-symbols-rounded" style="font-size: 18px;">school</span>
                                            <span>Kelas: <strong>{{ $santri->kelas->nama_kelas }}</strong></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-auto mt-3 mt-md-0">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('santri') }}"
                                        class="btn btn-outline-secondary mb-0 d-flex align-items-center gap-1"
                                        style="border-radius: 0.5rem;">
                                        <span class="material-symbols-rounded" style="font-size: 18px;">arrow_back</span>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-6">
                <!-- Data Pribadi Card -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle"
                                style="width: 40px; height: 40px;">
                                <span class="material-symbols-rounded text-white"
                                    style="font-size: 20px; line-height: 40px;">person</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Data Pribadi</h6>
                                <p class="text-xs text-muted mb-0">Informasi identitas santri</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa; border-left: 3px solid #2dce89;">
                                    <div class="text-xs text-muted mb-1">Nama Lengkap</div>
                                    <div class="fw-bold text-dark">{{ $santri->nama }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="text-xs text-muted mb-1">NIK</div>
                                    <div class="fw-semibold text-dark">{{ $santri->nik }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="text-xs text-muted mb-1">NIS</div>
                                    <div class="fw-semibold text-dark">{{ $santri->nis }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="text-xs text-muted mb-1">Jenis Kelamin</div>
                                    <div class="fw-semibold text-dark">
                                        @if ($santri->jenis_kelamin == 'L')
                                            <span class="badge bg-gradient-info px-3 py-1">Laki-laki</span>
                                        @else
                                            <span class="badge bg-gradient-warning px-3 py-1">Perempuan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="text-xs text-muted mb-1">Tanggal Lahir</div>
                                    <div class="fw-semibold text-dark">
                                        {{ date('d F Y', strtotime($santri->tanggal_lahir)) }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="text-xs text-muted mb-1">Tempat Lahir</div>
                                    <div class="fw-semibold text-dark">{{ $santri->tempat_lahir }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua Card -->
                <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle"
                                style="width: 40px; height: 40px;">
                                <span class="material-symbols-rounded text-white"
                                    style="font-size: 20px; line-height: 40px;">family_restroom</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Data Orang Tua</h6>
                                <p class="text-xs text-muted mb-0">Informasi orang tua/wali</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa; border-left: 3px solid #2dce89;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="material-symbols-rounded text-success"
                                            style="font-size: 20px;">man</span>
                                        <div class="text-xs text-muted">Nama Ayah</div>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $santri->ayah }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa; border-left: 3px solid #2dce89;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="material-symbols-rounded text-success"
                                            style="font-size: 20px;">woman</span>
                                        <div class="text-xs text-muted">Nama Ibu</div>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $santri->ibu }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-6">
                <!-- Data Akademik Card -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle"
                                style="width: 40px; height: 40px;">
                                <span class="material-symbols-rounded text-white"
                                    style="font-size: 20px; line-height: 40px;">school</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Data Akademik</h6>
                                <p class="text-xs text-muted mb-0">Informasi pendidikan santri</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-4 rounded-3 text-center"
                                    style="background: linear-gradient(135deg, #2dce8915 0%, #11cdef15 100%); border: 2px dashed #2dce8950;">
                                    <div class="mb-2">
                                        <span class="material-symbols-rounded"
                                            style="font-size: 48px; color: #2dce89;">school</span>
                                    </div>
                                    <div class="text-xs text-muted mb-1">Kelas Saat Ini</div>
                                    @if ($santri->kelas)
                                        <div class="fw-bold text-dark" style="font-size: 1.5rem;">
                                            {{ $santri->kelas->nama_kelas }}</div>
                                    @else
                                        <div class="fw-bold text-muted" style="font-size: 1rem;">Belum ada kelas</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="text-xs text-muted mb-1">Tahun Angkatan</div>
                                    <div class="fw-bold text-dark d-flex align-items-center gap-2">
                                        <span class="material-symbols-rounded"
                                            style="font-size: 20px; color: #28a745;">calendar_today</span>
                                        {{ $santri->thn_angkatan }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak & Alamat Card -->
                <div class="card shadow-sm border-0" style="border-radius: 1rem;">
                    <div class="card-header bg-transparent border-0 pt-4 pb-0 px-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="icon icon-shape bg-gradient-success shadow text-center rounded-circle"
                                style="width: 40px; height: 40px;">
                                <span class="material-symbols-rounded text-white"
                                    style="font-size: 20px; line-height: 40px;">contact_phone</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Kontak & Alamat</h6>
                                <p class="text-xs text-muted mb-0">Informasi kontak santri</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="material-symbols-rounded text-success"
                                            style="font-size: 20px;">phone</span>
                                        <div class="text-xs text-muted">Nomor Telepon Orang Tua</div>
                                    </div>
                                    <div class="fw-bold text-dark">{{ $santri->no_telp }}</div>
                                    <a href="tel:{{ $santri->no_telp }}"
                                        class="btn btn-sm btn-outline-success mt-2 mb-0">
                                        <span class="material-symbols-rounded"
                                            style="font-size: 16px; vertical-align: middle;">call</span>
                                        Hubungi
                                    </a>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 rounded-3" style="background: #f8f9fa;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="material-symbols-rounded text-success"
                                            style="font-size: 20px;">location_on</span>
                                        <div class="text-xs text-muted">Alamat Lengkap</div>
                                    </div>
                                    <div class="text-dark" style="line-height: 1.6;">{{ $santri->alamat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
