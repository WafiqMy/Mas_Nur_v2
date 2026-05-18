<?php

namespace App\Http\Controllers;

use App\Models\Persewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PersewaanController extends Controller
{
    // ===================== PUBLIK =====================

    public function index()
    {
        $semua      = Persewaan::all();
        $gedung     = $semua->where('Jenis', 'Gedung')->values();
        $multimedia = $semua->filter(fn($b) => str_contains(strtolower($b->Jenis), 'multimedia'))->values();
        $musik      = $semua->filter(fn($b) =>
            str_contains(strtolower($b->Jenis), 'musik') ||
            str_contains(strtolower($b->Jenis), 'banjari')
        )->values();

        return view('reservasi.index', compact('gedung', 'multimedia', 'musik'));
    }

    public function show($id)
    {
        $barang = Persewaan::findOrFail($id);
        return view('reservasi.detail-barang', compact('barang'));
    }

    // ===================== ADMIN ONLY =====================

    public function adminIndex()
    {
        $this->authorizeAdmin();
        $barang = Persewaan::orderBy('created_at', 'desc')->get();
        return view('admin.reservasi.kelola', compact('barang'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.reservasi.tambah-barang');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'Jenis'       => 'required|in:Gedung,Alat Musik,Alat Multimedia',
            'harga'       => 'required|numeric|min:0',
            'jumlah'      => 'required|integer|min:1',
            'deskripsi'   => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fasilitas'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'Jenis'       => $request->Jenis,
            'harga'       => $request->harga,
            'jumlah'      => $request->jumlah,
            'deskripsi'   => $request->deskripsi ?? '',
            'spesifikasi' => $request->spesifikasi ?? '',
            'fasilitas'   => $request->fasilitas ?? '',
        ];

        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('persewaan', $filename, 'public');
            $data['gambar'] = $filename;
        }

        Persewaan::create($data);

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $barang = Persewaan::findOrFail($id);
        return view('admin.reservasi.edit-barang', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $barang = Persewaan::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'Jenis'       => 'required|in:Gedung,Alat Musik,Alat Multimedia',
            'harga'       => 'required|numeric|min:0',
            'jumlah'      => 'required|integer|min:1',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'nama_barang' => $request->nama_barang,
            'Jenis'       => $request->Jenis,
            'harga'       => $request->harga,
            'jumlah'      => $request->jumlah,
            'deskripsi'   => $request->deskripsi ?? '',
            'spesifikasi' => $request->spesifikasi ?? '',
            'fasilitas'   => $request->fasilitas ?? '',
        ];

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete('persewaan/' . $barang->gambar);
            }
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('persewaan', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $barang->update($data);

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $barang = Persewaan::findOrFail($id);

        if ($barang->gambar) {
            Storage::disk('public')->delete('persewaan/' . $barang->gambar);
        }

        $barang->delete();

        return redirect()->route('admin.reservasi.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || strtolower(trim((string) ($user['role'] ?? ''))) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
