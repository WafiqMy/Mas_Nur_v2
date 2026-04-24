<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    // ===================== VERIFIKASI REGISTRASI =====================

    public function showVerifikasiForm(Request $request)
    {
        return view('auth.verifikasi', ['email' => $request->email]);
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $response = $this->api->verifikasi($request->email, $request->otp);

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('login')
                ->with('success', 'Akun berhasil diverifikasi! Silakan login.');
        }

        return back()->withErrors([
            'otp' => $response['message'] ?? 'Kode OTP tidak valid.',
        ]);
    }

    // ===================== LUPA PASSWORD =====================

    public function showLupaPasswordForm()
    {
        return view('auth.lupa-password');
    }

    public function requestOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = $this->api->lupaPasswordRequest($request->email);

        return response()->json($response);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string',
        ]);

        $response = $this->api->lupaPasswordVerify($request->email, $request->otp);

        return response()->json($response);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'required|string',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ]);

        $response = $this->api->lupaPasswordReset(
            $request->email,
            $request->otp,
            $request->password
        );

        return response()->json($response);
    }
}
