<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventApiController extends Controller
{
    // ===================== PUBLIK =====================

    /**
     * GET /api/v1/event
     */
    public function index(): JsonResponse
    {
        $events = Event::orderBy('tanggal_event', 'desc')->get()->map(fn($e) => $this->format($e));
        return response()->json(['status' => 'success', 'data' => $events]);
    }

    /**
     * GET /api/v1/event/{id}
     */
    public function show(int $id): JsonResponse
    {
        $e = Event::find($id);
        if (!$e) {
            return response()->json(['status' => 'error', 'message' => 'Acara tidak ditemukan.'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $this->format($e)]);
    }

    // ===================== ADMIN (butuh token) =====================

    /**
     * POST /api/v1/admin/event
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama_event'      => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'lokasi_event'    => 'nullable|string|max:255',
            'tanggal_event'   => 'nullable|date',
            'gambar_event'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('nama_event', 'deskripsi_event', 'lokasi_event', 'tanggal_event');

        if ($request->hasFile('gambar_event')) {
            $file     = $request->file('gambar_event');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('kegiatan', $filename, 'public');
            $data['gambar_event'] = $filename;
        }

        $event = Event::create($data);

        return response()->json([
            'status'  => 'success',
            'message' => 'Acara berhasil ditambahkan.',
            'data'    => $this->format($event),
        ], 201);
    }

    /**
     * POST /api/v1/admin/event/{id}  (dengan _method=PUT)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['status' => 'error', 'message' => 'Acara tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_event'      => 'required|string|max:255',
            'deskripsi_event' => 'nullable|string',
            'lokasi_event'    => 'nullable|string|max:255',
            'tanggal_event'   => 'nullable|date',
            'gambar_event'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $validator->errors()], 422);
        }

        $data = $request->only('nama_event', 'deskripsi_event', 'lokasi_event', 'tanggal_event');

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

        return response()->json([
            'status'  => 'success',
            'message' => 'Acara berhasil diperbarui.',
            'data'    => $this->format($event->fresh()),
        ]);
    }

    /**
     * DELETE /api/v1/admin/event/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['status' => 'error', 'message' => 'Acara tidak ditemukan.'], 404);
        }

        if ($event->gambar_event) {
            Storage::disk('public')->delete('kegiatan/' . $event->gambar_event);
        }

        $event->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Acara berhasil dihapus.',
        ]);
    }

    // ===================== HELPER =====================

    private function format(Event $e): array
    {
        return [
            'id'              => $e->id,
            'nama_event'      => $e->nama_event,
            'deskripsi_event' => $e->deskripsi_event,
            'lokasi_event'    => $e->lokasi_event,
            'tanggal_event'   => $e->tanggal_event?->format('Y-m-d H:i:s'),
            'gambar_event'    => $e->gambar_event,
            'gambar_url'      => $e->gambar_url,
        ];
    }
}
