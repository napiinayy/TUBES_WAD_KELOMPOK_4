
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengadaanController;

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Profile route (for both admin and aslab)
    Route::get('/profile', function() {
        return redirect()->route('admin.users.show', auth()->id());
    })->name('profile');
    
    // Admin routes
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/labs/store', [UserController::class, 'storeLab'])->name('admin.labs.store');
    Route::resource('admin/users', UserController::class)->names('admin.users');
    Route::resource('admin/kategoris', KategoriController::class)->names('admin.kategoris');
    Route::resource('admin/barang', BarangController::class)->names('admin.barang');
    Route::resource('admin/keluhan', KeluhanController::class)->names('admin.keluhan');
    // Admin keluhan status-only update
    Route::patch('admin/keluhan/{id}/status', [KeluhanController::class, 'updateStatus'])->name('admin.keluhan.updateStatus');
        // Admin pengadaan status update
        Route::patch('admin/pengadaan/{id}/status', [PengadaanController::class, 'updateStatus'])->name('admin.pengadaan.updateStatus');
    
    // Aslab routes
    Route::resource('aslab/pengadaan', PengadaanController::class)->names('aslab.pengadaan');
    Route::resource('aslab/barang', BarangController::class)->names('aslab.barang');
    Route::resource('aslab/keluhan', KeluhanController::class)->names('aslab.keluhan');
    // Aslab keluhan status-only update
    Route::patch('aslab/keluhan/{id}/status', [KeluhanController::class, 'updateStatus'])->name('aslab.keluhan.updateStatus');

    Route::resource('aslab/peminjaman', PeminjamanController::class)->names('aslab.peminjaman');
    
    // Admin peminjaman status update
    Route::patch('admin/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('admin.peminjaman.updateStatus');
});