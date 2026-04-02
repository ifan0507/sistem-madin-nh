<?php

namespace App\Http\Controllers\Web;

use App\DTO\JadwalKBMDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalKBMRequest;
use App\Services\JadwalKbmService;
use App\Services\KelasService;

class JadwalKbmWebController extends Controller
{
    public function __construct(
        protected JadwalKbmService $jadwalKbmService,
        protected KelasService $kelasService,
    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'akademik-jadwal-kbm',
            'activePageMaster' => 'akademik-management',
        ];

        $kelas = $this->kelasService->getAll();

        return view('pages.jadwal-kbm.index', [
            'active' => $active,
            'kelas' => $kelas,
        ]);
    }

    public function cetak()
    {
        $data = $this->jadwalKbmService->getDataCetak();
        return view('pages.jadwal-kbm.cetak', [
            'kelas' => $data['kelas'],
        ]);
    }

    public function store(JadwalKBMRequest $request)
    {
        $dto = JadwalKBMDto::fromRequest($request);
        $jadwal = $this->jadwalKbmService->createOrUpdate($dto);

        $bentrokIds = $this->jadwalKbmService->getJadwalBentrokIds();

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil disimpan!',
            'data' => $jadwal,
            'bentrok_ids' => $bentrokIds
        ]);
    }
}
