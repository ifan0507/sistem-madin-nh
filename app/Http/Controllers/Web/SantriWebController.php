<?php

namespace App\Http\Controllers\Web;

use App\DTO\SantriDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\SantriRequest;
use App\Services\KelasService;
use App\Services\SantriService;
use Illuminate\Http\Request;

class SantriWebController extends Controller
{
    public function __construct(
        protected SantriService $santri_service,
        protected KelasService $kelas_service
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active = (object)[
            'activePage' => 'santri',
            'activePageMaster' => 'user-management'
        ];

        $santris = $this->santri_service->getAll(); // Placeholder for santri data retrieval logic

        return view('pages.santri.index', ['active' => $active, 'santris' => $santris]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $active = (object)[
            'activePage' => 'santri',
            'activePageMaster' => 'user-management'
        ];

        $nis = $this->santri_service->generateNis();
        $kelas = $this->kelas_service->getAll();
        
        return view('pages.santri.form-santri', compact('active', 'kelas', 'nis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SantriRequest $request)
    {
        $dto = SantriDto::fromRequest($request);
        $this->santri_service->create($dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Santri berhasil ditambahkan',
            'redirect' => route('santri')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $active = (object)[
            'menu' => 'santri',
            'submenu' => '',
        ];

        $santri = $this->santri_service->getById($id);
        
        return view('pages.santri.detail-santri', compact('active', 'santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $active = (object)[
            'menu' => 'santri',
            'submenu' => '',
        ];

        $santri = $this->santri_service->getById($id);
        $kelas = $this->kelas_service->getAll();
        
        return view('pages.santri.edit-santri', compact('active', 'santri', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SantriRequest $request, string $id)
    {
        $dto = SantriDto::fromRequest($request);
        $this->santri_service->update($id, $dto);
        return response()->json([
            'success' => true,
            'message' => 'Data santri berhasil diperbarui',
            'redirect' => route('santri')
        ], 200);
    }

    public function updateKelasBulk(Request $request)
    {
        $request->validate([
            'santri_id'  => 'required|array',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $this->santri_service->updateKelasSantriBulk($request->santri_id, $request->kelas_id);
        return response()->json([
            'message' => count($request->santri_id) . ' Santri berhasil dipindah kelas!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $this->santri_service->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Santri berhasil dihapus'
        ]);
    }

    public function destroyKelas($id)
    {
        $this->santri_service->deleteKelas($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Santri berhasil dihapus dari kelas'
        ]);
    }
}
