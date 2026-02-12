<?php

use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\MapelWebController;
use App\Http\Controllers\Web\SantriWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardWebController::class, 'index']);
// Santri
Route::get('/santri', [SantriWebController::class, 'index'])->name('santri');
Route::get('/santri/create', [SantriWebController::class, 'create'])->name('santri.create');
Route::post('/santri/store', [SantriWebController::class, 'store'])->name('santri.store');

// guru
Route::get('/guru', [GuruWebController::class, 'index']);
Route::get('/guru/generate-token', [GuruWebController::class, 'generateToken'])->name('guru.generate-token');
Route::post('/guru/store', [GuruWebController::class, 'store'])->name('guru.store');
// Mapel
Route::get('/mapel', [MapelWebController::class, 'index'])->name('mapel');
Route::post('/mapel/store', [MapelWebController::class, 'store'])->name('mapel.store');
Route::put('/mapel/{id}/update', [MapelWebController::class, 'update'])->name('mapel.update');
Route::delete('/mapel/{id}/delete', [MapelWebController::class, 'destroy'])->name('mapel.destroy');

// Route::get('/transliterate', [PegonController::class, 'transliterate']);
