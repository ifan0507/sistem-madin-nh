<?php

namespace App\Services;

use App\Dto\JadwalKbmDto;
use App\Models\JadwalKBMModel;

class JadwalKbmService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return JadwalKBMModel::select('hari', 'mapel_kelas_id')->with('mapel_kelas')->get();
    }

    public function getById($id)
    {
        return JadwalKBMModel::with('mapel_kelas')->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(JadwalKbmDto $data)
    {
        $payload = $data->toArray();
        return JadwalKBMModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, JadwalKbmDto $data)
    {
        $item = JadwalKBMModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return JadwalKBMModel::destroy($id);
    }
}
