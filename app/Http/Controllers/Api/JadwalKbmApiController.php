<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    public function jadwalHariIni(Request $request)
    {
        try {
            $guruId = $request->query('guru_id');

            if (!$guruId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ID Guru tidak ditemukan'
                ], 400);
            }

            $data = $this->jadwalKbmService->getJadwalHariIni($guruId);

            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getJadwalGuru(Request $request)
    {
        $guruId = $request->query('guru_id');

        if (!$guruId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'ID Guru wajib dikirim'
            ], 400);
        }

        try {
            $data = $this->jadwalKbmService->getJadwalByGuru($guruId);

            return response()->json([
                'status' => 'success',
                'data'   => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil jadwal: ' . $e->getMessage()
            ], 500);
        }
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
