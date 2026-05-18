<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfaqRekening;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InfaqRekeningApiController extends Controller
{
    /**
     * GET /api/v1/admin/infaq/rekening
     * Semua rekening (aktif & nonaktif) — admin only
     */
    public function index(): JsonResponse
    {
        $data = InfaqRekening::orderBy('id', 'asc')->get()->map(fn($r) => $this->format($r));
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * POST /api/v1/admin/infaq/rekening
     * Tambah rekening baru
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_bank'      => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik'   => 'required|string|max:100',
            'qris_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_active'      => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = [
            'nama_bank'      => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik'   => $request->nama_pemilik,
            'is_active'      => $request->boolean('is_active', true),
        ];

        if ($request->hasFile('qris_image')) {
            $file     = $request->file('qris_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('infaq', $filename, 'public');
            $data['qris_image'] = $path;
        }

        $rekening = InfaqRekening::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Rekening berhasil ditambahkan.',
            'data'    => $this->format($rekening),
        ], 201);
    }

    /**
     * POST /api/v1/admin/infaq/rekening/{id}
     * Update rekening
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $rekening = InfaqRekening::find($id);
        if (!$rekening) {
            return response()->json(['status' => 'error', 'message' => 'Rekening tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_bank'      => 'required|string|max:100',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik'   => 'required|string|max:100',
            'qris_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_active'      => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = [
            'nama_bank'      => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik'   => $request->nama_pemilik,
            'is_active'      => $request->boolean('is_active', $rekening->is_active),
        ];

        if ($request->hasFile('qris_image')) {
            if ($rekening->qris_image && Storage::disk('public')->exists($rekening->qris_image)) {
                Storage::disk('public')->delete($rekening->qris_image);
            }
            $file     = $request->file('qris_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path     = $file->storeAs('infaq', $filename, 'public');
            $data['qris_image'] = $path;
        }

        $rekening->update($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Rekening berhasil diperbarui.',
            'data'    => $this->format($rekening->fresh()),
        ]);
    }

    /**
     * DELETE /api/v1/admin/infaq/rekening/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $rekening = InfaqRekening::find($id);
        if (!$rekening) {
            return response()->json(['status' => 'error', 'message' => 'Rekening tidak ditemukan.'], 404);
        }

        if ($rekening->qris_image && Storage::disk('public')->exists($rekening->qris_image)) {
            Storage::disk('public')->delete($rekening->qris_image);
        }

        $rekening->delete();

        return response()->json(['status' => 'success', 'message' => 'Rekening berhasil dihapus.']);
    }

    /**
     * PATCH /api/v1/admin/infaq/rekening/{id}/toggle
     * Toggle aktif/nonaktif
     */
    public function toggleActive(int $id): JsonResponse
    {
        $rekening = InfaqRekening::find($id);
        if (!$rekening) {
            return response()->json(['status' => 'error', 'message' => 'Rekening tidak ditemukan.'], 404);
        }

        $rekening->update(['is_active' => !$rekening->is_active]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Status rekening berhasil diubah.',
            'data'    => $this->format($rekening->fresh()),
        ]);
    }

    // ===================== HELPER =====================

    private function format(InfaqRekening $r): array
    {
        return [
            'id'             => $r->id,
            'nama_bank'      => $r->nama_bank,
            'nomor_rekening' => $r->nomor_rekening,
            'nama_pemilik'   => $r->nama_pemilik,
            'qris_url'       => $r->qris_image ? asset('storage/' . $r->qris_image) : null,
            'is_active'      => $r->is_active,
            'created_at'     => $r->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
