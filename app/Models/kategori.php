<?php
// app/Models/Kategori.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'jenis_barang',
    ];

    public function pengadaans()
    {
        return $this->hasMany(Pengadaan::class, 'id_kategori');
    }
}