<?php

namespace App\Services;

use App\Dto\AbsensiSantriDto;
use App\Models\AbsensiSantriModel;
use App\Models\PengaturanModel;
use App\Models\SantriModel;
use Carbon\Carbon;

class AbsensiSantriService
{
    /**
     * Mengambil semua data
     */

    public function getAbsensiData($kelasId, $filter, $customDates = [])
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();
                break;
            case 'thismonth':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'lastmonth':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'last7days':
                $startDate = Carbon::today()->subDays(6);
                $endDate = Carbon::today();
                break;
            case 'last30days':
                $startDate = Carbon::today()->subDays(29);
                $endDate = Carbon::today();
                break;
            case 'daily':
                $startDate = Carbon::parse($customDates['daily_date']);
                $endDate = Carbon::parse($customDates['daily_date']);
                break;
            case 'weekly':
                if (!empty($customDates['weekly_date'])) {
                    $parts = explode('-W', $customDates['weekly_date']);
                    $startDate = Carbon::now()->setISODate($parts[0], $parts[1])->startOfWeek();
                    $endDate = Carbon::now()->setISODate($parts[0], $parts[1])->endOfWeek();
                }
                break;
            case 'monthly':
                if (!empty($customDates['monthly_date'])) {
                    $startDate = Carbon::parse($customDates['monthly_date'])->startOfMonth();
                    $endDate = Carbon::parse($customDates['monthly_date'])->endOfMonth();
                }
                break;
            case 'tahun_ajaran':
                $tahunAjaran = $customDates['ta_tahun'] ?? null;
                $semester = $customDates['ta_semester'] ?? null;

                $tanggalMulai = AbsensiSantriModel::where('kelas_id', $kelasId)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('semester', $semester)
                    ->min('tanggal');

                $tanggalAkhir = AbsensiSantriModel::where('kelas_id', $kelasId)
                    ->where('tahun_ajaran', $tahunAjaran)
                    ->where('semester', $semester)
                    ->max('tanggal');

                if ($tanggalMulai && $tanggalAkhir) {
                    $startDate = Carbon::parse($tanggalMulai)->startOfDay();
                    $endDate = Carbon::parse($tanggalAkhir)->endOfDay();
                } else {
                    $startDate = Carbon::today();
                    $endDate = Carbon::today();
                }
                break;
            case 'range':
                $startDate = Carbon::parse($customDates['range_start']);
                $endDate = Carbon::parse($customDates['range_end']);
                break;
        }

        $santri = SantriModel::where('kelas_id', $kelasId)->orderBy('nama', 'asc')->get();

        $absensiRaw = AbsensiSantriModel::where('kelas_id', $kelasId)
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->get();

        $absensiGrouped = [];

        $rekap = [];
        foreach ($santri as $s) {
            $rekap[$s->id] = ['hadir' => 0, 'sakit' => 0, 'izin' => 0, 'alfa' => 0];
        }

        foreach ($absensiRaw as $absen) {
            $absensiGrouped[$absen->santri_id][$absen->tanggal] = $absen->status;
            if (isset($rekap[$absen->santri_id])) {
                if ($absen->status == '1') $rekap[$absen->santri_id]['hadir']++;
                elseif ($absen->status == '2') $rekap[$absen->santri_id]['sakit']++;
                elseif ($absen->status == '3') $rekap[$absen->santri_id]['izin']++;
                elseif ($absen->status == '4') $rekap[$absen->santri_id]['alfa']++;
            }
        }

        $monthsChunk = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $monthKey = $currentDate->format('Y-m');
            $monthName = $currentDate->locale('id')->isoFormat('MMMM YYYY');

            $startBulanIni = $currentDate->copy()->startOfMonth()->max($startDate);
            $endBulanIni = $currentDate->copy()->endOfMonth()->min($endDate);

            $monthsChunk[$monthKey] = [
                'title' => $monthName,
                'start' => $startBulanIni,
                'end'   => $endBulanIni,
                'dates' => []
            ];

            $loopDate = $startBulanIni->copy();
            while ($loopDate->lte($endBulanIni)) {
                $monthsChunk[$monthKey]['dates'][] = [
                    'full_date' => $loopDate->format('Y-m-d'),
                    'day'       => $loopDate->format('d'),
                    'isJumat'   => $loopDate->isFriday()
                ];
                $loopDate->addDay();
            }

            $currentDate->addMonth()->startOfMonth();
        }

        return [
            'santri'  => $santri,
            'absensi' => $absensiGrouped,
            'months'  => $monthsChunk,
            'rekap'   => $rekap
        ];
    }


    public function getAll()
    {
        return AbsensiSantriModel::select('santri_id', 'status')->with('santri')->get();
    }

    public function getById($id)
    {
        return AbsensiSantriModel::with('santri')->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(AbsensiSantriDto $data)
    {
        $payload = $data->toArray();
        return AbsensiSantriModel::create($payload);
    }

    public function createBulkAbsensi($dto)
    {
        $pengaturan = PengaturanModel::first();
        $defaultTahun = $pengaturan ? $pengaturan->tahun_ajaran : '2025/2026';
        $defaultSemester = $pengaturan ? $pengaturan->semester : 'Ganjil';

        foreach ($dto->absensi as $item) {
            AbsensiSantriModel::updateOrCreate(
                [
                    'santri_id' => $item['santri_id'],
                    'kelas_id'  => $dto->kelas_id,
                    'tanggal'   => $dto->tanggal,
                ],
                [
                    'status'       => $item['status'],
                    'tahun_ajaran' => $defaultTahun,
                    'semester'     => $defaultSemester,
                ]
            );
        }

        return true;
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, AbsensiSantriDto $data)
    {
        $item = AbsensiSantriModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return AbsensiSantriModel::destroy($id);
    }
}
