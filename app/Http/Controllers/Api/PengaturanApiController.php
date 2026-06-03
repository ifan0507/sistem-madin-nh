<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PengaturanService;
use Illuminate\Http\Request;

class PengaturanApiController extends Controller
{
    public function __construct(
        private PengaturanService $pengaturan_service
    ) {}

    public function getPengaturan()
    {
        $pengaturan = $this->pengaturan_service->getAll();

        return response()->json([
            'status' => 'success',
            'data' => $pengaturan
        ]);
    }
}
