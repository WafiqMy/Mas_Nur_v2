<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
        'nama_event',
        'gambar_event',
        'deskripsi_event',
        'lokasi_event',
        'tanggal_event',
        'dokumentasi',
        'video_urls',
    ];

    protected $casts = [
        'tanggal_event' => 'datetime',
        'video_urls' => 'array',
    ];

    public function getGambarUrlAttribute(): string
    {
        if ($this->gambar_event) {
            return asset('storage/kegiatan/' . $this->gambar_event);
        }
        return 'https://via.placeholder.com/800x400?text=No+Image';
    }

    public function getDokumentasiListAttribute(): array
    {
        if (empty($this->dokumentasi)) {
            return [];
        }
        return array_filter(array_map(function ($file) {
            return asset('storage/kegiatan/' . trim($file));
        }, explode(',', $this->dokumentasi)));
    }
}
