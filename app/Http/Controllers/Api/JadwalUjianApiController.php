<?php

namespace App\Http\Controllers\Api;

use App\DTO\JadwalUjianDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalUjianRequest;
use App\Services\JadwalUjianService;
use Illuminate\Http\Request;

class JadwalUjianApiController extends Controller
{
    public function __construct(
        protected JadwalUjianService $jadwalUjianService
    ) {}

    public function findAll()
    {
        $jadwal_ujian = $this->jadwalUjianService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $jadwal_ujian,
        ], 200);
    }

    public function findById($id)
    {
        $jadwal_ujian = $this->jadwalUjianService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $jadwal_ujian,
        ], 200);
    }

    public function store(JadwalUjianRequest $request)
    {
        $dto = JadwalUjianDto::fromRequest($request);
        $jadwal_ujian = $this->jadwalUjianService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $jadwal_ujian,
        ], 201);
    }

    public function update(JadwalUjianRequest $request, $id)
    {
        $dto = JadwalUjianDto::fromRequest($request);
        $this->jadwalUjianService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal Ujian updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $this->jadwalUjianService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Jadwal Ujian deleted successfully',
        ], 200);
    }
}
