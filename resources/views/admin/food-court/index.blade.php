@extends('layouts.app')

@section('title', 'Kelola Food Court - Admin')

@push('styles')
<style>
    /* ===== ADMIN FOOD COURT ===== */
    .admin-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.2);
    }

    .admin-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .admin-header p {
        opacity: 0.9;
        margin: 0;
    }

    /* Menu Cards Grid */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .menu-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
        border: 1px solid #e5e7eb;
        transition: box-shadow 0.3s ease;
    }

    .menu-card:hover {
        box-shadow: 0 8px 24px rgba(37, 99, 235, 0.12);
    }

    .menu-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
    }

    .menu-card-body {
        padding: 1rem;
    }

    .menu-card-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-card-desc {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 0.75rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-card-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Buttons */
    .btn-primary-custom {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: white;
    }

    /* Modal */
    .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        color: white;
        border-radius: 14px 14px 0 0;
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body { padding: 1.75rem; }
    .modal-footer { padding: 1.25rem 1.5rem; border-top: 1px solid #e5e7eb; }

    /* Image Preview */
    .img-preview-box {
        width: 100%;
        height: 160px;
        border: 2px dashed #d1d5db;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9fafb;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .img-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .img-preview-box.empty {
        color: #9ca3af;
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: #f9fafb;
        border-radius: 14px;
        border: 2px dashed #e5e7eb;
    }

    /* Alert */
    .alert-custom {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
        animation: slideIn 0.3s ease;
    }

    .alert-success-custom { background: #d1fae5; border-color: #10b981; color: #065f46; }
    .alert-danger-custom  { background: #fee2e2; border-color: #ef4444; color: #991b1b; }

    @keyframes slideIn {
        from { transform: translateY(-8px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }

    @media (max-width: 576px) {
        .menu-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
        .menu-card-img { height: 140px; }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success-custom">
            <i class="bi bi-check-circle me-2"></i><strong>Sukses!</strong> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger-custom">
            <i class="bi bi-exclamation-triangle me-2"></i><strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-1" style="padding-left: 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="admin-header">
        <h1><i class="bi bi-shop me-2"></i>Kelola Food Court</h1>
        <p>Tambah, edit, atau hapus menu yang ditampilkan di halaman Food Court</p>
    </div>

    {{-- Tombol Tambah --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <p class="text-muted mb-0">Total menu: <strong>{{ $menus->count() }}</strong></p>
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addMenuModal">
            <i class="bi bi-plus-lg me-1"></i>Tambah Menu
        </button>
    </div>

    {{-- Grid Menu --}}
    @if($menus->count() > 0)
        <div class="menu-grid">
            @foreach($menus as $menu)
                <div class="menu-card">
                    <img src="{{ $menu->gambar_url }}"
                         alt="{{ $menu->nama_menu }}"
                         class="menu-card-img"
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                    <div class="menu-card-body">
                        <div class="menu-card-name" title="{{ $menu->nama_menu }}">{{ $menu->nama_menu }}</div>
                        <div class="menu-card-desc" title="{{ $menu->deskripsi }}">
                            {{ $menu->deskripsi ?? '-' }}
                        </div>
                        <div class="menu-card-actions">
                            <button class="btn btn-sm btn-outline-warning flex-fill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editMenuModal{{ $menu->id_food }}"
                                    title="Edit">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </button>
                            <form action="{{ route('admin.food-court.destroy', $menu->id_food) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus menu \'{{ $menu->nama_menu }}\'?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-cup-hot display-3 text-muted opacity-50 d-block mb-3"></i>
            <h5 class="text-muted fw-semibold">Belum Ada Menu</h5>
            <p class="text-muted small mb-3">Mulai dengan menambahkan menu food court pertama.</p>
            <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                <i class="bi bi-plus-lg me-1"></i>Tambah Menu Pertama
            </button>
        </div>
    @endif
</div>

{{-- ===== MODAL TAMBAH ===== --}}
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuLabel">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Menu Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.food-court.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_menu"
                               class="form-control @error('nama_menu') is-invalid @enderror"
                               placeholder="Contoh: Nasi Goreng Spesial"
                               value="{{ old('nama_menu') }}" maxlength="50" required>
                        @error('nama_menu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi <span class="text-muted small">(opsional, maks. 50 karakter)</span></label>
                        <input type="text" name="deskripsi"
                               class="form-control @error('deskripsi') is-invalid @enderror"
                               placeholder="Contoh: Pedas, gurih, lezat"
                               value="{{ old('deskripsi') }}" maxlength="50">
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Menu <span class="text-muted small">(opsional)</span></label>
                        <input type="file" name="gambar"
                               class="form-control @error('gambar') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImg(this, 'addPreview')">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="img-preview-box empty" id="addPreview">
                            <i class="bi bi-image fs-3"></i>
                            <span>Belum ada foto</span>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks. 10MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg me-1"></i>Simpan Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL EDIT (per menu) ===== --}}
@foreach($menus as $menu)
<div class="modal fade" id="editMenuModal{{ $menu->id_food }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-1"></i>Edit Menu
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.food-court.update', $menu->id_food) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_menu" class="form-control"
                               value="{{ old('nama_menu', $menu->nama_menu) }}"
                               maxlength="50" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi <span class="text-muted small">(opsional)</span></label>
                        <input type="text" name="deskripsi" class="form-control"
                               value="{{ old('deskripsi', $menu->deskripsi) }}"
                               maxlength="50">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Menu</label>
                        @if($menu->gambar)
                            <div class="mb-2">
                                <img src="{{ $menu->gambar_url }}" alt="{{ $menu->nama_menu }}"
                                     class="rounded-2" style="max-height: 120px; object-fit: cover;">
                                <p class="text-muted small mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                            </div>
                        @endif
                        <input type="file" name="gambar" class="form-control"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImg(this, 'editPreview{{ $menu->id_food }}')">
                        <div class="img-preview-box empty" id="editPreview{{ $menu->id_food }}">
                            @if($menu->gambar)
                                <img src="{{ $menu->gambar_url }}" alt="{{ $menu->nama_menu }}">
                            @else
                                <i class="bi bi-image fs-3"></i>
                                <span>Belum ada foto baru</span>
                            @endif
                        </div>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks. 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    function previewImg(input, previewId) {
        const box = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                box.classList.remove('empty');
                box.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-dismiss alerts
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.alert-custom').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.3s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            }, 5000);
        });
    });
</script>
@endpush

@endsection
