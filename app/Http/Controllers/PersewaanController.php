<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PersewaanController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    // ===================== PUBLIK =====================

    public function index()
    {
        $raw = $this->api->getBarangList();

        // API api_barang.php mengembalikan array langsung
        $semua = is_array($raw) && isset($raw[0]) ? $raw : ($raw['data'] ?? []);

        $gedung     = array_values(array_filter($semua, fn($b) => strtolower($b['Jenis'] ?? '') === 'gedung'));
        $multimedia = array_values(array_filter($semua, fn($b) => str_contains(strtolower($b['Jenis'] ?? ''), 'multimedia')));
        $musik      = array_values(array_filter($semua, fn($b) =>
            str_contains(strtolower($b['Jenis'] ?? ''), 'musik') ||
            str_contains(strtolower($b['Jenis'] ?? ''), 'banjari')
        ));

        return view('reservasi.index', compact('gedung', 'multimedia', 'musik'));
    }

    public function show($id)
    {
        $raw = $this->api->getBarangList();
        $semua = is_array($raw) && isset($raw[0]) ? $raw : ($raw['data'] ?? []);

        $barang = null;
        foreach ($semua as $b) {
            if ((int)($b['id_persewaan'] ?? $b['id'] ?? 0) === (int)$id) {
                $barang = $b;
                break;
            }
        }

        if (!$barang) {
            abort(404, 'Barang tidak ditemukan.');
        }

        return view('reservasi.detail-barang', compact('barang'));
    }

    // ===================== ADMIN ONLY =====================

    public function adminIndex()
    {
        $this->authorizeAdmin();

        $raw = $this->api->getBarangList();
        $barang = is_array($raw) && isset($raw[0]) ? $raw : ($raw['data'] ?? []);

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
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fields = [
            'nama_barang' => $request->nama_barang,
            'Jenis'       => $request->Jenis,
            'harga'       => (int) $request->harga,
            'jumlah'      => (int) $request->jumlah,
            'deskripsi'   => $request->deskripsi ?? '',
            'spesifikasi' => $request->spesifikasi ?? '',
            'fasilitas'   => $request->fasilitas ?? '',
        ];

        $response = $this->api->tambahBarang(
            $fields,
            $request->hasFile('gambar') ? $request->file('gambar') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('admin.reservasi.index')
                ->with('success', 'Barang berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal menambahkan barang.'])
            ->withInput();
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $raw = $this->api->getBarangList();
        $semua = is_array($raw) && isset($raw[0]) ? $raw : ($raw['data'] ?? []);

        $barang = null;
        foreach ($semua as $b) {
            if ((int)($b['id_persewaan'] ?? $b['id'] ?? 0) === (int)$id) {
                $barang = $b;
                break;
            }
        }

        if (!$barang) {
            abort(404, 'Barang tidak ditemukan.');
        }

        return view('admin.reservasi.edit-barang', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'Jenis'       => 'required|in:Gedung,Alat Musik,Alat Multimedia',
            'harga'       => 'required|numeric|min:0',
            'jumlah'      => 'required|integer|min:1',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fields = [
            'id_persewaan' => $id,
            'nama_barang'  => $request->nama_barang,
            'Jenis'        => $request->Jenis,
            'harga'        => (int) $request->harga,
            'jumlah'       => (int) $request->jumlah,
            'deskripsi'    => $request->deskripsi ?? '',
            'spesifikasi'  => $request->spesifikasi ?? '',
            'fasilitas'    => $request->fasilitas ?? '',
        ];

        $response = $this->api->editBarang(
            $fields,
            $request->hasFile('gambar') ? $request->file('gambar') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('admin.reservasi.index')
                ->with('success', 'Barang berhasil diperbarui.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal memperbarui barang.'])
            ->withInput();
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $response = $this->api->hapusBarang((int) $id);

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('admin.reservasi.index')
                ->with('success', 'Barang berhasil dihapus.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal menghapus barang.']);
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
