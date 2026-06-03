<?php

namespace App\Services;

use App\Models\PengaturanModel;
use Exception;

class PengaturanService
{
    /**
     * Mengambil semua data
     */
    public function getAll()
    {
        return PengaturanModel::first();
    }

    public function getTahunAjaranAktif()
    {
        return PengaturanModel::select('tahun_ajaran', 'semester')->first();
    }

    public function getTglAwalSemester()
    {
        return PengaturanModel::select('tgl_awal_semester')->first()->tgl_awal_semester;
    }

    public function getTglBatasPengumpulanSoal()
    {
        return PengaturanModel::select('tgl_mulai_kumpul_soal', 'tgl_akhir_kumpul_soal')->first();
    }
    public function getTglBatasPengumpulanNilai()
    {
        return PengaturanModel::select('tgl_mulai_kumpul_nilai', 'tgl_akhir_kumpul_nilai')->first();
    }

    public function updatePengaturan(array $data, string $tipeUpdate)
    {
        try {
            $pengaturan = PengaturanModel::first();
            $fieldsToUpdate = match ($tipeUpdate) {
                'tahun_ajaran' => [
                    'tahun_ajaran' => $data['tahun_ajaran'] ?? $pengaturan->tahun_ajaran,
                    'semester'     => $data['semester'] ?? $pengaturan->semester,
                ],

                'awal_semester' => [
                    'tgl_awal_semester' => $data['tgl_awal_semester'] ?? $pengaturan->tgl_awal_semester,
                ],

                'kumpul_soal' => [
                    'tgl_mulai_kumpul_soal' => $data['tgl_mulai_kumpul_soal'] ?? $pengaturan->tgl_mulai_kumpul_soal,
                    'tgl_akhir_kumpul_soal' => $data['tgl_akhir_kumpul_soal'] ?? $pengaturan->tgl_akhir_kumpul_soal,
                ],

                'kumpul_nilai' => [
                    'tgl_mulai_kumpul_nilai' => $data['tgl_mulai_kumpul_nilai'] ?? $pengaturan->tgl_mulai_kumpul_nilai,
                    'tgl_akhir_kumpul_nilai' => $data['tgl_akhir_kumpul_nilai'] ?? $pengaturan->tgl_akhir_kumpul_nilai,
                ],
            };
            $pengaturan->update($fieldsToUpdate);

            return [
                'status'  => true,
                'message' => 'Pengaturan berhasil diperbarui.'
            ];
        } catch (Exception $e) {

            return [
                'status'  => false,
                'message' => 'Terjadi kesalahan sistem'
            ];
        }
    }
}
