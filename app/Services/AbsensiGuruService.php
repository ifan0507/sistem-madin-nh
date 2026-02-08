<?php

namespace App\Services;

use App\Dto\AbsensiGuruDto;
use App\Models\AbsensiGuruModel;

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

    public function getById($id)
    {
        return AbsensiGuruModel::with('mapel_kelas')->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(AbsensiGuruDto $data)
    {
        $payload = $data->toArray();
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
