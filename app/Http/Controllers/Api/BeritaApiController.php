<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaApiController extends Controller
{
    // ===================== PUBLIK =====================

    /**
     * GET /api/v1/berita
     */
    public function index(): JsonResponse
    {
        $berita = Berita::orderBy('tanggal_berita', 'desc')->get()->map(fn($b) => $this->format($b));
        return response()->json(['status' => 'success', 'data' => $berita]);
    }

    /**
     * GET /api/v1/berita/{id}
     */
    public function show(int $id): JsonResponse
    {
        $b = Berita::find($id);
        if (!$b) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $this->format($b)]);
    }

    // ===================== ADMIN (butuh token) =====================

    /**
     * POST /api/v1/admin/berita
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'judul_berita'   => 'required|string|max:255',
            'isi_berita'     => 'required|string',
            'tanggal_berita' => 'nullable|date',
            'foto_berita'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = [
            'judul_berita'   => $request->judul_berita,
            'isi_berita'     => $request->isi_berita,
            'tanggal_berita' => $request->tanggal_berita ?? now(),
            'username'       => $request->user()->username,
        ];

        if ($request->hasFile('foto_berita')) {
            $file     = $request->file('foto_berita');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('berita', $filename, 'public');
            $data['foto_berita'] = $filename;
        }

        $berita = Berita::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Berita berhasil ditambahkan.',
            'data'    => $this->format($berita),
        ], 201);
    }

    /**
     * POST /api/v1/admin/berita/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $berita = Berita::find($id);
        if (!$berita) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul_berita'   => 'required|string|max:255',
            'isi_berita'     => 'required|string',
            'tanggal_berita' => 'nullable|date',
            'foto_berita'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = [
            'judul_berita'   => $request->judul_berita,
            'isi_berita'     => $request->isi_berita,
            'tanggal_berita' => $request->tanggal_berita ?? $berita->tanggal_berita,
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

        return response()->json([
            'status'  => 'success',
            'message' => 'Berita berhasil diperbarui.',
            'data'    => $this->format($berita->fresh()),
        ]);
    }

    /**
     * DELETE /api/v1/admin/berita/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $berita = Berita::find($id);
        if (!$berita) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        if ($berita->foto_berita) {
            Storage::disk('public')->delete('berita/' . $berita->foto_berita);
        }

        $berita->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Berita berhasil dihapus.',
        ]);
    }

    // ===================== HELPER =====================

    private function format(Berita $b): array
    {
        return [
            'id'             => $b->id,
            'judul_berita'   => $b->judul_berita,
            'isi_berita'     => $b->isi_berita,
            'foto_berita'    => $b->foto_berita,
            'foto_url'       => $b->foto_url,
            'username'       => $b->username,
            'tanggal_berita' => $b->tanggal_berita?->format('Y-m-d H:i:s'),
        ];
    }
}
