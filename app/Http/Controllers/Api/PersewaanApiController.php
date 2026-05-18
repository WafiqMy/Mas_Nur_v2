<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Persewaan;
use App\Models\Reservasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PersewaanApiController extends Controller
{
    // ===================== PUBLIK =====================

    public function index(Request $request): JsonResponse
    {
        $query = Persewaan::query();
        if ($request->query('jenis')) {
            $query->where('Jenis', $request->query('jenis'));
        }
        return response()->json(['status' => 'success', 'data' => $query->get()->map(fn($b) => $this->format($b))]);
    }

    public function show(int $id): JsonResponse
    {
        $b = Persewaan::find($id);
        if (!$b) return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan.'], 404);
        return response()->json(['status' => 'success', 'data' => $this->format($b)]);
    }

    public function kalender(int $id): JsonResponse
    {
        $barang = Persewaan::find($id);
        if (!$barang) return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan.'], 404);

        $reservasi = Reservasi::where('nama_barang', $barang->nama_barang)
            ->whereIn('status_reservasi', ['Menunggu', 'Disetujui'])
            ->get()->map(fn($r) => [
                'title'           => $r->nama_pengguna,
                'start'           => $r->tanggal_mulai_reservasi->format('Y-m-d'),
                'end'             => $r->tanggal_selesai_reservasi->addDay()->format('Y-m-d'),
                'backgroundColor' => $r->status_color,
            ]);

        return response()->json(['status' => 'success', 'data' => $reservasi]);
    }

    // ===================== ADMIN — KELOLA BARANG =====================

    public function adminStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'Jenis'       => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'jumlah'      => 'required|integer|min:1',
            'deskripsi'   => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fasilitas'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('nama_barang', 'Jenis', 'harga', 'jumlah', 'deskripsi', 'spesifikasi', 'fasilitas');

        if ($request->hasFile('gambar')) {
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('persewaan', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $barang = Persewaan::create($data);

        return response()->json(['status' => 'success', 'message' => 'Barang berhasil ditambahkan.', 'data' => $this->format($barang)], 201);
    }

    public function adminUpdate(Request $request, int $id): JsonResponse
    {
        $barang = Persewaan::find($id);
        if (!$barang) return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan.'], 404);

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'Jenis'       => 'required|string|max:100',
            'harga'       => 'required|numeric|min:0',
            'jumlah'      => 'required|integer|min:1',
            'deskripsi'   => 'nullable|string',
            'spesifikasi' => 'nullable|string',
            'fasilitas'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('nama_barang', 'Jenis', 'harga', 'jumlah', 'deskripsi', 'spesifikasi', 'fasilitas');

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) Storage::disk('public')->delete('persewaan/' . $barang->gambar);
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('persewaan', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $barang->update($data);

        return response()->json(['status' => 'success', 'message' => 'Barang berhasil diperbarui.', 'data' => $this->format($barang->fresh())]);
    }

    public function adminDestroy(int $id): JsonResponse
    {
        $barang = Persewaan::find($id);
        if (!$barang) return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan.'], 404);

        if ($barang->gambar) Storage::disk('public')->delete('persewaan/' . $barang->gambar);
        $barang->delete();

        return response()->json(['status' => 'success', 'message' => 'Barang berhasil dihapus.']);
    }

    // ===================== ADMIN — KELOLA PERMINTAAN RESERVASI =====================

    public function semuaReservasi(Request $request): JsonResponse
    {
        $query = Reservasi::orderBy('created_at', 'desc');

        if ($request->query('status')) {
            $query->where('status_reservasi', $request->query('status'));
        }

        $data = $query->get()->map(fn($r) => $this->formatReservasi($r));

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function updateStatusReservasi(Request $request, int $id): JsonResponse
    {
        $reservasi = Reservasi::find($id);
        if (!$reservasi) return response()->json(['status' => 'error', 'message' => 'Reservasi tidak ditemukan.'], 404);

        $validator = Validator::make($request->all(), [
            'status_reservasi' => 'required|in:Menunggu,Disetujui,Ditolak,Batal',
            'notes'            => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $reservasi->update([
            'status_reservasi' => $request->status_reservasi,
            'notes'            => $request->notes,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Status reservasi berhasil diperbarui.',
            'data'    => $this->formatReservasi($reservasi->fresh()),
        ]);
    }

    // ===================== HELPER =====================

    private function format(Persewaan $b): array
    {
        return [
            'id'          => $b->id,
            'nama_barang' => $b->nama_barang,
            'Jenis'       => $b->Jenis,
            'harga'       => (float) $b->harga,
            'jumlah'      => $b->jumlah,
            'deskripsi'   => $b->deskripsi,
            'spesifikasi' => $b->spesifikasi,
            'fasilitas'   => $b->fasilitas,
            'gambar_url'  => $b->gambar_url,
        ];
    }

    private function formatReservasi(Reservasi $r): array
    {
        return [
            'id'                        => $r->id,
            'nama_barang'               => $r->nama_barang,
            'jenis'                     => $r->jenis,
            'nama_pengguna'             => $r->nama_pengguna,
            'no_tlp_pengguna'           => $r->no_tlp_pengguna,
            'email_pengguna'            => $r->email_pengguna,
            'username_pengguna'         => $r->username_pengguna,
            'tanggal_mulai_reservasi'   => $r->tanggal_mulai_reservasi?->format('Y-m-d'),
            'tanggal_selesai_reservasi' => $r->tanggal_selesai_reservasi?->format('Y-m-d'),
            'keperluan'                 => $r->keperluan,
            'total_peminjaman'          => $r->total_peminjaman,
            'total_harga'               => (float) $r->total_harga,
            'status_reservasi'          => $r->status_reservasi,
            'notes'                     => $r->notes,
            'created_at'                => $r->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
