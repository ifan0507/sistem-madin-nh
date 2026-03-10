<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        $data = $this->jadwalUjianService->getJadwalGrid();
        return view('pages.jadwal-ujian.index', [
            'active'         => $active,
            'kelasList'      => $data['kelasList'],
            'jadwalPerHari'  => $data['jadwalPerHari'],
            'tanggalPerHari' => $data['tanggalPerHari'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
