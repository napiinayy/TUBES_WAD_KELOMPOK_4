
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

// Route untuk index (list pengadaan)
Route::get('/test-pengadaan', function () {
    $pengadaans = collect([
        (object)[
            'id' => 1,
            'nama_barang' => 'monitor',
            'jumlah' => 5,
            'pengaju' => 'Rizaldy',
            'status' => 'pending',
            'created_at' => now(),
            'lab' => (object)['nama_lab' => 'SISJAR lab']
        ],
        (object)[
            'id' => 2,
            'nama_barang' => 'ERP License',
            'jumlah' => 100,
            'pengaju' => 'Khaira',
            'status' => 'approved',
            'created_at' => now()->subDays(2),
            'lab' => (object)['nama_lab' => 'ERP Lab']
        ],
        (object)[
            'id' => 3,
            'nama_barang' => 'proyektor',
            'jumlah' => 3,
            'pengaju' => 'Ayya',
            'status' => 'completed',
            'created_at' => now()->subDays(5),
            'lab' => (object)['nama_lab' => 'EAD Lab']
        ],
    ]);
    
    return view('aslab.pengadaan.index', compact('pengadaans'));
});

// Route untuk create (form tambah)
Route::get('/test-pengadaan/create', function () {
    $kategoris = collect([
        (object)['id' => 1, 'nama_barang' => 'monitor', 'jenis_barang' => 'Alat Laboratorium'],
        (object)['id' => 2, 'nama_barang' => 'ERP License', 'jenis_barang' => 'student license '],
        (object)['id' => 3, 'nama_barang' => 'proyektor ', 'jenis_barang' => 'Alat Praktikum'],
    ]);
    
    $labs = collect([
        (object)['id' => 1, 'nama_lab' => 'SISJAR Lab'],
        (object)['id' => 2, 'nama_lab' => 'ERP Lab'],
        (object)['id' => 3, 'nama_lab' => 'EAD Lab'],
    ]);
    
    return view('aslab.pengadaan.create', compact('kategoris', 'labs'));
});

// Route untuk show (detail)
Route::get('/test-pengadaan/{id}', function ($id) {
    $pengadaan = (object)[
        'id' => $id,
        'nama_barang' => 'monitor',
        'jumlah' => 5,
        'pengaju' => 'Rizaldy',
        'status' => 'pending',
        'spesifikasi' => 'monitor merk spesifik yaitu HP',
        'alasan_pengadaan' => 'untuk menggantikan monitor lama yang performa sudah menurun sehingga memperlancar proses praktikum',
        'created_at' => now(),
        'lab' => (object)['nama_lab' => 'SISJAR Lab']
    ];
    
    return view('aslab.pengadaan.show', compact('pengadaan'));
});

// Route untuk edit (form edit)
Route::get('/test-pengadaan/{id}/edit', function ($id) {
    $pengadaan = (object)[
        'id' => $id,
        'id_kategori' => 1,
        'nama_barang' => 'monitor',
        'spesifikasi' => 'monitor merk HP',
        'id_lab' => 1,
        'jumlah' => 5,
        'alasan_pengadaan' => 'Untuk praktikum mahasiswa',
    ];
    
    $kategoris = collect([
        (object)['id' => 1, 'nama_barang' => 'monitor', 'jenis_barang' => 'Alat Laboratorium'],
        (object)['id' => 2, 'nama_barang' => 'ERP License ', 'jenis_barang' => 'student license '],
        (object)['id' => 3, 'nama_barang' => 'proyektor', 'jenis_barang' => 'Alat Praktikum'],
    ]);
    
    $labs = collect([
        (object)['id' => 1, 'nama_lab' => 'SISJAR Lab'],
        (object)['id' => 2, 'nama_lab' => 'ERP Lab'],
        (object)['id' => 3, 'nama_lab' => 'EAD Lab'],
    ]);
    
    return view('aslab.pengadaan.edit', compact('pengadaan', 'kategoris', 'labs'));
});

// Route untuk POST (submit form)
Route::post('/test-pengadaan', function () {
    return redirect('/test-pengadaan')->with('success', 'Data berhasil ditambahkan (Mode Testing)');
});

// Route untuk PUT (update form)
Route::put('/test-pengadaan/{id}', function ($id) {
    return redirect('/test-pengadaan')->with('success', 'Data berhasil diupdate (Mode Testing)');
});

// Route untuk DELETE
Route::delete('/test-pengadaan/{id}', function ($id) {
    return redirect('/test-pengadaan')->with('success', 'Data berhasil dihapus (Mode Testing)');
});
});
//ini aku ubah juga//
