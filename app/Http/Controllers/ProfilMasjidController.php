<?php

namespace App\Http\Controllers;

use App\Models\ProfilMasjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProfilMasjidController extends Controller
{
    // ===================== PUBLIK =====================

    public function show()
    {
        $profil = ProfilMasjid::first();
        return view('profil-masjid.show', compact('profil'));
    }

    public function struktur()
    {
        $profil = ProfilMasjid::first();
        return view('profil-masjid.struktur', compact('profil'));
    }

    // ===================== ADMIN ONLY =====================

    public function edit()
    {
        $this->authorizeAdmin();
        $profil = ProfilMasjid::first() ?? new ProfilMasjid();
        return view('admin.profil-masjid.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_masjid'           => 'nullable|string|max:255',
            'deskripsi'             => 'nullable|string',
            'sejarah_masjid'        => 'nullable|string',
            'alamat'                => 'nullable|string|max:255',
            'telepon'               => 'nullable|string|max:20',
            'whatsapp'              => 'nullable|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'website'               => 'nullable|url|max:255',
            'gambar_sejarah_masjid' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $profil = ProfilMasjid::firstOrNew([]);

        $data = [
            'nama_masjid'    => $request->nama_masjid ?? $profil->nama_masjid,
            'deskripsi'      => $request->deskripsi,
            'sejarah_masjid' => $request->sejarah_masjid ?? $request->deskripsi_sejarah,
            'alamat'         => $request->alamat,
            'telepon'        => $request->telepon,
            'whatsapp'       => $request->whatsapp,
            'email'          => $request->email,
            'website'        => $request->website,
        ];

        if ($request->hasFile('gambar_sejarah_masjid')) {
            if ($profil->gambar_sejarah_masjid) {
                Storage::disk('public')->delete('profil_masjid/' . $profil->gambar_sejarah_masjid);
            }
            $file     = $request->file('gambar_sejarah_masjid');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profil_masjid', $filename, 'public');
            $data['gambar_sejarah_masjid'] = $filename;
        }

        $profil->fill($data)->save();

        return redirect()->route('admin.profil-masjid.edit')
            ->with('success', 'Profil masjid berhasil diperbarui.');
    }

    public function editStruktur()
    {
        $this->authorizeAdmin();
        $profil = ProfilMasjid::first() ?? new ProfilMasjid();
        return view('admin.profil-masjid.edit-struktur', compact('profil'));
    }

    public function updateStruktur(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'deskripsi_remas'            => 'nullable|string',
            'gambar_struktur_organisasi' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'gambar_struktur_remas'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $profil = ProfilMasjid::firstOrNew([]);
        $data   = ['deskripsi_remas' => $request->deskripsi_remas];

        if ($request->hasFile('gambar_struktur_organisasi')) {
            $file     = $request->file('gambar_struktur_organisasi');
            $filename = time() . '_org_' . $file->getClientOriginalName();
            $file->storeAs('profil_masjid', $filename, 'public');
            $data['gambar_sampul'] = $filename; // pakai gambar_sampul untuk org
        }

        if ($request->hasFile('gambar_struktur_remas')) {
            if ($profil->gambar_struktur_remas) {
                Storage::disk('public')->delete('profil_masjid/' . $profil->gambar_struktur_remas);
            }
            $file     = $request->file('gambar_struktur_remas');
            $filename = time() . '_remas_' . $file->getClientOriginalName();
            $file->storeAs('profil_masjid', $filename, 'public');
            $data['gambar_struktur_remas'] = $filename;
        }

        $profil->fill($data)->save();

        return redirect()->route('admin.profil-masjid.edit-struktur')
            ->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || strtolower(trim((string) ($user['role'] ?? ''))) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
