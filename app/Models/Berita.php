<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul_berita',
        'isi_berita',
        'foto_berita',
        'username',
        'tanggal_berita',
    ];

    protected $casts = [
        'tanggal_berita' => 'datetime',
    ];

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto_berita) {
            return asset('storage/berita/' . $this->foto_berita);
        }
        return 'https://via.placeholder.com/800x400?text=No+Image';
    }

    public function scopeLatest3($query)
    {
        return $query->orderBy('tanggal_berita', 'desc')->limit(3);
    }
}
