<?php

namespace App\Services;

use App\Dto\JadwalKbmDto;
use App\Models\JadwalKBMModel;
use App\Models\KelasModel;

class JadwalKbmService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return JadwalKBMModel::select('hari', 'mapel_kelas_id')->with([
            'jadwal_kbms.mapel_kelas.mapel',
            'jadwal_kbms.mapel_kelas.guru'
        ])->get();
    }

    public function getById($id)
    {
        return JadwalKBMModel::with('mapel_kelas')->findOrFail($id);
    }

    public function getDataCetak(): array
    {
        $kelas = KelasModel::with([
            'jadwal_kbms.mapel_kelas.mapel',
            'jadwal_kbms.mapel_kelas.guru'
        ])->orderBy('id', 'asc')->get();

        return [
            'kelas' => $kelas,
        ];
    }
    /**
     * Menyimpan data baru berdasarkan DTO
     */
    public function createOrUpdate(JadwalKbmDto $data,)
    {
        return JadwalKBMModel::updateOrCreate(
            ['id' => $data->getId()],
            $data->toArray()
        );
    }

    /**
     * Fungsi untuk mencari semua ID jadwal yang gurunya mengajar lebih dari 1 kali 
     * di hari dan sesi (pagi/malam) yang sama.
     */
    public function getJadwalBentrokIds(): array
    {
        $jadwalBentrokIds = [];

        $semuaJadwal = JadwalKBMModel::with(['mapel_kelas'])->get();

        $hari_list = ['Sabtu', 'Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis'];

        foreach ($hari_list as $hari) {
            $guru_per_hari = [];

            $jadwalHariIni = $semuaJadwal->where('hari', $hari);

            foreach ($jadwalHariIni as $jdwl) {
                if ($jdwl->mapel_kelas) {
                    $guruId = $jdwl->mapel_kelas->guru_id;

                    $kelasId = $jdwl->mapel_kelas->kelas_id;

                    $isKelasMalam = in_array($kelasId, [6, 7]);

                    if (!isset($guru_per_hari[$guruId])) {
                        $guru_per_hari[$guruId] = ['pagi' => [], 'malam' => []];
                    }

                    if ($isKelasMalam) {
                        $guru_per_hari[$guruId]['malam'][] = $jdwl->id;
                    } else {
                        $guru_per_hari[$guruId]['pagi'][] = $jdwl->id;
                    }
                }
            }

            foreach ($guru_per_hari as $guruId => $jadwalGuru) {
                if (count($jadwalGuru['pagi']) > 1) {
                    $jadwalBentrokIds = array_merge($jadwalBentrokIds, $jadwalGuru['pagi']);
                }

                if (count($jadwalGuru['malam']) > 1) {
                    $jadwalBentrokIds = array_merge($jadwalBentrokIds, $jadwalGuru['malam']);
                }
            }
        }

        return $jadwalBentrokIds;
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return JadwalKBMModel::destroy($id);
    }
}
