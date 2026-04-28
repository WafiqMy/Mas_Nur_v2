@extends('layouts.app')

@section('title', 'Edit Barang - Admin')

@section('content')
<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.reservasi.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Edit Barang Persewaan</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4">
        <form action="{{ route('admin.reservasi.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" class="form-control"
                           value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Jenis <span class="text-danger">*</span></label>
                    <select name="Jenis" class="form-select" required>
                        <option value="Gedung" {{ $barang->Jenis === 'Gedung' ? 'selected' : '' }}>Gedung</option>
                        <option value="Alat Musik" {{ $barang->Jenis === 'Alat Musik' ? 'selected' : '' }}>Alat Musik</option>
                        <option value="Alat Multimedia" {{ $barang->Jenis === 'Alat Multimedia' ? 'selected' : '' }}>Alat Multimedia</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Harga/Hari (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga" class="form-control"
                           value="{{ old('harga', $barang->harga) }}" min="0" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control"
                           value="{{ old('jumlah', $barang->jumlah) }}" min="1" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Gambar</label>
                    @if($barang->gambar)
                    <div class="mb-2">
                        <img src="{{ $barang->gambar_url }}" alt="Gambar saat ini" class="img-fluid rounded-2" style="max-height: 150px;">
                        <p class="text-muted small mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                    </div>
                    @endif
                    <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <div id="imagePreview" class="mt-2" style="display:none;">
                        <img src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 150px;">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Spesifikasi</label>
                    <textarea name="spesifikasi" class="form-control" rows="3">{{ old('spesifikasi', $barang->spesifikasi) }}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fasilitas</label>
                    <textarea name="fasilitas" class="form-control" rows="3">{{ old('fasilitas', $barang->fasilitas) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
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
