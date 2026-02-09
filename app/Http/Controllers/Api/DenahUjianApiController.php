<?php

namespace App\Http\Controllers\Api;

use App\DTO\DenahUjianDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\DenahUjianRequest;
use App\Services\DenahUjianService;
use Illuminate\Http\Request;

class DenahUjianApiController extends Controller
{
    public function __construct(
        protected DenahUjianService $denahService
    ) {}

    public function findAll()
    {
        $denah = $this->denahService->getAll();
        return response()->json([
            'status' => 'success',
            'data' => $denah,
        ], 200);
    }

    public function store(DenahUjianRequest $request)
    {
        $dto = DenahUjianDto::fromRequest($request);

        // 2. Eksekusi Service
        $this->denahService->generate($dto);

        return response()->json([
            'status' => 'success',
            'message' => 'Denah ujian berhasil digenerate dari 7 kelas secara merata.',
        ], 201);
    }
}
