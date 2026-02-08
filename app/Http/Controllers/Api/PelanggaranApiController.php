<?php

namespace App\Http\Controllers\Api;

use App\DTO\PelanggaranDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\PelanggaranRequest;
use App\Services\PelanggaranService;
use Illuminate\Http\Request;

class PelanggaranApiController extends Controller
{
    public function __construct(
        protected PelanggaranService $pelanggaranService
    ) {}

    public function findAll()
    {
        $data = $this->pelanggaranService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function findById($id)
    {
        $data = $this->pelanggaranService->getById($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function store(PelanggaranRequest $request)
    {
        $dto = PelanggaranDto::fromRequest($request);
        $data = $this->pelanggaranService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 201);
    }

    public function update($id, PelanggaranRequest $request)
    {
        $dto = PelanggaranDto::fromRequest($request);
        $this->pelanggaranService->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Data pelanggaran berhasil diperbarui'
        ]);
    }


    public function delete($id)
    {
        $this->pelanggaranService->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Data pelanggaran berhasil dihapus'
        ]);
    }
}
