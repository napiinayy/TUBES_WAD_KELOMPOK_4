<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeluhanController;

Route::get('/', function () {
    return view('welcome');
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
