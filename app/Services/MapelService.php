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
            'kkm',
        )->active()->orderby('created_at', 'asc')->get();
    }

    public function getById($id)
    {
        return MapelModel::select(
            'id',
            'kode_mapel',
            'nama_mapel',
            'kkm',
        )->findOrFail($id);
    }

    public function generateKodeMapel()
    {
        $lastMapel = MapelModel::orderBy('kode_mapel', 'desc')->first();

        if (!$lastMapel) {
            $kode = 'MP001';
        } else {
            $lastNumber = (int) substr($lastMapel->kode_mapel, 2);
            $nextNumber = $lastNumber + 1;
            $kode = 'MP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        return $kode;
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
        return $item->update(['deleted_at' => '1']);
    }
}
