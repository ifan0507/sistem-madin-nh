<?php

namespace App\Http\Controllers\Api;

use App\DTO\AbsensiGuruDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbsensiGuruRequest;
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

    public function detailAbsensiFromGuru(Request $request)
    {
        $request->validate([
            'mapel_kelas_id' => 'required|integer',
            'kelas_id'       => 'required|integer',
            'tanggal'        => 'required|date'
        ]);

        try {
            $data = $this->absensiGuruService->getDetailAbsensi(
                $request->query('mapel_kelas_id'),
                $request->query('kelas_id'),
                $request->query('tanggal')
            );

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil detail absensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRekapBulanan(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|integer',
            'bulan'   => 'required|integer|min:1|max:12',
            'tahun'   => 'required|integer|min:2020'
        ]);

        try {
            $data = $this->absensiGuruService->getRekapBulanan(
                $request->query('guru_id'),
                $request->query('bulan'),
                $request->query('tahun')
            );

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil rekap absensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(AbsensiGuruRequest $request)
    {
        $dto = AbsensiGuruDto::fromRequest($request);
        $absensi_guru = $this->absensiGuruService->create($dto);
        return response()->json([
            'status' => 'success',
            'data' => $absensi_guru,
        ], 201);
    }

    public function update(AbsensiGuruRequest $request, $id)
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
