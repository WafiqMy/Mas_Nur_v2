<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publikasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublikasiApiController extends Controller
{
    // ===================== PUBLIK =====================

    public function index(): JsonResponse
    {
        $data = Publikasi::active()->orderBy('created_at', 'desc')->get()->map(fn($p) => $this->format($p));
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    // ===================== ADMIN (butuh token) =====================

    public function adminIndex(): JsonResponse
    {
        $data = Publikasi::orderBy('created_at', 'desc')->get()->map(fn($p) => $this->format($p));
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:255',
            'foto'       => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keterangan' => 'nullable|string|max:500',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $file     = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('publikasi', $filename, 'public');

        $publikasi = Publikasi::create([
            'judul'      => $request->judul,
            'foto'       => $filename,
            'keterangan' => $request->keterangan,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Poster berhasil ditambahkan.', 'data' => $this->format($publikasi)], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $publikasi = Publikasi::find($id);
        if (!$publikasi) return response()->json(['status' => 'error', 'message' => 'Poster tidak ditemukan.'], 404);

        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:255',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keterangan' => 'nullable|string|max:500',
            'is_active'  => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = [
            'judul'      => $request->judul,
            'keterangan' => $request->keterangan,
            'is_active'  => $request->boolean('is_active', $publikasi->is_active),
        ];

        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete('publikasi/' . $publikasi->foto);
            $file     = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('publikasi', $filename, 'public');
            $data['foto'] = $filename;
        }

        $publikasi->update($data);

        return response()->json(['status' => 'success', 'message' => 'Poster berhasil diperbarui.', 'data' => $this->format($publikasi->fresh())]);
    }

    public function destroy(int $id): JsonResponse
    {
        $publikasi = Publikasi::find($id);
        if (!$publikasi) return response()->json(['status' => 'error', 'message' => 'Poster tidak ditemukan.'], 404);

        Storage::disk('public')->delete('publikasi/' . $publikasi->foto);
        $publikasi->delete();

        return response()->json(['status' => 'success', 'message' => 'Poster berhasil dihapus.']);
    }

    public function toggleActive(int $id): JsonResponse
    {
        $publikasi = Publikasi::find($id);
        if (!$publikasi) return response()->json(['status' => 'error', 'message' => 'Poster tidak ditemukan.'], 404);

        $publikasi->update(['is_active' => !$publikasi->is_active]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Status poster berhasil diubah.',
            'data'    => $this->format($publikasi->fresh()),
        ]);
    }

    // ===================== HELPER =====================

    private function format(Publikasi $p): array
    {
        return [
            'id'         => $p->id,
            'judul'      => $p->judul,
            'keterangan' => $p->keterangan,
            'foto_url'   => $p->foto_url,
            'is_active'  => $p->is_active,
            'created_at' => $p->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
