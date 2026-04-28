@extends('layouts.app')

@section('title', 'Kelola Infaq Dana - Admin')

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

    .dashboard-card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .card-primary { background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%); color: white; }
    .card-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
    .card-warning { background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%); color: white; }
    .card-info { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; }

    .admin-table {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        background: white;
    }

    .admin-table thead {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
    }

    .admin-table th {
        padding: 1.2rem;
        font-weight: 700;
        border: none;
    }

    .admin-table td {
        padding: 1rem 1.2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .admin-table tbody tr:hover {
        background: #f8f9fa;
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

    .no-data-message {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .admin-table {
            font-size: 0.9rem;
        }

        .admin-table th,
        .admin-table td {
            padding: 0.7rem;
        }
    }
</style>
@endpush

@section('content')

<div class="container py-5">
    <div class="mb-5">
        <h1 class="page-title">Kelola Infaq Dana</h1>
        <p class="page-subtitle">Manajemen data infaq dan dana yang masuk</p>
    </div>

    {{-- DASHBOARD CARDS --}}
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon card-primary me-3">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Dana Bulan Ini</p>
                            <h4 class="mb-0" style="color: #2563eb; font-weight: 700;">
                                Rp {{ number_format((float) $totalBulanIni, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon card-success me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Dana Keseluruhan</p>
                            <h4 class="mb-0" style="color: #059669; font-weight: 700;">
                                Rp {{ number_format((float) $totalKeseluruhan, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon card-warning me-3">
                            <i class="bi bi-hash"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Jumlah Transaksi</p>
                            <h4 class="mb-0" style="color: #F59E0B; font-weight: 700;">{{ $jumlahTransaksi }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ADD BUTTON --}}
    <div class="mb-4">
        <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addInfaqModal">
            <i class="bi bi-plus-circle me-2"></i>Tambah Data Infaq
        </button>
        <a href="{{ route('admin.infaq.rekening.index') }}" class="btn btn-outline-primary ms-2">
            <i class="bi bi-gear me-2"></i>Kelola Rekening & QRIS
        </a>
    </div>

    {{-- FILTER FORM --}}
    <div class="card mb-4" style="border: none; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-600">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromFormat('m', $i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-600">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for($i = now()->year; $i >= now()->year - 5; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary-custom w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    @if($dana->count() > 0)
        <div class="table-responsive admin-table">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 20%">Tanggal</th>
                        <th style="width: 25%">Judul</th>
                        <th style="width: 30%">Keterangan</th>
                        <th style="width: 15%" class="text-end">Jumlah</th>
                        <th style="width: 5%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dana as $item)
                        <tr>
                            <td>{{ ($dana->currentPage() - 1) * $dana->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->tanggal->format('d M Y') }}</td>
                            <td><strong>{{ $item->judul }}</strong></td>
                            <td>{{ \Illuminate\Support\Str::limit($item->keterangan ?? '-', 50) }}</td>
                            <td class="text-end" style="color: #059669; font-weight: 700;">
                                Rp {{ number_format((float) $item->jumlah, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary-custom btn-sm-custom" 
                                        data-bs-toggle="modal" data-bs-target="#editInfaqModal{{ $item->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('admin.infaq.dana.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-custom" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $dana->links() }}
        </div>
    @else
        <div class="card no-data-message" style="border: none; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <p>Belum ada data infaq dana</p>
        </div>
    @endif
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addInfaqModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Infaq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.infaq.dana.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-600">Judul</label>
                        <input type="text" name="judul" class="form-control" required placeholder="Contoh: Infaq Pembangunan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" step="0.01" required placeholder="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-600">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
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
@foreach($dana as $item)
    <div class="modal fade" id="editInfaqModal{{ $item->id }}" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Infaq</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.infaq.dana.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-600">Judul</label>
                            <input type="text" name="judul" class="form-control" required value="{{ $item->judul }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" class="form-control" step="0.01" required value="{{ $item->jumlah }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required value="{{ $item->tanggal->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-600">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ $item->keterangan }}</textarea>
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
