<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservasiApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_pengguna'             => 'required|string|max:255',
            'no_tlp_pengguna'           => 'required|string|max:20',
            'email_pengguna'            => 'required|email',
            'username_pengguna'         => 'required|string',
            'nama_barang'               => 'required|string',
            'jenis'                     => 'required|string',
            'keperluan'                 => 'required|string',
            'tanggal_mulai_reservasi'   => 'required|date',
            'tanggal_selesai_reservasi' => 'required|date|after_or_equal:tanggal_mulai_reservasi',
            'total_peminjaman'          => 'required|integer|min:1',
            'total_harga'               => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $reservasi = Reservasi::create($request->all() + ['status_reservasi' => 'Menunggu']);

        return response()->json(['status' => 'success', 'message' => 'Reservasi berhasil dikirim.', 'data' => ['id' => $reservasi->id]], 201);
    }

    public function show(int $id): JsonResponse
    {
        $r = Reservasi::find($id);
        if (!$r) {
            return response()->json(['status' => 'error', 'message' => 'Reservasi tidak ditemukan.'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $this->format($r)]);
    }

    public function riwayat(string $username): JsonResponse
    {
        $data = Reservasi::where('username_pengguna', $username)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($r) => $this->format($r));

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    private function format(Reservasi $r): array
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
