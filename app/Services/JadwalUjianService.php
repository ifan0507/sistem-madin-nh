<?php

namespace App\Services;

use App\Dto\JadwalUjianDto;
use App\Models\JadwalUjianModel;

class JadwalUjianService
{
    /**
     * Mengambil semua data
     */
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
