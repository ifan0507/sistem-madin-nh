<?php

namespace App\Http\Controllers\Web;

use App\Exports\AbsensiRekapSantri;
use App\Exports\AbsensiSantriExport;
use App\Http\Controllers\Controller;
use App\Services\AbsensiSantriService;
use App\Services\KelasService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsensiSantriWebController extends Controller
{
    public function __construct(
        protected AbsensiSantriService $absensi_santri_service,
        protected KelasService $kelas_service
    ) {}

    public function index()
    {
        $active = (object)[
            'activePage' => 'laporan-absensi-santri',
            'activePageMaster' => 'laporan-management',
        ];

        $kelasList = $this->kelas_service->getAllKelasCountSantri();

        $defaultKelasId = $kelasList->first()->id ?? null;

        return view('pages.absensi-santri.index', compact('active', 'kelasList', 'defaultKelasId'));
    }

    public function getAbsensiAjax(Request $request)
    {
        $kelasId = $request->kelas_id;
        $filterWaktu = $request->filter_waktu;
        $customData = $request->only(['daily_date', 'weekly_date', 'monthly_date', 'range_start', 'range_end', 'ta_tahun', 'ta_semester']);

        $data = $this->absensi_santri_service->getAbsensiData($kelasId, $filterWaktu, $customData);

        $html = view('pages.absensi-santri.tabel-partial', array_merge($data, ['kelasId' => $kelasId]))->render();

        return response()->json([
            'status' => 'success',
            'html' => $html
        ]);
    }

    public function exportExcel(Request $request)
    {
        $kelasId = $request->kelas_id;
        $filterWaktu = $request->filter_waktu;
        $customData = $request->only(['daily_date', 'weekly_date', 'monthly_date', 'range_start', 'range_end']);

        $data = $this->absensi_santri_service->getAbsensiData($kelasId, $filterWaktu, $customData);
        $kelas = $this->kelas_service->getById($kelasId);
        $data['kelas'] = $kelas;

        $periodeLabel = $this->getPeriodeLabel($filterWaktu, $customData);
        $namaKelasClean = strtolower($kelas->nama_kelas);
        $namaFile = 'Absensi_Kelas_' . $namaKelasClean . '_' . $periodeLabel . '.xlsx';

        return Excel::download(new AbsensiSantriExport($data), $namaFile);
    }

    public function exportExcelRekap(Request $request)
    {
        $kelasId = $request->kelas_id;
        $filterWaktu = $request->filter_waktu;
        $customData = $request->only(['daily_date', 'weekly_date', 'monthly_date', 'range_start', 'range_end']);

        $data = $this->absensi_santri_service->getAbsensiData($kelasId, $filterWaktu, $customData);
        $kelas = $this->kelas_service->getById($kelasId);
        $data['kelas'] = $kelas;
        $periodeLabel = $this->getPeriodeLabel($filterWaktu, $customData);
        $data['filter_waktu'] = $periodeLabel;
        $namaKelasClean = str_replace(' ', '_', $kelas->nama_kelas);
        $namaFile = 'Rekap_Absensi_Kelas_' . $namaKelasClean . '_' . $periodeLabel . '.xlsx';

        return Excel::download(new AbsensiRekapSantri($data), $namaFile);
    }

    private function getPeriodeLabel($filterWaktu, $customData)
    {
        switch ($filterWaktu) {
            case 'today':
                return 'Hari_Ini';
            case 'yesterday':
                return 'Kemarin';
            case 'thismonth':
                return 'Bulan_Ini';
            case 'lastmonth':
                return 'Bulan_Lalu';
            case 'last7days':
                return '7_Hari_Terakhir';
            case 'last30days':
                return '30_Hari_Terakhir';
            case 'daily':
                return 'Harian_' . $customData['daily_date'];
            case 'weekly':
                return 'Mingguan_' . $customData['weekly_date'];
            case 'monthly':
                return 'Bulanan_' . $customData['monthly_date'];
            case 'range':
                return $customData['range_start'] . '_sd_' . $customData['range_end'];
            default:
                return date('Ymd');
        }
    }
}
