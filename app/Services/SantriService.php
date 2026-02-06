<?php

namespace App\Services;

use App\Dto\SantriDto;
use App\Models\SantriModel;

class SantriService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return SantriModel::select(
            'id',
            'nama',
            'nis',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'ayah',
            'ibu',
            'no_telp',
            'jenis_kelamin',
            'thn_angkatan',
            'kelas_id',
        )->with('kelas')->get();
    }

    public  function getById($id)
    {
        return SantriModel::select(
            'nama',
            'nis',
            'nik',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'ayah',
            'ibu',
            'no_telp',
            'jenis_kelamin',
            'thn_angkatan',
            'kelas_id',
        )->with('kelas')->findOrFail($id);
    }


    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(SantriDto $data)
    {
        $payload = $data->toArray();
        return SantriModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update(int $id, SantriDto $data)
    {
        $item = SantriModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete(int $id)
    {
        $item = SantriModel::findOrFail($id);
        return $item->update(['deleted_at' => 1]);
    }
}
