
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('admin/users', UserController::class);
    Route::resource('admin/kategori', KategoriController::class);
    Route::resource('admin/keluhan', KeluhanController::class);
    Route::resource('aslab/pengadaan', PengadaanController::class);

    Route::prefix('aslab/peminjaman')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::put('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    });
});