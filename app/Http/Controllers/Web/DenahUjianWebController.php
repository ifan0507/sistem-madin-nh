<?php

namespace App\Http\Controllers\Web;

use App\DTO\DenahUjianDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\DenahUjianRequest;
use App\Services\DenahUjianService;
use App\Services\KelasService;
use Illuminate\Http\Request;

class DenahUjianWebController extends Controller
{
    public function __construct(
        protected DenahUjianService $denah_ujian_service,
        protected KelasService $kelas_service,

    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'ujian-denah-ujian',
            'activePageMaster' => 'ujian-management',
        ];

        $kelas = $this->kelas_service->getAll();
        $denahList = $this->denah_ujian_service->getAll();
        return view('pages.denah-ujian.index', compact('active', 'kelas', 'denahList'));
    }

    public function generate(DenahUjianRequest $request)
    {
        $dto = DenahUjianDto::fromRequest($request);
        $this->denah_ujian_service->generate($dto);
        return response()->json([
            'status' => 'success',
            'message' => 'Denah ujian berhasil digenerate',

        ]);
    }
}
