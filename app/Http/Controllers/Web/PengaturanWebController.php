<?php

namespace App\Http\Controllers\Web;

use App\DTO\PengaturanDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengaturanRequest;
use App\Services\PengaturanService;
use Illuminate\Http\Request;

class PengaturanWebController extends Controller
{
    public function __construct(
        protected PengaturanService $pengaturan_service
    ) {}


    public function index()
    {
        $data = $this->pengaturan_service->getAll();
        $active = (object)[
            'activePage' => 'setting',
            'activePageMaster' => 'setting',
        ];
        return view('pages.pengaturan.index', [
            'active' => $active,
            'data' => $data
        ]);
    }

    public function update(Request $request)
    {
        $result = $this->pengaturan_service->updatePengaturan($request->all(), $request->tipe_update);
        if ($result['status']) {
            return response()->json([
                'status' => true,
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => $result['message']
        ]);
    }
}
