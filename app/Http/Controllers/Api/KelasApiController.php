<?php

namespace App\Http\Controllers\Api;

use App\DTO\KelasDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\KelasRequest;
use App\Services\KelasService;
use Illuminate\Http\Request;

class KelasApiController extends Controller
{
    public function __construct(
        protected KelasService $kelasService
    ) {}

    public function findAll()
    {
        $kelas = $this->kelasService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $kelas
        ], 200);
    }

    public function findById($id)
    {
        $kelas = $this->kelasService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $kelas
        ], 200);
    }

    public function store(KelasRequest $request)
    {
        $dto = KelasDto::fromRequest($request);
        $kelas = $this->kelasService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $kelas
        ], 201);
    }

    public function update(KelasRequest $request, $id)
    {
        $dto = KelasDto::fromRequest($request);
        $this->kelasService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Kelas updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->kelasService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Kelas deleted successfully'
        ], 200);
    }
}
