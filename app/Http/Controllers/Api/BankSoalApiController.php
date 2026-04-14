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
        // return response()->json([
        //     'message' => 'Daftar Bank Soal',
        //     'data' => $this->bankSoalService->getAll(),
        // ]);
    }

    public function getBankSoalGuru($guruId)
    {
        try {
            $result = $this->bankSoalService->getBankSoalGuru($guruId);
            return response()->json([
                'status'       => 'success',
                'tahun_ajaran' => $result['tahun_ajaran'],
                'semester'     => $result['semester'],
                'data'         => $result['data']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memuat data: ' . $e->getMessage()
            ], 500);
        }
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

    public function show(Request $request)
    {
        try {
            $mapelKelasId = $request->query('mapel_kelas_id');
            $tahunAjaran = $request->query('tahun_ajaran');
            $semester = $request->query('semester');
            $data = $this->bankSoalService->getDataForMobile($mapelKelasId, $tahunAjaran, $semester);

            if (!$data) {
                return response()->json(['status' => 'error', 'message' => 'Soal belum dibuat'], 404);
            }
            return response()->json([
                'status' => 'success',
                'data' => [
                    'bank_soal_id' => $data->id,
                    'soal' => is_string($data->soal) ? json_decode($data->soal) : $data->soal
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generate(Request $request)
    {
        $data = $this->bankSoalService->generate($request->text);
        return response()->json([
            'status' => 'success',
            'text_pegon' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'soal' => 'required|array',
        ]);

        try {
            $this->bankSoalService->updateSoal($id, $request->soal);
            return response()->json([
                'status'  => 'success',
                'message' => 'Perubahan soal berhasil disimpan!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
