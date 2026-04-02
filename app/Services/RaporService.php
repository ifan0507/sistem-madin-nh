<?php

namespace App\Services;

use App\Dto\RaporDto;
use App\Models\KelasModel;
use App\Models\MapelKelasModel;
use App\Models\NilaiUjianModel;
use App\Models\NilaiUjianPraktekModel;
use App\Models\RaporModel;
use App\Models\SantriModel;

class RaporService
{

    public function getSantriWithRaporStatus($kelasId, $tahunAjaran, $semester)
    {
        $santri = SantriModel::where('kelas_id', $kelasId)->orderBy('nama', 'asc')->get();

        $raporTerbuat = RaporModel::where('kelas_id', $kelasId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->pluck('id', 'santri_id');

        return $santri->map(function ($s) use ($raporTerbuat) {
            return [
                'id'        => $s->id,
                'nis'       => $s->nis,
                'nama'      => $s->nama,
                'has_rapor' => $raporTerbuat->has($s->id),
            ];
        });
    }

    public function generateBulkRapor($kelasId, $tahunAjaran, $semester)
    {
        $santris = SantriModel::where('kelas_id', $kelasId)->get();

        $jumlahDibuat = 0;

        foreach ($santris as $santri) {
            $raporAda = RaporModel::where('santri_id', $santri->id)
                ->where('kelas_id', $kelasId)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->exists();

            if (!$raporAda) {
                RaporModel::create([
                    'santri_id'    => $santri->id,
                    'kelas_id'     => $kelasId,
                    'tahun_ajaran' => $tahunAjaran,
                    'semester'     => $semester,
                    'sikap_kerapian'   => 'B',
                    'sikap_kerajinan'  => 'B',
                    'sikap_ketertiban' => 'B',
                    'absen_sakit'      => 0,
                    'absen_izin'       => 0,
                    'absen_alfa'       => 0,
                    'catatan'          => 'Tingkatkan terus semangat belajarmu dan pertahankan prestasimu.',
                    'peringkat'        => 0
                ]);
                $jumlahDibuat++;
            }
        }

        return $jumlahDibuat;
    }

    public function getDetailRaporLengkap($kelasId, $santriId, $tahunAjaran, $semester)
    {
        $santri = SantriModel::findOrFail($santriId);
        $kelas = KelasModel::with('wali_kelas')->findOrFail($kelasId);

        $nilaiSantri = NilaiUjianModel::where('kelas_id', $kelasId)
            ->where('santri_id', $santriId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()->keyBy('mapel_id');

        $nilaiPraktek = NilaiUjianPraktekModel::where('santri_id', $santriId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->first();

        $santriIdsDiKelas = SantriModel::where('kelas_id', $kelasId)->pluck('id');

        $rataPraktekQuran = NilaiUjianPraktekModel::whereIn('santri_id', $santriIdsDiKelas)
            ->where('tahun_ajaran', $tahunAjaran)->where('semester', $semester)
            ->avg('al_quran') ?? 0;

        $rataPraktekKitab = NilaiUjianPraktekModel::whereIn('santri_id', $santriIdsDiKelas)
            ->where('tahun_ajaran', $tahunAjaran)->where('semester', $semester)
            ->avg('kitab') ?? 0;

        $rataPraktekMuhafadloh = NilaiUjianPraktekModel::whereIn('santri_id', $santriIdsDiKelas)
            ->where('tahun_ajaran', $tahunAjaran)->where('semester', $semester)
            ->avg('muhafadloh') ?? 0;

        $mapelKelas = MapelKelasModel::with('mapel')->where('kelas_id', $kelasId)->get();

        $listNilai = [];
        $totalNilai = 0;

        if ($nilaiPraktek) {
            $totalNilai += ($nilaiPraktek->al_quran ?? 0);
            $totalNilai += ($nilaiPraktek->kitab ?? 0);
            $totalNilai += ($nilaiPraktek->muhafadloh ?? 0);
        }

        foreach ($mapelKelas as $mk) {
            $mapelId = $mk->mapel_id;
            $nilaiAngka = isset($nilaiSantri[$mapelId]) ? $nilaiSantri[$mapelId]->nilai : 0;

            $totalNilai += $nilaiAngka;

            $rataKelas = NilaiUjianModel::where('kelas_id', $kelasId)
                ->where('mapel_id', $mapelId)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->avg('nilai') ?? 0;

            $listNilai[] = [
                'nama_mapel' => $mk->mapel->nama_mapel,
                'kkm'        => $mk->mapel->kkm ?? 70,
                'angka'      => $nilaiAngka,
                'huruf'      => angkaKeHuruf($nilaiAngka),
                'rata_kelas' => round($rataKelas, 2),
            ];
        }

        $semuaNilaiReguler = NilaiUjianModel::where('kelas_id', $kelasId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()
            ->groupBy('santri_id');

        $semuaNilaiPraktek = NilaiUjianPraktekModel::whereIn('santri_id', $santriIdsDiKelas)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()
            ->keyBy('santri_id');

        $rekapTotalKelas = [];
        foreach ($santriIdsDiKelas as $sId) {
            $total = 0;

            if (isset($semuaNilaiReguler[$sId])) {
                $total += $semuaNilaiReguler[$sId]->sum('nilai');
            }
            if (isset($semuaNilaiPraktek[$sId])) {
                $total += ($semuaNilaiPraktek[$sId]->al_quran ?? 0);
                $total += ($semuaNilaiPraktek[$sId]->kitab ?? 0);
                $total += ($semuaNilaiPraktek[$sId]->muhafadloh ?? 0);
            }

            $rekapTotalKelas[$sId] = $total;
        }

        arsort($rekapTotalKelas);

        $peringkat = 1;
        $peringkatSantriIni = '-';
        $nilaiSebelumnya = null;
        $peringkatAsli = 1;

        foreach ($rekapTotalKelas as $id => $total) {
            if ($nilaiSebelumnya !== null && $total < $nilaiSebelumnya) {
                $peringkatAsli = $peringkat;
            }

            if ($id == $santriId) {
                $peringkatSantriIni = $peringkatAsli;
                break;
            }

            $peringkat++;
            $nilaiSebelumnya = $total;
        }

        $rapor = RaporModel::where('santri_id', $santriId)
            ->where('kelas_id', $kelasId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->first();

        return [
            'santri' => $santri,
            'kelas'  => $kelas,
            'tahun_ajaran' => $tahunAjaran,
            'semester' => $semester,
            'list_nilai' => $listNilai,
            'total_nilai' => $totalNilai,
            'peringkat' => $peringkatSantriIni,
            'rapor' => $rapor,
            'nilaiPraktek' => $nilaiPraktek,
            'rataPraktekQuran' => round($rataPraktekQuran, 2),
            'rataPraktekKitab' => round($rataPraktekKitab, 2),
            'rataPraktekMuhafadloh' => round($rataPraktekMuhafadloh, 2),
        ];
    }

    public function generateRankingList($kelasId, $tahunAjaran, $semester)
    {
        $santris = SantriModel::where('kelas_id', $kelasId)->get()->keyBy('id');
        $santriIds = $santris->keys();

        $semuaNilaiReguler = NilaiUjianModel::where('kelas_id', $kelasId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()->groupBy('santri_id');

        $semuaNilaiPraktek = NilaiUjianPraktekModel::whereIn('santri_id', $santriIds)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()->keyBy('santri_id');

        $rekap = [];

        foreach ($santris as $sId => $santri) {
            $total = 0;

            if (isset($semuaNilaiReguler[$sId])) {
                $total += $semuaNilaiReguler[$sId]->sum('nilai');
            }
            if (isset($semuaNilaiPraktek[$sId])) {
                $total += ($semuaNilaiPraktek[$sId]->al_quran ?? 0);
                $total += ($semuaNilaiPraktek[$sId]->kitab ?? 0);
                $total += ($semuaNilaiPraktek[$sId]->muhafadloh ?? 0);
            }

            $rekap[] = [
                'santri_id'   => $sId,
                'nis'         => $santri->nis,
                'nama'        => $santri->nama,
                'total_nilai' => $total,
            ];
        }

        usort($rekap, function ($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        $peringkat = 1;
        $peringkatAsli = 1;
        $nilaiSebelumnya = null;

        foreach ($rekap as $key => $data) {
            if ($nilaiSebelumnya !== null && $data['total_nilai'] < $nilaiSebelumnya) {
                $peringkatAsli = $peringkat;
            }
            $rekap[$key]['peringkat'] = $peringkatAsli;

            $peringkat++;
            $nilaiSebelumnya = $data['total_nilai'];
        }

        return $rekap;
    }
}
