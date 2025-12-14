<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluhan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_item',
        'jenis_keluhan',
        'deskripsi_keluhan',
        'pelapor',
        'status',
    ];
}
