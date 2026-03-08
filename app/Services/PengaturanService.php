<?php

namespace App\Services;

use App\Dto\PengaturanDto;
use App\Models\PengaturanModel;

class PengaturanService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return PengaturanModel::all();
    }

    public function getById($id)
    {
        return PengaturanModel::findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(PengaturanDto $data)
    {
        $payload = $data->toArray();
        // return Model::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, PengaturanDto $data)
    {
        $item = PengaturanModel::findOrFail($id);
        $payload = $data->toArray();
        $payload['is_active'] = true;
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        // return Model::destroy($id);
    }
}
