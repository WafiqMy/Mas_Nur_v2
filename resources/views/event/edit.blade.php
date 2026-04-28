@extends('layouts.app')

@section('title', 'Edit Acara - Admin')

@section('content')
@php
    $BASE_IMG = config('app.api_base_url');
    $gambar = $event['gambar_event'] ?? '';
    if ($gambar && !str_starts_with($gambar, 'http')) {
        $gambar = $BASE_IMG . '/uploads/kegiatan/' . $gambar;
    }
    $idEvent = $event['id_event'] ?? 0;

    $videoUrls = $event['video_urls'] ?? [];
    if (is_string($videoUrls)) $videoUrls = json_decode($videoUrls, true) ?? [];
    $videoText = implode("\n", $videoUrls);

    $tanggalVal = '';
    if (!empty($event['tanggal_event'])) {
        $tanggalVal = date('Y-m-d\TH:i', strtotime($event['tanggal_event']));
    }
@endphp

<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('event.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Edit Acara</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('admin.acara.update', $idEvent) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nama Acara <span class="text-danger">*</span></label>
                    <input type="text" name="nama_event" class="form-control"
                           value="{{ old('nama_event', $event['nama_event'] ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Acara</label>
                    <input type="datetime-local" name="tanggal_event" class="form-control"
                           value="{{ old('tanggal_event', $tanggalVal) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Lokasi</label>
                    <input type="text" name="lokasi_event" class="form-control"
                           value="{{ old('lokasi_event', $event['lokasi_event'] ?? '') }}">
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar Utama</label>
                    @if($gambar)
                    <div class="mb-2">
                        <img src="{{ $gambar }}" alt="Gambar saat ini" class="img-fluid rounded-2"
                             style="max-height: 150px;" onerror="this.style.display='none'">
                        <p class="text-muted small mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                    </div>
                    @endif
                    <input type="file" name="gambar_event" class="form-control" accept="image/*"
                           onchange="previewImage(this)">
                    <div id="imagePreview" class="mt-2" style="display:none;">
                        <img src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 150px;">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi_event" class="form-control" rows="6">{{ old('deskripsi_event', $event['deskripsi_event'] ?? '') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">URL Video</label>
                    <textarea name="video_urls" class="form-control" rows="3"
                              placeholder="Satu URL per baris...">{{ old('video_urls', $videoText) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('event.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const c = document.getElementById('imagePreview');
                c.querySelector('img').src = e.target.result;
                c.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
