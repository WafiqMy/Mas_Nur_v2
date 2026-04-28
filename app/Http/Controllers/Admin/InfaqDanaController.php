<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfaqDana;
use Illuminate\Http\Request;

class InfaqDanaController extends Controller
{
    /**
     * Constructor - apply admin middleware
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display list of infaq dana entries
     */
    public function index(Request $request)
    {
        $query = InfaqDana::query();

        // Date filter
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $bulan = (int) $request->bulan;
            $tahun = (int) $request->tahun;
            $query->whereYear('tanggal', $tahun)
                  ->whereMonth('tanggal', $bulan);
        }

        $dana = $query->orderBy('tanggal', 'desc')->paginate(15);
        $totalBulanIni = InfaqDana::getTotalByMonth(now()->month, now()->year);
        $totalKeseluruhan = InfaqDana::getTotalAll();
        $jumlahTransaksi = InfaqDana::count();

        return view('admin.infaq.dana.index', compact(
            'dana',
            'totalBulanIni',
            'totalKeseluruhan',
            'jumlahTransaksi'
        ));
    }

    /**
     * Store a newly created infaq dana entry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
            'tanggal' => 'required|date',
        ]);

        InfaqDana::create($validated);

        return redirect()->route('admin.infaq.dana.index')
                        ->with('success', 'Data infaq dana berhasil ditambahkan.');
    }

    /**
     * Update the specified infaq dana entry
     */
    public function update(Request $request, InfaqDana $dana)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
            'tanggal' => 'required|date',
        ]);

        $dana->update($validated);

        return redirect()->route('admin.infaq.dana.index')
                        ->with('success', 'Data infaq dana berhasil diperbarui.');
    }

    /**
     * Delete the specified infaq dana entry
     */
    public function destroy(InfaqDana $dana)
    {
        $dana->delete();

        return redirect()->route('admin.infaq.dana.index')
                        ->with('success', 'Data infaq dana berhasil dihapus.');
    }
}
