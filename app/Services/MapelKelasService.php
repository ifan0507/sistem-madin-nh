<?php

namespace App\Services;

use App\Dto\MapelKelasDto;
use App\Models\MapelKelasModel;

class MapelKelasService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return MapelKelasModel::select(
            'semester',
            'tahun_ajaran',
            'guru_id',
            'kelas_id',
            'mapel_id',
            'deleted_at'
        )->with(['kelas', 'mapel', 'guru'])->get();
    }

    public function getById($id)
    {
        return MapelKelasModel::with(['kelas', 'mapel', 'guru'])->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(MapelKelasDto $data)
    {
        $payload = $data->toArray();
        return MapelKelasModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, MapelKelasDto $data)
    {
        $item = MapelKelasModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        $item = MapelKelasModel::findOrFail($id);
        return $item->update(['deleted_at' => '1']);
    }
}
