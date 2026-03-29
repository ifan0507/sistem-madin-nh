<?php

namespace App\Services;

use App\Dto\RaporDto;
use App\Models\MapelKelasModel;
use App\Models\NilaiUjianModel;
use App\Models\RaporModel;
use App\Models\SantriModel;

class RaporService
{
    public function create(RaporDto $dto)
    {
        try {
            $rapor = RaporModel::updateOrCreate(
                [
                    'santri_id'    => $dto->santriId,
                    'kelas_id'     => $dto->kelasId,
                    'tahun_ajaran' => $dto->tahunAjaran,
                    'semester'     => $dto->semester,
                ],
                [
                    'absen_sakit'      => $dto->absenSakit,
                    'absen_izin'       => $dto->absenIzin,
                    'absen_alfa'       => $dto->absenAlfa,

                    'nilai_kerapian'   => $dto->nilaiKerapian,
                    'nilai_kerajinan'  => $dto->nilaiKerajinan,
                    'nilai_ketertiban' => $dto->nilaiKetertiban,

                    'catatan'          => $dto->catatan,
                    'is_naik_kelas'    => $dto->isNaikKelas,
                ]
            );

            return $rapor;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getDetailRaporSantri($santriId, $kelasId, $tahunAjaran, $semester)
    {
        try {
            $santri = SantriModel::findOrFail($santriId);

            $raporAdmin = RaporModel::where('santri_id', $santriId)
                ->where('kelas_id', $kelasId)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->first();

            $daftarMapelKelas = MapelKelasModel::with(['mapel', 'guru'])
                ->where('kelas_id', $kelasId)
                ->get();

            $nilaiUjian = NilaiUjianModel::where('santri_id', $santriId)
                ->where('kelas_id', $kelasId)
                ->where('tahun_ajaran', $tahunAjaran)
                ->where('semester', $semester)
                ->get()
                ->keyBy('mapel_id');

            $listNilai = $daftarMapelKelas->map(function ($mk) use ($nilaiUjian) {
                $recordNilai = $nilaiUjian->get($mk->mapel_id);

                return [
                    'mapel_id'    => $mk->mapel_id,
                    'nama_mapel'  => $mk->mapel->nama_mapel,
                    'kode_mapel'  => $mk->mapel->kode_mapel,
                    'guru_nama'   => $mk->guru->name ?? 'Belum ada guru',
                    'nilai_angka' => $recordNilai ? $recordNilai->nilai : null,
                    'status'      => $recordNilai ? 'Sudah Dinilai' : 'Belum Dinilai',
                ];
            });

            return [
                'santri'      => $santri,
                'rapor_admin' => $raporAdmin,
                'list_nilai'  => $listNilai,
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
