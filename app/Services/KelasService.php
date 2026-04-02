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
        $kelas = KelasModel::select('id', 'nama_kelas', 'wali_kelas_id')
            ->with('wali_kelas')
            ->get();

        return $kelas->sortBy(function ($k) {
            $nama = strtolower(trim($k->nama_kelas));
            if ($nama === 'sifir' || $nama === '0') return 0;
            return (int) $nama;
        })->values();
    }

    public function getAllKelasCountSantri()
    {
        $kelas =  KelasModel::select('id', 'nama_kelas')->withCount('santri')->get();
        return $kelas->sortBy(function ($k) {
            $nama = strtolower(trim($k->nama_kelas));
            if ($nama === 'sifir' || $nama === '0') return 0;
            return (int) $nama;
        })->values();
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

    public function updateWaliKelas($kelasId, $waliKelasId)
    {
        try {
            $kelas = KelasModel::findOrFail($kelasId);

            $kelas->wali_kelas_id = $waliKelasId ?: null;
            $kelas->save();

            return [
                'success' => true,
                'message' => 'Wali Kelas ' . getKelasArab($kelasId) . ' berhasil diperbarui.'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan sistem.'
            ];
        }
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        $item = KelasModel::findOrFail($id);
        return $item->update(['deleted_at' => '1']);
    }
}
