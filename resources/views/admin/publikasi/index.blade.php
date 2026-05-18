@extends('layouts.app')
@section('title', 'Kelola Publikasi - Admin')

@push('styles')
<style>
.pub-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    color: white; padding: 2rem; border-radius: 14px; margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(124,58,237,0.2);
}
.pub-header h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.2rem; }
.pub-header p  { opacity: 0.9; margin: 0; }

.summary-card {
    border: none; border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07); transition: transform 0.2s;
}
.summary-card:hover { transform: translateY(-3px); }
.s-icon {
    width: 52px; height: 52px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
}

/* Poster Grid */
.poster-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.25rem;
}
.poster-card {
    background: white; border-radius: 14px; overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07); border: 1px solid #e5e7eb;
    transition: box-shadow 0.3s;
}
.poster-card:hover { box-shadow: 0 8px 24px rgba(124,58,237,0.15); }
.poster-card.inactive { opacity: 0.55; }
.poster-img {
    width: 100%; height: 200px; object-fit: cover; display: block; cursor: pointer;
}
.poster-body { padding: 0.9rem; }
.poster-title {
    font-weight: 700; font-size: 0.9rem; color: #1f2937;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0.3rem;
}
.poster-desc {
    font-size: 0.78rem; color: #6b7280;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 0.6rem;
}
.poster-actions { display: flex; gap: 0.4rem; flex-wrap: wrap; }

/* Badge */
.badge-aktif   { background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600; }
.badge-nonaktif{ background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:20px;font-size:0.75rem;font-weight:600; }

