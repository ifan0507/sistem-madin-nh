<?php

namespace App\Services;

use App\Dto\DenahUjianDto;
use App\Models\DenahUjianModel;
use App\Models\KelasModel;
use App\Models\SantriModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DenahUjianService
{


    public function generate(DenahUjianDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            $totalKursi = (int) $dto->total_kursi;

            $existingDenahs = DenahUjianModel::get(['susunan_denah']);
            $usedSantriIds = [];

            foreach ($existingDenahs as $denah) {
                if (!empty($denah->susunan_denah) && is_array($denah->susunan_denah)) {
                    foreach ($denah->susunan_denah as $seat) {
                        if (!empty($seat['santri_id'])) {
                            $usedSantriIds[] = $seat['santri_id'];
                        }
                    }
                }
            }

            $usedSantriIds = array_unique($usedSantriIds);

            $kelasIds = KelasModel::pluck('id')->toArray();
            $jumlahKelas = count($kelasIds);


            $baseQuota = floor($totalKursi / $jumlahKelas);
            $sisaQuota = $totalKursi % $jumlahKelas;

            $kandidatSantri = collect();

            foreach ($kelasIds as $index => $kelasId) {
                $limit = $baseQuota + ($index < $sisaQuota ? 1 : 0);

                if ($limit > 0) {
                    $santri = SantriModel::where('kelas_id', $kelasId)
                        ->whereNotIn('id', $usedSantriIds)
                        ->select(['id', 'nama', 'nis', 'kelas_id'])
                        ->inRandomOrder()
                        ->limit($limit)
                        ->get();

                    $kandidatSantri = $kandidatSantri->merge($santri);
                }
            }

            $shuffledSantri = $kandidatSantri->shuffle();
            $susunanDenah = [];

            for ($i = 1; $i <= $totalKursi; $i++) {
                $santri = $shuffledSantri->get($i - 1);

                $susunanDenah[] = [
                    'nomor_kursi' => $i,
                    'is_filled'   => $santri ? true : false,
                    'santri_id'   => $santri ? $santri->id : null,
                    'nama_santri' => $santri ? $santri->nama : 'KOSONG',
                    'nis'         => $santri ? $santri->nis : '-',
                    'kelas_id'    => $santri ? $santri->kelas_id : null,
                ];
            }

            DenahUjianModel::insert([
                'nama_ruangan'  => $dto->nama_ruangan,
                'total_kursi'   => $dto->total_kursi,
                'susunan_denah' => json_encode($susunanDenah),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);

            return true;
        });
    }


    public function getAll()
    {
        return DenahUjianModel::select('id', 'nama_ruangan', 'total_kursi', 'susunan_denah')->get();
    }

    public function getById($id)
    {
        // return Model::findOrFail($id);
    }

    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function create(DenahUjianDto $data)
    {
        $payload = $data->toArray();
        // return Model::create($payload);
    }

    /**
     * Memperbarui data berdasarkan ID dan DTO
     */
    public function update($id, DenahUjianDto $data)
    {
        // $item = Model::findOrFail($id);
        $payload = $data->toArray();
        // return $item->update($payload);
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        // return Model::destroy($id);
    }
}
