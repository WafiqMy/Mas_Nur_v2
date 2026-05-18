<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $table = 'publikasi';

    protected $fillable = [
        'judul',
        'foto',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFotoUrlAttribute(): string
    {
        return asset('storage/publikasi/' . $this->foto);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
