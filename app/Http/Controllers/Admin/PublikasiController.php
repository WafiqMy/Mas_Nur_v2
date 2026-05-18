<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiController extends Controller
{
    public function index()
    {
        $publikasi = Publikasi::orderBy('created_at', 'desc')->paginate(12);
        $totalAktif = Publikasi::active()->count();
        $totalSemua = Publikasi::count();

        return view('admin.publikasi.index', compact('publikasi', 'totalAktif', 'totalSemua'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'foto'       => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keterangan' => 'nullable|string|max:500',
            'is_active'  => 'nullable|boolean',
        ]);

        $file     = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('publikasi', $filename, 'public');

        Publikasi::create([
            'judul'      => $request->judul,
            'foto'       => $filename,
            'keterangan' => $request->keterangan,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Poster berhasil ditambahkan.');
    }

    public function update(Request $request, Publikasi $publikasi)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keterangan' => 'nullable|string|max:500',
            'is_active'  => 'nullable|boolean',
        ]);

        $data = [
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'is_active'  => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            Storage::disk('public')->delete('publikasi/' . $publikasi->foto);

            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('publikasi', $filename, 'public');
            $data['foto'] = $filename;
        }

        $publikasi->update($data);

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Poster berhasil diperbarui.');
    }

    public function destroy(Publikasi $publikasi)
    {
        Storage::disk('public')->delete('publikasi/' . $publikasi->foto);
        $publikasi->delete();

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Poster berhasil dihapus.');
    }

    public function toggleActive(Publikasi $publikasi)
    {
        $publikasi->update(['is_active' => !$publikasi->is_active]);
        $status = $publikasi->is_active ? 'ditampilkan' : 'disembunyikan';

        return redirect()->route('admin.publikasi.index')
            ->with('success', "Poster berhasil {$status}.");
    }
}
