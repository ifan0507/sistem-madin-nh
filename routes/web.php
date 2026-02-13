<?php

use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\KelasWebController;
use App\Http\Controllers\Web\MapelKelasWebController;
use App\Http\Controllers\Web\MapelWebController;
use App\Http\Controllers\Web\SantriWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardWebController::class, 'index']);
// Santri
Route::get('/santri', [SantriWebController::class, 'index']);
Route::delete('/santri/{id}/delete-kelas', [SantriWebController::class, 'destroyKelas']);
Route::put('/santri/bulk-update-kelas', [SantriWebController::class, 'updateKelasBulk'])->name('santri.updateKelasBulk');

// guru
Route::get('/guru', [GuruWebController::class, 'index']);
Route::get('/guru/generate-token', [GuruWebController::class, 'generateToken'])->name('guru.generate-token');
Route::post('/guru/store', [GuruWebController::class, 'store'])->name('guru.store');
Route::put('/guru/{id}/update', [GuruWebController::class, 'update'])->name('guru.update');
Route::delete('/guru/{id}/delete', [GuruWebController::class, 'destroy'])->name('guru.destroy');

// Kelas
Route::get('/kelas', [KelasWebController::class, 'index'])->name('kelas');
Route::get('/kelas/santri-kelas/{kelas_id}', [KelasWebController::class, 'getSantriByKelas'])->name('kelas.getSantriByKelas');

// Mapel
Route::get('/mapel', [MapelWebController::class, 'index'])->name('mapel');
Route::post('/mapel/store', [MapelWebController::class, 'store'])->name('mapel.store');
Route::put('/mapel/{id}/update', [MapelWebController::class, 'update'])->name('mapel.update');
Route::delete('/mapel/{id}/delete', [MapelWebController::class, 'destroy'])->name('mapel.destroy');

// Mapel Kelas
Route::get('/mapel-kelas', [MapelKelasWebController::class, 'index'])->name('mapel-kelas');
Route::get('/mapel-kelas/kelas/{kelas_id}', [MapelKelasWebController::class, 'getMapelKelasByKelas'])->name('mapel-kelas.getMapelKelasByKelas');
Route::get('/mapel-kelas/guru', [MapelKelasWebController::class, 'getAllGuru'])->name('mapel-kelas.getAllGuru');
Route::get('/mapel-kelas/mapel', [MapelKelasWebController::class, 'getAllMapel'])->name('mapel-kelas.getAllMapel');
Route::post('/mapel-kelas/store', [MapelKelasWebController::class, 'store'])->name('mapel-kelas.store');
Route::put('/mapel-kelas/{id}/update', [MapelKelasWebController::class, 'update'])->name('mapel-kelas.update');
Route::delete('/mapel-kelas/{id}/delete', [MapelKelasWebController::class, 'destroy'])->name('mapel-kelas.destroy');

// Route::get('/transliterate', [PegonController::class, 'transliterate']);
