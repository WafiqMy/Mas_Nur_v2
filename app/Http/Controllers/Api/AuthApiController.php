<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthApiController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    // ── LOGIN ─────────────────────────────────────────────────────────────

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response = $this->api->login($request->username, $request->password);

        return response()->json($response);
    }

    // ── LOGOUT ────────────────────────────────────────────────────────────

    public function logout(Request $request): JsonResponse
    {
        return response()->json(['status' => 'success', 'message' => 'Logout berhasil.']);
    }

    // ── ME ────────────────────────────────────────────────────────────────

    public function me(Request $request): JsonResponse
    {
        $username = $request->header('X-Username') ?? $request->query('username', '');

        if (empty($username)) {
            return response()->json(['status' => 'error', 'message' => 'Username diperlukan.'], 400);
        }

        $response = $this->api->getProfilUser($username);

        return response()->json($response);
    }

    // ── UPDATE PROFIL ─────────────────────────────────────────────────────

    public function updateProfil(Request $request): JsonResponse
    {
        $request->validate([
            'username'   => 'required|string',
            'nama'       => 'required|string',
            'email'      => 'required|email',
            'no_telpon'  => 'nullable|string',
        ]);

        $response = $this->api->updateProfilUser($request->only(['username', 'nama', 'email', 'no_telpon']));

        return response()->json($response);
    }

    // ── LUPA PASSWORD — STEP 1: Kirim OTP ────────────────────────────────

    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = $this->api->lupaPasswordRequest($request->email);

        // Normalkan status agar Flutter bisa baca konsisten
        // API lama mungkin return berbagai format
        $status = strtolower($response['status'] ?? '');

        if (in_array($status, ['success', 'ok', 'sent', 'valid', '1', 'true'])) {
            return response()->json([
                'status'  => 'success',
                'message' => $response['message'] ?? 'Kode OTP telah dikirim ke email Anda.',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => $response['message'] ?? 'Email tidak terdaftar atau gagal mengirim OTP.',
        ], 422);
    }

    // ── LUPA PASSWORD — STEP 2: Verifikasi OTP ───────────────────────────

    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $response = $this->api->lupaPasswordVerify($request->email, $request->otp);

        $status = strtolower($response['status'] ?? '');

        if (in_array($status, ['success', 'ok', 'valid', 'verified', '1', 'true'])) {
            // Simpan OTP yang sudah terverifikasi di cache selama 10 menit
            // agar bisa dipakai di step reset tanpa Flutter perlu kirim ulang
            $cacheKey = 'otp_verified_' . md5($request->email);
            Cache::put($cacheKey, $request->otp, now()->addMinutes(10));

            return response()->json([
                'status'  => 'success',
                'message' => $response['message'] ?? 'OTP valid.',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => $response['message'] ?? 'Kode OTP tidak valid atau sudah kadaluarsa.',
        ], 422);
    }

    // ── LUPA PASSWORD — STEP 3: Reset Password ───────────────────────────

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Ambil OTP dari cache (disimpan saat verifyOtp berhasil)
        $cacheKey = 'otp_verified_' . md5($request->email);
        $otp = Cache::get($cacheKey);

        if (!$otp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sesi OTP sudah kadaluarsa. Silakan ulangi dari awal.',
            ], 422);
        }

        $response = $this->api->lupaPasswordReset(
            $request->email,
            $otp,
            $request->password
        );

        $status = strtolower($response['status'] ?? '');

        if (in_array($status, ['success', 'ok', 'updated', 'valid', '1', 'true'])) {
            // Hapus cache OTP setelah berhasil
            Cache::forget($cacheKey);

            return response()->json([
                'status'  => 'success',
                'message' => $response['message'] ?? 'Password berhasil diubah.',
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => $response['message'] ?? 'Gagal mereset password.',
        ], 422);
    }
}
