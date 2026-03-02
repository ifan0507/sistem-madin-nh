<?php

namespace App\Http\Controllers\Api;

use App\DTO\BankSoalDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankSoalRequest;
use App\Services\BankSoalService;
use Illuminate\Http\Request;

class BankSoalApiController extends Controller
{
    public function __construct(
        protected BankSoalService $bankSoalService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Daftar Bank Soal',
            'data' => $this->bankSoalService->getAll(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankSoalRequest $request)
    {
        $dto = BankSoalDto::fromRequest($request);
        $data = $this->bankSoalService->create($dto);
        return response()->json([
            'message' => 'Bank Soal berhasil dibuat',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
