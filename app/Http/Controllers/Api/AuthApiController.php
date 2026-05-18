<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthApiController extends Controller
{
    // ── LOGIN ─────────────────────────────────────────────────────────────

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

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
                'message' => 'Akun belum aktif. Silakan verifikasi email Anda.',
            ], 403);
        }

        // Generate simple token (simpan di cache)
        $token = Str::random(60);
        cache()->put('token_' . $token, $akun->id, now()->addDays(7));

        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil.',
            'token'   => $token,
            'data'    => [
                'id'        => $akun->id,
                'nama'      => $akun->nama,
                'username'  => $akun->username,
                'email'     => $akun->email,
                'no_telpon' => $akun->no_telpon,
                'role'      => $akun->role,
                'gambar'    => $akun->gambar_url,
            ],
        ]);
    }

    // ── LOGOUT ────────────────────────────────────────────────────────────

    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken();
        if ($token) {
            cache()->forget('token_' . $token);
        }
        return response()->json(['status' => 'success', 'message' => 'Logout berhasil.']);
    }

    // ── ME ────────────────────────────────────────────────────────────────

    public function me(Request $request): JsonResponse
    {
        $akun = $this->getAkunFromToken($request);
        if (!$akun) {
            return response()->json(['status' => 'error', 'message' => 'Tidak terautentikasi.'], 401);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'        => $akun->id,
                'nama'      => $akun->nama,
                'username'  => $akun->username,
                'email'     => $akun->email,
                'no_telpon' => $akun->no_telpon,
                'role'      => $akun->role,
                'gambar'    => $akun->gambar_url,
            ],
        ]);
    }

    // ── UPDATE PROFIL ─────────────────────────────────────────────────────

    public function updateProfil(Request $request): JsonResponse
    {
        $akun = $this->getAkunFromToken($request);
        if (!$akun) {
            return response()->json(['status' => 'error', 'message' => 'Tidak terautentikasi.'], 401);
        }

        $request->validate([
            'nama'      => 'required|string|max:100',
            'email'     => 'required|email|unique:akun,email,' . $akun->id,
            'no_telpon' => 'nullable|string|max:20',
        ]);

        $akun->update([
            'nama'      => $request->nama,
            'email'     => $request->email,
            'no_telpon' => $request->no_telpon,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Profil berhasil diperbarui.']);
    }

    // ── LUPA PASSWORD — STEP 1: Kirim OTP ────────────────────────────────

    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email tidak terdaftar.',
            ], 422);
        }

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan OTP ke tabel akun, expired 10 menit
        $akun->update([
            'otp'         => $otp,
            'otp_expired' => now()->addMinutes(10),
        ]);

        // Kirim email
        try {
            Mail::send([], [], function ($message) use ($akun, $otp) {
                $message->to($akun->email, $akun->nama)
                    ->subject('Kode OTP Reset Password - Masjid Nurul Huda')
                    ->html($this->buildOtpEmailHtml($akun->nama, $otp));
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal kirim OTP email: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim email OTP. Coba lagi.',
            ], 500);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Kode OTP telah dikirim ke email Anda.',
        ]);
    }

    // ── LUPA PASSWORD — STEP 2: Verifikasi OTP ───────────────────────────

    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email tidak terdaftar.',
            ], 422);
        }

        if ($akun->otp !== $request->otp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP tidak valid.',
            ], 422);
        }

        if (!$akun->otp_expired || now()->isAfter($akun->otp_expired)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.',
            ], 422);
        }

        // Tandai OTP sudah diverifikasi di cache (10 menit)
        $cacheKey = 'otp_verified_' . md5($request->email);
        cache()->put($cacheKey, $request->otp, now()->addMinutes(10));

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP valid.',
        ]);
    }

    // ── LUPA PASSWORD — STEP 3: Reset Password ───────────────────────────

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Cek apakah OTP sudah diverifikasi
        $cacheKey = 'otp_verified_' . md5($request->email);
        if (!cache()->has($cacheKey)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Sesi OTP sudah kadaluarsa. Silakan ulangi dari awal.',
            ], 422);
        }

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email tidak terdaftar.',
            ], 422);
        }

        // Update password dan hapus OTP
        $akun->update([
            'password'    => Hash::make($request->password),
            'otp'         => null,
            'otp_expired' => null,
        ]);

        // Hapus cache verifikasi
        cache()->forget($cacheKey);

        return response()->json([
            'status'  => 'success',
            'message' => 'Password berhasil diubah.',
        ]);
    }

    // ── HELPER ────────────────────────────────────────────────────────────

    private function getAkunFromToken(Request $request): ?Akun
    {
        $token = $request->bearerToken();
        if (!$token) return null;

        $akunId = cache()->get('token_' . $token);
        if (!$akunId) return null;

        return Akun::find($akunId);
    }

    private function buildOtpEmailHtml(string $nama, string $otp): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"></head>
        <body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
            <div style="max-width: 480px; margin: 0 auto; background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div style="text-align: center; margin-bottom: 24px;">
                    <h2 style="color: #0277BD; margin: 0;">Masjid Nurul Huda</h2>
                    <p style="color: #666; margin: 4px 0 0;">Reset Kata Sandi</p>
                </div>
                <p style="color: #333;">Assalamu'alaikum, <strong>{$nama}</strong></p>
                <p style="color: #555;">Kami menerima permintaan reset kata sandi untuk akun Anda. Gunakan kode OTP berikut:</p>
                <div style="text-align: center; margin: 28px 0;">
                    <span style="font-size: 40px; font-weight: bold; letter-spacing: 12px; color: #0277BD; background: #E3F2FD; padding: 16px 24px; border-radius: 8px;">{$otp}</span>
                </div>
                <p style="color: #888; font-size: 13px; text-align: center;">Kode berlaku selama <strong>10 menit</strong>. Jangan bagikan kode ini kepada siapapun.</p>
                <hr style="border: none; border-top: 1px solid #eee; margin: 24px 0;">
                <p style="color: #aaa; font-size: 12px; text-align: center;">Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>
            </div>
        </body>
        </html>
        HTML;
    }
}
