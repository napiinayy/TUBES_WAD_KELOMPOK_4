<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AslabController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->middleware('auth')->group(function () {
    // PROFIL ADMIN
    Route::get('/profil', [AdminController::class, 'editProfil']);
    Route::put('/profil', [AdminController::class, 'updateProfil']);

    // KELOLA ASLAB
    Route::get('/aslab', [AdminController::class, 'indexAslab']);
    Route::get('/aslab/{id}/edit', [AdminController::class, 'editAslab']);
    Route::put('/aslab/{id}', [AdminController::class, 'updateAslab']);

});

// Profil Aslab
Route::prefix('aslab')->group(function () {
    Route::get('/profil', [AslabController::class, 'editProfil']);
    Route::put('/profil', [AslabController::class, 'updateProfil']);
});
