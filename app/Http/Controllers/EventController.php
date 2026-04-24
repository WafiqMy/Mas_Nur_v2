<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->getEventList();

        // API get_acara.php / api_get_event.php bisa return array langsung atau {status, data}
        $events = [];
        if (isset($response['status']) && $response['status'] === 'success') {
            $events = $response['data'] ?? [];
        } elseif (is_array($response) && isset($response[0])) {
            $events = $response;
        }

        return view('event.index', compact('events'));
    }

    public function show($id)
    {
        $response = $this->api->getEvent((int) $id);

        if (!isset($response['status']) || $response['status'] !== 'success') {
            abort(404, 'Acara tidak ditemukan.');
        }

        $event = $response['data'];
        return view('event.show', compact('event'));
    }

    // ===================== ADMIN ONLY =====================

    public function create()
    {
        $this->authorizeAdmin();
        return view('event.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_event'      => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'lokasi_event'    => 'required|string|max:255',
            'tanggal_event'   => 'required|date',
            'gambar_event'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'dokumentasi.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video_urls'      => 'nullable|string',
        ]);

        $videoUrls = [];
        if ($request->video_urls) {
            $videoUrls = array_values(array_filter(
                array_map('trim', explode("\n", $request->video_urls))
            ));
        }

        $fields = [
            'nama_event'      => $request->nama_event,
            'deskripsi_event' => $request->deskripsi_event ?? '',
            'lokasi_event'    => $request->lokasi_event,
            'tanggal_event'   => date('Y-m-d H:i:s', strtotime($request->tanggal_event)),
            'video_urls'      => json_encode($videoUrls),
        ];

        $dokumentasi = $request->hasFile('dokumentasi') ? $request->file('dokumentasi') : [];

        $response = $this->api->tambahEvent(
            $fields,
            $request->hasFile('gambar_event') ? $request->file('gambar_event') : null,
            $dokumentasi
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('event.index')
                ->with('success', 'Acara berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal menambahkan acara.'])
            ->withInput();
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $response = $this->api->getEvent((int) $id);

        if (!isset($response['status']) || $response['status'] !== 'success') {
            abort(404, 'Acara tidak ditemukan.');
        }

        $event = $response['data'];
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_event'      => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'lokasi_event'    => 'nullable|string|max:255',
            'tanggal_event'   => 'nullable|date',
            'gambar_event'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $videoUrls = [];
        if ($request->video_urls) {
            $videoUrls = array_values(array_filter(
                array_map('trim', explode("\n", $request->video_urls))
            ));
        }

        $fields = [
            'id_event'        => $id,
            'nama_event'      => $request->nama_event,
            'deskripsi_event' => $request->deskripsi_event ?? '',
            'lokasi_event'    => $request->lokasi_event ?? '',
            'tanggal_event'   => $request->tanggal_event
                ? date('Y-m-d H:i:s', strtotime($request->tanggal_event))
                : '',
            'video_urls'      => json_encode($videoUrls),
        ];

        $response = $this->api->editEvent(
            $fields,
            $request->hasFile('gambar_event') ? $request->file('gambar_event') : null
        );

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('event.index')
                ->with('success', 'Acara berhasil diperbarui.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal memperbarui acara.'])
            ->withInput();
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $response = $this->api->hapusEvent((int) $id);

        if (isset($response['status']) && $response['status'] === 'success') {
            return redirect()->route('event.index')
                ->with('success', 'Acara berhasil dihapus.');
        }

        return back()->withErrors(['error' => $response['message'] ?? 'Gagal menghapus acara.']);
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || ($user['role'] ?? '') !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
