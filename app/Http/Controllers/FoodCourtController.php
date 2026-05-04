<?php

namespace App\Http\Controllers;

use App\Models\FoodCourt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class FoodCourtController extends Controller
{
    // ===================== PUBLIK (semua orang bisa lihat) =====================

    public function index()
    {
        $menus = FoodCourt::orderBy('created_at', 'desc')->get();
        return view('food-court.index', compact('menus'));
    }

    // ===================== ADMIN ONLY =====================

    public function adminIndex()
    {
        $this->authorizeAdmin();
        $menus = FoodCourt::orderBy('created_at', 'desc')->get();
        return view('admin.food-court.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $data = [
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('food_court', $filename, 'public');
            $data['gambar'] = $filename;
        }

        FoodCourt::create($data);

        return redirect()->route('admin.food-court.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function update(Request $request, FoodCourt $foodCourt)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $data = [
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            if ($foodCourt->gambar) {
                Storage::disk('public')->delete('food_court/' . $foodCourt->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('food_court', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $foodCourt->update($data);

        return redirect()->route('admin.food-court.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(FoodCourt $foodCourt)
    {
        $this->authorizeAdmin();

        if ($foodCourt->gambar) {
            Storage::disk('public')->delete('food_court/' . $foodCourt->gambar);
        }

        $foodCourt->delete();

        return redirect()->route('admin.food-court.index')
            ->with('success', 'Menu berhasil dihapus.');
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || strtolower(trim((string) ($user['role'] ?? ''))) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
