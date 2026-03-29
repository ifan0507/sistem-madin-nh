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
}
