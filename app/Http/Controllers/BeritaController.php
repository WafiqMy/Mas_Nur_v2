<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BeritaController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->getBeritaList();

        // API berita-list.php mengembalikan {status, data:[...]}
        $berita = [];
        if (isset($response['status']) && $response['status'] === 'success') {
            $berita = $response['data'] ?? [];
        } elseif (is_array($response) && isset($response[0])) {
            // fallback jika API langsung return array
            $berita = $response;
        }

        return view('berita.index', compact('berita'));
    }

    public function show($id)
    {
        $response = $this->api->getBerita((int) $id);

        if (!isset($response['status']) || $response['status'] !== 'success') {
            abort(404, 'Berita tidak ditemukan.');
        }

        $berita = $response['data'];
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
            'isi_berita'   => 'required|string|max:12000',
            'foto_berita'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Session::get('user');

        $fields = [
            'judul_berita'  => $request->judul_berita,
            'isi_berita'    => $request->isi_berita,
            'tanggal_berita'=> now()->format('Y-m-d'),
            'username'      => $user['username'] ?? 'admin',
        ];

        $response = $this->api->tambahBerita(
            $fields,
            $request->hasFile('foto_berita') ? $request->file('foto_berita') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('berita.index')
                ->with('success', 'Berita berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal menambahkan berita.'])
            ->withInput();
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $response = $this->api->getBerita((int) $id);

        if (!isset($response['status']) || $response['status'] !== 'success') {
            abort(404, 'Berita tidak ditemukan.');
        }

        $berita = $response['data'];
        return view('berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'isi_berita'   => 'required|string|max:12000',
            'foto_berita'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Session::get('user');

        $fields = [
            'id_berita'    => $id,
            'judul_berita' => $request->judul_berita,
            'isi_berita'   => $request->isi_berita,
            'username'     => $user['username'] ?? 'admin',
        ];

        $response = $this->api->editBerita(
            $fields,
            $request->hasFile('foto_berita') ? $request->file('foto_berita') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('berita.index')
                ->with('success', 'Berita berhasil diperbarui.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal memperbarui berita.'])
            ->withInput();
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $response = $this->api->hapusBerita((int) $id);

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('berita.index')
                ->with('success', 'Berita berhasil dihapus.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal menghapus berita.']);
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
