<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Session::has('user')) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $akun = Akun::where('username', $request->username)->first();

        if (!$akun || !Hash::check($request->password, $akun->password)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput();
        }

        if ($akun->status !== 'aktif') {
            return back()->withErrors([
                'username' => 'Akun belum diverifikasi. Silakan cek email kamu.',
            ])->withInput();
        }

        $role = strtolower(trim((string) $akun->role));

        Session::put('user', [
            'username'  => $akun->username,
            'nama'      => $akun->nama,
            'email'     => $akun->email,
            'role'      => $role,
            'foto'      => $akun->gambar ?? '',
            'no_telpon' => $akun->no_telpon ?? '',
        ]);

        $request->session()->regenerate();

        if ($role === 'admin') {
            return redirect()->route('admin.berita.index')
                ->with('success', 'Selamat datang, Admin!');
        }

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Session::forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
