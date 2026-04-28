<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfaqRekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfaqRekeningController extends Controller
{
    /**
     * Constructor - apply admin middleware
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display list of rekening settings
     */
    public function index()
    {
        $rekenings = InfaqRekening::all();
        return view('admin.infaq.rekening.index', compact('rekenings'));
    }

    /**
     * Store a new rekening entry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:255',
            'qris_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            $file = $request->file('qris_image');
            $filename = 'qris_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('infaq', $filename, 'public');
            $validated['qris_image'] = $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        InfaqRekening::create($validated);

        return redirect()->route('admin.infaq.rekening.index')
                        ->with('success', 'Rekening berhasil ditambahkan.');
    }

    /**
     * Update the specified rekening
     */
    public function update(Request $request, InfaqRekening $rekening)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik' => 'required|string|max:255',
            'qris_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            // Delete old image if exists
            if ($rekening->qris_image) {
                Storage::disk('public')->delete('infaq/' . $rekening->qris_image);
            }

            $file = $request->file('qris_image');
            $filename = 'qris_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('infaq', $filename, 'public');
            $validated['qris_image'] = $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', $rekening->is_active);

        $rekening->update($validated);

        return redirect()->route('admin.infaq.rekening.index')
                        ->with('success', 'Rekening berhasil diperbarui.');
    }

    /**
     * Delete the specified rekening
     */
    public function destroy(InfaqRekening $rekening)
    {
        // Delete QRIS image if exists
        if ($rekening->qris_image) {
            Storage::disk('public')->delete('infaq/' . $rekening->qris_image);
        }

        $rekening->delete();

        return redirect()->route('admin.infaq.rekening.index')
                        ->with('success', 'Rekening berhasil dihapus.');
    }

    /**
     * Toggle active status (via AJAX)
     */
    public function toggleActive(Request $request, InfaqRekening $rekening)
    {
        $rekening->update(['is_active' => !$rekening->is_active]);

        return response()->json(['success' => true, 'is_active' => $rekening->is_active]);
    }
}
