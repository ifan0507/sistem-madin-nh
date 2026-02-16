<?php

namespace App\Http\Controllers\Web;

use App\DTO\JadwalKBMDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalKBMRequest;
use App\Services\JadwalKbmService;
use App\Services\KelasService;
use App\Services\MapelKelasService;
use Illuminate\Http\Request;

class JadwalKbmWebController extends Controller
{
    public function __construct(
        protected JadwalKbmService $jadwalKbmService,
        protected KelasService $kelasService,
        protected MapelKelasService $mapelKelasService,
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

    public function getMapelKelasByKelas($kelas_id)
    {
        $data = $this->mapelKelasService->getMapelKelasByKelas($kelas_id);
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(JadwalKBMRequest $request)
    {
        $dto = JadwalKBMDto::fromRequest($request);
        $jadwal = $this->jadwalKbmService->createOrUpdate($dto);

        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal berhasil disimpan!',
            'data' => $jadwal
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
