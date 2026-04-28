<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfilMasjidController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function show()
    {
        $raw    = $this->api->getLandingContent();
        $profil = $raw['profil'] ?? null;
        return view('profil-masjid.show', compact('profil'));
    }

    public function struktur()
    {
        $response = $this->api->getStruktur();
        $struktur = ($response['status'] ?? '') === 'success' ? ($response['data'] ?? null) : null;
        return view('profil-masjid.struktur', compact('struktur'));
    }

    // ===================== ADMIN ONLY =====================

    public function edit()
    {
        $this->authorizeAdmin();
        $raw    = $this->api->getLandingContent();
        $profil = $raw['profil'] ?? [];
        return view('admin.profil-masjid.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'judul_sejarah'        => 'required|string|max:255',
            'deskripsi_sejarah'    => 'required|string',
            'gambar_sejarah_masjid'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $user = Session::get('user');

        $fields = [
            'judul_sejarah'     => $request->judul_sejarah,
            'deskripsi_sejarah' => $request->deskripsi_sejarah,
            'username'          => $user['username'] ?? 'admin',
        ];

        $response = $this->api->editProfilMasjid(
            $fields,
            $request->hasFile('gambar_sejarah_masjid') ? $request->file('gambar_sejarah_masjid') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('admin.profil-masjid.edit')
                ->with('success', 'Profil masjid berhasil diperbarui.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal memperbarui profil.'])
            ->withInput();
    }

    public function editStruktur()
    {
        $this->authorizeAdmin();
        $response = $this->api->getStruktur();
        $struktur = ($response['status'] ?? '') === 'success' ? ($response['data'] ?? []) : [];
        return view('admin.profil-masjid.edit-struktur', compact('struktur'));
    }

    public function updateStruktur(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'gambar_struktur_organisasi' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'gambar_struktur_remas'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $user = Session::get('user');

        $fields = [
            'username' => $user['username'] ?? 'admin',
        ];

        $response = $this->api->editStruktur(
            $fields,
            $request->hasFile('gambar_struktur_organisasi') ? $request->file('gambar_struktur_organisasi') : null,
            $request->hasFile('gambar_struktur_remas') ? $request->file('gambar_struktur_remas') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('admin.profil-masjid.edit-struktur')
                ->with('success', 'Struktur organisasi berhasil diperbarui.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal memperbarui struktur.'])
            ->withInput();
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
