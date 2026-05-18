<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodCourt;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FoodCourtApiController extends Controller
{
    // ===================== PUBLIK =====================

    public function index(): JsonResponse
    {
        $menus = FoodCourt::orderBy('created_at', 'desc')->get()->map(fn($m) => $this->format($m));
        return response()->json(['status' => 'success', 'data' => $menus]);
    }

    public function show(int $id): JsonResponse
    {
        $menu = FoodCourt::find($id);
        if (!$menu) return response()->json(['status' => 'error', 'message' => 'Menu tidak ditemukan.'], 404);
        return response()->json(['status' => 'success', 'data' => $this->format($menu)]);
    }

    // ===================== ADMIN (butuh token) =====================

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('nama_menu', 'deskripsi');

        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('food_court', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $menu = FoodCourt::create($data);

        return response()->json(['status' => 'success', 'message' => 'Menu berhasil ditambahkan.', 'data' => $this->format($menu)], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $menu = FoodCourt::find($id);
        if (!$menu) return response()->json(['status' => 'error', 'message' => 'Menu tidak ditemukan.'], 404);

        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('nama_menu', 'deskripsi');

        if ($request->hasFile('gambar')) {
            if ($menu->gambar) Storage::disk('public')->delete('food_court/' . $menu->gambar);
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('food_court', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $menu->update($data);

        return response()->json(['status' => 'success', 'message' => 'Menu berhasil diperbarui.', 'data' => $this->format($menu->fresh())]);
    }

    public function destroy(int $id): JsonResponse
    {
        $menu = FoodCourt::find($id);
        if (!$menu) return response()->json(['status' => 'error', 'message' => 'Menu tidak ditemukan.'], 404);

        if ($menu->gambar) Storage::disk('public')->delete('food_court/' . $menu->gambar);
        $menu->delete();

        return response()->json(['status' => 'success', 'message' => 'Menu berhasil dihapus.']);
    }

    // ===================== HELPER =====================

    private function format(FoodCourt $m): array
    {
        return [
            'id'         => $m->id_food,
            'nama_menu'  => $m->nama_menu,
            'deskripsi'  => $m->deskripsi,
            'gambar_url' => $m->gambar_url,
        ];
    }
}
