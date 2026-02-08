<?php

use App\Http\Controllers\Api\AbsensiGuruApiController;
use App\Http\Controllers\Api\AbsensiSantriApiController;
use App\Http\Controllers\Api\JadwaKbmController;
use App\Http\Controllers\Api\JadwalKbmApiController;
use App\Http\Controllers\Api\JadwalUjianApiController;
use App\Http\Controllers\Api\KelasApiController;
use App\Http\Controllers\Api\MapelApiController;
use App\Http\Controllers\Api\PegonApiController;
use App\Http\Controllers\Api\PelanggaranApiController;
use App\Http\Controllers\Api\SantriApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/transliterate', [PegonApiController::class, 'transliterate']);

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
Route::delete('/kelas/{id}', [KelasApiController::class, 'destroy']);

// Api Mapel
Route::get('/mapel', [MapelApiController::class, 'findAll']);
Route::get('/mapel/{id}', [MapelApiController::class, 'findById']);
Route::post('/mapel', [MapelApiController::class, 'strore']);
Route::put('/mapel/{id}', [MapelApiController::class, 'update']);
Route::delete('/mapel/{id}', [MapelApiController::class, 'destroy']);

// Api Mapel Kelas
Route::get('/mapel-kelas', [MapelApiController::class, 'findAll']);
Route::get('/mapel-kelas/{id}', [MapelApiController::class, 'findById']);
Route::post('/mapel-kelas', [MapelApiController::class, 'store']);
Route::put('/mapel-kelas/{id}', [MapelApiController::class, 'update']);
Route::delete('/mapel-kelas/{id}', [MapelApiController::class, 'destroy']);

// Api Jadwal KBM
Route::get('/jadwal-kbm', [JadwalKbmApiController::class, 'findAll']);
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
Route::get('/absensi-guru/{id}', [AbsensiGuruApiController::class, 'findById']);
Route::post('/absensi-guru', [AbsensiGuruApiController::class, 'store']);
Route::put('/absensi-guru/{id}', [AbsensiGuruApiController::class, 'update']);
Route::delete('/absensi-guru/{id}', [AbsensiGuruApiController::class, 'destroy']);

// Api Absensi Santri
Route::get('/absensi-santri', [AbsensiSantriApiController::class, 'findAll']);
Route::get('/absensi-santri/{id}', [AbsensiSantriApiController::class, 'findById']);
Route::post('/absensi-santri', [AbsensiSantriApiController::class, 'store']);
Route::put('/absensi-santri/{id}', [AbsensiSantriApiController::class, 'update']);
Route::delete('/absensi-santri/{id}', [AbsensiSantriApiController::class, 'destroy']);

// Api Pelanggaran Santri
Route::get('/pelanggaran-santri', [PelanggaranApiController::class, 'findAll']);
Route::get('/pelanggaran-santri/{id}', [PelanggaranApiController::class, 'findById']);
Route::post('/pelanggaran-santri', [PelanggaranApiController::class, 'store']);
Route::put('/pelanggaran-santri/{id}', [PelanggaranApiController::class, 'update']);
Route::delete('/pelanggaran-santri/{id}', [PelanggaranApiController::class, 'destroy']);
