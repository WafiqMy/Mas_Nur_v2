<?php

namespace App\Http\Controllers;

use App\Models\InfaqDana;
use App\Models\InfaqPengeluaran;
use App\Models\InfaqRekening;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    public function index(Request $request)
    {
        $rekenings       = InfaqRekening::active()->get();
        $totalMasuk      = InfaqDana::getTotalAll();
        $totalKeluar     = InfaqPengeluaran::getTotalAll();
        $saldo           = $totalMasuk - $totalKeluar;
        $totalMasukBulan = InfaqDana::getTotalByMonth(now()->month, now()->year);
        $totalKeluarBulan= InfaqPengeluaran::getTotalByMonth(now()->month, now()->year);

        // Laporan masuk terbaru
        $laporanMasuk = InfaqDana::orderBy('tanggal', 'desc')->limit(10)->get();

        // Laporan keluar terbaru
        $laporanKeluar = InfaqPengeluaran::orderBy('tanggal', 'desc')->limit(10)->get();

        return view('infaq.index', compact(
            'rekenings',
            'totalMasuk',
            'totalKeluar',
            'saldo',
            'totalMasukBulan',
            'totalKeluarBulan',
            'laporanMasuk',
            'laporanKeluar'
        ));
    }
}
