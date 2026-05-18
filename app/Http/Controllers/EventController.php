<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // ===================== PUBLIK =====================

    public function index()
    {
        $events = Event::orderBy('tanggal_event', 'desc')->get();
        return view('event.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
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
            'gambar_event'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'dokumentasi.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'video_urls'      => 'nullable|string',
        ]);

        $videoUrls = [];
        if ($request->video_urls) {
            $videoUrls = array_values(array_filter(
                array_map('trim', explode("\n", $request->video_urls))
            ));
        }

        $data = [
            'nama_event'      => $request->nama_event,
            'deskripsi_event' => $request->deskripsi_event ?? '',
            'lokasi_event'    => $request->lokasi_event,
            'tanggal_event'   => $request->tanggal_event,
            'video_urls'      => $videoUrls,
        ];

        if ($request->hasFile('gambar_event')) {
            $file     = $request->file('gambar_event');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('kegiatan', $filename, 'public');
            $data['gambar_event'] = $filename;
        }

        // Handle multiple dokumentasi
        $dokFiles = [];
        if ($request->hasFile('dokumentasi')) {
            foreach ($request->file('dokumentasi') as $dok) {
                $filename = time() . '_' . uniqid() . '_' . $dok->getClientOriginalName();
                $dok->storeAs('kegiatan', $filename, 'public');
                $dokFiles[] = $filename;
            }
        }
        $data['dokumentasi'] = implode(',', $dokFiles);

        Event::create($data);

        return redirect()->route('event.index')
            ->with('success', 'Acara berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $this->authorizeAdmin();
        $event = Event::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeAdmin();

        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event'      => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'lokasi_event'    => 'nullable|string|max:255',
            'tanggal_event'   => 'nullable|date',
            'gambar_event'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $videoUrls = [];
        if ($request->video_urls) {
            $videoUrls = array_values(array_filter(
                array_map('trim', explode("\n", $request->video_urls))
            ));
        }

        $data = [
            'nama_event'      => $request->nama_event,
            'deskripsi_event' => $request->deskripsi_event ?? '',
            'lokasi_event'    => $request->lokasi_event ?? '',
            'tanggal_event'   => $request->tanggal_event,
            'video_urls'      => $videoUrls,
        ];

        if ($request->hasFile('gambar_event')) {
            if ($event->gambar_event) {
                Storage::disk('public')->delete('kegiatan/' . $event->gambar_event);
            }
            $file     = $request->file('gambar_event');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('kegiatan', $filename, 'public');
            $data['gambar_event'] = $filename;
        }

        $event->update($data);

        return redirect()->route('event.index')
            ->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->authorizeAdmin();

        $event = Event::findOrFail($id);

        if ($event->gambar_event) {
            Storage::disk('public')->delete('kegiatan/' . $event->gambar_event);
        }

        $event->delete();

        return redirect()->route('event.index')
            ->with('success', 'Acara berhasil dihapus.');
    }

    private function authorizeAdmin(): void
    {
        $user = Session::get('user');
        if (!$user || strtolower(trim((string) ($user['role'] ?? ''))) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang diizinkan.');
        }
    }
}
