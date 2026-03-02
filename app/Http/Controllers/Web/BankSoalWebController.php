<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\BankSoalService;
use Illuminate\Http\Request;

class BankSoalWebController extends Controller
{
    public function __construct(
        protected BankSoalService $bank_soal_service,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = (object)[
            'activePage' => 'ujian-bank-soal',
            'activePageMaster' => 'ujian-management',
        ];

        $data = $this->bank_soal_service->getBankSoal();
        return view('pages.bank-soal.index', [
            'active'            => $active,
            'kelasList'         => $data['kelasList'],
            'mapelPerKelas'     => $data['mapelPerKelas'],
            'totalMapel'        => $data['totalMapel'],
            'sudahMengumpulkan' => $data['sudahMengumpulkan'],
            'belumMengumpulkan' => $data['belumMengumpulkan'],
        ]);
    }


    public function cetakSoal($id)
    {
        try {
            $data = $this->bank_soal_service->getDataCetakSoal($id);

            return view('pages.bank-soal.cetak-soal', [
                'mapel_kelas' => $data['mapel_kelas'],
                'bank_soal'   => $data['bank_soal']
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat soal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $active = (object)[
            'activePage' => 'ujian-bank-soal',
            'activePageMaster' => 'ujian-management',
        ];
        try {
            $data = $this->bank_soal_service->getDataCetakSoal($id);

            return view('pages.bank-soal.preview', [
                'active'      => $active,
                'mapel_kelas' => $data['mapel_kelas'],
                'bank_soal'   => $data['bank_soal']
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat soal: ' . $e->getMessage());
        }
    }

    public function generate(Request $request)
    {
        $data = $this->bank_soal_service->generate($request->text);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
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
            $this->bank_soal_service->updateSoal($id, $request->soal);
            return response()->json([
                'status'  => 'success',
                'message' => 'Perubahan soal berhasil disimpan!',
                'print_url' => route('bank-soal.cetak', $id)
            ]);
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
