@extends('layouts.app')

@section('title', 'Edit Struktur Organisasi - Admin')

@section('content')
@php
    $BASE_IMG = config('app.api_base_url');
    $gambarOrg = $struktur['gambar_struktur_organisasi_url'] ?? $struktur['gambar_struktur_organisasi'] ?? '';
    $gambarRemas = $struktur['gambar_struktur_remas_url'] ?? $struktur['gambar_struktur_remas'] ?? '';
    if ($gambarOrg && !str_starts_with($gambarOrg, 'http')) {
        $gambarOrg = $BASE_IMG . '/uploads/profil_masjid/' . $gambarOrg;
    }
    if ($gambarRemas && !str_starts_with($gambarRemas, 'http')) {
        $gambarRemas = $BASE_IMG . '/uploads/profil_masjid/' . $gambarRemas;
    }
@endphp

<div class="container py-5" style="max-width: 700px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('profil-masjid.struktur') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Edit Struktur Organisasi</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('admin.profil-masjid.update-struktur') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="form-label fw-semibold">Gambar Struktur Pengurus</label>
                @if($gambarOrg)
                <div class="mb-2">
                    <img src="{{ $gambarOrg }}" alt="Struktur Pengurus" class="img-fluid rounded-2"
                         style="max-height: 200px;" onerror="this.style.display='none'">
                    <p class="text-muted small mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                </div>
                @endif
                <input type="file" name="gambar_struktur_organisasi" class="form-control" accept="image/*"
                       onchange="previewImage(this, 'previewOrg')">
                <div id="previewOrg" class="mt-2" style="display:none;">
                    <img src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 150px;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Gambar Struktur Remaja Masjid</label>
                @if($gambarRemas)
                <div class="mb-2">
                    <img src="{{ $gambarRemas }}" alt="Struktur Remas" class="img-fluid rounded-2"
                         style="max-height: 200px;" onerror="this.style.display='none'">
                    <p class="text-muted small mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                </div>
                @endif
                <input type="file" name="gambar_struktur_remas" class="form-control" accept="image/*"
                       onchange="previewImage(this, 'previewRemas')">
                <div id="previewRemas" class="mt-2" style="display:none;">
                    <img src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 150px;">
                </div>
                <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 3MB</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('profil-masjid.struktur') }}" class="btn btn-outline-secondary px-4">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input, containerId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                const c = document.getElementById(containerId);
                c.querySelector('img').src = e.target.result;
                c.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
