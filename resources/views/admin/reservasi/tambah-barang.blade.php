@extends('layouts.app')

@section('title', 'Tambah Barang - Admin')

@section('content')
<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Tambah Barang Persewaan</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('admin.reservasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                           value="{{ old('nama_barang') }}" required>
                    @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis <span class="text-danger">*</span></label>
                    <select name="Jenis" class="form-select @error('Jenis') is-invalid @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="Gedung" {{ old('Jenis') === 'Gedung' ? 'selected' : '' }}>Gedung</option>
                        <option value="Alat Musik" {{ old('Jenis') === 'Alat Musik' ? 'selected' : '' }}>Alat Musik</option>
                        <option value="Alat Multimedia" {{ old('Jenis') === 'Alat Multimedia' ? 'selected' : '' }}>Alat Multimedia</option>
                    </select>
                    @error('Jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Harga/Hari (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                           value="{{ old('harga') }}" min="0" required>
                    @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                           value="{{ old('jumlah', 1) }}" min="1" required>
                    @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*"
                           onchange="previewImage(this)">
                    <div id="imagePreview" class="mt-2" style="display:none;">
                        <img src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 200px;">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3">{{ old('spesifikasi') }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fasilitas</label>
                    <textarea name="fasilitas" class="form-control" rows="3">{{ old('fasilitas') }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Barang
                </button>
                <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
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
