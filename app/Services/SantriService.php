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
        )->with('kelas')->active()->orderBy('created_at', 'asc')->get();
    }
 
    public  function getById($id)
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
        )->with('kelas')->findOrFail($id);
    }

    public function generateNis()
    {
        $tahun = date('Y');

        $lastSantri = SantriModel::where('nis', 'like', $tahun . '%')
            ->orderBy('nis', 'desc')
            ->first();

        if ($lastSantri) {
            $lastNumber = (int) substr($lastSantri->nis, 4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $tahun . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
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

    public function updateKelasSantriBulk($santri_id, $kelas_id)
    {
        return SantriModel::whereIn('id', $santri_id)
            ->update(['kelas_id' => $kelas_id]);
    }

    /**
     * Menghapus data
     */
    public function delete(int $id)
    {
        $item = SantriModel::findOrFail($id);
        $item->update(['deleted_at' => '1']);
        return $item;
    }


    public function deleteKelas(int $id)
    {
        $item = SantriModel::findOrFail($id);
        return $item->update(['kelas_id' => null]);
    }
}

