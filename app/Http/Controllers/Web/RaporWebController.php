<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PengaturanModel;
use App\Models\SantriModel;
use App\Services\KelasService;
use App\Services\RaporService;
use Illuminate\Http\Request;

class RaporWebController extends Controller
{
    public function __construct(
        protected RaporService $rapor_service,
        protected KelasService $kelas_service
    ) {}


    public function index(Request $request)
    {
        $active = (object)[
            'activePage' => 'laporan-rapor-santri',
            'activePageMaster' => 'laporan-management',
        ];

        $pengaturan = PengaturanModel::first();
        $defaultTahun = $pengaturan ? $pengaturan->tahun_ajaran : '2025/2026';
        $defaultSemester = $pengaturan ? $pengaturan->semester : 'Ganjil';

        $tahunAjaran = $request->query('tahun_ajaran', $defaultTahun);
        $semester    = $request->query('semester', $defaultSemester);

        $kelas = $this->kelas_service->getAllKelasCountSantri();

        return view('pages.rapor.index', [
            'active'      => $active,
            'kelas'       => $kelas,
            'tahunAjaran' => $tahunAjaran,
            'semester'    => $semester,
        ]);
    }


    public function getSantriKelasFromRapor(Request $request)
    {
        $kelasId = $request->query('kelas_id');
        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $dataSantri = $this->rapor_service->getSantriWithRaporStatus($kelasId, $tahunAjaran, $semester);

        return response()->json(['data' => $dataSantri]);
    }

    public function detail(Request $request, $kelasId, $santriId)
    {
        $active = (object)[
            'activePage' => 'laporan-rapor-santri',
            'activePageMaster' => 'laporan-management',
        ];
        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $data = $this->rapor_service->getDetailRaporLengkap($kelasId, $santriId, $tahunAjaran, $semester);

        return view('pages.rapor.detail-rapor-santri', [
            'active' => $active,
            'santri' => $data['santri'],
            'kelas'  => $data['kelas'],
            'tahun_ajaran' => $data['tahun_ajaran'],
            'semester' => $data['semester'],
            'list_nilai' => $data['list_nilai'],
            'total_nilai' => $data['total_nilai'],
            'peringkat' => $data['peringkat'],
            'rapor' => $data['rapor'],
            'nilaiPraktek' => $data['nilaiPraktek'],
            'rataPraktekQuran' => $data['rataPraktekQuran'],
            'rataPraktekKitab' => $data['rataPraktekKitab'],
            'rataPraktekMuhafadloh' => $data['rataPraktekMuhafadloh'],
        ]);
    }

    public function bulkCreate(Request $request)
    {
        $request->validate([
            'kelas_id'     => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required|string',
            'semester'     => 'required|string',
        ]);

        try {
            $jumlahDibuat = $this->rapor_service->generateBulkRapor(
                $request->kelas_id,
                $request->tahun_ajaran,
                $request->semester
            );

            if ($jumlahDibuat > 0) {
                $pesan = "Berhasil membuat $jumlahDibuat rapor baru untuk kelas ini.";
            } else {
                $pesan = "Semua santri di kelas ini sudah memiliki data rapor (Tidak ada yang baru ditambahkan).";
            }

            return response()->json([
                'status'  => 'success',
                'message' => $pesan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRankingKelas(Request $request, $kelasId)
    {
        $ranking = $this->rapor_service->generateRankingList(
            $kelasId,
            $request->query('tahun_ajaran'),
            $request->query('semester')
        );

        return response()->json(['status' => 'success', 'data' => $ranking]);
    }

    public function cetakSingle($kelasId, $santriId, Request $request)
    {
        $dataRapor = $this->rapor_service->getDetailRaporLengkap($kelasId, $santriId, $request->tahun_ajaran, $request->semester);

        $kumpulan_rapor = [$dataRapor];

        return view('pages.rapor.cetak', compact('kumpulan_rapor'));
    }

    public function cetakBulk($kelasId, Request $request)
    {
        $santriIds = SantriModel::where('kelas_id', $kelasId)->pluck('id');
        $kumpulan_rapor = [];

        foreach ($santriIds as $sId) {
            $dataRapor = $this->rapor_service->getDetailRaporLengkap($kelasId, $sId, $request->tahun_ajaran, $request->semester);
            $kumpulan_rapor[] = $dataRapor;
        }

        return view('pages.rapor.cetak', compact('kumpulan_rapor'));
    }

    public function cetakDaftarJuara(Request $request, $kelasId)
    {
        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $kelas = $this->kelas_service->getById($kelasId);

        $ranking = $this->rapor_service->generateRankingList($kelasId, $tahunAjaran, $semester);

        return view('pages.rapor.cetak-juara-kelas', compact('ranking', 'kelas', 'tahunAjaran', 'semester'));
    }
}
