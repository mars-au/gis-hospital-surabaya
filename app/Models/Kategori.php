<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategori';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon'
    ];

    public function objekPoints(): HasMany
    {
        return $this->hasMany(ObjekPoint::class, 'kategori_id');
    }
}
