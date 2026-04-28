<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProfileUserController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function show()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login');
        }

        $response  = $this->api->getProfilUser($user['username']);
        $profilUser = ($response['status'] ?? '') === 'success' ? $response['data'] : null;

        if (!$profilUser) {
            $profilUser = $user; // fallback ke session data
        }

        return view('profil-user.show', compact('profilUser'));
    }

    public function update(Request $request)
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email',
            'no_telpon' => 'nullable|string|max:20',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $fields = [
            'username'  => $user['username'],
            'nama'      => $request->nama,
            'email'     => $request->email,
            'no_telpon' => $request->no_telpon ?? '',
        ];

        $response = $this->api->updateProfilUser(
            $fields,
            $request->hasFile('gambar') ? $request->file('gambar') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            // Update nama di session
            $sessionUser = Session::get('user');
            $sessionUser['nama'] = $request->nama;
            Session::put('user', $sessionUser);

            return redirect()->route('profil-user.show')
                ->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal memperbarui profil.'])
            ->withInput();
    }

    public function requestOtp()
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Tidak terautentikasi.']);
        }

        $response = $this->api->requestOtpProfile($user['username']);
        return response()->json($response);
    }

    public function updatePassword(Request $request)
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Tidak terautentikasi.']);
        }

        $request->validate([
            'otp'           => 'required|string',
            'password_baru' => 'required|string|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
        ]);

        $response = $this->api->updatePassword(
            $user['username'],
            $request->otp,
            $request->password_baru
        );

        return response()->json($response);
    }
}
