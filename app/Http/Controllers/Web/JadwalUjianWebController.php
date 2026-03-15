<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\JadwalUjianRequest;
use App\Http\Requests\UpdateJadwalPengawasUjianRequest;
use App\Http\Requests\UpdateMapelJadwalUjianRequest;
use App\Services\JadwalUjianService;
use Illuminate\Http\Request;

class JadwalUjianWebController extends Controller
{
    public function __construct(protected JadwalUjianService $jadwalUjianService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = (object)[
            'activePage' => 'ujian-jadwal-ujian',
            'activePageMaster' => 'ujian-management',
        ];
        $data = $this->jadwalUjianService->getJadwalAndPengawas();
        return view('pages.jadwal-ujian.index', [
            'active'         => $active,
            'kelasList'      => $data['kelasList'],
            'ruangList'      => $data['ruangList'],
            'jadwalPerHari'  => $data['jadwalPerHari'],
            'pengawasPerHari' => $data['pengawasPerHari'],
            'tanggalPerHari' => $data['tanggalPerHari'],
        ]);
    }

    public function updateTanggal(JadwalUjianRequest $request)
    {
        try {
            $this->jadwalUjianService->updateTanggalUjian($request->hari_ke, $request->tanggal);

            return response()->json([
                'status'  => 'success',
                'message' => 'Tanggal ujian berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateMapel(UpdateMapelJadwalUjianRequest $request)
    {
        try {
            $this->jadwalUjianService->updateMapel($request->jadwal_id, $request->mapel_kelas_id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Mata pelajaran berhasil diupdate!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePengawas(UpdateJadwalPengawasUjianRequest $request)
    {
        try {
            $this->jadwalUjianService->updatePengawas($request->guru_id, $request->jadwal_pengawas_id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Pengawas ujian berhasil diatur!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
