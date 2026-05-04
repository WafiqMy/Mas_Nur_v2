<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

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

        $response = $this->api->login($request->username, $request->password);

        if (isset($response['status']) && $response['status'] === 'success') {
            // Ambil data dari response API
            $data = $response['data'] ?? [];

            // Cek berbagai kemungkinan key untuk role dari API
            $role = $data['role']      ??
                    $data['Role']      ??
                    $data['tipe']      ??
                    $data['user_role'] ??
                    $data['level']     ??
                    'user';

            // Normalisasi role ke lowercase
            $role = strtolower(trim((string) $role));

            // Simpan data user ke session
            Session::put('user', [
                'username' => $request->username,
                'nama'     => $data['nama']      ?? $data['name']     ?? $data['nama_lengkap'] ?? $request->username,
                'email'    => $data['email']     ?? '',
                'role'     => $role,
                'foto'     => $data['foto']      ?? $data['gambar']   ?? '',
            ]);

            $request->session()->regenerate();

            // Redirect admin ke halaman admin, user biasa ke home
            if ($role === 'admin') {
                return redirect()->route('admin.berita.index')
                    ->with('success', 'Selamat datang, Admin!');
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => $response['message'] ?? 'Login gagal. Periksa username dan password Anda.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Session::forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
