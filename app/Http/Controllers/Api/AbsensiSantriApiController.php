<?php

namespace App\Http\Controllers\Api;

use App\DTO\AbsensiSantriDto;
use App\Http\Controllers\Controller;
use App\Services\AbsensiSantriService;
use Illuminate\Http\Request;

class AbsensiSantriApiController extends Controller
{
    public function __construct(
        protected AbsensiSantriService $absensiSantriService
    ) {}

    public function findAll()
    {
        $absensi_santri = $this->absensiSantriService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $absensi_santri,
        ], 200);
    }

    public function findById($id)
    {
        $absensi_santri = $this->absensiSantriService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $absensi_santri,
        ], 200);
    }

    public function store(Request $request)
    {
        $dto = AbsensiSantriDto::fromRequest($request);
        $absensi_santri = $this->absensiSantriService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $absensi_santri,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $dto = AbsensiSantriDto::fromRequest($request);
        $this->absensiSantriService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Absensi Santri updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $this->absensiSantriService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Absensi Santri deleted successfully',
        ], 200);
    }
}
