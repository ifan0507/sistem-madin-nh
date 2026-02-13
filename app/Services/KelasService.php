<?php

namespace App\Services;

use App\Dto\KelasDto;
use App\Models\KelasModel;
use App\Models\SantriModel;

class KelasService
{
    /**
     * Mengambil semua data
     */

    public function getAll()
    {
        return KelasModel::select('id', 'nama_kelas')->get();
    }

    public function getAllKelasCountSantri()
    {
        return KelasModel::select('id', 'nama_kelas')->withCount('santri')->get();
    }

    public function getById($id)
    {
        return KelasModel::select('id', 'nama_kelas')->findOrFail($id);
    }

    public function getSantriByKelas($kelas_id)
    {
        return SantriModel::select(
            'id',
            'nis',
            'nama'
        )->where('kelas_id', $kelas_id)->orderby('nama', 'asc')->get();
    }
    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(KelasDto $data)
    {
        $payload = $data->toArray();
        return KelasModel::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, KelasDto $data)
    {
        $item = KelasModel::findOrFail($id);
        $payload = $data->toArray();
        return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        $item = KelasModel::findOrFail($id);
        return $item->update(['delete_at' => '1']);
    }
}
