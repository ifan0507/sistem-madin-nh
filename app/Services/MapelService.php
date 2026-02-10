<?php

namespace App\Services;

use App\DTO\MapelDto;
use App\Models\MapelModel;

class MapelService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return MapelModel::select(
            'id',
            'kode_mapel',
            'nama_mapel',
        )->active()->orderby('created_at', 'asc')->get();
    }

    public function getById($id)
    {
        return MapelModel::select(
            'id',
            'kode_mapel',
            'nama_mapel',
        )->findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(MapelDto $data)
    {
        $payload = $data->toArray();
        return MapelModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, MapelDto $data)
    {
        $item = MapelModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete(int $id)
    {
        $item = MapelModel::findOrFail($id);
        return $item->update(['delete_at' => '1']);
    }
}
