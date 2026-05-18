<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Session;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login');
        }

        $notifikasi = Notifikasi::where('username', $user['username'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Mark semua sebagai sudah dibaca
        Notifikasi::where('username', $user['username'])
            ->where('is_new', true)
            ->update(['is_new' => false]);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function count()
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $count = Notifikasi::where('username', $user['username'])
            ->where('is_new', true)
            ->count();

        return response()->json(['count' => $count]);
    }
}
