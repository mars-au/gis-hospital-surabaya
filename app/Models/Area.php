<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'area';
    
    protected $fillable = [
        'nama_area',
        'polygon_json',
        'tipe_area',
        'deskripsi'
    ];

    protected $casts = [
        'polygon_json' => 'array'
    ];
}
