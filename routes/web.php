<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;

Route::prefix('test-admin')->group(function () {
    Route::resource('kategori', KategoriController::class);
});
