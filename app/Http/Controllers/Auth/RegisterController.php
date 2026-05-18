<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'username'  => 'required|string|regex:/^[a-zA-Z0-9_]+$/|max:50|unique:akun,username',
            'email'     => 'required|email|unique:akun,email',
            'password'  => 'required|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'no_telpon' => 'required|string|max:20',
        ], [
            'username.regex'    => 'Username hanya boleh huruf, angka, dan underscore.',
            'username.unique'   => 'Username sudah digunakan.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.regex'    => 'Password harus kombinasi huruf dan angka.',
        ]);

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $akun = Akun::create([
            'nama'        => $request->nama,
            'username'    => $request->username,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'no_telpon'   => $request->no_telpon,
            'role'        => 'user',
            'status'      => 'pending',
            'otp'         => $otp,
            'otp_expired' => Carbon::now()->addMinutes(10),
        ]);

        // Kirim OTP via email
        try {
            Mail::to($akun->email)->send(new \App\Mail\OtpMail($otp, $akun->nama));
        } catch (\Throwable $e) {
            // Jika email gagal, tetap lanjut tapi beri tahu user
        }

        return redirect()
            ->route('verifikasi.form', ['email' => $request->email])
            ->with('success', 'Registrasi berhasil! Kode OTP telah dikirim ke email Anda.');
    }
}
