<?php

namespace App\Services;

use App\Dto\AbsensiGuruDto;
use App\Models\AbsensiGuruModel;
use App\Models\JadwalKBMModel;
use App\Models\MapelKelasModel;
use App\Models\PengaturanModel;
use Carbon\Carbon;

class AbsensiGuruService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return AbsensiGuruModel::select(
            'mapel_kelas_id',
            'status',
            'materi_pembelajaran',
            'ket_izin',
        )->with('mapel_kelas')->get();
    }


    public function generateRekap($guruId, $filter, $customDates = [])
    {
        $dateRange = $this->parseDateRange($guruId, $filter, $customDates);
        $startDate = $dateRange['start'];
        $endDate   = $dateRange['end'];

        $listMapel = MapelKelasModel::with(['mapel', 'kelas'])
            ->where('guru_id', $guruId)
            ->get()
            ->sortBy(function ($item) {
                return $item->kelas->nama_kelas ?? '';
            })->values();

        $mapelIds = $listMapel->pluck('id')->toArray();

        $jadwalRaw = JadwalKBMModel::whereIn('mapel_kelas_id', $mapelIds)->get();
        $jadwalGrouped = [];
        foreach ($jadwalRaw as $jadwal) {
            $jadwalGrouped[$jadwal->mapel_kelas_id][] = strtolower(trim($jadwal->hari));
        }

        $absensiRaw = AbsensiGuruModel::whereIn('mapel_kelas_id', $mapelIds)
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        $absensiGrouped = [];
        foreach ($absensiRaw as $absen) {
            $absensiGrouped[$absen->mapel_kelas_id][$absen->tanggal] = $absen;
        }

        $rekapBulanan = [];
        $hariIni = Carbon::today();
        Carbon::setLocale('id');

        $currentPeriod = $startDate->copy()->startOfMonth();

        while ($currentPeriod->startOfMonth()->lte($endDate->copy()->startOfMonth())) {

            $monthStart = $currentPeriod->copy()->startOfMonth();
            $monthEnd   = $currentPeriod->copy()->endOfMonth();

            if ($monthStart->lt($startDate)) $monthStart = $startDate->copy();
            if ($monthEnd->gt($endDate))   $monthEnd   = $endDate->copy();
            $periodeBulanIni = $monthStart->translatedFormat('d M Y') . ' - ' . $monthEnd->translatedFormat('d M Y');
            $bulanNama = $currentPeriod->translatedFormat('F Y');
            $bulanKey  = $currentPeriod->format('Y-m');

            $dataRekapBulanIni = [];
            $maxPertemuanPerMinggu = [];
            $grandTotalBulanIni = ['hadir' => 0, 'izin' => 0, 'alpha' => 0];
            $startWeek = $monthStart->copy()->startOfWeek();

            foreach ($listMapel as $mapel) {
                $jadwalMapelIni = $jadwalGrouped[$mapel->id] ?? [];
                $pertemuanMapel = [];
                $pertemuanKe = 1;
                $rekapMapel = ['hadir' => 0, 'izin' => 0, 'alpha' => 0];

                $loopDate = $monthStart->copy();
                while ($loopDate->lte($monthEnd)) {
                    $namaHari = strtolower($loopDate->translatedFormat('l'));

                    if (in_array($namaHari, $jadwalMapelIni)) {
                        $tanggalStr = $loopDate->format('Y-m-d');
                        $status = null;
                        $materi = null;
                        $ket = null;

                        if (isset($absensiGrouped[$mapel->id][$tanggalStr])) {
                            $dataAbsen = $absensiGrouped[$mapel->id][$tanggalStr];
                            $status = $dataAbsen->status;
                            $materi = $dataAbsen->materi_pembelajaran;
                            $ket    = $dataAbsen->ket_izin;
                        } elseif ($loopDate->lt($hariIni)) {
                            $status = '3';
                        }

                        if ($status == '1') {
                            $rekapMapel['hadir']++;
                            $grandTotalBulanIni['hadir']++;
                        } elseif ($status == '2') {
                            $rekapMapel['izin']++;
                            $grandTotalBulanIni['izin']++;
                        } elseif ($status == '3') {
                            $rekapMapel['alpha']++;
                            $grandTotalBulanIni['alpha']++;
                        }

                        $currentWeek = $loopDate->copy()->startOfWeek();
                        $mingguKe = $startWeek->diffInWeeks($currentWeek) + 1;

                        if (!isset($pertemuanMapel[$mingguKe])) {
                            $pertemuanMapel[$mingguKe] = [];
                        }

                        $pertemuanMapel[$mingguKe][] = [
                            'pertemuan_ke' => $pertemuanKe,
                            'tanggal'      => $tanggalStr,
                            'format_tgl'   => $loopDate->translatedFormat('D, d M'),
                            'status'       => $status,
                            'materi'       => $materi,
                            'ket'          => $ket
                        ];
                        $pertemuanKe++;
                    }
                    $loopDate->addDay();
                }

                foreach ($pertemuanMapel as $mKe => $arrPertemuan) {
                    $jml = count($arrPertemuan);
                    if (!isset($maxPertemuanPerMinggu[$mKe]) || $jml > $maxPertemuanPerMinggu[$mKe]) {
                        $maxPertemuanPerMinggu[$mKe] = $jml;
                    }
                }

                $dataRekapBulanIni[] = [
                    'mapel_info'           => $mapel,
                    'pertemuan_per_minggu' => $pertemuanMapel,
                    'rekap'                => $rekapMapel
                ];
            }

            if (!empty($maxPertemuanPerMinggu)) {
                ksort($maxPertemuanPerMinggu);
                $rekapBulanan[$bulanKey] = [
                    'nama_bulan'            => $bulanNama,
                    'dataRekap'             => $dataRekapBulanIni,
                    'maxPertemuanPerMinggu' => $maxPertemuanPerMinggu,
                    'grandTotal'            => $grandTotalBulanIni,
                    'periode_bulan'         => $periodeBulanIni,
                ];
            }

            $currentPeriod->addMonth();
        }

        $stringPeriode = $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');

        return [
            'rekapBulanan'  => $rekapBulanan,
            'stringPeriode' => $stringPeriode
        ];
    }

    private function parseDateRange($guruId, $filter, $customDates)
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate   = Carbon::now()->endOfMonth();

        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate   = Carbon::today();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate   = Carbon::yesterday();
                break;
            case 'thismonth':
                $startDate = Carbon::now()->startOfMonth();
                $endDate   = Carbon::now()->endOfMonth();
                break;
            case 'lastmonth':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate   = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'last7days':
                $startDate = Carbon::today()->subDays(6);
                $endDate   = Carbon::today();
                break;
            case 'last30days':
                $startDate = Carbon::today()->subDays(29);
                $endDate   = Carbon::today();
                break;
            case 'daily':
                $startDate = Carbon::parse($customDates['daily_date']);
                $endDate   = Carbon::parse($customDates['daily_date']);
                break;
            case 'weekly':
                if (!empty($customDates['weekly_date'])) {
                    $parts = explode('-W', $customDates['weekly_date']);
                    $startDate = Carbon::now()->setISODate($parts[0], $parts[1])->startOfWeek();
                    $endDate   = Carbon::now()->setISODate($parts[0], $parts[1])->endOfWeek();
                }
                break;
            case 'monthly':
                if (!empty($customDates['monthly_date'])) {
                    $startDate = Carbon::parse($customDates['monthly_date'])->startOfMonth();
                    $endDate   = Carbon::parse($customDates['monthly_date'])->endOfMonth();
                }
                break;
            case 'tahun_ajaran':
                $tahunAjaran = $customDates['ta_tahun'] ?? null;
                $semester = $customDates['ta_semester'] ?? null;

                $absenGuru = AbsensiGuruModel::whereHas('mapel_kelas', function ($q) use ($guruId) {
                    $q->where('guru_id', $guruId);
                })
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('semester', $semester);

                $tanggalMulai = $absenGuru->min('tanggal');
                $tanggalAkhir = $absenGuru->max('tanggal');

                if ($tanggalMulai && $tanggalAkhir) {
                    $startDate = Carbon::parse($tanggalMulai)->startOfDay();
                    $endDate   = Carbon::parse($tanggalAkhir)->endOfDay();
                } else {
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate   = Carbon::now()->endOfMonth();
                }
                break;
            case 'range':
                $startDate = Carbon::parse($customDates['range_start']);
                $endDate   = Carbon::parse($customDates['range_end']);
                break;
        }

        return ['start' => $startDate, 'end' => $endDate];
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(AbsensiGuruDto $data)
    {
        $pengaturan = PengaturanModel::first();
        $payload = $data->toArray();

        $payload['tahun_ajaran'] = $pengaturan->tahun_ajaran;
        $payload['semester'] = $pengaturan->semester;

        return AbsensiGuruModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, AbsensiGuruDto $data)
    {
        $item = AbsensiGuruModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return AbsensiGuruModel::destroy($id);
    }
}
