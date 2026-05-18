<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class ProfileUserController extends Controller
{
    public function show()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login');
        }

        $akun = Akun::where('username', $user['username'])->first();
        $profilUser = $akun ?? $user;

        // Ambil no_telpon dari session jika tidak ada di model
        $noTelp = $akun?->no_telpon ?? $user['no_telpon'] ?? '';

        return view('profil-user.show', compact('profilUser', 'noTelp'));
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

        $akun = Akun::where('username', $user['username'])->firstOrFail();

        $data = [
            'nama'      => $request->nama,
            'email'     => $request->email,
            'no_telpon' => $request->no_telpon ?? '',
        ];

        if ($request->hasFile('gambar')) {
            // Hapus foto lama
            if ($akun->gambar) {
                Storage::disk('public')->delete('profil_user/' . $akun->gambar);
            }
            $file     = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profil_user', $filename, 'public');
            $data['gambar'] = $filename;
        }

        $akun->update($data);

        // Update session
        $sessionUser = Session::get('user');
        $sessionUser['nama']      = $request->nama;
        $sessionUser['email']     = $request->email;
        $sessionUser['no_telpon'] = $request->no_telpon ?? '';
        Session::put('user', $sessionUser);

        return redirect()->route('profil-user.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function requestOtp()
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Tidak terautentikasi.']);
        }

        $akun = Akun::where('username', $user['username'])->first();
        if (!$akun) {
            return response()->json(['status' => 'error', 'message' => 'Akun tidak ditemukan.']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $akun->update([
            'otp'         => $otp,
            'otp_expired' => Carbon::now()->addMinutes(10),
        ]);

        try {
            \Mail::to($akun->email)->send(new \App\Mail\OtpMail($otp, $akun->nama));
        } catch (\Throwable $e) {
            // tetap return success
        }

        return response()->json(['status' => 'success', 'message' => 'OTP dikirim ke email.']);
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
        ], [
            'password_baru.regex' => 'Password harus kombinasi huruf dan angka.',
        ]);

        $akun = Akun::where('username', $user['username'])->first();
        if (!$akun) {
            return response()->json(['status' => 'error', 'message' => 'Akun tidak ditemukan.']);
        }

        if ($akun->otp !== $request->otp) {
            return response()->json(['status' => 'error', 'message' => 'OTP tidak valid.']);
        }

        if ($akun->otp_expired && Carbon::now()->isAfter($akun->otp_expired)) {
            return response()->json(['status' => 'error', 'message' => 'OTP sudah kadaluarsa.']);
        }

        $akun->update([
            'password'    => Hash::make($request->password_baru),
            'otp'         => null,
            'otp_expired' => null,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Password berhasil diperbarui.']);
    }
}
