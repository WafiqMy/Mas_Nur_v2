<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // ===================== PUBLIK =====================

    public function index()
    {
        $berita = Berita::orderBy('tanggal_berita', 'desc')->get();
        return view('berita.index', compact('berita'));
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.show', compact('berita'));
    }

    // ===================== ADMIN ONLY =====================

    public function create()
    {
        $this->authorizeAdmin();
        return view('berita.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'isi_berita'   => 'required|string',
            'foto_berita'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $user = Session::get('user');

        $data = [
            'judul_berita'   => $request->judul_berita,
            'isi_berita'     => $request->isi_berita,
            'tanggal_berita' => now(),
            'username'       => $user['username'] ?? 'admin',
        ];

        if ($request->hasFile('foto_berita')) {
            $file     = $request->file('foto_berita');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('berita', $filename, 'public');
            $data['foto_berita'] = $filename;
        }

        Berita::create($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $berita = Berita::findOrFail($id);
        return view('berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'isi_berita'   => 'required|string',
            'foto_berita'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'judul_berita' => $request->judul_berita,
            'isi_berita'   => $request->isi_berita,
        ];

        if ($request->hasFile('foto_berita')) {
            if ($berita->foto_berita) {
                Storage::disk('public')->delete('berita/' . $berita->foto_berita);
            }
            $file     = $request->file('foto_berita');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('berita', $filename, 'public');
            $data['foto_berita'] = $filename;
        }

        $berita->update($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $berita = Berita::findOrFail($id);

        if ($berita->foto_berita) {
            Storage::disk('public')->delete('berita/' . $berita->foto_berita);
        }

        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || strtolower(trim((string) ($user['role'] ?? ''))) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
