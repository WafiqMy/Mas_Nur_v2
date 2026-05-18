<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InfaqRekening extends Model
{
    protected $table = 'infaq_rekening';

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'qris_image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get URL for QRIS image
     */
    public function getQrisUrlAttribute(): ?string
    {
        if ($this->qris_image) {
            // Controller menyimpan sebagai 'infaq/filename.ext'
            // asset('storage/infaq/filename.ext') sudah benar
            return asset('storage/' . $this->qris_image);
        }
        return null;
    }

    /**
     * Scope: Get active accounts only
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Get by bank name
     */
    public function scopeByBank(Builder $query, string $bank): Builder
    {
        return $query->where('nama_bank', $bank);
    }
}
