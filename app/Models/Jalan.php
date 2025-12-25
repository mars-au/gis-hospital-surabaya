<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    protected $table = 'jalan';
    
    protected $fillable = [
        'nama_jalan',
        'koordinat_json',
        'tipe_jalan',
        'deskripsi'
    ];

    protected $casts = [
        'koordinat_json' => 'array'
    ];
}
