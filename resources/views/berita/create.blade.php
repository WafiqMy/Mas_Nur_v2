@extends('layouts.app')

@section('title', 'Tambah Berita - Admin')

@section('content')
<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-0">Tambah Berita</h2>
            <p class="text-muted mb-0 small">Buat artikel berita baru</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Berita <span class="text-danger">*</span></label>
                <input type="text" name="judul_berita" class="form-control @error('judul_berita') is-invalid @enderror"
                       value="{{ old('judul_berita') }}" placeholder="Masukkan judul berita..." required>
                @error('judul_berita') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Foto Berita</label>
                <input type="file" name="foto_berita" class="form-control @error('foto_berita') is-invalid @enderror"
                       accept="image/*" onchange="previewImage(this)">
                @error('foto_berita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div id="imagePreview" class="mt-2" style="display:none;">
                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 200px;">
                </div>
                <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 2MB</small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Isi Berita <span class="text-danger">*</span></label>
                <textarea name="isi_berita" class="form-control @error('isi_berita') is-invalid @enderror"
                          rows="12" placeholder="Tulis isi berita di sini..." required
                          maxlength="12000">{{ old('isi_berita') }}</textarea>
                @error('isi_berita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-muted">Maks. 12.000 karakter. <span id="charCount">0</span>/12000</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-send me-2"></i>Publikasikan
                </button>
                <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
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
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    const textarea = document.querySelector('textarea[name="isi_berita"]');
    const counter = document.getElementById('charCount');
    textarea.addEventListener('input', () => counter.textContent = textarea.value.length);
</script>
@endpush
