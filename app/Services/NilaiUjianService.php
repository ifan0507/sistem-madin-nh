<?php

namespace App\Services;

use App\Dto\NilaiUjianDto;
use App\Models\MapelKelasModel;
use App\Models\NilaiUjianModel;
use App\Models\SantriModel;
use Illuminate\Support\Facades\DB;

class NilaiUjianService
{
    public function __construct(
        protected KelasService $kelas_service
    ) {}

    public function getNilaiUjian($tahunAjaran, $semester)
    {
        $kelas = $this->kelas_service->getAll();

        $santriPerKelas = SantriModel::select('kelas_id', DB::raw('count(*) as total'))
            ->groupBy('kelas_id')
            ->pluck('total', 'kelas_id');

        $semuaMapelKelas = MapelKelasModel::with(['mapel', 'guru'])->get();

        $progressNilai = NilaiUjianModel::where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->select('kelas_id', 'mapel_id', DB::raw('count(DISTINCT santri_id) as jumlah_dinilai'))
            ->groupBy('kelas_id', 'mapel_id')
            ->get()
            ->groupBy('kelas_id');

        $globalTotalMapel = 0;
        $globalSelesai = 0;

        $dataPerKelas = [];

        foreach ($kelas as $kls) {
            $totalSantri = $santriPerKelas->get($kls->id, 0);
            $mapelDiKelasIni = $semuaMapelKelas->where('kelas_id', $kls->id);

            $progressKelasIni = $progressNilai->get($kls->id, collect());

            $listMapel = [];

            foreach ($mapelDiKelasIni as $mk) {
                $globalTotalMapel++;

                $progressMapel = $progressKelasIni->where('mapel_id', $mk->mapel_id)->first();
                $jumlahDinilai = $progressMapel ? $progressMapel->jumlah_dinilai : 0;

                $status = 'Belum Diinput';
                $isLengkap = false;

                if ($jumlahDinilai > 0 && $jumlahDinilai < $totalSantri) {
                    $status = 'Draft';
                } elseif ($jumlahDinilai >= $totalSantri && $totalSantri > 0) {
                    $status = 'Selesai';
                    $isLengkap = true;
                    $globalSelesai++;
                }

                $listMapel[] = [
                    'mapel_id'       => $mk->mapel_id,
                    'kode_mapel'     => $mk->mapel->kode_mapel,
                    'nama_mapel'     => $mk->mapel->nama_mapel,
                    'guru_nama'      => $mk->guru->name ?? 'Belum Diatur',
                    'jumlah_dinilai' => $jumlahDinilai,
                    'total_santri'   => $totalSantri,
                    'status'         => $status,
                    'is_lengkap'     => $isLengkap,
                ];
            }

            $dataPerKelas[] = [
                'kelas_id'   => $kls->id,
                'nama_kelas' => $kls->nama_kelas,
                'list_mapel' => $listMapel,
            ];
        }

        return [
            'summary' => [
                'total_mapel' => $globalTotalMapel,
                'selesai'     => $globalSelesai,
                'belum'       => $globalTotalMapel - $globalSelesai,
            ],
            'data_per_kelas' => $dataPerKelas
        ];
    }

    public function getDetailNilaiMapel($kelasId, $mapelId, $tahunAjaran, $semester)
    {
        $daftarSantri = SantriModel::where('kelas_id', $kelasId)
            ->orderBy('nama', 'asc')
            ->get();

        $nilaiMasuk = NilaiUjianModel::with('guru')
            ->where('kelas_id', $kelasId)
            ->where('mapel_id', $mapelId)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->get()
            ->keyBy('santri_id');

        $hasil = $daftarSantri->map(function ($santri) use ($nilaiMasuk) {
            $dataNilai = $nilaiMasuk->get($santri->id);

            return [
                'nis'   => $santri->nis,
                'nama'  => $santri->nama,
                'nilai' => $dataNilai ? $dataNilai->nilai : null,
                'guru'  => $dataNilai && $dataNilai->guru ? $dataNilai->guru->name : '-'
            ];
        });

        return $hasil;
    }

    public function createBulk(NilaiUjianDto $data)
    {
        DB::beginTransaction();

        try {
            $savedData = [];

            foreach ($data->nilaiSantri as $item) {
                $savedData[] = NilaiUjianModel::updateOrCreate(
                    [
                        'santri_id'    => $item['santri_id'],
                        'mapel_id'     => $data->mapelId,
                        'kelas_id'     => $data->kelasId,
                        'tahun_ajaran' => $data->tahunAjaran,
                        'semester'     => $data->semester,
                    ],
                    [
                        'guru_id' => $data->guruId,
                        'nilai'   => $item['nilai'],
                    ]
                );
            }

            DB::commit();

            return $savedData;
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
