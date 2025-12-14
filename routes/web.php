<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;

Route::prefix('peminjaman')->group(function () {
    Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeluhanController;

Route::prefix('test-admin')->group(function () {
    Route::resource('kategori', KategoriController::class);
});

Route::prefix('test-keluhan')->group(function () {
    Route::get('/', [KeluhanController::class, 'index']);
    Route::get('/create', [KeluhanController::class, 'create']);
    Route::post('/', [KeluhanController::class, 'store']);
    Route::get('/{id}', [KeluhanController::class, 'show']);
    Route::delete('/{id}', [KeluhanController::class, 'destroy']); 
    Route::delete('/debug-delete', function () {
    return 'DELETE WORKS';
});

});
//ini aku ubah juga//