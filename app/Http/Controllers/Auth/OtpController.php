<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class OtpController extends Controller
{
    // ===================== VERIFIKASI REGISTRASI =====================

    public function showVerifikasiForm(Request $request)
    {
        return view('auth.verifikasi', ['email' => $request->email ?? session('email')]);
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun) {
            return back()->withErrors(['otp' => 'Email tidak ditemukan.']);
        }

        if ($akun->status === 'aktif') {
            return redirect()->route('login')->with('success', 'Akun sudah aktif. Silakan login.');
        }

        if ($akun->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        if ($akun->otp_expired && Carbon::now()->isAfter($akun->otp_expired)) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan daftar ulang.']);
        }

        $akun->update([
            'status'      => 'aktif',
            'otp'         => null,
            'otp_expired' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil diverifikasi! Silakan login.');
    }

    // ===================== LUPA PASSWORD =====================

    public function showLupaPasswordForm()
    {
        return view('auth.lupa-password');
    }

    public function requestOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun) {
            return response()->json(['status' => 'error', 'message' => 'Email tidak terdaftar.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $akun->update([
            'otp'         => $otp,
            'otp_expired' => Carbon::now()->addMinutes(10),
        ]);

        try {
            Mail::to($akun->email)->send(new \App\Mail\OtpMail($otp, $akun->nama));
        } catch (\Throwable $e) {
            // log error tapi tetap return success agar tidak expose info
        }

        return response()->json(['status' => 'success', 'message' => 'OTP telah dikirim ke email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun || $akun->otp !== $request->otp) {
            return response()->json(['status' => 'error', 'message' => 'OTP tidak valid.']);
        }

        if ($akun->otp_expired && Carbon::now()->isAfter($akun->otp_expired)) {
            return response()->json(['status' => 'error', 'message' => 'OTP sudah kadaluarsa.']);
        }

        return response()->json(['status' => 'success', 'message' => 'OTP valid.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'required|string',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ], [
            'password.regex' => 'Password harus kombinasi huruf dan angka.',
        ]);

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun || $akun->otp !== $request->otp) {
            return response()->json(['status' => 'error', 'message' => 'OTP tidak valid.']);
        }

        if ($akun->otp_expired && Carbon::now()->isAfter($akun->otp_expired)) {
            return response()->json(['status' => 'error', 'message' => 'OTP sudah kadaluarsa.']);
        }

        $akun->update([
            'password'    => Hash::make($request->password),
            'otp'         => null,
            'otp_expired' => null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Password berhasil direset.']);
    }
}
