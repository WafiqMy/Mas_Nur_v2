@extends('layouts.app')

@section('title', 'Kelola Rekening & QRIS - Admin Infaq')

@push('styles')
<style>
    /* ===== REKENING ADMIN SECTION ===== */

    .admin-header {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 8px 24px rgba(59, 91, 219, 0.15);
    }

    .admin-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .admin-header p {
        font-size: 1rem;
        opacity: 0.95;
        margin: 0;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        border-color: #3B5BDB;
        box-shadow: 0 8px 20px rgba(59, 91, 219, 0.1);
    }

    .dashboard-card .card-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #3B5BDB;
        margin: 1rem 0 0.5rem 0;
        font-family: 'Poppins', sans-serif;
    }

    .dashboard-card .card-label {
        font-size: 0.95rem;
        color: #6b7280;
        font-weight: 500;
    }

    .dashboard-card .card-icon {
        font-size: 2rem;
        color: #3B5BDB;
        margin-bottom: 0.5rem;
    }

    /* Status Badge */
    .badge-status {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .badge-active {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-qris {
        background: #dbeafe;
        color: #0c4a6e;
    }

    /* Buttons */
    .btn-primary-custom {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(59, 91, 219, 0.3);
        color: white;
    }

    .btn-secondary-custom {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #374151;
        padding: 0.625rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-secondary-custom:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }

    .btn-danger-custom {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .btn-danger-custom:hover {
        background: #fecaca;
    }

    .btn-success-custom {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #86efac;
    }

    .btn-success-custom:hover {
        background: #a7f3d0;
    }

    /* Admin Table */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .admin-table thead {
        background: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
    }

    .admin-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 700;
        color: #374151;
        font-size: 0.95rem;
        font-family: 'Poppins', sans-serif;
    }

    .admin-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #4b5563;
    }

    .admin-table tbody tr {
        transition: all 0.2s ease;
    }

    .admin-table tbody tr:hover {
        background: #f9fafb;
    }

    .admin-table .text-muted {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    /* Modal Content */
    .modal-content {
        border: none;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
        border-radius: 12px 12px 0 0;
        border: none;
        padding: 1.5rem;
    }

    .modal-header h5 {
        margin: 0;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
    }

    .form-control:focus {
        outline: none;
        border-color: #3B5BDB;
        box-shadow: 0 0 0 3px rgba(59, 91, 219, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.375rem;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0;
        border: 2px solid #d1d5db;
        border-radius: 4px;
        cursor: pointer;
        accent-color: #3B5BDB;
    }

    .form-check-input:checked {
        background: #3B5BDB;
        border-color: #3B5BDB;
    }

    /* Image Preview */
    .image-preview {
        max-width: 150px;
        height: 150px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9fafb;
        overflow: hidden;
        margin-top: 0.75rem;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .image-preview.empty {
        color: #9ca3af;
    }

    /* Action Buttons Row */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Alert Messages */
    .alert-custom {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
        animation: slideIn 0.3s ease;
    }

    .alert-success-custom {
        background: #d1fae5;
        border-color: #10b981;
        color: #065f46;
    }

    .alert-danger-custom {
        background: #fee2e2;
        border-color: #ef4444;
        color: #991b1b;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-header h1 {
            font-size: 1.875rem;
        }

        .admin-table {
            font-size: 0.9rem;
        }

        .admin-table th,
        .admin-table td {
            padding: 0.75rem 0.5rem;
        }

        .action-buttons {
            gap: 0.25rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .modal-body {
            padding: 1.5rem;
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #9ca3af;
        margin-bottom: 1.5rem;
    }

    /* Copy Button */
    .copy-btn {
        cursor: pointer;
        font-size: 0.9rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .copy-btn:hover {
        background: #f3f4f6;
    }

    .copy-btn.copied {
        color: #10b981;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    {{-- Alert Messages --}}
    @if ($errors->any())
    <div class="alert alert-danger-custom">
        <strong><i class="bi bi-exclamation-triangle"></i> Terjadi Kesalahan!</strong>
        <ul class="mb-0 mt-2" style="padding-left: 1.5rem;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success-custom">
        <strong><i class="bi bi-check-circle"></i> Sukses!</strong>
        {{ session('success') }}
    </div>
    @endif

    {{-- Page Header --}}
    <div class="admin-header">
        <h1><i class="bi bi-bank"></i> Kelola Rekening & QRIS</h1>
        <p>Atur nomor rekening bank dan kode QRIS untuk penerimaan infaq</p>
    </div>

    {{-- Dashboard Cards Row --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <div class="card-icon"><i class="bi bi-collection"></i></div>
                <div class="card-label">Total Rekening</div>
                <div class="card-value">{{ $totalRekenings }}</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <div class="card-icon"><i class="bi bi-check-lg"></i></div>
                <div class="card-label">Rekening Aktif</div>
                <div class="card-value">{{ $activeCount }}</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <div class="card-icon"><i class="bi bi-qr-code"></i></div>
                <div class="card-label">Dengan QRIS</div>
                <div class="card-value">{{ $withQrisCount }}</div>
            </div>
        </div>
    </div>

    {{-- Add Button --}}
    <div class="mb-4">
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addRekeningModal">
            <i class="bi bi-plus-lg"></i> Tambah Rekening
        </button>
    </div>

    {{-- Rekening Table --}}
    <div class="table-responsive">
        @if ($rekenings->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
            <div class="empty-state-title">Belum Ada Rekening</div>
            <div class="empty-state-text">Mulai dengan menambahkan rekening bank baru untuk menerima infaq</div>
            <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addRekeningModal">
                <i class="bi bi-plus-lg"></i> Tambah Rekening Pertama
            </button>
        </div>
        @else
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 10%;">No.</th>
                    <th style="width: 20%;">Bank</th>
                    <th style="width: 18%;">Nomor Rekening</th>
                    <th style="width: 20%;">Nama Pemilik</th>
                    <th style="width: 12%;">QRIS</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 8%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekenings as $index => $rekening)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td><strong>{{ $rekening->nama_bank }}</strong></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="font-family: 'Courier New', monospace; font-weight: 600;">
                                {{ $rekening->nomor_rekening }}
                            </span>
                            <button class="copy-btn" onclick="copyToClipboard('{{ $rekening->nomor_rekening }}')"
                                    title="Salin">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ $rekening->nama_pemilik }}</td>
                    <td>
                        @if ($rekening->qris_image)
                        <span class="badge badge-qris">
                            <i class="bi bi-qr-code"></i> Ada
                        </span>
                        @else
                        <span class="text-muted"><i class="bi bi-dash"></i> Belum</span>
                        @endif
                    </td>
                    <td>
                        @if ($rekening->is_active)
                        <span class="badge badge-active"><i class="bi bi-check-lg"></i> Aktif</span>
                        @else
                        <span class="badge badge-inactive"><i class="bi bi-x-lg"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <div class="action-buttons" style="justify-content: center;">
                            <button class="btn btn-secondary-custom btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editRekeningModal{{ $rekening->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.infaq.rekening.destroy', $rekening) }}"
                                  style="display: inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus rekening ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-custom btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

{{-- ADD REKENING MODAL --}}
<div class="modal fade" id="addRekeningModal" tabindex="-1" aria-labelledby="addRekeningLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRekeningLabel">
                    <i class="bi bi-plus-lg"></i> Tambah Rekening Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.infaq.rekening.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Bank <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nama_bank" class="form-control @error('nama_bank') is-invalid @enderror"
                               placeholder="Contoh: BCA, Mandiri, BNI" value="{{ old('nama_bank') }}" required>
                        @error('nama_bank')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Rekening <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror"
                               placeholder="Contoh: 123456789012" value="{{ old('nomor_rekening') }}" required>
                        @error('nomor_rekening')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Pemilik <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nama_pemilik" class="form-control @error('nama_pemilik') is-invalid @enderror"
                               placeholder="Nama sesuai dengan rekening" value="{{ old('nama_pemilik') }}" required>
                        @error('nama_pemilik')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gambar QRIS <span style="color: #9ca3af; font-size: 0.85rem;">(Opsional)</span></label>
                        <input type="file" name="qris_image" class="form-control @error('qris_image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               onchange="previewImage(this, 'qrisPreview')">
                        <div class="image-preview empty" id="qrisPreview">
                            <i class="bi bi-image"></i> Belum Ada Gambar
                        </div>
                        @error('qris_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, atau WEBP. Ukuran maksimal 2MB</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active_add" checked>
                        <label class="form-label" for="is_active_add" style="margin: 0;">
                            Aktifkan rekening ini
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg"></i> Simpan Rekening
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT REKENING MODALS --}}
@foreach ($rekenings as $rekening)
<div class="modal fade" id="editRekeningModal{{ $rekening->id }}" tabindex="-1"
     aria-labelledby="editRekeningLabel{{ $rekening->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRekeningLabel{{ $rekening->id }}">
                    <i class="bi bi-pencil"></i> Edit Rekening - {{ $rekening->nama_bank }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.infaq.rekening.update', $rekening) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Nama Bank <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nama_bank" class="form-control"
                               value="{{ old('nama_bank', $rekening->nama_bank) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Rekening <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nomor_rekening" class="form-control"
                               value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Pemilik <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="nama_pemilik" class="form-control"
                               value="{{ old('nama_pemilik', $rekening->nama_pemilik) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Gambar QRIS <span style="color: #9ca3af; font-size: 0.85rem;">(Opsional)</span></label>

                        @if ($rekening->qris_image)
                        <div style="margin-bottom: 1rem;">
                            <img src="{{ asset('storage/' . $rekening->qris_image) }}" alt="QRIS"
                                 style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 1px solid #e5e7eb;">
                            <form method="POST" action="{{ route('admin.infaq.rekening.removeQris', $rekening) }}"
                                  style="display: inline; margin-top: 0.5rem;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger-custom btn-sm"
                                        onclick="return confirm('Hapus QRIS ini?');">
                                    <i class="bi bi-trash"></i> Hapus QRIS
                                </button>
                            </form>
                        </div>
                        @endif

                        <input type="file" name="qris_image" class="form-control"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               onchange="previewImage(this, 'qrisPreview{{ $rekening->id }}')">
                        <div class="image-preview empty" id="qrisPreview{{ $rekening->id }}">
                            @if ($rekening->qris_image)
                            <img src="{{ asset('storage/' . $rekening->qris_image) }}" alt="QRIS">
                            @else
                            <i class="bi bi-image"></i> Belum Ada Gambar Baru
                            @endif
                        </div>
                        <small class="text-muted">Format: JPG, PNG, atau WEBP. Ukuran maksimal 2MB</small>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                               id="is_active_{{ $rekening->id }}"
                               @if ($rekening->is_active) checked @endif>
                        <label class="form-label" for="is_active_{{ $rekening->id }}" style="margin: 0;">
                            Aktifkan rekening ini
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    // Image Preview Function
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Copy to Clipboard Function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show feedback
            const btn = event.target.closest('.copy-btn');
            const originalIcon = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
            btn.classList.add('copied');

            setTimeout(() => {
                btn.innerHTML = originalIcon;
                btn.classList.remove('copied');
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy:', err);
        });
    }

    // Close alert after 5 seconds
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert-custom');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        });
    });
</script>
@endpush
