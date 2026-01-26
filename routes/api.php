<?php

use App\Http\Controllers\Api\PegonApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/transliterate', [PegonApiController::class, 'transliterate']);
Route::post('/users', [UserApiController::class, 'store']);
Route::get('/users/{id}', [UserApiController::class, 'getUserById']);
Route::put('/users/{id}', [UserApiController::class, 'update']);
