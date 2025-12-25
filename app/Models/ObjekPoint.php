<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ObjekPoint extends Model
{
    protected $table = 'objek_point';
    
    protected $fillable = [
        'nama_objek',
        'kategori_id',
        'latitude',
        'longitude',
        'deskripsi',
        'kecamatan_id',
        'alamat',
        'telepon'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
