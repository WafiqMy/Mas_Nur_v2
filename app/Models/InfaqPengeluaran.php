<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfaqPengeluaran extends Model
{
    protected $table = 'infaq_pengeluaran';

    protected $fillable = [
        'keperluan',
        'jumlah',
        'keterangan',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    public function getJumlahFormatAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->jumlah, 0, ',', '.');
    }

    public static function getTotalAll(): float
    {
        return (float) self::sum('jumlah');
    }

    public static function getTotalByMonth(int $month, int $year): float
    {
        return (float) self::whereYear('tanggal', $year)
                           ->whereMonth('tanggal', $month)
                           ->sum('jumlah');
    }
}