/* Modal */
.modal-content { border: none; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.modal-header  { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; border-radius: 14px 14px 0 0; border: none; }
.modal-header .btn-close { filter: brightness(0) invert(1); }

.btn-pub {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    border: none; color: white; padding: 0.6rem 1.4rem;
    border-radius: 8px; font-weight: 600; transition: all 0.3s;
}
.btn-pub:hover { opacity: 0.9; transform: translateY(-1px); color: white; }

.img-preview-box {
    width: 100%; height: 180px; border: 2px dashed #d1d5db; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    background: #f9fafb; overflow: hidden; margin-top: 0.5rem;
}
.img-preview-box img { width: 100%; height: 100%; object-fit: cover; }
.img-preview-box.empty { color: #9ca3af; flex-direction: column; gap: 0.4rem; font-size: 0.85rem; }

/* Lightbox */
.lightbox-overlay {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9);
    z-index: 9999; align-items: center; justify-content: center;
}
.lightbox-overlay.show { display: flex; }
.lightbox-overlay img { max-width: 90vw; max-height: 90vh; border-radius: 8px; }
.lightbox-close {
    position: absolute; top: 20px; right: 24px; color: white;
    font-size: 2rem; cursor: pointer; line-height: 1;
}

.alert-custom { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; border-left: 4px solid; }
.alert-success-custom { background: #d1fae5; border-color: #10b981; color: #065f46; }
.alert-danger-custom  { background: #fee2e2; border-color: #ef4444; color: #991b1b; }

/* Link publikasi box */
.pub-link-box {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 2px dashed #2563eb; border-radius: 14px; padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success-custom"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger-custom">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="pub-header">
        <h1><i class="bi bi-megaphone me-2"></i>Kelola Publikasi</h1>
        <p>Tambah, edit, atau hapus poster/iklan yang ditampilkan di halaman publikasi</p>
    </div>

    {{-- Link ke website publikasi --}}
    <div class="pub-link-box">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="fw-700 mb-1" style="font-weight:700;color:#1e3a5f;">
                    <i class="bi bi-box-arrow-up-right me-2"></i>Website Publikasi
                </div>
                <div class="text-muted small">Halaman ini yang dilihat oleh masyarakat umum — terpisah dari website utama</div>
            </div>
            <a href="{{ route('publikasi.page') }}" target="_blank"
               class="btn btn-sm"
               style="background:#2563eb;color:white;border-radius:8px;font-weight:600;padding:8px 20px;">
                <i class="bi bi-eye me-1"></i>Buka Website Publikasi
            </a>
        </div>
        <div class="mt-2">
            <code style="background:white;padding:4px 10px;border-radius:6px;font-size:0.85rem;color:#2563eb;">
                {{ url('/publikasi') }}
            </code>
            <button class="btn btn-sm btn-outline-secondary ms-2" style="font-size:0.8rem;"
                    onclick="navigator.clipboard.writeText('{{ url('/publikasi') }}');this.innerHTML='<i class=\'bi bi-check\' ></i> Tersalin';setTimeout(()=>this.innerHTML='<i class=\'bi bi-clipboard\'></i> Salin Link',2000)">
                <i class="bi bi-clipboard"></i> Salin Link
            </button>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card summary-card">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="s-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-images"></i></div>
                    <div>
                        <div class="text-muted small">Total Poster</div>
                        <div style="font-size:1.4rem;font-weight:800;color:#2563eb;">{{ $totalSemua }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card summary-card">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="s-icon" style="background:#d1fae5;color:#059669;"><i class="bi bi-eye"></i></div>
                    <div>
                        <div class="text-muted small">Sedang Ditampilkan</div>
                        <div style="font-size:1.4rem;font-weight:800;color:#059669;">{{ $totalAktif }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0 small">Klik poster untuk memperbesar tampilan</p>
        <button class="btn btn-pub" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i>Tambah Poster
        </button>
    </div>

    {{-- Grid Poster --}}
    @if($publikasi->count() > 0)
        <div class="poster-grid">
            @foreach($publikasi as $item)
            <div class="poster-card {{ !$item->is_active ? 'inactive' : '' }}">
                <div style="position:relative;">
                    <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}"
                         class="poster-img"
                         onclick="openLightbox('{{ $item->foto_url }}', '{{ $item->judul }}')"
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                    <span style="position:absolute;top:8px;right:8px;">
                        @if($item->is_active)
                            <span class="badge-aktif"><i class="bi bi-eye me-1"></i>Aktif</span>
                        @else
                            <span class="badge-nonaktif"><i class="bi bi-eye-slash me-1"></i>Nonaktif</span>
                        @endif
                    </span>
                </div>
                <div class="poster-body">
                    <div class="poster-title" title="{{ $item->judul }}">{{ $item->judul }}</div>
                    @if($item->keterangan)
                        <div class="poster-desc" title="{{ $item->keterangan }}">{{ $item->keterangan }}</div>
                    @endif
                    <div class="text-muted" style="font-size:0.72rem;margin-bottom:0.6rem;">
                        {{ $item->created_at->format('d M Y') }}
                    </div>
                    <div class="poster-actions">
                        <button class="btn btn-sm btn-outline-warning flex-fill"
                                data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.publikasi.toggle', $item->id) }}" method="POST" class="flex-fill">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm w-100 {{ $item->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                    title="{{ $item->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                <i class="bi {{ $item->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.publikasi.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus poster \'{{ $item->judul }}\'?')">
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
        <div class="mt-4">{{ $publikasi->links() }}</div>
    @else
        <div class="text-center py-5" style="background:#f9fafb;border-radius:14px;border:2px dashed #e5e7eb;">
            <i class="bi bi-megaphone display-3 text-muted opacity-50 d-block mb-3"></i>
            <h5 class="text-muted fw-semibold">Belum Ada Poster</h5>
            <p class="text-muted small mb-3">Mulai dengan menambahkan poster atau iklan pertama.</p>
            <button class="btn btn-pub" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg me-1"></i>Tambah Poster Pertama
            </button>
        </div>
    @endif
</div>

{{-- Lightbox --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <img src="" id="lightboxImg" alt="">
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-lg me-2"></i>Tambah Poster Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.publikasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Poster <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required
                               placeholder="Contoh: Pengumuman Acara Maulid Nabi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto / Poster <span class="text-danger">*</span></label>
                        <input type="file" name="foto" class="form-control" required
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImg(this,'prevTambah')">
                        <div class="img-preview-box empty" id="prevTambah">
                            <i class="bi bi-image fs-2"></i>
                            <span>Belum ada foto</span>
                        </div>
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks. 5MB.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan <span class="text-muted small">(opsional)</span></label>
                        <textarea name="keterangan" class="form-control" rows="2"
                                  placeholder="Deskripsi singkat poster ini"></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="activeAdd">
                        <label class="form-check-label fw-semibold" for="activeAdd">Tampilkan di website publikasi</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pub"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach($publikasi as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Poster</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.publikasi.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Poster</label>
                        <input type="text" name="judul" class="form-control" required value="{{ $item->judul }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ganti Foto <span class="text-muted small">(opsional)</span></label>
                        <div class="mb-2">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}"
                                 class="rounded-2" style="max-height:100px;object-fit:cover;">
                            <p class="text-muted small mt-1">Foto saat ini. Upload baru untuk mengganti.</p>
                        </div>
                        <input type="file" name="foto" class="form-control"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImg(this,'prevEdit{{ $item->id }}')">
                        <div class="img-preview-box empty" id="prevEdit{{ $item->id }}">
                            <i class="bi bi-image fs-2"></i>
                            <span>Belum ada foto baru</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                               id="activeEdit{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="activeEdit{{ $item->id }}">
                            Tampilkan di website publikasi
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-pub"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
function previewImg(input, id) {
    const box = document.getElementById(id);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            box.classList.remove('empty');
            box.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function openLightbox(src, title) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').classList.add('show');
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('show');
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

// Auto dismiss alerts
document.querySelectorAll('.alert-custom').forEach(el => {
    setTimeout(() => { el.style.opacity='0'; setTimeout(()=>el.remove(),300); }, 4000);
});
</script>
@endpush
@endsection
