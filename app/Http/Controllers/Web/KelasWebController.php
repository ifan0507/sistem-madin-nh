<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\KelasService;
use App\Services\UserService;
use Illuminate\Http\Request;

class KelasWebController extends Controller
{
    public function __construct(
        protected KelasService $kelas_service,
        protected UserService $user_service
    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'akademik-kelas',
            'activePageMaster' => 'akademik-management',
        ];

        $kelas = $this->kelas_service->getAllKelasCountSantri();
        return view('pages.kelas.index', compact('active', 'kelas',));
    }

    public function getDataModalWali()
    {
        $kelas = $this->kelas_service->getAll();
        $gurus = $this->user_service->getAllGuru();

        return response()->json([
            'status' => 'success',
            'data' => [
                'kelas' => $kelas,
                'gurus' => $gurus
            ]
        ]);
    }

    public function getSantriByKelas($id)
    {
        $data = $this->kelas_service->getSantriByKelas($id);
        return response()->json($data);
    }

    public function updateWali(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'wali_kelas_id' => 'nullable|exists:users,id'
        ]);

        $result = $this->kelas_service->updateWaliKelas(
            $request->kelas_id,
            $request->wali_kelas_id
        );

        if ($result['success']) {
            return response()->json($result);
        }

        return response()->json($result, 500);
    }
}
