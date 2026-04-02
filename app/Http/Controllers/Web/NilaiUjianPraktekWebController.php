<?php

namespace App\Http\Controllers\Web;

use App\DTO\NilaiUjianPraktekDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\NilaiUjianPraktekRequest;
use App\Models\PengaturanModel;
use App\Services\KelasService;
use App\Services\NilaiUjianPraktekService;
use Illuminate\Http\Request;

class NilaiUjianPraktekWebController extends Controller
{
    public function __construct(
        protected NilaiUjianPraktekService $nilai_ujian_praktek_service,
        protected KelasService $kelas_service
    ) {}

    public function index(Request $request)
    {
        $active = (object)[
            'activePage' => 'ujian-nilai-ujian-praktek',
            'activePageMaster' => 'laporan-management',
        ];

        $pengaturan = PengaturanModel::first();
        $defaultTahun = $pengaturan ? $pengaturan->tahun_ajaran : '2025/2026';
        $defaultSemester = $pengaturan ? $pengaturan->semester : 'Ganjil';

        $tahunAjaran = $request->query('tahun_ajaran', $defaultTahun);
        $semester    = $request->query('semester', $defaultSemester);

        $kelas = $this->kelas_service->getAllKelasCountSantri();;

        return view('pages.nilai-ujian-praktek.index', [
            'active'      => $active,
            'kelas'       => $kelas,
            'tahunAjaran' => $tahunAjaran,
            'semester'    => $semester,
        ]);
    }

    public function getSantriByKelas(Request $request, $kelasId)
    {
        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $santris = $this->nilai_ujian_praktek_service->getSantriForBulkInput($kelasId, $tahunAjaran, $semester);

        return response()->json([
            'status' => 'success',
            'data' => $santris
        ]);
    }

    public function storeBulk(NilaiUjianPraktekRequest $request)
    {
        try {
            $dto = NilaiUjianPraktekDto::fromRequest($request);
            $this->nilai_ujian_praktek_service->bulkStore($dto);

            return response()->json([
                'status'  => 'success',
                'message' => 'Nilai Ujian Praktek Berhasil Disimpan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Waduh, terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
