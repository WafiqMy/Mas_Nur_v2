<?php

namespace App\Http\Controllers;

use App\Models\InfaqDana;
use App\Models\InfaqRekening;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    /**
     * Display the public infaq landing page
     */
    public function index()
    {
        $rekenings = InfaqRekening::active()->get();
        $laporanTerbaru = InfaqDana::latest10()->get();
        $totalBulanIni = InfaqDana::getTotalByMonth(now()->month, now()->year);
        $totalKeseluruhan = InfaqDana::getTotalAll();
        $jumlahTransaksi = InfaqDana::count();

        return view('infaq.index', compact(
            'rekenings',
            'laporanTerbaru',
            'totalBulanIni',
            'totalKeseluruhan',
            'jumlahTransaksi'
        ));
    }
}
