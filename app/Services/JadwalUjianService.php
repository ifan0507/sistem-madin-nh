<?php

namespace App\Services;

use App\Models\JadwalPengawasUjianModel;
use App\Models\JadwalUjianModel;
use App\Models\KelasModel;
use App\Models\RuangUjianModel;

class JadwalUjianService
{
    /**
     * Mengambil semua data
     */

    public function getJadwalAndPengawas()
    {
        $kelasList = KelasModel::orderBy('id', 'asc')->get();
        $ruangList = RuangUjianModel::orderBy('id', 'asc')->get();

        if (JadwalUjianModel::count() == 0 && $kelasList->isNotEmpty()) {
            $dataKosong = [];
            for ($hari = 1; $hari <= 6; $hari++) {
                foreach ($kelasList as $kelas) {
                    $dataKosong[] = [
                        'hari_ke'        => $hari,
                        'tanggal_ujian'  => null,
                        'kelas_id'       => $kelas->id,
                        'mapel_kelas_id' => null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }
            }
            JadwalUjianModel::insert($dataKosong);
        }

        if (JadwalPengawasUjianModel::count() == 0 && $ruangList->isNotEmpty()) {
            $dataKosongPengawas = [];
            for ($hari = 1; $hari <= 6; $hari++) {
                foreach ($ruangList as $ruang) {
                    $dataKosongPengawas[] = [
                        'hari_ke'       => $hari,
                        'tanggal_ujian' => null,
                        'ruang_id'      => $ruang->id,
                        'guru_id'   => null,
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ];
                }
            }
            JadwalPengawasUjianModel::insert($dataKosongPengawas);
        }

        $jadwalRaw = JadwalUjianModel::with(['mapel_kelas.mapel'])->get();
        $pengawasRaw = JadwalPengawasUjianModel::with(['guru'])->get();

        $jadwalPerHari = [];
        $tanggalPerHari = [];
        $pengawasPerHari = [];

        for ($hari = 1; $hari <= 6; $hari++) {
            $jadwalHariIni = $jadwalRaw->where('hari_ke', $hari)->keyBy('kelas_id');
            $jadwalPerHari[$hari] = $jadwalHariIni;
            $tanggalPerHari[$hari] = $jadwalHariIni->first()->tanggal_ujian ?? null;
            $pengawasPerHari[$hari] = $pengawasRaw->where('hari_ke', $hari)->keyBy('ruang_id');
        }

        return [
            'kelasList'       => $kelasList,
            'ruangList'       => $ruangList,
            'jadwalPerHari'   => $jadwalPerHari,
            'pengawasPerHari' => $pengawasPerHari,
            'tanggalPerHari'  => $tanggalPerHari,
        ];
    }


    public function updateTanggalUjian(int $hariKe, string $tanggal)
    {
        JadwalUjianModel::where('hari_ke', $hariKe)
            ->update([
                'tanggal_ujian' => $tanggal,
                'updated_at'    => now()
            ]);
    }

    public function updateMapel(int $jadwal_id, int $mapel_kelas_id)
    {
        JadwalUjianModel::where('id', $jadwal_id)
            ->update([
                'mapel_kelas_id' => $mapel_kelas_id,
                'updated_at'     => now()
            ]);
    }

    public function updatePengawas(int $guru_id, int $jadwal_pengawas_id)
    {
        JadwalPengawasUjianModel::where('id', $jadwal_pengawas_id)
            ->update([
                'guru_id' => $guru_id,
                'updated_at'  => now()
            ]);
    }
}
