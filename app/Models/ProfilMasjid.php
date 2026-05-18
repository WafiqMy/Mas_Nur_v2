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
        'whatsapp',
        'email',
        'website',
    ];

    /**
     * Mengembalikan URL WhatsApp yang siap dipakai di href.
     * Ambil dari kolom whatsapp di DB, fallback ke config masjid.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $nomor = $this->whatsapp ?? config('masjid.sosial.whatsapp');

        if (!$nomor) {
            return '#';
        }

        // Jika sudah berupa URL lengkap (https://wa.me/...)
        if (str_starts_with($nomor, 'http')) {
            return $nomor;
        }

        // Bersihkan karakter non-digit kecuali +
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        // Ubah awalan 0 jadi 62
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        return 'https://wa.me/' . $nomor;
    }

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
