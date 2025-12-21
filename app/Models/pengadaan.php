<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $table = 'pengadaans';

    protected $fillable = [
        'id_kategori',
        'kategori_barang',
        'nama_barang',
        'spesifikasi',
        'id_lab',
        'jumlah',
        'alasan_pengadaan',
        'pengaju',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationship with Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // Relationship with Lab
    public function lab()
    {
        return $this->belongsTo(Lab::class, 'id_lab');
    }

    // Relationship with User (pengaju)
    public function user()
    {
        return $this->belongsTo(User::class, 'pengaju', 'name');
    }
}
