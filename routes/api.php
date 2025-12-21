<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\KeluhanController;
use App\Http\Controllers\Api\PengadaanController;
use App\Http\Controllers\Api\PeminjamanController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API for User Management
Route::apiResource('users', UserController::class);

// API for Kategori
Route::apiResource('kategori', KategoriController::class);

// API for Keluhan
Route::apiResource('keluhan', KeluhanController::class);

// API for Pengadaan
Route::apiResource('pengadaan', PengadaanController::class);
Route::patch('pengadaan/{id}/status', [PengadaanController::class, 'updateStatus']);

// API for Peminjaman
Route::apiResource('peminjaman', PeminjamanController::class);
Route::patch('peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus']);