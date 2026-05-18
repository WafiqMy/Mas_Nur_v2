<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    /**
     * POST /api/v1/login
     * Login admin — mengembalikan token Sanctum
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Username dan password wajib diisi.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $akun = Akun::where('username', $request->username)->first();

        if (!$akun || !Hash::check($request->password, $akun->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Username atau password salah.',
            ], 401);
        }

        if ($akun->status !== 'aktif') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akun belum aktif. Hubungi administrator.',
            ], 403);
        }

        // Hanya admin yang boleh login di mobile
        if ($akun->role !== 'admin') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak. Aplikasi ini hanya untuk admin.',
            ], 403);
        }

        // Hapus token lama, buat token baru
        $akun->tokens()->delete();
        $token = $akun->createToken('mobile-admin')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil.',
            'token'   => $token,
            'data'    => [
                'id'        => $akun->id,
                'username'  => $akun->username,
                'nama'      => $akun->nama,
                'email'     => $akun->email,
                'role'      => $akun->role,
                'no_telpon' => $akun->no_telpon,
                'foto'      => $akun->gambar_url,
            ],
        ]);
    }

    /**
     * POST /api/v1/logout
     * Logout — hapus token aktif
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout berhasil.',
        ]);
    }

    /**
     * GET /api/v1/me
     * Ambil data admin yang sedang login
     */
    public function me(Request $request): JsonResponse
    {
        $akun = $request->user();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'        => $akun->id,
                'username'  => $akun->username,
                'nama'      => $akun->nama,
                'email'     => $akun->email,
                'role'      => $akun->role,
                'no_telpon' => $akun->no_telpon,
                'foto'      => $akun->gambar_url,
            ],
        ]);
    }

    // ===== Placeholder lainnya =====

    public function register(Request $request): JsonResponse
    {
        return response()->json(['status' => 'error', 'message' => 'Registrasi tidak tersedia di aplikasi admin.'], 403);
    }

    public function profil(string $username): JsonResponse
    {
        $akun = Akun::where('username', $username)->first();
        if (!$akun) {
            return response()->json(['status' => 'error', 'message' => 'User tidak ditemukan.'], 404);
        }
        return response()->json(['status' => 'success', 'data' => [
            'username'  => $akun->username,
            'nama'      => $akun->nama,
            'email'     => $akun->email,
            'no_telpon' => $akun->no_telpon,
            'role'      => $akun->role,
            'foto'      => $akun->gambar_url,
        ]]);
    }

    public function verifikasiOtp(Request $request): JsonResponse
    {
        return response()->json(['status' => 'success', 'message' => 'OTP diverifikasi.']);
    }

    public function lupaPasswordRequest(Request $request): JsonResponse
    {
        return response()->json(['status' => 'success', 'message' => 'Fitur dalam pengembangan.']);
    }

    public function lupaPasswordReset(Request $request): JsonResponse
    {
        return response()->json(['status' => 'success', 'message' => 'Fitur dalam pengembangan.']);
    }
}
