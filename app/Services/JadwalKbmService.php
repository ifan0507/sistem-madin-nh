<?php

namespace App\Services;

use App\Dto\JadwalKbmDto;
use App\Models\JadwalKBMModel;
use App\Models\MapelKelasModel;

class JadwalKbmService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return JadwalKBMModel::select('hari', 'mapel_kelas_id')->with([
            'jadwal_kbms.mapel_kelas.mapel',
            'jadwal_kbms.mapel_kelas.guru'
        ])->get();
    }

    public function getById($id)
    {
        return JadwalKBMModel::with('mapel_kelas')->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function createOrUpdate(JadwalKbmDto $data,)
    {
        return JadwalKBMModel::updateOrCreate(
            ['id' => $data->getId()],
            $data->toArray()
        );
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return JadwalKBMModel::destroy($id);
    }
}
