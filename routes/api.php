<?php

use App\Http\Controllers\Api\KelasApiController;
use App\Http\Controllers\Api\MapelApiController;
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
Route::get('/kelas/{id}', [KelasApiController::class, 'findById']);
Route::post('/kelas', [KelasApiController::class, 'store']);
Route::put('/kelas/{id}', [KelasApiController::class, 'update']);
Route::delete('/kelas/{id}', [KelasApiController::class, 'destroy']);

// Route Mapel
Route::get('/mapel', [MapelApiController::class, 'findAll']);
Route::get('/mapel/{id}', [MapelApiController::class, 'findById']);
Route::post('/mapel', [MapelApiController::class, 'strore']);
Route::put('/mapel/{id}', [MapelApiController::class, 'update']);
Route::delete('/mapel/{id}', [MapelApiController::class, 'destroy']);
