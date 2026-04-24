@extends('layouts.app')

@section('title', 'Edit Profil Masjid - Admin')

@section('content')
@php
    $BASE_IMG = config('app.api_base_url');
    $gambarSejarah = $profil['gambar_sejarah_masjid'] ?? $profil['gambar_sejarah'] ?? '';
    if ($gambarSejarah && !str_starts_with($gambarSejarah, 'http')) {
        $gambarSejarah = $BASE_IMG . '/uploads/profil_masjid/' . $gambarSejarah;
    }
@endphp

<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('profil-masjid.show') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Edit Profil Masjid</h2>
    </div>

    <div class="alert alert-info small">
        <i class="bi bi-info-circle me-2"></i>
        Form ini mengupdate <strong>judul sejarah</strong> dan <strong>deskripsi sejarah</strong> masjid.
        Untuk mengubah gambar struktur organisasi, gunakan menu
        <a href="{{ route('admin.profil-masjid.edit-struktur') }}">Edit Struktur</a>.
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('admin.profil-masjid.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Sejarah <span class="text-danger">*</span></label>
                <input type="text" name="judul_sejarah" class="form-control @error('judul_sejarah') is-invalid @enderror"
                       value="{{ old('judul_sejarah', $profil['judul_sejarah'] ?? 'Sejarah Masjid') }}" required>
                @error('judul_sejarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi Sejarah <span class="text-danger">*</span></label>
                <textarea name="deskripsi_sejarah" class="form-control @error('deskripsi_sejarah') is-invalid @enderror"
                          rows="8" required>{{ old('deskripsi_sejarah', $profil['deskripsi_sejarah'] ?? $profil['sejarah_masjid'] ?? '') }}</textarea>
                @error('deskripsi_sejarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Gambar Sejarah Masjid</label>
                @if($gambarSejarah)
                <div class="mb-2">
                    <img src="{{ $gambarSejarah }}" alt="Gambar saat ini" class="img-fluid rounded-2"
                         style="max-height: 150px;" onerror="this.style.display='none'">
                    <p class="text-muted small mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                </div>
                @endif
                <input type="file" name="gambar_sejarah_masjid" class="form-control" accept="image/*"
                       onchange="previewImage(this)">
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 150px;">
                </div>
                <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 3MB</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('profil-masjid.show') }}" class="btn btn-outline-secondary px-4">Batal</a>
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
