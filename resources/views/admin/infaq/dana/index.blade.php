@extends('layouts.app')
@section('title', 'Kelola Infaq - Admin')

@push('styles')
<style>
.infaq-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    color: white; padding: 2rem; border-radius: 14px; margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(37,99,235,0.2);
}
.infaq-header h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.2rem; }
.infaq-header p  { opacity: 0.9; margin: 0; }

/* Ringkasan Cards */
.summary-card {
    border: none; border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.summary-card:hover { transform: translateY(-4px); }
.summary-icon {
    width: 56px; height: 56px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
}
.icon-masuk   { background: #d1fae5; color: #059669; }
.icon-keluar  { background: #fee2e2; color: #dc2626; }
.icon-saldo   { background: #dbeafe; color: #2563eb; }
.icon-bulan   { background: #fef3c7; color: #d97706; }

/* Tabs */
.infaq-tabs .nav-link {
    border-radius: 10px 10px 0 0; font-weight: 600; color: #6b7280;
    border: none; padding: 0.75rem 1.5rem;
}
.infaq-tabs .nav-link.active { background: white; color: #2563eb; border-bottom: 3px solid #2563eb; }

/* Table */
.infaq-table { border-radius: 14px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.07); }
.infaq-table thead { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; }
.infaq-table th, .infaq-table td { padding: 1rem 1.2rem; border: none; border-bottom: 1px solid #f3f4f6; }
.infaq-table tbody tr:hover { background: #f8f9ff; }

/* Badge tipe */
.badge-masuk  { background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
.badge-keluar { background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }

/* Modal */
.modal-content { border: none; border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.modal-header  { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; border-radius: 14px 14px 0 0; border: none; }
.modal-header .btn-close { filter: brightness(0) invert(1); }

.btn-primary-custom {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    border: none; color: white; padding: 0.6rem 1.4rem;
    border-radius: 8px; font-weight: 600; transition: all 0.3s;
}
.btn-primary-custom:hover { opacity: 0.9; transform: translateY(-1px); color: white; }

.alert-custom { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; border-left: 4px solid; }
.alert-success-custom { background: #d1fae5; border-color: #10b981; color: #065f46; }
.alert-danger-custom  { background: #fee2e2; border-color: #ef4444; color: #991b1b; }
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
            <i class="bi bi-exclamation-triangle me-2"></i><strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="infaq-header">
        <h1><i class="bi bi-cash-coin me-2"></i>Kelola Laporan Infaq</h1>
        <p>Catat dana masuk dan pengeluaran infaq masjid secara transparan</p>
    </div>

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card summary-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon icon-masuk"><i class="bi bi-arrow-down-circle-fill"></i></div>
                    <div>
                        <div class="text-muted small">Total Dana Masuk</div>
                        <div class="fw-700 fs-6" style="color:#059669;font-weight:700;">Rp {{ number_format($totalMasuk,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card summary-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon icon-keluar"><i class="bi bi-arrow-up-circle-fill"></i></div>
                    <div>
                        <div class="text-muted small">Total Dana Keluar</div>
                        <div class="fw-700 fs-6" style="color:#dc2626;font-weight:700;">Rp {{ number_format($totalKeluar,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card summary-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon icon-saldo"><i class="bi bi-wallet2"></i></div>
                    <div>
                        <div class="text-muted small">Saldo Saat Ini</div>
                        <div class="fw-700 fs-6" style="color:#2563eb;font-weight:700;">Rp {{ number_format($saldo,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card summary-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="summary-icon icon-bulan"><i class="bi bi-calendar-month"></i></div>
                    <div>
                        <div class="text-muted small">Masuk Bulan Ini</div>
                        <div class="fw-700 fs-6" style="color:#d97706;font-weight:700;">Rp {{ number_format($totalMasukBulan,0,',','.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card mb-4" style="border:none;border-radius:14px;box-shadow:0 4px 15px rgba(0,0,0,0.07);">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Bulan</label>
                    <select name="bulan" class="form-select form-select-sm">
                        <option value="">Semua Bulan</option>
                        @for($i=1;$i<=12;$i++)
                            <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                                {{ \Carbon\Carbon::createFromFormat('m',$i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small">Tahun</label>
                    <select name="tahun" class="form-select form-select-sm">
                        <option value="">Semua Tahun</option>
                        @for($i=now()->year;$i>=now()->year-5;$i--)
                            <option value="{{ $i }}" {{ $tahun==$i?'selected':'' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary-custom btn-sm w-100">
                        <i class="bi bi-funnel me-1"></i>Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.infaq.dana.index') }}" class="btn btn-outline-secondary btn-sm w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav infaq-tabs mb-0 border-bottom" id="infaqTab">
        <li class="nav-item">
            <a class="nav-link active" id="masuk-tab" data-bs-toggle="tab" href="#tab-masuk">
                <i class="bi bi-arrow-down-circle me-1 text-success"></i>Dana Masuk
                <span class="badge bg-success ms-1">{{ $danaMasuk->total() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="keluar-tab" data-bs-toggle="tab" href="#tab-keluar">
                <i class="bi bi-arrow-up-circle me-1 text-danger"></i>Dana Keluar
                <span class="badge bg-danger ms-1">{{ $danaKeluar->total() }}</span>
            </a>
        </li>
    </ul>

    <div class="tab-content bg-white rounded-bottom p-3" style="box-shadow:0 4px 15px rgba(0,0,0,0.07);">

        {{-- TAB DANA MASUK --}}
        <div class="tab-pane fade show active" id="tab-masuk">
            <div class="d-flex justify-content-between align-items-center mb-3 pt-2">
                <p class="text-muted mb-0 small">Catat setiap dana infaq yang diterima masjid</p>
                <button class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahMasuk">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Dana Masuk
                </button>
            </div>

            @if($danaMasuk->count() > 0)
                <div class="table-responsive infaq-table">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:18%">Tanggal</th>
                                <th>Keterangan / Sumber</th>
                                <th style="width:20%" class="text-end">Jumlah</th>
                                <th style="width:10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($danaMasuk as $item)
                            <tr>
                                <td>{{ ($danaMasuk->currentPage()-1)*$danaMasuk->perPage()+$loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $item->tanggal->format('d M Y') }}</div>
                                    <div class="text-muted small">{{ $item->tanggal->translatedFormat('l') }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->judul }}</div>
                                    @if($item->keterangan)
                                        <div class="text-muted small">{{ Str::limit($item->keterangan, 60) }}</div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="badge-masuk">+ Rp {{ number_format((float)$item->jumlah,0,',','.') }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning me-1"
                                            data-bs-toggle="modal" data-bs-target="#modalEditMasuk{{ $item->id }}"
                                            title="Edit"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.infaq.dana.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $danaMasuk->appends(request()->query())->links() }}</div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-4 d-block mb-2 opacity-50"></i>
                    <p>Belum ada data dana masuk</p>
                </div>
            @endif
        </div>

        {{-- TAB DANA KELUAR --}}
        <div class="tab-pane fade" id="tab-keluar">
            <div class="d-flex justify-content-between align-items-center mb-3 pt-2">
                <p class="text-muted mb-0 small">Catat setiap penggunaan dana infaq masjid</p>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKeluar"
                        style="border-radius:8px;font-weight:600;">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Dana Keluar
                </button>
            </div>

            @if($danaKeluar->count() > 0)
                <div class="table-responsive infaq-table">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:18%">Tanggal</th>
                                <th>Digunakan Untuk</th>
                                <th style="width:20%" class="text-end">Jumlah</th>
                                <th style="width:10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($danaKeluar as $item)
                            <tr>
                                <td>{{ ($danaKeluar->currentPage()-1)*$danaKeluar->perPage()+$loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $item->tanggal->format('d M Y') }}</div>
                                    <div class="text-muted small">{{ $item->tanggal->translatedFormat('l') }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $item->keperluan }}</div>
                                    @if($item->keterangan)
                                        <div class="text-muted small">{{ Str::limit($item->keterangan, 60) }}</div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="badge-keluar">- Rp {{ number_format((float)$item->jumlah,0,',','.') }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-warning me-1"
                                            data-bs-toggle="modal" data-bs-target="#modalEditKeluar{{ $item->id }}"
                                            title="Edit"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.infaq.pengeluaran.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $danaKeluar->appends(request()->query())->links() }}</div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-4 d-block mb-2 opacity-50"></i>
                    <p>Belum ada data dana keluar</p>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL TAMBAH DANA MASUK --}}
<div class="modal fade" id="modalTambahMasuk" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-arrow-down-circle me-2"></i>Tambah Dana Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.infaq.dana.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sumber / Keterangan Dana <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" required
                               placeholder="Contoh: Infaq Jum'at, Donasi Pembangunan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" required min="1"
                               placeholder="Contoh: 500000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                        <div class="input-group"><span class="input-group-text bg-primary text-white"><i class="bi bi-calendar3"></i></span><input type="date" name="tanggal" class="form-control" required value="{{ now()->format('Y-m-d') }}"></div><div class="date-helper"><i class="bi bi-info-circle me-1"></i>Klik untuk memilih tanggal</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan Tambahan <span class="text-muted small">(opsional)</span></label>
                        <textarea name="keterangan" class="form-control" rows="2"
                                  placeholder="Catatan tambahan jika ada"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH DANA KELUAR --}}
<div class="modal fade" id="modalTambahKeluar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#7f1d1d,#dc2626);">
                <h5 class="modal-title"><i class="bi bi-arrow-up-circle me-2"></i>Tambah Dana Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.infaq.pengeluaran.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Digunakan Untuk <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" class="form-control" required
                               placeholder="Contoh: Perbaikan Atap Masjid, Beli Karpet">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" required min="1"
                               placeholder="Contoh: 1500000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                        <div class="input-group"><span class="input-group-text bg-primary text-white"><i class="bi bi-calendar3"></i></span><input type="date" name="tanggal" class="form-control" required value="{{ now()->format('Y-m-d') }}"></div><div class="date-helper"><i class="bi bi-info-circle me-1"></i>Klik untuk memilih tanggal</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan Tambahan <span class="text-muted small">(opsional)</span></label>
                        <textarea name="keterangan" class="form-control" rows="2"
                                  placeholder="Detail penggunaan dana"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" style="border-radius:8px;font-weight:600;">
                        <i class="bi bi-check-lg me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT DANA MASUK --}}
@foreach($danaMasuk as $item)
<div class="modal fade" id="modalEditMasuk{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Dana Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.infaq.dana.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sumber / Keterangan Dana</label>
                        <input type="text" name="judul" class="form-control" required value="{{ $item->judul }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" required min="1" value="{{ $item->jumlah }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Masuk</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar3"></i></span>
                            <input type="date" name="tanggal" class="form-control" required value="{{ $item->tanggal->format('Y-m-d') }}">
                        </div>
                        <div class="date-helper"><i class="bi bi-info-circle me-1"></i>Klik untuk memilih tanggal</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Catatan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary-custom"><i class="bi bi-check-lg me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- MODAL EDIT DANA KELUAR --}}
@foreach($danaKeluar as $item)
<div class="modal fade" id="modalEditKeluar{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#7f1d1d,#dc2626);">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Dana Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.infaq.pengeluaran.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Digunakan Untuk</label>
                        <input type="text" name="keperluan" class="form-control" required value="{{ $item->keperluan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" required min="1" value="{{ $item->jumlah }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Pengeluaran</label>
                        <div class="input-group">
                            <span class="input-group-text bg-danger text-white"><i class="bi bi-calendar3"></i></span>
                            <input type="date" name="tanggal" class="form-control" required value="{{ $item->tanggal->format('Y-m-d') }}">
                        </div>
                        <div class="date-helper"><i class="bi bi-info-circle me-1"></i>Klik untuk memilih tanggal</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" style="border-radius:8px;font-weight:600;">
                        <i class="bi bi-check-lg me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@push('scripts')
<script>
// Buka tab yang sesuai jika ada hash di URL
document.addEventListener('DOMContentLoaded', function () {
    if (window.location.hash === '#keluar') {
        const tab = document.getElementById('keluar-tab');
        if (tab) new bootstrap.Tab(tab).show();
    }
    // Auto dismiss alerts
    document.querySelectorAll('.alert-custom').forEach(el => {
        setTimeout(() => { el.style.opacity='0'; setTimeout(()=>el.remove(),300); }, 4000);
    });
});
</script>
@endpush
@endsection
