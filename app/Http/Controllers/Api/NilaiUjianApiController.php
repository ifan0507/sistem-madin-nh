<?php

namespace App\Http\Controllers\Api;

use App\DTO\NilaiUjianDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\NilaiUjianRequest;
use App\Services\NilaiUjianService;
use Illuminate\Http\Request;

class NilaiUjianApiController extends Controller
{

    public function __construct(
        protected NilaiUjianService $nilai_ujian_service
    ) {}

    public function store(NilaiUjianRequest $request)
    {
        $dto = NilaiUjianDto::fromRequest($request);
        $data =  $this->nilai_ujian_service->createBulk($dto);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getMapelNilaiUjian(Request $request)
    {
        $guruId = $request->query('guru_id');

        if (!$guruId) {
            return response()->json(['status' => 'error', 'message' => 'guru_id wajib dikirim'], 400);
        }

        try {
            $data = $this->nilai_ujian_service->getListNilaiMapelGuru($guruId);

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil data mapel: ' . $e->getMessage()
            ], 500);
        }
    }

    public function detailNilai(Request $request)
    {
        $request->validate([
            'kelas_id'     => 'required|integer',
            'mapel_id'     => 'required|integer',
            'tahun_ajaran' => 'required|string',
            'semester'     => 'required|string'
        ]);

        try {
            $data = $this->nilai_ujian_service->getDetailNilaiForMobile(
                $request->query('kelas_id'),
                $request->query('mapel_id'),
                $request->query('tahun_ajaran'),
                $request->query('semester')
            );

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil detail nilai: ' . $e->getMessage()
            ], 500);
        }
    }
}
