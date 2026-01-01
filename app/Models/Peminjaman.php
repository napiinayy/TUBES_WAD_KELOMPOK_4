<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'peminjamans';

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'id_lab',
        'kelas',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'alasan_peminjaman',
        'peminjam',
        'status'
    ];

    // Cast otomatis untuk tanggal
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
    ];

    /**
     * Relasi ke tabel Lab (belongsTo)
     * Digunakan di view: $peminjaman->lab->nama_lab
     */
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'id_lab');
    }

    /**
     * Relasi ke tabel User (belongsTo)
     * Digunakan di view: $peminjaman->user->nama_lengkap
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'peminjam', 'id');
    }

    /**
     * Relasi ke tabel Kategori (belongsTo)
     * Digunakan untuk memastikan item yang dipinjam berasal dari katalog pembelian
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}
