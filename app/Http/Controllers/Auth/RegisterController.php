<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'username'  => 'required|string|regex:/^[a-zA-Z0-9_]+$/|max:50',
            'email'     => 'required|email',
            'password'  => 'required|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'no_telpon' => 'required|string|max:20',
        ], [
            'username.regex'  => 'Username hanya boleh huruf, angka, dan underscore.',
            'password.min'    => 'Password minimal 8 karakter.',
            'password.regex'  => 'Password harus kombinasi huruf dan angka.',
        ]);

        $response = $this->api->register([
            'nama'      => $request->nama,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => $request->password,
            'no_telpon' => $request->no_telpon,
        ]);

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()
                ->route('verifikasi.form', ['email' => $request->email])
                ->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.');
        }

        return back()->withErrors([
            'username' => $response['message'] ?? 'Registrasi gagal. Coba lagi.',
        ])->withInput();
    }
}
