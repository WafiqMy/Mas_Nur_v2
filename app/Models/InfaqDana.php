<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InfaqDana extends Model
{
    protected $table = 'infaq_dana';

    protected $fillable = [
        'judul',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Format jumlah as Indonesian Rupiah
     */
    public function getJumlahFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->jumlah, 0, ',', '.');
    }

    /**
     * Scope: Get latest entries
     */
    public function scopeLatest10(Builder $query): Builder
    {
        return $query->orderBy('tanggal', 'desc')->limit(10);
    }

    /**
     * Scope: Get entries for current month
     */
    public function scopeCurrentMonth(Builder $query): Builder
    {
        return $query->whereYear('tanggal', now()->year)
                     ->whereMonth('tanggal', now()->month);
    }

    /**
     * Calculate total for a given month
     */
    public static function getTotalByMonth(int $month, int $year): float
    {
        return (float) self::whereYear('tanggal', $year)
                   ->whereMonth('tanggal', $month)
                   ->sum('jumlah');
    }

    /**
     * Calculate total for all time
     */
    public static function getTotalAll(): float
    {
        return (float) self::sum('jumlah');
    }
}
