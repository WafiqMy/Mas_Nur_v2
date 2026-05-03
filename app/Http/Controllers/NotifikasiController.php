<?php

namespace App\Http\Controllers;

use App\Helpers\NotifikasiHelper;
use App\Services\ApiService;
use Illuminate\Support\Facades\Session;

class NotifikasiController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login');
        }

        $response   = $this->api->getNotifikasi($user['username'], $user['role']);
        $notifikasi = $response['data'] ?? [];

        // Process setiap notifikasi untuk fix link
        $notifikasi = array_map(function ($n) {
            // Convert legacy link ke format baru
            if (isset($n['link'])) {
                $n['link'] = NotifikasiHelper::convertLegacyLink($n['link']);
            }
            return $n;
        }, $notifikasi);

        return view('notifikasi.index', compact('notifikasi'));
    }

    public function count()
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['count' => 0]);
        }

        $response   = $this->api->getNotifikasi($user['username'], $user['role']);
        $notifikasi = $response['data'] ?? [];

        // Hitung yang is_new = true
        $count = count(array_filter($notifikasi, fn($n) => !empty($n['is_new'])));

        return response()->json(['count' => $count]);
    }
}
