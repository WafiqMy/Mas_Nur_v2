<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservasiController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    // ===================== USER =====================

    public function store(Request $request)
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'id_persewaan'              => 'required',
            'nama_barang'               => 'required|string',
            'jenis'                     => 'nullable|string',
            'tanggal_mulai_reservasi'   => 'required|date|after_or_equal:today',
            'tanggal_selesai_reservasi' => 'required|date|after_or_equal:tanggal_mulai_reservasi',
            'keperluan'                 => 'required|string|max:500',
            'total_peminjaman'          => 'required|integer|min:1',
            'harga_satuan'              => 'required|numeric|min:0',
        ]);

        // Hitung total harga
        $mulai   = \Carbon\Carbon::parse($request->tanggal_mulai_reservasi);
        $selesai = \Carbon\Carbon::parse($request->tanggal_selesai_reservasi);
        $hari    = $mulai->diffInDays($selesai) + 1;
        $totalHarga = (float)$request->harga_satuan * (int)$request->total_peminjaman * $hari;

        // Ambil data profil user dari API untuk melengkapi data reservasi
        $profilResponse = $this->api->getProfilUser($user['username']);
        $profilUser = $profilResponse['data'] ?? [];

        $response = $this->api->simpanReservasi([
            'nama_pengguna'             => $user['nama'],
            'no_tlp'                    => $profilUser['no_telpon'] ?? '-',
            'email'                     => $profilUser['email'] ?? '-',
            'nama_barang'               => $request->nama_barang,
            'jenis'                     => $request->jenis ?? '',
            'jumlah'                    => (int) $request->total_peminjaman,
            'total_harga'               => $totalHarga,
            'keperluan'                 => $request->keperluan,
            'username'                  => $user['username'],
            'tanggal_mulai'             => $request->tanggal_mulai_reservasi,
            'tanggal_selesai'           => $request->tanggal_selesai_reservasi,
        ]);

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('reservasi.status')
                ->with('success', 'Permintaan reservasi berhasil dikirim!');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal mengirim reservasi.']);
    }

    public function statusPemesanan()
    {
        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login');
        }

        $response = $this->api->getRiwayatUser($user['username']);
        $pesanan  = $response['data'] ?? [];

        return view('reservasi.status', compact('pesanan'));
    }

    // ===================== ADMIN =====================

    public function permintaan()
    {
        $this->authorizeAdmin();

        $response   = $this->api->getDetailReservasi();
        $permintaan = [];

        // API bisa return array langsung atau {status, data}
        if (is_array($response) && isset($response[0])) {
            $permintaan = $response;
        } elseif (isset($response['data'])) {
            $permintaan = $response['data'];
        }

        return view('admin.reservasi.permintaan', compact('permintaan'));
    }

    public function detailPermintaan($id)
    {
        $this->authorizeAdmin();

        $response = $this->api->getDetailReservasi((int) $id);

        if (isset($response['status']) && $response['status'] === 'success') {
            $reservasi = $response['data'];
        } elseif (isset($response['id'])) {
            $reservasi = $response;
        } else {
            abort(404, 'Data reservasi tidak ditemukan.');
        }

        return view('admin.reservasi.detail-permintaan', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status_reservasi' => 'required|in:Disetujui,Ditolak,Batal',
            'notes'            => 'nullable|string|max:500',
        ]);

        $response = $this->api->updateStatusReservasi(
            (int) $id,
            $request->status_reservasi,
            $request->notes
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('admin.reservasi.permintaan')
                ->with('success', "Status berhasil diubah menjadi {$request->status_reservasi}.");
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal mengubah status.']);
    }

    // ===================== API: Kalender =====================

    public function kalender($id)
    {
        $events = $this->api->getKalenderReservasi((int) $id);

        // API sudah mengembalikan format FullCalendar langsung
        if (is_array($events) && isset($events[0])) {
            return response()->json($events);
        }

        return response()->json([]);
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
