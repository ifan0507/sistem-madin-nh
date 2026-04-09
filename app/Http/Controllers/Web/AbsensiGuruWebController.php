<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AbsensiGuruService;
use App\Services\MapelKelasService;
use App\Services\UserService;
use Illuminate\Http\Request;

class AbsensiGuruWebController extends Controller
{
    public function __construct(
        protected AbsensiGuruService $absensi_guru_service,
        protected UserService $user_service,
        protected MapelKelasService $mapel_kelas_service,
    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'laporan-absensi-guru',
            'activePageMaster' => 'laporan-management',
        ];

        $guruList = $this->user_service->getAllGuru();

        return view('pages.absensi-guru.index', [
            'guruList' => $guruList,
            'active' => $active,
        ]);
    }

    public function getAbsensiGuruAjax(Request $request)
    {
        $guruId = $request->guru_id;
        $filterWaktu = $request->filter_waktu;

        $customData = $request->only([
            'daily_date',
            'weekly_date',
            'monthly_date',
            'range_start',
            'range_end',
            'ta_tahun',
            'ta_semester'
        ]);

        $guru = $this->user_service->getById($guruId);
        $result = $this->absensi_guru_service->generateRekap($guruId, $filterWaktu, $customData);

        $html = view('pages.absensi-guru.tabel-partial', [
            'rekapBulanan'  => $result['rekapBulanan'],
            'guru'          => $guru,
            'stringPeriode' => $result['stringPeriode']
        ])->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }
}
