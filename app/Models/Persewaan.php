<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persewaan extends Model
{
    protected $table = 'persewaan';

    protected $fillable = [
        'nama_barang',
        'Jenis',
        'harga',
        'jumlah',
        'deskripsi',
        'spesifikasi',
        'fasilitas',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar) {
            return asset('storage/persewaan/' . $this->gambar);
        }
        return 'https://via.placeholder.com/300x200?text=No+Image';
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'nama_barang', 'nama_barang');
    }
}
