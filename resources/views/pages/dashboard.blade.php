@extends('layout.template') @section('content')
    <div class="content">
        <div class="container-fluid py-2">

            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Beranda</h3>
                    <p class="mb-4">
                        Ahlan wa Sahlan, <strong>{{ $nama }}</strong>. Berikut ringkasan data akademik PP Nurul Huda
                        hari ini.
                    </p>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Santri Aktif</p>
                                    <h4 class="mb-0">{{ number_format($stats['total_santri']) }}</h4>
                                </div>
                                <div
                                    class="icon icon-md icon-shape bg-gradient-success shadow-success text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">groups</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">TA. {{ $tahun_aktif }}
                                </span>Semester {{ $sem_aktif }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Total Asatidz</p>
                                    <h4 class="mb-0">{{ number_format($stats['total_guru']) }}</h4>
                                </div>
                                <div
                                    class="icon icon-md icon-shape bg-gradient-success shadow-success text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">school</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">Siap Mengajar</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Kehadiran Hari Ini</p>
                                    <h4 class="mb-0">{{ $stats['persen_hadir'] }}%</h4>
                                </div>
                                <div
                                    class="icon icon-md icon-shape bg-gradient-success shadow-success text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">how_to_reg</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm">
                                @if ($stats['santri_berhalangan'] == 0)
                                    <span class="text-success font-weight-bolder">Hadir Semua!</span>
                                @else
                                    <span class="text-danger font-weight-bolder">{{ $stats['santri_berhalangan'] }}
                                        Santri</span> izin/sakit
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-2 ps-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="text-sm mb-0 text-capitalize">Progres Rapor</p>
                                    <h4 class="mb-0">{{ $stats['persen_rapor'] }}%</h4>
                                </div>
                                <div
                                    class="icon icon-md icon-shape bg-gradient-success shadow-success text-center border-radius-lg">
                                    <i class="material-symbols-rounded opacity-10">assignment_turned_in</i>
                                </div>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-2 ps-3">
                            <p class="mb-0 text-sm"><span class="text-info font-weight-bolder">{{ $stats['rapor_terisi'] }}
                                    Rapor </span>selesai dicetak</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0">Rata-Rata Nilai per Kelas</h6>
                            <p class="text-sm">Berdasarkan ujian terakhir</p>
                            <div class="pe-2">
                                <div class="chart">
                                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0">Tren Kehadiran Mingguan</h6>
                            <p class="text-sm">Persentase santri hadir 7 hari terakhir</p>
                            <div class="pe-2">
                                <div class="chart">
                                    <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-0">Tren Kehadiran Asatidz</h6>
                            <p class="text-sm">Persentase asatidz hadir 7 hari terakhir</p>
                            <div class="pe-2">
                                <div class="chart">
                                    <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Progres Rapor per Kelas</h6>
                                    <p class="text-sm mb-0">
                                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                                        Pantau kelengkapan pengisian nilai oleh Wali Kelas
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Kelas</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Wali Kelas</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total Santri</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Penyelesaian Rapor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($progres as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Kelas {{ $item['nama_kelas'] }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-xs font-weight-bold">{{ $item['wali_kelas'] }}</span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-xs font-weight-bold">{{ $item['total_santri'] }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="progress-wrapper w-75 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                                <span
                                                                    class="text-xs font-weight-bold">{{ $item['persentase'] }}%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            @php
                                                                $color =
                                                                    $item['persentase'] == 100
                                                                        ? 'bg-gradient-success'
                                                                        : ($item['persentase'] > 50
                                                                            ? 'bg-gradient-info'
                                                                            : 'bg-gradient-danger');
                                                            @endphp
                                                            <div class="progress-bar {{ $color }}"
                                                                role="progressbar"
                                                                style="width: {{ $item['persentase'] }}%"
                                                                aria-valuenow="{{ $item['persentase'] }}"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-sm">Belum ada data kelas</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Aktivitas Sistem Terbaru</h6>
                            <p class="text-sm">Pantauan real-time</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side">
                                @foreach ($aktivitas as $log)
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i
                                                class="material-symbols-rounded text-{{ $log['color'] }} text-gradient">{{ $log['icon'] }}</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $log['title'] }}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                {{ $log['desc'] }} • {{ $log['time'] }}</p>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil data JSON dari Laravel Controller
            const chartNilaiData = @json($chart_nilai);
            const chartHadirData = @json($chart_hadir);
            const chartHadirGuruData = @json($chart_hadir_guru);
            // 1. Chart Bar - Rata-Rata Nilai
            var ctx1 = document.getElementById("chart-bars").getContext("2d");
            new Chart(ctx1, {
                type: "bar",
                data: {
                    labels: chartNilaiData.labels,
                    datasets: [{
                        label: "Rata-rata Nilai",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "#4CAF50", // Hijau
                        data: chartNilaiData.data,
                        maxBarThickness: 6
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                },
            });

            // 2. Chart Line - Tren Kehadiran
            var ctx2 = document.getElementById("chart-line").getContext("2d");
            new Chart(ctx2, {
                type: "line",
                data: {
                    labels: chartHadirData.labels,
                    datasets: [{
                        label: "Kehadiran (%)",
                        tension: 0,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: "#e91e63", // Pink/Merah
                        borderColor: "#e91e63",
                        backgroundColor: "transparent",
                        fill: true,
                        data: chartHadirData.data,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 0,
                            max: 100
                        }
                    }
                },
            });

            var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");
            new Chart(ctx3, {
                type: "line",
                data: {
                    labels: chartHadirGuruData.labels,
                    datasets: [{
                        label: "Kehadiran Asatidz (%)",
                        tension: 0,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointBackgroundColor: "#3A416F", // Warna Biru Dongker biar beda sama santri
                        borderColor: "#3A416F",
                        backgroundColor: "transparent",
                        fill: true,
                        data: chartHadirGuruData.data,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 0,
                            max: 100
                        }
                    }
                },
            });
        });
    </script>
@endsection
