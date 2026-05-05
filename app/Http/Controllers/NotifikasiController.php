<?php

namespace App\Http\Controllers;

use App\Helpers\NotifikasiHelper;
use App\Models\Notifikasi;
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

        // Hitung hanya notifikasi yang belum dibaca (is_new = true) milik user ini
        $unreadCount = Notifikasi::forUser($user['username'], $user['role'] ?? 'user')
            ->unread()
            ->count();

        return response()->json(['count' => $unreadCount]);
    }

    public function markAsRead($id)
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        try {
            // Update notifikasi di database lokal
            $notifikasi = Notifikasi::findOrFail($id);

            // Validasi ownership
            if ($notifikasi->username !== $user['username']) {
                return response()->json(['status' => 'unauthorized'], 403);
            }

            $notifikasi->update(['is_new' => false]);

            // Hitung ulang unread count
            $unreadCount = Notifikasi::forUser($user['username'], $user['role'] ?? 'user')
                ->unread()
                ->count();

            return response()->json([
                'status'       => 'success',
                'message'      => 'Notifikasi telah ditandai dibaca',
                'unreadCount'  => $unreadCount
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Notifikasi tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function markAllAsRead()
    {
        $user = Session::get('user');
        if (!$user) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        try {
            // Update semua notifikasi milik user ini menjadi dibaca
            Notifikasi::forUser($user['username'], $user['role'] ?? 'user')
                ->where('is_new', true)
                ->update(['is_new' => false]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Semua notifikasi telah ditandai dibaca',
                'count'   => 0
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
