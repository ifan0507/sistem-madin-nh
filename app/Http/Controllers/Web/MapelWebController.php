<?php

namespace App\Http\Controllers\Web;

use App\DTO\MapelDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapelRequest;
use App\Services\MapelService;

class MapelWebController extends Controller
{
    public function __construct(
        protected MapelService $mapel_service
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = (object)[
            'activePage' => 'akademik-mapel',
            'activePageMaster' => 'akademik-management',
        ];
        $kode_mapel = $this->mapel_service->generateKodeMapel();
        $mapels = $this->mapel_service->getAll();

        return view('pages.mapel.index', compact('active', 'mapels', 'kode_mapel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MapelRequest $request)
    {
        $dto = MapelDto::fromRequest($request);
        $this->mapel_service->create($dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel berhasil ditambahkan',
        ], 201);
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
    public function update($id, MapelRequest $request)
    {
        $dto = MapelDto::fromRequest($request);
        $this->mapel_service->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel berhasil diubah',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->mapel_service->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel berhasil dihapus'
        ], 200);
    }
}
