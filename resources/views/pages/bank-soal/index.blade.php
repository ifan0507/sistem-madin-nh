@extends('layout.template')
@section('content')
    <div class="content">
        <div class="container-fluid py-2">
            {{-- HEADER --}}
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold text-secondary">Total Mapel
                                            Diujikan
                                        </p>
                                        <h5 class="font-weight-bolder mb-0 text-success">
                                            {{ $totalMapel }} <span
                                                class="text-sm font-weight-normal text-secondary">Mapel</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-book-open text-lg opacity-10" aria-hidden="true"
                                            style="color: white;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold text-secondary">Sudah
                                            Mengumpulkan
                                        </p>
                                        <h5 class="font-weight-bolder mb-0 text-success">
                                            {{ $sudahMengumpulkan }} <span
                                                class="text-sm font-weight-normal text-secondary">Mapel</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-check-double text-lg opacity-10" aria-hidden="true"
                                            style="color: white;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold text-secondary">Belum
                                            Mengumpulkan
                                        </p>
                                        <h5 class="font-weight-bolder mb-0 text-success">
                                            {{ $belumMengumpulkan }} <span
                                                class="text-sm font-weight-normal text-secondary">Mapel</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-clock-rotate-left text-lg opacity-10" aria-hidden="true"
                                            style="color: white;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card shadow-sm">
                        <div class="card-body p-3">
                            <form action="{{ route('bank-soal') }}" method="GET" class="row align-items-center">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="input-group input-group-static">
                                            <select class="form-control text-sm font-weight-bold" name="filter_tahun">
                                                <option value="">-- Tahun --</option>
                                                <option value="2024/2025"
                                                    {{ request('filter_tahun') == '2024/2025' ? 'selected' : '' }}>2024/2025
                                                </option>
                                                <option value="2025/2026"
                                                    {{ request('filter_tahun') == '2025/2026' ? 'selected' : '' }}>2025/2026
                                                </option>
                                                <option value="2026/2027"
                                                    {{ request('filter_tahun') == '2026/2027' ? 'selected' : '' }}>2026/2027
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <div class="input-group input-group-static">
                                            <select class="form-control text-sm font-weight-bold" name="filter_semester">
                                                <option value="">-- Smt --</option>
                                                <option value="Ganjil"
                                                    {{ request('filter_semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                                </option>
                                                <option value="Genap"
                                                    {{ request('filter_semester') == 'Genap' ? 'selected' : '' }}>Genap
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-2 p-0 text-end">
                                        <div id="btnSubmitFilter"
                                            class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle"
                                            style="cursor: pointer">
                                            <i class="fa-solid fa-filter text-lg opacity-10" aria-hidden="true"
                                                style="color: white;"></i>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- BODY --}}
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header pb-2 bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">

                                <h6 class="mb-0 py-2"><i class="fa-solid fa-layer-group text-success me-2"></i> Monitoring
                                    Bank Soal</h6>

                                <ul class="nav nav-tabs nav-tabs-arab border-bottom-0 justify-content-end" id="kelasTabs"
                                    role="tablist">
                                    @foreach ($kelasList as $index => $kelas)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                id="tab-{{ $kelas->id }}" data-bs-toggle="tab"
                                                data-bs-target="#content-{{ $kelas->id }}" type="button"
                                                role="tab">
                                                <span
                                                    style="font-size: 1.2rem; font-family: 'Amiri', serif;">{{ getKelasArab($kelas->id) }}</span>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="tab-content mt-3 px-3" id="kelasTabsContent">
                                @foreach ($kelasList as $index => $kelas)
                                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                                        id="content-{{ $kelas->id }}" role="tabpanel">

                                        <div class="table-responsive p-0">
                                            <table class="table align-items-center mb-0 table-hover">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Mata Pelajaran</th>
                                                        <th
                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                            Guru Pengampu</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Status Pengumpulan</th>
                                                        <th
                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($mapelPerKelas[$kelas->id]))
                                                        @foreach ($mapelPerKelas[$kelas->id] as $mapel_kelas)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex px-3 py-1">
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center">
                                                                            <h6 class="mb-0 text-sm font-weight-bold"
                                                                                dir="rtl">
                                                                                {{ $mapel_kelas->mapel->nama_mapel }}</h6>
                                                                            <span
                                                                                class="text-xs text-secondary">{{ $mapel_kelas->mapel->kode_mapel }}</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <p class="text-sm font-weight-bold mb-0">
                                                                        {{ $mapel_kelas->guru->name ?? 'Belum Diatur' }}
                                                                    </p>
                                                                </td>

                                                                <td class="align-middle text-center text-sm">
                                                                    @if ($mapel_kelas->bank_soal->isNotEmpty())
                                                                        <span class="badge badge-sm bg-success"><i
                                                                                class="fa fa-check-circle me-1"></i>
                                                                            Sudah</span>
                                                                        <div class="text-xs text-secondary mt-1">
                                                                            {{ $mapel_kelas->bank_soal->last()->created_at->format('d M Y') }}
                                                                        </div>
                                                                    @else
                                                                        <span class="badge badge-sm bg-danger"><i
                                                                                class="fa fa-times-circle me-1"></i>
                                                                            Belum</span>
                                                                    @endif
                                                                </td>

                                                                <td class="align-middle text-center">
                                                                    @if ($mapel_kelas->bank_soal->isNotEmpty())
                                                                        <a href="{{ route('bank-soal.preview', $mapel_kelas->bank_soal->last()->id) }}"
                                                                            class="btn btn-outline-info btn-sm d-inline-flex align-items-center justify-content-center rounded-circle"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Lihat Preview Soal"
                                                                            style="width: 32px; height: 32px;">
                                                                            <i class="fa fa-info"
                                                                                style="font-size: 12px;"></i>
                                                                        </a>
                                                                        <a href="{{ route('bank-soal.cetak', $mapel_kelas->bank_soal->last()->id) }}"
                                                                            target="_blank"
                                                                            class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center justify-content-center rounded-circle"
                                                                            data-bs-toggle="tooltip" title="Cetak"
                                                                            style="width: 32px; height: 32px;">
                                                                            <i class="fa fa-print"
                                                                                style="font-size: 12px;"></i>
                                                                        </a>
                                                                    @else
                                                                        <span
                                                                            class="text-xs text-secondary fst-italic">Menunggu
                                                                            input...</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="4"
                                                                class="text-center py-4 text-secondary text-sm">
                                                                Belum ada mata pelajaran yang diatur untuk kelas ini.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#btnSubmitFilter').on('click', function() {
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection
