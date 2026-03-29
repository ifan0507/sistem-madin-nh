<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PengaturanModel;
use App\Services\NilaiUjianService;
use Illuminate\Http\Request;

class NilaiUjianWebController extends Controller
{
    public  function __construct(
        protected NilaiUjianService $nilai_ujian_service
    ) {}

    public function index(Request $request)
    {
        $active = (object)[
            'activePage' => 'ujian-nilai-ujian',
            'activePageMaster' => 'ujian-management',
        ];


        $pengaturan = PengaturanModel::first();
        $defaultTahun = $pengaturan ? $pengaturan->tahun_ajaran : '2025/2026';
        $defaultSemester = $pengaturan ? $pengaturan->semester : 'Ganjil';

        $tahunAjaran = $request->query('tahun_ajaran', $defaultTahun);
        $semester    = $request->query('semester', $defaultSemester);

        $monitoringData = $this->nilai_ujian_service->getNilaiUjian($tahunAjaran, $semester);

        return view('pages.nilai-ujian.index', [
            'active'      => $active,
            'tahunAjaran' => $tahunAjaran,
            'semester'    => $semester,
            'summary'     => $monitoringData['summary'],
            'dataKelas'   => $monitoringData['data_per_kelas'],
        ]);
    }

    public function getNilaiAjax(Request $request)
    {
        $kelasId     = $request->query('kelas_id');
        $mapelId     = $request->query('mapel_id');
        $tahunAjaran = $request->query('tahun_ajaran');
        $semester    = $request->query('semester');

        $dataNilai = $this->nilai_ujian_service->getDetailNilaiMapel($kelasId, $mapelId, $tahunAjaran, $semester);
        return response()->json([
            'status'     => 'success',
            'data'       => $dataNilai
        ]);
    }
}
