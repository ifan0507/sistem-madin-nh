<?php

namespace App\Services;

use App\Dto\JadwalUjianDto;
use App\Models\JadwalUjianModel;
use App\Models\KelasModel;

class JadwalUjianService
{
    /**
     * Mengambil semua data
     */

    public function getJadwalGrid()
    {
        $kelasList = KelasModel::orderBy('id', 'asc')->get();

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

        $jadwalRaw = JadwalUjianModel::with(['mapel_kelas.mapel'])->get();

        $jadwalPerHari = [];
        $tanggalPerHari = [];

        for ($hari = 1; $hari <= 6; $hari++) {
            $jadwalHariIni = $jadwalRaw->where('hari_ke', $hari)->keyBy('kelas_id');
            $jadwalPerHari[$hari] = $jadwalHariIni;

            $tanggalPerHari[$hari] = $jadwalHariIni->first()->tanggal_ujian ?? null;
        }

        return [
            'kelasList'      => $kelasList,
            'jadwalPerHari'  => $jadwalPerHari,
            'tanggalPerHari' => $tanggalPerHari,
        ];
    }

    public function getAll()
    {
        return JadwalUjianModel::select('tanggal_ujian', 'mapel_kelas_id')->with('mapel_kelas')->get();
    }

    public function getById($id)
    {
        return JadwalUjianModel::with('mapel_kelas')->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(JadwalUjianDto $data)
    {
        $payload = $data->toArray();
        return JadwalUjianModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, JadwalUjianDto $data)
    {
        $item = JadwalUjianModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return JadwalUjianModel::destroy($id);
    }
}
