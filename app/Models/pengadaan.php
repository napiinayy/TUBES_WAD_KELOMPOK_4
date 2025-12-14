<?php
// app/Models/Pengadaan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori',
        'nama_barang',
        'spesifikasi',
        'id_lab',
        'jumlah',
        'alasan_pengadaan',
        'pengaju',
        'status',
    ];

    // Relasi ke Lab
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'id_lab');
    }

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}