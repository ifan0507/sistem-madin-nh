<?php

use App\Http\Controllers\pegon\PegonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/transliterate', [PegonController::class, 'transliterate']);
