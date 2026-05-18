<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Persewaan;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReservasiController extends Controller
{
    // ===================== USER (LOGIN REQUIRED) =====================

    public function store(Request $request)
    {
        $request->validate([
            'nama_pengguna'             => 'required|string|max:255',
            'no_tlp_pengguna'           => 'required|string|max:20',
            'email_pengguna'            => 'required|email',
            'nama_barang'               => 'required|string',
            'jenis'                     => 'required|string',
            'keperluan'                 => 'required|string',
            'tanggal_mulai_reservasi'   => 'required|date',
            'tanggal_selesai_reservasi' => 'required|date|after_or_equal:tanggal_mulai_reservasi',
            'total_peminjaman'          => 'required|integer|min:1',
            'total_harga'               => 'required|numeric|min:0',
        ]);

        $user = Session::get('user');

        $reservasi = Reservasi::create([
            'nama_barang'               => $request->nama_barang,
            'jenis'                     => $request->jenis,
            'nama_pengguna'             => $request->nama_pengguna,
            'no_tlp_pengguna'           => $request->no_tlp_pengguna,
            'email_pengguna'            => $request->email_pengguna,
            'username_pengguna'         => $user['username'] ?? null,
            'tanggal_mulai_reservasi'   => $request->tanggal_mulai_reservasi,
            'tanggal_selesai_reservasi' => $request->tanggal_selesai_reservasi,
            'keperluan'                 => $request->keperluan,
            'total_peminjaman'          => $request->total_peminjaman,
            'total_harga'               => $request->total_harga,
            'status_reservasi'          => 'Menunggu',
        ]);

        // Kirim notifikasi ke admin
        Notifikasi::create([
            'username'     => 'admin',
            'role'         => 'admin',
            'judul'        => 'Permintaan Sewa Baru',
            'pesan'        => "Ada permintaan sewa {$request->nama_barang} dari {$request->nama_pengguna}.",
            'link'         => route('admin.reservasi.detail-permintaan', $reservasi->id),
            'status_badge' => 'Menunggu',
            'is_new'       => true,
            'tipe'         => 'reservasi',
            'reference_id' => $reservasi->id,
        ]);

        // Notifikasi ke user
        if ($user) {
            Notifikasi::create([
                'username'     => $user['username'],
                'role'         => 'user',
                'judul'        => 'Permintaan Sewa Dikirim',
                'pesan'        => "Permintaan sewa {$request->nama_barang} berhasil dikirim. Menunggu konfirmasi admin.",
                'link'         => route('reservasi.status'),
                'status_badge' => 'Menunggu',
                'is_new'       => true,
                'tipe'         => 'reservasi',
                'reference_id' => $reservasi->id,
            ]);
        }

        return redirect()->route('reservasi.status')
            ->with('success', 'Permintaan sewa berhasil dikirim. Menunggu konfirmasi admin.');
    }

    public function statusPemesanan()
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pesanan = Reservasi::where('username_pengguna', $user['username'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservasi.status', compact('pesanan'));
    }

    // ===================== ADMIN ONLY =====================

    public function permintaan()
    {
        $this->authorizeAdmin();
        $permintaan = Reservasi::orderBy('created_at', 'desc')->get();
        $riwayat    = Reservasi::whereIn('status_reservasi', ['Disetujui', 'Ditolak', 'Batal'])
                        ->orderBy('updated_at', 'desc')->get();
        return view('admin.reservasi.permintaan', compact('permintaan', 'riwayat'));
    }

    public function detailPermintaan($id)
    {
        $this->authorizeAdmin();
        $reservasi = Reservasi::findOrFail($id);
        return view('admin.reservasi.detail-permintaan', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak,Batal',
            'notes'  => 'nullable|string|max:500',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status_reservasi' => $request->status,
            'notes'            => $request->notes,
        ]);

        // Notifikasi ke user
        if ($reservasi->username_pengguna) {
            Notifikasi::create([
                'username'     => $reservasi->username_pengguna,
                'role'         => 'user',
                'judul'        => 'Status Sewa Diperbarui',
                'pesan'        => "Permintaan sewa {$reservasi->nama_barang} telah {$request->status}." .
                                  ($request->notes ? " Catatan: {$request->notes}" : ''),
                'link'         => route('reservasi.status'),
                'status_badge' => $request->status,
                'is_new'       => true,
                'tipe'         => 'reservasi',
                'reference_id' => $reservasi->id,
            ]);
        }

        return redirect()->route('admin.reservasi.permintaan')
            ->with('success', "Status reservasi berhasil diubah menjadi {$request->status}.");
    }

    public function kalender($id)
    {
        $reservasi = Reservasi::where('nama_barang', function ($q) use ($id) {
            $q->select('nama_barang')->from('persewaan')->where('id', $id);
        })->whereIn('status_reservasi', ['Menunggu', 'Disetujui'])->get();

        $events = $reservasi->map(fn($r) => [
            'title'           => $r->nama_pengguna,
            'start'           => $r->tanggal_mulai_reservasi->format('Y-m-d'),
            'end'             => $r->tanggal_selesai_reservasi->addDay()->format('Y-m-d'),
            'backgroundColor' => $r->status_color,
            'borderColor'     => $r->status_color,
        ]);

        return response()->json($events);
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || strtolower(trim((string) ($user['role'] ?? ''))) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
