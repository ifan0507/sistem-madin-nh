<?php

use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\SantriWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardWebController::class, 'index']);
// Santri
Route::get('/santri', [SantriWebController::class, 'index']);
Route::get('/guru', [GuruWebController::class, 'index']);

// Route::get('/transliterate', [PegonController::class, 'transliterate']);
