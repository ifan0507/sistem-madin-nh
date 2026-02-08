<?php

namespace App\Http\Controllers\Api;

use App\DTO\JadwalKBMDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalKBMRequest;
use App\Services\JadwalKbmService;
use Illuminate\Http\Request;

class JadwalKbmApiController extends Controller
{
    public function __construct(
        protected JadwalKbmService $jadwalKbmService
    ) {}

    public function findAll()
    {
        $jadwa_kbm = $this->jadwalKbmService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $jadwa_kbm
        ], 200);
    }

    public function findById($id)
    {
        $jadwa_kbm = $this->jadwalKbmService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $jadwa_kbm
        ], 200);
    }

    public function store(JadwalKBMRequest $request)
    {
        $dto = JadwalKBMDto::fromRequest($request);
        $jadwa_kbm = $this->jadwalKbmService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $jadwa_kbm
        ], 201);
    }

    public function update(JadwalKBMRequest $request, $id)
    {
        $dto = JadwalKBMDto::fromRequest($request);
        $this->jadwalKbmService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal KBM updated successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $this->jadwalKbmService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal KBM deleted successfully'
        ], 200);
    }
}
