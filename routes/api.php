<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\KeluhanController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API for User Management
Route::apiResource('users', UserController::class);

// API for Kategori
Route::apiResource('kategori', KategoriController::class);

// API for Keluhan
Route::apiResource('keluhan', KeluhanController::class);
Route::patch('keluhan/{id}/status', [KeluhanController::class, 'updateStatus']);