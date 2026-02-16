<?php

namespace App\Services;

use App\Dto\MapelKelasDto;
use App\Models\JadwalKBMModel;
use App\Models\KelasModel;
use App\Models\MapelKelasModel;
use Illuminate\Support\Facades\DB;

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

    public function getMapelKelasByKelas($id)
    {
        return MapelKelasModel::select(
            'mapel_kelas.id',
            'mapel_kelas.guru_id',
            'mapel_kelas.kelas_id',
            'mapel_kelas.mapel_id',
        )
            ->join('mapels', 'mapels.id', '=', 'mapel_kelas.mapel_id')
            ->with(['mapel', 'guru'])
            ->active()
            ->where('mapel_kelas.kelas_id', $id)
            ->orderBy('mapels.kode_mapel', 'asc')
            ->get();
    }

    public function getKelasCountMapel()
    {
        return KelasModel::select('id', 'nama_kelas')
            ->withCount('mapel_kelas')
            ->get();
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
        DB::beginTransaction();

        try {
            $item = MapelKelasModel::findOrFail($id);
            JadwalKBMModel::where('mapel_kelas_id', $id)->delete();
            $item->update(['deleted_at' => '1']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
