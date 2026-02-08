<?php

namespace App\Services;

use App\Dto\AbsensiSantriDto;
use App\Models\AbsensiSantriModel;

class AbsensiSantriService
{
    /**
     * Mengambil semua data
     */
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
