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
            // Simpan data user ke session
            Session::put('user', [
                'username' => $request->username,
                'nama'     => $response['data']['nama'] ?? $request->username,
                'role'     => $response['data']['role'] ?? 'user',
            ]);

            $request->session()->regenerate();

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
