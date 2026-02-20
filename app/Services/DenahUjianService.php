<?php

namespace App\Services;

use App\Dto\DenahUjianDto;
use App\Models\DenahUjianModel;
use App\Models\SantriModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DenahUjianService
{


    public function generate(DenahUjianDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            $totalKursi = $dto->total_kursi;

            $kelasIds = $dto->kelas_ids;
            $jumlahKelas = count($kelasIds);

            $existingDenahs = DenahUjianModel::get(['susunan_denah']);
            $usedSantriIds = [];
            $currentYear = date('Y');
            $maxSequence = 0;

            foreach ($existingDenahs as $denah) {
                $susunan = is_string($denah->susunan_denah) ? json_decode($denah->susunan_denah, true) : $denah->susunan_denah;
                if (!empty($susunan) && is_array($susunan)) {
                    foreach ($susunan as $seat) {
                        if (!empty($seat['santri_id'])) {
                            $usedSantriIds[] = $seat['santri_id'];
                            if (!empty($seat['nomor_ujian'])) {
                                $parts = explode('-', $seat['nomor_ujian']);
                                if (count($parts) == 2 && $parts[0] == $currentYear) {
                                    $seq = (int) $parts[1];
                                    if ($seq > $maxSequence) {
                                        $maxSequence = $seq;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $usedSantriIds = array_unique($usedSantriIds);

            $baseQuota = floor($totalKursi / $jumlahKelas);
            $sisaQuota = $totalKursi % $jumlahKelas;

            $kandidatPerKelas = [];

            foreach ($kelasIds as $index => $kelasId) {
                $limit = $baseQuota + ($index < $sisaQuota ? 1 : 0);

                if ($limit > 0) {
                    $santri = SantriModel::where('kelas_id', $kelasId)
                        ->whereNotIn('id', $usedSantriIds)
                        ->select(['id', 'nama', 'nis', 'kelas_id'])
                        ->inRandomOrder()
                        ->limit($limit)
                        ->get();

                    $kandidatPerKelas[$kelasId] = $santri;
                } else {
                    $kandidatPerKelas[$kelasId] = collect();
                }
            }

            $shuffledSantri = collect();
            $hasMore = true;

            while ($hasMore) {
                $hasMore = false;
                foreach ($kelasIds as $kelasId) {
                    if ($kandidatPerKelas[$kelasId]->isNotEmpty()) {
                        $shuffledSantri->push($kandidatPerKelas[$kelasId]->shift());
                        $hasMore = true;
                    }
                }
            }

            $susunanDenah = [];

            for ($i = 1; $i <= $totalKursi; $i++) {
                $santri = $shuffledSantri->get($i - 1);

                $nomorUjian = null;
                if ($santri) {
                    $maxSequence++;
                    $nomorUjian = $currentYear . '-' . str_pad($maxSequence, 3, '0', STR_PAD_LEFT);
                }
                $susunanDenah[] = [
                    'nomor_kursi' => $i,
                    'is_filled'   => $santri ? true : false,
                    'santri_id'   => $santri ? $santri->id : null,
                    'nama_santri' => $santri ? $santri->nama : 'KOSONG',
                    'nis'         => $santri ? $santri->nis : '-',
                    'kelas_id'    => $santri ? $santri->kelas_id : null,
                    'nomor_ujian' => $nomorUjian,
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

    public function acakUlang($id)
    {
        return DB::transaction(function () use ($id) {
            $denah = DenahUjianModel::findOrFail($id);
            $susunan = is_string($denah->susunan_denah) ? json_decode($denah->susunan_denah, true) : $denah->susunan_denah;

            $groupedStudents = [];
            $urutanNomorUjian = [];

            foreach ($susunan as $seat) {
                if ($seat['is_filled']) {
                    $groupedStudents[$seat['kelas_id']][] = $seat;
                    $urutanNomorUjian[] = $seat['nomor_ujian'];
                }
            }

            $kelasIds = array_keys($groupedStudents);
            foreach ($kelasIds as $kelasId) {
                shuffle($groupedStudents[$kelasId]);
            }

            $shuffledStudents = collect();
            $hasMore = true;

            while ($hasMore) {
                $hasMore = false;
                foreach ($kelasIds as $kelasId) {
                    if (count($groupedStudents[$kelasId]) > 0) {
                        $shuffledStudents->push(array_shift($groupedStudents[$kelasId]));
                        $hasMore = true;
                    }
                }
            }

            $newSusunan = [];
            $totalKursi = $denah->total_kursi;
            $nomorUjianIndex = 0;

            for ($i = 1; $i <= $totalKursi; $i++) {
                $santri = $shuffledStudents->get($i - 1);

                $newSusunan[] = [
                    'nomor_kursi' => $i,
                    'is_filled'   => $santri ? true : false,
                    'santri_id'   => $santri ? $santri['santri_id'] : null,
                    'nama_santri' => $santri ? $santri['nama_santri'] : 'KOSONG',
                    'nis'         => $santri ? $santri['nis'] : '-',
                    'kelas_id'    => $santri ? $santri['kelas_id'] : null,
                    'nomor_ujian' => $santri ? $urutanNomorUjian[$nomorUjianIndex++] : null,
                ];
            }

            $denah->update([
                'susunan_denah' => json_encode($newSusunan),
                'updated_at'    => Carbon::now(),
            ]);

            return true;
        });
    }

    public function getAll()
    {
        return DenahUjianModel::select('id', 'nama_ruangan', 'total_kursi', 'susunan_denah')->orderby('nama_ruangan')->get();
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
        return DenahUjianModel::destroy($id);
    }
}
