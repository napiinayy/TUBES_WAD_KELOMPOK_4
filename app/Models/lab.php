<?php
// app/Models/Lab.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lab',
        'kode_lab',
    ];

    public function pengadaans()
    {
        return $this->hasMany(Pengadaan::class, 'id_lab');
    }
}
