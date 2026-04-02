<?php

namespace App\Http\Controllers\Api;

use App\DTO\RaporDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\RaporRequest;
use App\Services\RaporService;
use Illuminate\Http\Request;

class RaporApiController extends Controller
{
    public function __construct(
        protected RaporService $rapor_service
    ) {}

    // public function store(RaporRequest $request)
    // {
    //     $dto = RaporDto::fromRequest($request);
    //     $data = $this->rapor_service->create($dto);
    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $data
    //     ]);
    // }

    // public function getDetailRapor(Request $request, $kelasId, $santriId)
    // {
    //     try {
    //         $tahunAjaran = $request->query('tahun_ajaran');
    //         $semester    = $request->query('semester');

    //         if (!$tahunAjaran || !$semester) {
    //             return response()->json([
    //                 'status'  => 'error',
    //                 'message' => 'Parameter tahun_ajaran dan semester wajib diisi via query string!'
    //             ], 400);
    //         }

    //         $dataRapor = $this->rapor_service->getDetailRaporSantri(
    //             $santriId,
    //             $kelasId,
    //             $tahunAjaran,
    //             $semester
    //         );

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Detail rapor berhasil ditarik',
    //             'data'    => $dataRapor
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Gagal menarik data rapor: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
