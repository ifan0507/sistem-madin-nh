<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\guru\GuruController;
use App\Http\Controllers\pegon\PegonController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/guru', [GuruController::class, 'index']);
// Route::get('/transliterate', [PegonController::class, 'transliterate']);
