<?php

namespace App\Http\Controllers\Api;

use App\DTO\AbsensiGuruDto;
use App\Http\Controllers\Controller;
use App\Services\AbsensiGuruService;
use Illuminate\Http\Request;

class AbsensiGuruApiController extends Controller
{
    public function __construct(
        protected AbsensiGuruService $absensiGuruService
    ) {}

    public function findAll()
    {
        $absensi_guru = $this->absensiGuruService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $absensi_guru,
        ], 200);
    }

    public function findById($id)
    {
        $absensi_guru = $this->absensiGuruService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $absensi_guru,
        ], 200);
    }

    public function store(Request $request)
    {
        $dto = AbsensiGuruDto::fromRequest($request);
        $absensi_guru = $this->absensiGuruService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $absensi_guru,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $dto = AbsensiGuruDto::fromRequest($request);
        $this->absensiGuruService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Absensi Guru updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $this->absensiGuruService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Absensi Guru deleted successfully',
        ], 200);
    }
}
