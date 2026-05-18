<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInfaqRekeningRequest;
use App\Http\Requests\UpdateInfaqRekeningRequest;
use App\Models\InfaqRekening;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class InfaqRekeningController extends Controller
{
    /**
     * Display a listing of rekening resources.
     */
    public function index(): View
    {
        $rekenings = InfaqRekening::orderBy('id', 'asc')->get();
        $activeCount = InfaqRekening::active()->count();
        $withQrisCount = InfaqRekening::whereNotNull('qris_image')->count();

        return view('admin.infaq.rekening.index', [
            'rekenings'      => $rekenings,
            'activeCount'    => $activeCount,
            'withQrisCount'  => $withQrisCount,
            'totalRekenings' => $rekenings->count(),
        ]);
    }

    /**
     * Store a newly created rekening resource in storage.
     */
    public function store(StoreInfaqRekeningRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('qris_image')) {
            $file = $request->file('qris_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('infaq', $filename, 'public');
            $data['qris_image'] = $path;
        }

        InfaqRekening::create($data);

        return redirect()->route('admin.infaq.rekening.index')
            ->with('success', 'Rekening berhasil ditambahkan');
    }

    /**
     * Update the specified rekening resource in storage.
     */
    public function update(UpdateInfaqRekeningRequest $request, InfaqRekening $rekening): RedirectResponse
    {
        $data = $request->validated();

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            // Delete old image if exists
            if ($rekening->qris_image && Storage::disk('public')->exists($rekening->qris_image)) {
                Storage::disk('public')->delete($rekening->qris_image);
            }

            $file = $request->file('qris_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('infaq', $filename, 'public');
            $data['qris_image'] = $path;
        }

        $rekening->update($data);

        return redirect()->route('admin.infaq.rekening.index')
            ->with('success', 'Rekening berhasil diperbarui');
    }

    /**
     * Remove the specified rekening resource from storage.
     */
    public function destroy(InfaqRekening $rekening): RedirectResponse
    {
        // Delete QRIS image if exists
        if ($rekening->qris_image && Storage::disk('public')->exists($rekening->qris_image)) {
            Storage::disk('public')->delete($rekening->qris_image);
        }

        $rekening->delete();

        return redirect()->route('admin.infaq.rekening.index')
            ->with('success', 'Rekening berhasil dihapus');
    }

    /**
     * Toggle the active status of a rekening.
     */
    public function toggleActive(InfaqRekening $rekening): RedirectResponse
    {
        $rekening->update([
            'is_active' => !$rekening->is_active,
        ]);

        $status = $rekening->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.infaq.rekening.index')
            ->with('success', "Rekening berhasil {$status}");
    }

    /**
     * Remove QRIS image from a rekening.
     */
    public function removeQris(InfaqRekening $rekening): RedirectResponse
    {
        if ($rekening->qris_image && Storage::disk('public')->exists($rekening->qris_image)) {
            Storage::disk('public')->delete($rekening->qris_image);
            $rekening->update(['qris_image' => null]);
        }

        return redirect()->route('admin.infaq.rekening.index')
            ->with('success', 'QRIS berhasil dihapus');
    }
}
