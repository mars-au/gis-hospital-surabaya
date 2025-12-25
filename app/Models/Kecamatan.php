<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    
    protected $fillable = [
        'nama_kecamatan',
        'deskripsi'
    ];

    public function objekPoints(): HasMany
    {
        return $this->hasMany(ObjekPoint::class, 'kecamatan_id');
    }
}
