<?php

namespace App\Http\Controllers\Api;

use App\DTO\MapelKelasDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapelKelasRequest;
use App\Services\MapelKelasService;
use Illuminate\Http\Request;

class MapelKelasApiController extends Controller
{
    public function __construct(
        private readonly MapelKelasService $mapelKelasService
    ) {}

    public function findAll()
    {
        $mapel_kelas = $this->mapelKelasService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $mapel_kelas
        ], 200);
    }

    public function findById($id)
    {
        $mapel_kelas = $this->mapelKelasService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $mapel_kelas
        ], 200);
    }

    public function store(MapelKelasRequest $request)
    {
        $dto = MapelKelasDto::fromRequest($request);
        $mapel_kelas = $this->mapelKelasService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $mapel_kelas
        ], 201);
    }

    public function update(MapelKelasRequest $request, $id)
    {
        $dto = MapelKelasDto::fromRequest($request);
        $this->mapelKelasService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel Kelas updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->mapelKelasService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel Kelas deleted successfully'
        ], 200);
    }
}
