<?php

use App\Http\Controllers\Api\KelasApiController;
use App\Http\Controllers\Api\PegonApiController;
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

// Santri Routes
Route::get('/santri', [SantriApiController::class, 'findAll']);
Route::get('/santri/{id}', [SantriApiController::class, 'findById']);
Route::post('/santri', [SantriApiController::class, 'store']);
Route::put('/santri/{id}', [SantriApiController::class, 'update']);
Route::delete('/santri/{id}', [SantriApiController::class, 'destroy']);

// Route kelas
Route::get('/kelas', [KelasApiController::class, 'findAll']);
