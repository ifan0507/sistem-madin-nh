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

    public function update($id, PengaturanRequest $request)
    {
        $dto = PengaturanDto::fromRequest($request);
        $data = $this->pengaturan_service->update($id, $dto);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
