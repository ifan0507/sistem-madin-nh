<?php

namespace App\Services;

use App\Models\AbsensiGuruModel;
use App\Models\AbsensiSantriModel;
use App\Models\KelasModel;
use App\Models\NilaiUjianModel;
use App\Models\RaporModel;
use App\Models\SantriModel;
use App\Models\User;
use Carbon\Carbon;

class DashboardService
{
    public function getAllDashboardData($tahunAjaran, $semester): array
    {
        return [
            'quick_stats'      => $this->getQuickStats($tahunAjaran, $semester),
            'chart_nilai'      => $this->getChartRataRataNilai($tahunAjaran, $semester),
            'chart_kehadiran'  => $this->getChartTrenKehadiran(),
            'chart_hadir_guru' => $this->getChartKehadiranGuru(),
            'progres_kelas'    => $this->getProgresNilaiKelas($tahunAjaran, $semester),
            'aktivitas_terbaru' => $this->getAktivitasTerbaru(),
        ];
    }

    /**
     * 1. Data untuk 4 Kartu Paling Atas
     */
    private function getQuickStats($tahunAjaran, $semester): array
    {
        $hariIni = Carbon::today();
        $totalSantri = SantriModel::count() ?? 0;
        $totalGuru = User::where('role', 3)->count() ?? 0;

        $santriBerhalangan = AbsensiSantriModel::whereDate('tanggal', $hariIni)
            ->whereIn('status', ['2', '3', '4'])
            ->count() ?? 0;

        $hadir = $totalSantri - $santriBerhalangan;
        $persenHadir = $totalSantri > 0 ? round(($hadir / $totalSantri) * 100) : 0;

        $raporTerisi = RaporModel::where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->count() ?? 0;

        $persenRapor = $totalSantri > 0 ? round(($raporTerisi / $totalSantri) * 100) : 0;

        return [
            'total_santri'       => $totalSantri,
            'total_guru'         => $totalGuru,
            'persen_hadir'       => $persenHadir,
            'santri_berhalangan' => $santriBerhalangan,
            'persen_rapor'       => $persenRapor,
            'rapor_terisi'       => $raporTerisi,
        ];
    }

    /**
     * 2. Data Grafik Kiri: Rata-rata Nilai per Kelas (Bar Chart)
     */
    private function getChartRataRataNilai($tahunAjaran, $semester): array
    {
        $kelasList = KelasModel::orderBy('nama_kelas')->get();
        $labels = [];
        $data = [];

        foreach ($kelasList as $kelas) {
            // Ambil rata-rata semua nilai ujian di kelas ini
            $rataRata = NilaiUjianModel::where('kelas_id', $kelas->id)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->avg('nilai') ?? 0;

            $labels[] = $kelas->nama_kelas;
            $data[] = round($rataRata, 2);
        }

        return [
            'labels' => $labels,
            'data'   => $data,
        ];
    }

    /**
     * 3. Data Grafik Tengah: Tren Kehadiran 7 Hari Terakhir (Line Chart)
     */
    private function getChartTrenKehadiran(): array
    {
        $labels = [];
        $data = [];
        $totalSantri = SantriModel::count() ?? 0;

        // Looping mundur dari 6 hari yang lalu sampai hari ini
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);

            $berhalangan = AbsensiSantriModel::whereDate('tanggal', $tanggal->toDateString())
                ->whereIn('status', ['2', '3', '4'])
                ->count() ?? 0;

            $hadir = $totalSantri - $berhalangan;
            $persen = $totalSantri > 0 ? round(($hadir / $totalSantri) * 100) : 0;

            // Masukkan ke array format Hari (Contoh: "Senin", "Selasa")
            $labels[] = $tanggal->translatedFormat('l');
            $data[] = $persen;
        }

        return [
            'labels' => $labels,
            'data'   => $data,
        ];
    }

    private function getChartKehadiranGuru(): array
    {
        $labels = [];
        $data = [];

        $totalGuru = User::where('role', 3)->count() ?? 0;

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $labels[] = $tanggal->translatedFormat('l');

            $guruBerhalangan = AbsensiGuruModel::whereDate('tanggal', $tanggal->toDateString())
                ->whereIn('status', ['2', '3', '4'])
                ->count() ?? 0;

            $guruHadir = $totalGuru - $guruBerhalangan;

            $persen = $totalGuru > 0 ? round(($guruHadir / $totalGuru) * 100) : 0;

            $data[] = $persen;
        }

        return [
            'labels' => $labels,
            'data'   => $data,
        ];
    }

    /**
     * 5. Data Tabel Bawah Kiri: Progres Pengisian Rapor per Kelas
     */
    private function getProgresNilaiKelas($tahunAjaran, $semester)
    {
        // Ambil data kelas beserta data User Wali Kelasnya
        $kelas = KelasModel::with('wali_kelas')->get();
        $progresList = [];

        foreach ($kelas as $k) {
            $jumlahSantri = SantriModel::where('kelas_id', $k->id)->count() ?? 0;

            $raporSelesai = RaporModel::where('kelas_id', $k->id)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->count() ?? 0;

            $persentase = $jumlahSantri > 0 ? round(($raporSelesai / $jumlahSantri) * 100) : 0;

            $progresList[] = [
                'nama_kelas'   => $k->nama_kelas,
                'wali_kelas'   => $k->wali_kelas ? $k->wali_kelas->name : 'Belum Diatur',
                'foto_wali'    => $k->wali_kelas ? $k->wali_kelas->foto : null, // Jika ada field foto
                'total_santri' => $jumlahSantri,
                'rapor_selesai' => $raporSelesai,
                'persentase'   => $persentase,
            ];
        }

        return $progresList;
    }

    /**
     * 6. Data Timeline Bawah Kanan: Aktivitas Sistem Terbaru
     */
    private function getAktivitasTerbaru()
    {
        return [
            [
                'icon'  => 'qr_code_scanner',
                'color' => 'success',
                'title' => 'Login QR Code Berhasil',
                'desc'  => 'Ust. Ahmad H. masuk ke sistem',
                'time'  => Carbon::now()->subMinutes(5)->diffForHumans()
            ],
            [
                'icon'  => 'print',
                'color' => 'info',
                'title' => 'Rapor Dicetak',
                'desc'  => 'Bu Inggrid mencetak rapor Kelas 3A',
                'time'  => Carbon::now()->subHours(1)->diffForHumans()
            ],
            [
                'icon'  => 'warning',
                'color' => 'danger',
                'title' => 'Peringatan Absensi',
                'desc'  => 'Santri a.n Budi (Alfa) 3 hari berturut-turut',
                'time'  => Carbon::now()->subHours(3)->diffForHumans()
            ],
            [
                'icon'  => 'smart_toy',
                'color' => 'primary',
                'title' => 'AI RAG Digunakan',
                'desc'  => 'Mencari "Aturan kelulusan pondok"',
                'time'  => Carbon::now()->subHours(5)->diffForHumans()
            ]
        ];
    }
}
