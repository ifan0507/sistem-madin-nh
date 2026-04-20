<?php

use App\Http\Controllers\Api\AbsensiGuruApiController;
use App\Http\Controllers\Api\AbsensiSantriApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BankSoalApiController;
use App\Http\Controllers\Api\DenahUjianApiController;
use App\Http\Controllers\Api\JadwalKbmApiController;
use App\Http\Controllers\Api\JadwalUjianApiController;
use App\Http\Controllers\Api\KelasApiController;
use App\Http\Controllers\Api\MapelApiController;
use App\Http\Controllers\Api\MapelKelasApiController;
use App\Http\Controllers\Api\NilaiUjianApiController;
use App\Http\Controllers\Api\PelanggaranApiController;
use App\Http\Controllers\Api\RaporApiController;
use App\Http\Controllers\Api\SantriApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login-qr', [AuthApiController::class, 'loginQr']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserApiController::class, 'findAll']);
    Route::post('/users', [UserApiController::class, 'store']);

    Route::get('/users/{id}', [UserApiController::class, 'findById']);
    Route::put('/users/{id}', [UserApiController::class, 'update']);
    Route::delete('/users/{id}', [UserApiController::class, 'destroy']);

    // Api Santri
    Route::get('/santri', [SantriApiController::class, 'findAll']);
    Route::get('/santri/{id}', [SantriApiController::class, 'findById']);
    Route::post('/santri', [SantriApiController::class, 'store']);
    Route::put('/santri/{id}', [SantriApiController::class, 'update']);
    Route::delete('/santri/{id}', [SantriApiController::class, 'destroy']);

    // Api kelas
    Route::get('/kelas', [KelasApiController::class, 'findAll']);
    Route::get('/kelas/{id}', [KelasApiController::class, 'findById']);
    Route::post('/kelas', [KelasApiController::class, 'store']);
    Route::put('/kelas/{id}', [KelasApiController::class, 'update']);
    Route::get('/kelas/santri/{id}', [KelasApiController::class, 'findSantriByKelas']);
    Route::delete('/kelas/{id}', [KelasApiController::class, 'destroy']);

    // Api Mapel
    Route::get('/mapel', [MapelApiController::class, 'findAll']);
    Route::get('/mapel/{id}', [MapelApiController::class, 'findById']);
    Route::post('/mapel', [MapelApiController::class, 'strore']);
    Route::put('/mapel/{id}', [MapelApiController::class, 'update']);
    Route::delete('/mapel/{id}', [MapelApiController::class, 'destroy']);

    // Api Mapel Kelas
    Route::get('/mapel-kelas', [MapelKelasApiController::class, 'findAll']);
    Route::get('/mapel-kelas/{id}', [MapelKelasApiController::class, 'findById']);
    Route::get('/mapel-kelas/kelas/{id}', [MapelKelasApiController::class, 'findByKelas']);
    Route::post('/mapel-kelas', [MapelKelasApiController::class, 'store']);
    Route::put('/mapel-kelas/{id}', [MapelKelasApiController::class, 'update']);
    Route::delete('/mapel-kelas/{id}', [MapelKelasApiController::class, 'destroy']);

    // Api Jadwal KBM
    Route::get('/jadwal-kbm', [JadwalKbmApiController::class, 'findAll']);
    Route::get('/jadwal-kbm/hari-ini', [JadwalKbmApiController::class, 'jadwalHariIni']);
    Route::get('/jadwal-kbm/guru', [JadwalKbmApiController::class, 'getJadwalGuru']);
    Route::get('/jadwal-kbm/{id}', [JadwalKbmApiController::class, 'findById']);
    Route::post('/jadwal-kbm', [JadwalKbmApiController::class, 'store']);
    Route::put('/jadwal-kbm/{id}', [JadwalKbmApiController::class, 'update']);
    Route::delete('/jadwal-kbm/{id}', [JadwalKbmApiController::class, 'destroy']);

    // Api Jadwal Ujian
    Route::get('/jadwal-ujian', [JadwalUjianApiController::class, 'findAll']);
    Route::get('/jadwal-ujian/{id}', [JadwalUjianApiController::class, 'findById']);
    Route::post('/jadwal-ujian', [JadwalUjianApiController::class, 'store']);
    Route::put('/jadwal-ujian/{id}', [JadwalUjianApiController::class, 'update']);
    Route::delete('/jadwal-ujian/{id}', [JadwalUjianApiController::class, 'destroy']);

    // Api Absensi Guru
    Route::get('/absensi-guru', [AbsensiGuruApiController::class, 'findAll']);
    Route::get('/absensi-guru/detail', [AbsensiGuruApiController::class, 'detailAbsensiFromGuru']);
    Route::get('/absensi-guru/rekap-bulanan', [AbsensiGuruApiController::class, 'getRekapBulanan']);
    Route::post('/absensi-guru', [AbsensiGuruApiController::class, 'store']);
    Route::put('/absensi-guru/{id}', [AbsensiGuruApiController::class, 'update']);
    Route::delete('/absensi-guru/{id}', [AbsensiGuruApiController::class, 'destroy']);

    // Api Absensi Santri
    Route::get('/absensi-santri', [AbsensiSantriApiController::class, 'findAll']);
    Route::get('/absensi-santri/{id}', [AbsensiSantriApiController::class, 'findById']);
    Route::post('/absensi-santri', [AbsensiSantriApiController::class, 'store']);
    Route::post('/absensi-santri/bulk', [AbsensiSantriApiController::class, 'storeBulk']);
    Route::put('/absensi-santri/{id}', [AbsensiSantriApiController::class, 'update']);
    Route::delete('/absensi-santri/{id}', [AbsensiSantriApiController::class, 'destroy']);

    // Api Pelanggaran Santri
    Route::get('/pelanggaran-santri', [PelanggaranApiController::class, 'findAll']);
    Route::get('/pelanggaran-santri/{id}', [PelanggaranApiController::class, 'findById']);
    Route::post('/pelanggaran-santri', [PelanggaranApiController::class, 'store']);
    Route::put('/pelanggaran-santri/{id}', [PelanggaranApiController::class, 'update']);
    Route::delete('/pelanggaran-santri/{id}', [PelanggaranApiController::class, 'destroy']);

    // Api Denah Ujian
    Route::get('/denah-ujian', [DenahUjianApiController::class, 'findAll']);
    Route::post('/denah-ujian', [DenahUjianApiController::class, 'store']);

    // Api Bank Soal
    Route::get('/bank-soal/guru/{guru_id}', [BankSoalApiController::class, 'getBankSoalGuru']);
    Route::get('/bank-soal', [BankSoalApiController::class, 'show']);
    Route::post('/bank-soal', [BankSoalApiController::class, 'store']);
    Route::post('/bank-soal/{id}/update-soal', [BankSoalApiController::class, 'update']);
    Route::post('/bank-soal/generate', [BankSoalApiController::class, 'generate']);

    // Api Nilai Ujian
    Route::get('/nilai-ujian/get-list-mapel-guru', [NilaiUjianApiController::class, 'getMapelNilaiUjian']);
    Route::get('/nilai-ujian/detail-nilai', [NilaiUjianApiController::class, 'detailNilai']);
    Route::post('/nilai-ujian', [NilaiUjianApiController::class, 'store']);

    Route::get('/rapor/kelas/{kelas_id}/santri/{santri_id}', [RaporApiController::class, 'getDetailRapor']);
    Route::post('/rapor', [RaporApiController::class, 'store']);

    Route::post('/logout', [AuthApiController::class, 'logout']);
});
