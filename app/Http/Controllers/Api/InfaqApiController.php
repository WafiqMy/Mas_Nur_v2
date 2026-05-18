<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfaqDana;
use App\Models\InfaqPengeluaran;
use App\Models\InfaqRekening;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InfaqApiController extends Controller
{
    // ===================== PUBLIK =====================

    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'rekening'         => $this->getRekeningData(),
                'laporan_masuk'    => $this->getDanaMasukData(10),
                'laporan_keluar'   => $this->getPengeluaranData(10),
                'total_masuk'      => InfaqDana::getTotalAll(),
                'total_keluar'     => InfaqPengeluaran::getTotalAll(),
                'saldo'            => InfaqDana::getTotalAll() - InfaqPengeluaran::getTotalAll(),
                'total_masuk_bulan'=> InfaqDana::getTotalByMonth(now()->month, now()->year),
            ],
        ]);
    }

    public function rekening(): JsonResponse
    {
        return response()->json(['status' => 'success', 'data' => $this->getRekeningData()]);
    }

    public function laporan(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'masuk'       => $this->getDanaMasukData(),
                'keluar'      => $this->getPengeluaranData(),
                'total_masuk' => InfaqDana::getTotalAll(),
                'total_keluar'=> InfaqPengeluaran::getTotalAll(),
                'saldo'       => InfaqDana::getTotalAll() - InfaqPengeluaran::getTotalAll(),
            ],
        ]);
    }

    // ===================== ADMIN — GET DATA =====================

    public function adminDana(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $this->getDanaMasukData(),
        ]);
    }

    public function adminPengeluaran(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => $this->getPengeluaranData(),
        ]);
    }

    public function adminRingkasan(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'dana_masuk'       => $this->getDanaMasukData(),
                'dana_keluar'      => $this->getPengeluaranData(),
                'rekening'         => $this->getRekeningData(),
                'total_masuk'      => InfaqDana::getTotalAll(),
                'total_keluar'     => InfaqPengeluaran::getTotalAll(),
                'saldo'            => InfaqDana::getTotalAll() - InfaqPengeluaran::getTotalAll(),
                'total_masuk_bulan'=> InfaqDana::getTotalByMonth(now()->month, now()->year),
                'total_keluar_bulan'=> InfaqPengeluaran::getTotalByMonth(now()->month, now()->year),
            ],
        ]);
    }

    // ===================== ADMIN — DANA MASUK =====================

    public function storeDana(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $dana = InfaqDana::create($request->only('judul', 'jumlah', 'tanggal', 'keterangan'));

        return response()->json([
            'status'  => 'success',
            'message' => 'Dana masuk berhasil ditambahkan.',
            'data'    => $this->formatDana($dana),
        ], 201);
    }

    public function updateDana(Request $request, int $id): JsonResponse
    {
        $dana = InfaqDana::find($id);
        if (!$dana) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);

        $validator = Validator::make($request->all(), [
            'judul'      => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $dana->update($request->only('judul', 'jumlah', 'tanggal', 'keterangan'));

        return response()->json(['status' => 'success', 'message' => 'Dana masuk berhasil diperbarui.', 'data' => $this->formatDana($dana->fresh())]);
    }

    public function destroyDana(int $id): JsonResponse
    {
        $dana = InfaqDana::find($id);
        if (!$dana) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);

        $dana->delete();
        return response()->json(['status' => 'success', 'message' => 'Dana masuk berhasil dihapus.']);
    }

    // ===================== ADMIN — DANA KELUAR =====================

    public function storePengeluaran(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'keperluan'  => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $pengeluaran = InfaqPengeluaran::create($request->only('keperluan', 'jumlah', 'tanggal', 'keterangan'));

        return response()->json([
            'status'  => 'success',
            'message' => 'Dana keluar berhasil ditambahkan.',
            'data'    => $this->formatPengeluaran($pengeluaran),
        ], 201);
    }

    public function updatePengeluaran(Request $request, int $id): JsonResponse
    {
        $pengeluaran = InfaqPengeluaran::find($id);
        if (!$pengeluaran) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);

        $validator = Validator::make($request->all(), [
            'keperluan'  => 'required|string|max:255',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $pengeluaran->update($request->only('keperluan', 'jumlah', 'tanggal', 'keterangan'));

        return response()->json(['status' => 'success', 'message' => 'Dana keluar berhasil diperbarui.', 'data' => $this->formatPengeluaran($pengeluaran->fresh())]);
    }

    public function destroyPengeluaran(int $id): JsonResponse
    {
        $pengeluaran = InfaqPengeluaran::find($id);
        if (!$pengeluaran) return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.'], 404);

        $pengeluaran->delete();
        return response()->json(['status' => 'success', 'message' => 'Dana keluar berhasil dihapus.']);
    }

    // ===================== HELPER =====================

    private function getRekeningData(): array
    {
        return InfaqRekening::where('is_active', true)->get()->map(fn($r) => [
            'id'             => $r->id,
            'nama_bank'      => $r->nama_bank,
            'nomor_rekening' => $r->nomor_rekening,
            'nama_pemilik'   => $r->nama_pemilik,
            'qris_url'       => $r->qris_image ? asset('storage/' . $r->qris_image) : null,
        ])->toArray();
    }

    private function getDanaMasukData(int $limit = 0): array
    {
        $query = InfaqDana::orderBy('tanggal', 'desc');
        if ($limit > 0) $query->limit($limit);
        return $query->get()->map(fn($d) => $this->formatDana($d))->toArray();
    }

    private function getPengeluaranData(int $limit = 0): array
    {
        $query = InfaqPengeluaran::orderBy('tanggal', 'desc');
        if ($limit > 0) $query->limit($limit);
        return $query->get()->map(fn($p) => $this->formatPengeluaran($p))->toArray();
    }

    private function formatDana(InfaqDana $d): array
    {
        return [
            'id'         => $d->id,
            'judul'      => $d->judul,
            'jumlah'     => (float) $d->jumlah,
            'keterangan' => $d->keterangan,
            'tanggal'    => $d->tanggal?->format('Y-m-d'),
        ];
    }

    private function formatPengeluaran(InfaqPengeluaran $p): array
    {
        return [
            'id'         => $p->id,
            'keperluan'  => $p->keperluan,
            'jumlah'     => (float) $p->jumlah,
            'keterangan' => $p->keterangan,
            'tanggal'    => $p->tanggal?->format('Y-m-d'),
        ];
    }
}
