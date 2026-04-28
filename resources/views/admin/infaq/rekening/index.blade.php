@extends('layouts.app')

@section('title', 'Kelola Rekening & QRIS - Admin')

@push('styles')
<style>
    .dashboard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .rekening-item {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background: white;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: start;
    }

    .rekening-item:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .rekening-info h5 {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .rekening-info p {
        margin: 0.3rem 0;
        font-size: 0.95rem;
        color: #6b7280;
    }

    .rekening-account {
        background: #f3f4f6;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        color: #1f2937;
        font-size: 0.9rem;
        word-break: break-all;
    }

    .qris-preview {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .badge-active {
        background: #10b981;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-inactive {
        background: #ef4444;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .btn-sm-custom {
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-sm-custom:hover {
        transform: translateY(-2px);
    }

    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 16px 16px 0 0;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 0.7rem 1rem;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .btn-danger-custom {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-danger-custom:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .preview-image {
        max-width: 100%;
        max-height: 200px;
        margin-top: 1rem;
        border-radius: 8px;
    }

    .no-data-message {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .rekening-item {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

<div class="container py-5">
    <div class="mb-5">
        <h1 class="page-title">Kelola Rekening & QRIS</h1>
        <p class="page-subtitle">Atur nomor rekening dan kode QRIS untuk infaq</p>
    </div>

    {{-- ADD BUTTON --}}
    <div class="mb-4">
        <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addRekeningModal">
            <i class="bi bi-plus-circle me-2"></i>Tambah Rekening
        </button>
        <a href="{{ route('admin.infaq.dana.index') }}" class="btn btn-outline-primary ms-2">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Kelola Dana
        </a>
    </div>

    {{-- REKENING LIST --}}
    @if($rekenings->count() > 0)
        @foreach($rekenings as $rekening)
            <div class="rekening-item">
                <div class="rekening-info flex-grow-1">
                    <h5>
                        {{ $rekening->nama_bank }}
                        @if($rekening->is_active)
                            <span class="badge-active ms-2">Aktif</span>
                        @else
                            <span class="badge-inactive ms-2">Nonaktif</span>
                        @endif
                    </h5>

                    <p><strong>Nomor Rekening:</strong></p>
                    <div class="rekening-account mb-2">{{ $rekening->nomor_rekening }}</div>

                    <p class="mb-0"><strong>Atas Nama:</strong> {{ $rekening->nama_pemilik }}</p>

                    @if($rekening->qris_image)
                        <p class="mt-2 mb-1"><strong>QRIS Image:</strong></p>
                        <img src="{{ $rekening->qris_url }}" alt="QRIS" class="qris-preview">
                    @endif
                </div>

                <div class="ms-3 d-flex gap-2 flex-column">
                    <button type="button" class="btn btn-primary-custom btn-sm-custom" 
                            data-bs-toggle="modal" data-bs-target="#editRekeningModal{{ $rekening->id }}">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </button>
                    <form action="{{ route('admin.infaq.rekening.destroy', $rekening->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-custom w-100" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="card no-data-message" style="border: none; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <p>Belum ada rekening yang terdaftar</p>
        </div>
    @endif
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addRekeningModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rekening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.infaq.rekening.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Bank</label>
                        <input type="text" name="nama_bank" class="form-control" required placeholder="Contoh: Bank Mandiri">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" class="form-control" required placeholder="Contoh: 123456789">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Nama Pemilik Rekening</label>
                        <input type="text" name="nama_pemilik" class="form-control" required placeholder="Contoh: Masjid Nurul Huda">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Upload QRIS Image (Optional)</label>
                        <input type="file" name="qris_image" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WEBP. Max 2MB</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="addIsActive" checked>
                            <label class="form-check-label" for="addIsActive">
                                Aktifkan rekening ini
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary-custom">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- EDIT MODALS --}}
@foreach($rekenings as $rekening)
    <div class="modal fade" id="editRekeningModal{{ $rekening->id }}" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.infaq.rekening.update', $rekening->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-600">Nama Bank</label>
                            <input type="text" name="nama_bank" class="form-control" required value="{{ $rekening->nama_bank }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" class="form-control" required value="{{ $rekening->nomor_rekening }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Nama Pemilik Rekening</label>
                            <input type="text" name="nama_pemilik" class="form-control" required value="{{ $rekening->nama_pemilik }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Upload QRIS Image (Optional)</label>
                            @if($rekening->qris_image)
                                <div class="mb-2">
                                    <p class="text-muted mb-2">QRIS Saat Ini:</p>
                                    <img src="{{ $rekening->qris_url }}" alt="QRIS" class="qris-preview">
                                </div>
                            @endif
                            <input type="file" name="qris_image" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP. Max 2MB. Biarkan kosong jika tidak ingin mengubah.</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="editIsActive{{ $rekening->id }}" {{ $rekening->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="editIsActive{{ $rekening->id }}">
                                    Aktifkan rekening ini
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary-custom">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
