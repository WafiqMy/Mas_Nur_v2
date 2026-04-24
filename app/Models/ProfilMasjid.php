<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilMasjid extends Model
{
    protected $table = 'profil_masjid';

    protected $fillable = [
        'nama_masjid',
        'deskripsi',
        'sejarah_masjid',
        'gambar_sampul',
        'gambar_sejarah_masjid',
        'gambar_struktur_remas',
        'deskripsi_remas',
        'alamat',
        'telepon',
        'email',
        'website',
    ];

    public function getGambarSampulUrlAttribute(): string
    {
        if ($this->gambar_sampul) {
            return asset('storage/profil_masjid/' . $this->gambar_sampul);
        }
        return asset('img/ms3.png');
    }

    public function getGambarSejarahUrlAttribute(): string
    {
        if ($this->gambar_sejarah_masjid) {
            return asset('storage/profil_masjid/' . $this->gambar_sejarah_masjid);
        }
        return 'https://via.placeholder.com/800x600?text=No+Image';
    }

    public function getGambarStrukturUrlAttribute(): string
    {
        if ($this->gambar_struktur_remas) {
            return asset('storage/profil_masjid/' . $this->gambar_struktur_remas);
        }
        return 'https://via.placeholder.com/800x600?text=No+Image';
    }
}
