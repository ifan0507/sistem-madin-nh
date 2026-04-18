<?php

namespace App\Services;

use App\Dto\AbsensiGuruDto;
use App\Models\AbsensiGuruModel;
use App\Models\AbsensiSantriModel;
use App\Models\JadwalKBMModel;
use App\Models\MapelKelasModel;
use App\Models\PengaturanModel;
use App\Models\SantriModel;
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

    public function getRekapBulanan($guruId, $bulan, $tahun)
    {
        $absensiRaw = AbsensiGuruModel::with(['mapel_kelas.mapel', 'mapel_kelas.kelas'])
            ->whereHas('mapel_kelas', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $jadwalGuru = JadwalKBMModel::with(['mapel_kelas.mapel', 'mapel_kelas.kelas'])
            ->whereHas('mapel_kelas', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId);
            })
            ->get();

        $hariMap = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];

        $detail = [];
        $summary = ['hadir' => 0, 'izin' => 0, 'alfa' => 0];

        $jumlahHari = Carbon::createFromDate($tahun, $bulan, 1)->daysInMonth;
        $hariIni = Carbon::now();

        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tanggalLoop = Carbon::createFromDate($tahun, $bulan, $i);
            $tanggalString = $tanggalLoop->format('Y-m-d');
            $namaHariLoop = $hariMap[$tanggalLoop->dayOfWeek];

            $jadwalHariIni = $jadwalGuru->filter(function ($j) use ($namaHariLoop) {
                return strtolower(trim($j->hari)) === strtolower($namaHariLoop);
            });

            foreach ($jadwalHariIni as $jadwal) {
                $recordAbsen = $absensiRaw->filter(function ($absen) use ($tanggalString, $jadwal) {
                    $absenTanggal = $absen->tanggal instanceof \Carbon\Carbon
                        ? $absen->tanggal->format('Y-m-d')
                        : substr((string)$absen->tanggal, 0, 10);

                        return $absenTanggal === $tanggalString &&
                        $absen->mapel_kelas_id == $jadwal->mapel_kelas_id;
                })->first();

                if ($recordAbsen) {
                    $statusArr = ['1' => 'hadir', '2' => 'izin', '3' => 'alfa'];
                    $statusString = $statusArr[$recordAbsen->status] ?? 'none';

                    $detail[] = [
                        'tanggal'    => $tanggalString,
                        'status'     => $statusString,
                        'nama_mapel' => $jadwal->mapel_kelas->mapel->nama_mapel,
                        'kelas_id'   => $jadwal->mapel_kelas->kelas->id,
                        'keterangan' => ($recordAbsen->status == '2') ? $recordAbsen->ket_izin : null,
                    ];

                    if (isset($summary[$statusString])) $summary[$statusString]++;
                } else {
                    if ($tanggalLoop->startOfDay()->lte($hariIni->startOfDay())) {
                        $detail[] = [
                            'tanggal'    => $tanggalString,
                            'status'     => 'alfa',
                            'nama_mapel' => $jadwal->mapel_kelas->mapel->nama_mapel,
                            'kelas_id'   => $jadwal->mapel_kelas->kelas->id,
                            'keterangan' => 'Tanpa Keterangan',
                        ];

                        $summary['alfa']++;
                    }
                }
            }
        }

        $firstRecord = $absensiRaw->first();

        return [
            'semester'     => $firstRecord->semester ?? 'Ganjil',
            'tahun_ajaran' => $firstRecord->tahun_ajaran ?? '2025/2026',
            'summary'      => $summary,
            'detail'       => collect($detail)->sortByDesc('tanggal')->values()->all()
        ];
    }

    public function getDetailAbsensi($mapelKelasId, $kelasId, $tanggal)
    {
        $absensiGuru = AbsensiGuruModel::where('mapel_kelas_id', $mapelKelasId)
            ->where('tanggal', $tanggal)
            ->first();

        $absensiSantri = AbsensiSantriModel::where('kelas_id', $kelasId)
            ->where('tanggal', $tanggal)
            ->get()
            ->keyBy('santri_id');

        $santri = SantriModel::select('id', 'nis', 'nama')
            ->where('kelas_id', $kelasId)
            ->orderBy('nama', 'asc')
            ->get();

        $detailSantri = $santri->map(function ($s) use ($absensiSantri) {
            $statusKehadiran = isset($absensiSantri[$s->id]) ? $absensiSantri[$s->id]->status : 1;

            return [
                'santri' => [
                    'id'   => $s->id,
                    'nis'  => $s->nis,
                    'nama' => $s->nama,
                ],
                'status' => $statusKehadiran
            ];
        });

        return [
            'materi_pembelajaran' => $absensiGuru ? $absensiGuru->materi_pembelajaran : '',
            'list_absensi'        => $detailSantri
        ];
    }


    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(AbsensiGuruDto $data)
    {
        $pengaturan = PengaturanModel::first();
        $payload = $data->toArray();

        $tahun_ajaran = $pengaturan ? $pengaturan->tahun_ajaran : '2025/2026';
        $semester = $pengaturan ? $pengaturan->semester : 'Ganjil';

        return AbsensiGuruModel::updateOrCreate(
            [
                'mapel_kelas_id' => $payload['mapel_kelas_id'],
                'tanggal'        => $payload['tanggal'],
            ],
            [
                'status'              => $payload['status'],
                'materi_pembelajaran' => $payload['materi_pembelajaran'] ?? null,
                'ket_izin'            => $payload['ket_izin'] ?? null,
                'tahun_ajaran'        => $tahun_ajaran,
                'semester'            => $semester,
            ]
        );
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
