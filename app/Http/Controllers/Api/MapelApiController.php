<?php

namespace App\Http\Controllers\Api;

use App\DTO\MapelDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MapelRequest;
use App\Services\MapelService;
use Illuminate\Http\Request;

class MapelApiController extends Controller
{
    public function __construct(
        protected MapelService $mapelService
    ) {}
    public function findAll()
    {
        $mapel = $this->mapelService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $mapel
        ], 200);
    }

    public function findById($id)
    {
        $mapel = $this->mapelService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $mapel
        ], 200);
    }

    public function strore(MapelRequest $request)
    {
        $dto = MapelDto::fromRequest($request);
        $mapel = $this->mapelService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $mapel
        ], 201);
    }

    public function update(MapelRequest $request, $id)
    {
        $dto = MapelDto::fromRequest($request);
        $this->mapelService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->mapelService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Mapel deleted successfully'
        ], 200);
    }
}
