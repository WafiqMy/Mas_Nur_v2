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
    /**
     * GET /api/food-court
     * Menampilkan semua menu food court (publik).
     */
    public function index(): JsonResponse
    {
        $menus = FoodCourt::orderBy('created_at', 'desc')->get()->map(function ($menu) {
            return [
                'id_food'    => $menu->id_food,
                'nama_menu'  => $menu->nama_menu,
                'deskripsi'  => $menu->deskripsi,
                'gambar'     => $menu->gambar,
                'gambar_url' => $menu->gambar_url,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data'   => $menus,
        ]);
    }

    /**
     * GET /api/food-court/{id}
     * Menampilkan detail satu menu (publik).
     */
    public function show(int $id): JsonResponse
    {
        $menu = FoodCourt::find($id);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id_food'    => $menu->id_food,
                'nama_menu'  => $menu->nama_menu,
                'deskripsi'  => $menu->deskripsi,
                'gambar'     => $menu->gambar,
                'gambar_url' => $menu->gambar_url,
            ],
        ]);
    }

    /**
     * POST /api/food-court
     * Tambah menu baru (admin only).
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:50',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

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

        $menu = FoodCourt::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Menu berhasil ditambahkan.',
            'data'    => [
                'id_food'    => $menu->id_food,
                'nama_menu'  => $menu->nama_menu,
                'deskripsi'  => $menu->deskripsi,
                'gambar_url' => $menu->gambar_url,
            ],
        ], 201);
    }

    /**
     * POST /api/food-court/{id} (dengan _method=PUT)
     * Update menu (admin only).
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $menu = FoodCourt::find($id);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_menu' => 'required|string|max:50',
            'deskripsi' => 'nullable|string|max:50',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = [
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            if ($menu->gambar) {
                Storage::disk('public')->delete('food_court/' . $menu->gambar);
            }
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('food_court', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $menu->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Menu berhasil diperbarui.',
            'data'    => [
                'id_food'    => $menu->id_food,
                'nama_menu'  => $menu->nama_menu,
                'deskripsi'  => $menu->deskripsi,
                'gambar_url' => $menu->gambar_url,
            ],
        ]);
    }

    /**
     * DELETE /api/food-court/{id}
     * Hapus menu (admin only).
     */
    public function destroy(int $id): JsonResponse
    {
        $menu = FoodCourt::find($id);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu tidak ditemukan.',
            ], 404);
        }

        if ($menu->gambar) {
            Storage::disk('public')->delete('food_court/' . $menu->gambar);
        }

        $menu->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Menu berhasil dihapus.',
        ]);
    }
}
