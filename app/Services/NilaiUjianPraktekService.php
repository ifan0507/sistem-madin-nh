<?php

namespace App\Services;

use App\Dto\NilaiUjianPraktekDto;
use App\Models\NilaiUjianPraktekModel;
use App\Models\SantriModel;
use Illuminate\Support\Facades\DB;

class NilaiUjianPraktekService
{
    /**
     * Mengambil semua data
     */
    public function getSantriForBulkInput(int $kelasId, string $tahunAjaran, string $semester)
    {
        return SantriModel::where('kelas_id', $kelasId)
            ->with(['nilai_praktek' => function ($query) use ($tahunAjaran, $semester) {
                $query->where('tahun_ajaran', $tahunAjaran)
                    ->where('semester', $semester);
            }])
            ->orderBy('nama', 'asc')
            ->get();
    }

    public function bulkStore(NilaiUjianPraktekDto $dto)
    {
        DB::beginTransaction();

        try {
            foreach ($dto->nilaiData as $item) {
                if (!is_null($item['al_quran']) || !is_null($item['kitab']) || !is_null($item['muhafadloh'])) {
                    NilaiUjianPraktekModel::updateOrCreate(
                        [
                            'santri_id'    => $item['santri_id'],
                            'tahun_ajaran' => $dto->tahunAjaran,
                            'semester'     => $dto->semester,
                        ],
                        [
                            'al_quran'     => $item['al_quran'],
                            'kitab'        => $item['kitab'],
                            'muhafadloh'   => $item['muhafadloh'],
                        ]
                    );
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        // return Model::destroy($id);
    }
}
