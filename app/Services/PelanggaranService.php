<?php

namespace App\Services;

use App\Dto\PelanggaranDto;
use App\Models\PelanggaranModel;

class PelanggaranService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return PelanggaranModel::select(
            'santri_id',
            'nama_pelanggaran',
            'pengurus_id'
        )->with('santri', 'pengurus')->get();
    }

    public function getById($id)
    {
        return PelanggaranModel::with('santri', 'pengurus')->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(PelanggaranDto $data)
    {
        $payload = $data->toArray();
        return PelanggaranModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, PelanggaranDto $data)
    {
        $item = PelanggaranModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return PelanggaranModel::destroy($id);
    }
}
