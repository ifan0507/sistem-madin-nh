<?php

use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\GuruWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardWebController::class, 'index']);
Route::get('/guru', [GuruWebController::class, 'index']);
// Route::get('/transliterate', [PegonController::class, 'transliterate']);
