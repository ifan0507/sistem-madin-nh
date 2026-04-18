<?php

namespace App\Services;

use App\Dto\JadwalKbmDto;
use App\Models\AbsensiGuruModel;
use App\Models\JadwalKBMModel;
use App\Models\KelasModel;
use Carbon\Carbon;

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


    public function getJadwalHariIni($guruId)
    {
        $hariInggris = date('l');
        $mapHari = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];
        $hariIni = $mapHari[$hariInggris];
        $tanggalHariIni = date('Y-m-d');

        $jadwal = JadwalKBMModel::with(['mapel_kelas.mapel', 'mapel_kelas.kelas'])
            ->whereHas('mapel_kelas', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->where('hari', $hariIni)
            ->get();

        $data = $jadwal->map(function ($item) use ($tanggalHariIni) {

            $absenHariIni = AbsensiGuruModel::where('mapel_kelas_id', $item->mapel_kelas_id)
                ->whereDate('tanggal', $tanggalHariIni)
                ->first();
            $sudahAbsen = $absenHariIni ? true : false;
            $jam_malam = in_array($item->mapel_kelas->kelas_id, [6, 7]);
            return [
                'jadwal_id'      => $item->id,
                'mapel_kelas_id' => $item->mapel_kelas_id,
                'nama_mapel'     => $item->mapel_kelas->mapel->nama_mapel ?? 'Tidak diketahui',
                'kelas_id'       => $item->mapel_kelas->kelas->id ?? '-',
                'jam_mulai'      => $jam_malam ? '23:00' : '15:30',
                'jam_selesai'    => $jam_malam ? '24:00' : '16:30',
                'sudah_absen'    => $sudahAbsen,
                'status_absen'   => $absenHariIni ? $absenHariIni->status : null,
                'ket_izin'       => ($absenHariIni && $absenHariIni->status == '2') ? $absenHariIni->ket_izin : null,
            ];
        });

        return [
            'hari'    => $hariIni,
            'tanggal' => Carbon::now()->isoFormat('D MMMM Y'),
            'jadwal'  => $data
        ];
    }

    public function getJadwalByGuru($guruId)
    {

        $jadwalRaw = JadwalKBMModel::with(['mapel_kelas.mapel', 'mapel_kelas.kelas', 'mapel_kelas.guru'])
            ->whereHas('mapel_kelas', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->orderBy('hari', 'asc')
            ->get();

        $jadwalFormatted = $jadwalRaw->map(function ($item) {
            $mapelKelas = $item->mapel_kelas;
            $jam_malam = in_array($item->mapel_kelas->kelas_id, [6, 7]);
            return [
                'hari'           => $item->hari,
                'kelas_id'       => $mapelKelas->kelas->id,
                'jam_mulai'      => $jam_malam ? '20:00' : '15:30',
                'jam_selesai'    => $jam_malam ? '21:00' : '16:30',
                'nama_mapel'     => $mapelKelas->mapel->nama_mapel,
            ];
        });

        return $jadwalFormatted;
    }

    /**
     * Menghapus data
     */
    public function delete($id)
    {
        return JadwalKBMModel::destroy($id);
    }
}
