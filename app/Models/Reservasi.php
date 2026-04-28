<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';

    protected $fillable = [
        'nama_barang',
        'jenis',
        'nama_pengguna',
        'no_tlp_pengguna',
        'email_pengguna',
        'username_pengguna',
        'tanggal_mulai_reservasi',
        'tanggal_selesai_reservasi',
        'keperluan',
        'total_peminjaman',
        'total_harga',
        'status_reservasi',
        'notes',
    ];

    protected $casts = [
        'tanggal_mulai_reservasi' => 'date',
        'tanggal_selesai_reservasi' => 'date',
        'total_harga' => 'decimal:2',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status_reservasi) {
            'Disetujui' => '#198754',
            'Ditolak', 'Batal' => '#dc3545',
            default => '#ffc107',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_reservasi) {
            'Disetujui' => 'bg-success',
            'Ditolak', 'Batal' => 'bg-danger',
            default => 'bg-warning text-dark',
        };
    }
}
