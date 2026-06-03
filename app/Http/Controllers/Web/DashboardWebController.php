<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PengaturanModel;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardWebController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'dashboard',
            'activePageMaster' => ''
        ];

        $user = Auth::user();
        $setting = PengaturanModel::first();
        $tahunAjaran = $setting->tahun_ajaran;
        $semester = $setting->semester;
        $dashboardData = $this->dashboardService->getAllDashboardData($tahunAjaran, $semester);

        $data = [
            'nama'   => $user->name ?? $user->username,
            'role'   => in_array($user->role, [1, 2]) ? 'Admin' : 'Guru',
            'tahun_aktif' => $tahunAjaran,
            'sem_aktif'   => $semester,

            'stats'       => $dashboardData['quick_stats'],
            'chart_nilai' => $dashboardData['chart_nilai'],
            'chart_hadir' => $dashboardData['chart_kehadiran'],
            'chart_hadir_guru' => $dashboardData['chart_hadir_guru'],
            'progres'     => $dashboardData['progres_kelas'],
            'aktivitas'   => $dashboardData['aktivitas_terbaru'],
        ];

        return view('pages.dashboard', ['active' => $active], $data);
    }
}
