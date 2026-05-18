<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfaqDana;
use App\Models\InfaqPengeluaran;
use Illuminate\Http\Request;

class InfaqDanaController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // Filter bulan/tahun
        $bulan = $request->filled('bulan') ? (int) $request->bulan : null;
        $tahun = $request->filled('tahun') ? (int) $request->tahun : null;

        // Query dana masuk
        $queryMasuk = InfaqDana::query();
        if ($bulan && $tahun) {
            $queryMasuk->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
        }
        $danaMasuk = $queryMasuk->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'masuk');

        // Query dana keluar
        $queryKeluar = InfaqPengeluaran::query();
        if ($bulan && $tahun) {
            $queryKeluar->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
        }
        $danaKeluar = $queryKeluar->orderBy('tanggal', 'desc')->paginate(10, ['*'], 'keluar');

        // Ringkasan
        $totalMasuk       = InfaqDana::getTotalAll();
        $totalKeluar      = InfaqPengeluaran::getTotalAll();
        $saldo            = $totalMasuk - $totalKeluar;
        $totalMasukBulan  = InfaqDana::getTotalByMonth(now()->month, now()->year);
        $totalKeluarBulan = InfaqPengeluaran::getTotalByMonth(now()->month, now()->year);

        return view('admin.infaq.dana.index', compact(
            'danaMasuk',
            'danaKeluar',
            'totalMasuk',
            'totalKeluar',
            'saldo',
            'totalMasukBulan',
            'totalKeluarBulan',
            'bulan',
            'tahun'
        ));
    }

    // ===== DANA MASUK =====

    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'tanggal'    => 'required|date',
        ]);

        InfaqDana::create($request->only('judul', 'jumlah', 'keterangan', 'tanggal'));

        return redirect()->route('admin.infaq.dana.index')
            ->with('success', 'Dana masuk berhasil ditambahkan.');
    }

    public function update(Request $request, InfaqDana $dana)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'tanggal'    => 'required|date',
        ]);

        $dana->update($request->only('judul', 'jumlah', 'keterangan', 'tanggal'));

        return redirect()->route('admin.infaq.dana.index')
            ->with('success', 'Dana masuk berhasil diperbarui.');
    }

    public function destroy(InfaqDana $dana)
    {
        $dana->delete();

        return redirect()->route('admin.infaq.dana.index')
            ->with('success', 'Data dana masuk berhasil dihapus.');
    }

    // ===== DANA KELUAR =====

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'keperluan'  => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'tanggal'    => 'required|date',
        ]);

        InfaqPengeluaran::create($request->only('keperluan', 'jumlah', 'keterangan', 'tanggal'));

        return redirect()->route('admin.infaq.dana.index')
            ->with('success', 'Laporan pengeluaran berhasil ditambahkan.');
    }

    public function updatePengeluaran(Request $request, InfaqPengeluaran $pengeluaran)
    {
        $request->validate([
            'keperluan'  => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:500',
            'tanggal'    => 'required|date',
        ]);

        $pengeluaran->update($request->only('keperluan', 'jumlah', 'keterangan', 'tanggal'));

        return redirect()->route('admin.infaq.dana.index')
            ->with('success', 'Laporan pengeluaran berhasil diperbarui.');
    }

    public function destroyPengeluaran(InfaqPengeluaran $pengeluaran)
    {
        $pengeluaran->delete();

        return redirect()->route('admin.infaq.dana.index')
            ->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
