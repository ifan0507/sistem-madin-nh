<?php

namespace App\Http\Controllers\Web;

use App\DTO\MapelKelasDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapelKelasRequest;
use App\Services\MapelKelasService;
use App\Services\MapelService;
use App\Services\UserService;
use Illuminate\Http\Request;

class MapelKelasWebController extends Controller
{
    public function __construct(
        protected MapelKelasService $mapelKelasService,
        protected UserService $guruService,
        protected MapelService $mapelService,
    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'akademik-mapel-kelas',
            'activePageMaster' => 'akademik-management',
        ];
        $kelas = $this->mapelKelasService->getKelasCountMapel();
        return view('pages.mapel-kelas.index', [
            'active' => $active,
            'kelas' => $kelas,
        ]);
    }

    public function getMapelKelasByKelas($id)
    {
        $data = $this->mapelKelasService->getMapelKelasByKelas($id);
        return response()->json($data);
    }

    public function getAllGuru()
    {
        $data = $this->guruService->getAllGuru();
        return response()->json($data);
    }

    public function getAllMapel()
    {
        $data = $this->mapelService->getAll();
        return response()->json($data);
    }

    public function store(MapelKelasRequest $request)
    {
        $dto = MapelKelasDto::fromRequest($request);
        $data = $this->mapelKelasService->create($dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Data mata pelajaran berhasil ditambahkan ke kelas.',
            'data_id' => $data->id,
        ]);
    }

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
