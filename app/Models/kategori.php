<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'categories'; // Keep the existing database table name

    protected $fillable = [
        'nama_kategori'
    ];

    /**
     * Get the barangs that belong to this kategori.
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'category_id');
    }

    /**
     * Get the pengadaans that belong to this kategori.
     */
    public function pengadaans()
    {
        return $this->hasMany(Pengadaan::class, 'id_kategori');
    }
}
