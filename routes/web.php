<?php

use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\KelasWebController;
use App\Http\Controllers\Web\MapelWebController;
use App\Http\Controllers\Web\SantriWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardWebController::class, 'index']);

// Santri

Route::get('/santri', [SantriWebController::class, 'index'])->name('santri');
Route::get('/santri/create', [SantriWebController::class, 'create'])->name('santri.create');
Route::post('/santri/store', [SantriWebController::class, 'store'])->name('santri.store');
Route::get('/santri/{id}/detail', [SantriWebController::class, 'show'])->name('santri.show');
Route::get('/santri/{id}/edit', [SantriWebController::class, 'edit'])->name('santri.edit');
Route::put('/santri/{id}/update', [SantriWebController::class, 'update'])->name('santri.update');
Route::delete('/santri/{id}/delete', [SantriWebController::class, 'destroy'])->name('santri.destroy');
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

// Route::get('/transliterate', [PegonController::class, 'transliterate']);
