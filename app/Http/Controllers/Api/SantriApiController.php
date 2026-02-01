<?php

namespace App\Http\Controllers\Api;

use App\DTO\SantriDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\SantriRequest;
use App\Services\SantriService;

class SantriApiController extends Controller
{
    public function __construct(
        protected SantriService $santriService
    ) {}

    public function findAll()
    {
        $santris = $this->santriService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $santris
        ], 200);
    }

    public function findById($id)
    {
        $santri = $this->santriService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $santri
        ], 200);
    }

    public function store(SantriRequest $request)
    {
        $dto = SantriDto::fromRequest($request);
        $santri = $this->santriService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $santri
        ], 201);
    }

    public function update(SantriRequest $request, $id)
    {
        $dto = SantriDto::fromRequest($request);
        $this->santriService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Santri updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->santriService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Santri deleted successfully'
        ], 200);
    }
}
