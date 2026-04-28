@extends('layouts.app')

@section('title', 'Detail Permintaan - Admin')

@section('content')
@php
    // Data bisa dari format kalender (extendedProps) atau langsung dari tabel
    $props = $reservasi['extendedProps'] ?? $reservasi;
    $status = $reservasi['status_reservasi'] ?? ($props['status'] ?? 'Menunggu');
    $statusLower = strtolower($status);
    $badgeClass = 'bg-warning text-dark';
    if (str_contains($statusLower, 'setuju')) $badgeClass = 'bg-success';
    elseif (str_contains($statusLower, 'tolak') || str_contains($statusLower, 'batal')) $badgeClass = 'bg-danger';

    $idReservasi = $reservasi['id_reservasi'] ?? ($reservasi['id'] ?? 0);
@endphp

<div class="container py-5" style="max-width: 700px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.reservasi.permintaan') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Detail Permintaan Reservasi</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <p class="text-muted small mb-1">Barang</p>
                <p class="fw-semibold mb-0">{{ $reservasi['nama_barang'] ?? ($props['barang'] ?? '-') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Jenis</p>
                <p class="fw-semibold mb-0">{{ $reservasi['jenis'] ?? ($props['jenis'] ?? '-') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Peminjam</p>
                <p class="fw-semibold mb-0">{{ $reservasi['nama_pengguna'] ?? ($props['peminjam'] ?? '-') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">No. Telepon</p>
                <p class="fw-semibold mb-0">{{ $reservasi['no_tlp_pengguna'] ?? ($props['telepon'] ?? '-') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Email</p>
                <p class="fw-semibold mb-0">{{ $reservasi['email_pengguna'] ?? ($props['email'] ?? '-') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Jumlah Unit</p>
                <p class="fw-semibold mb-0">{{ $reservasi['total_peminjaman'] ?? ($props['jumlah'] ?? 1) }} Unit</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Tanggal Mulai</p>
                <p class="fw-semibold mb-0">
                    @php $tglMulai = $reservasi['tanggal_mulai_reservasi'] ?? ($reservasi['start'] ?? '-'); @endphp
                    {{ $tglMulai !== '-' ? date('d F Y', strtotime($tglMulai)) : '-' }}
                </p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Tanggal Selesai</p>
                <p class="fw-semibold mb-0">
                    @php $tglSelesai = $reservasi['tanggal_selesai_reservasi'] ?? ($reservasi['end'] ?? '-'); @endphp
                    {{ $tglSelesai !== '-' ? date('d F Y', strtotime($tglSelesai)) : '-' }}
                </p>
            </div>
            <div class="col-12">
                <p class="text-muted small mb-1">Keperluan</p>
                <p class="fw-semibold mb-0">{{ $reservasi['keperluan'] ?? ($props['keperluan'] ?? '-') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Total Biaya</p>
                <p class="fw-bold text-primary mb-0 fs-5">
                    Rp {{ number_format((float)($reservasi['total_harga'] ?? $props['harga'] ?? 0), 0, ',', '.') }}
                </p>
            </div>
            <div class="col-md-6">
                <p class="text-muted small mb-1">Status</p>
                <span class="badge {{ $badgeClass }} px-3 py-2">{{ strtoupper($status) }}</span>
            </div>
            @if(!empty($reservasi['notes']))
            <div class="col-12">
                <p class="text-muted small mb-1">Catatan</p>
                <p class="fw-semibold mb-0">{{ $reservasi['notes'] }}</p>
            </div>
            @endif
        </div>
    </div>

    @if(strtolower($status) === 'menunggu')
    <div class="card border-0 shadow-sm rounded-3 p-4">
        <h5 class="fw-bold mb-3">Update Status</h5>
        <form action="{{ route('admin.reservasi.update-status', $idReservasi) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Status Baru <span class="text-danger">*</span></label>
                <select name="status_reservasi" class="form-select" required>
                    <option value="">Pilih Status</option>
                    <option value="Disetujui">✅ Disetujui</option>
                    <option value="Ditolak">❌ Ditolak</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Catatan (opsional)</label>
                <textarea name="notes" class="form-control" rows="3"
                          placeholder="Alasan penolakan atau catatan untuk peminjam..."></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-2"></i>Simpan Status
                </button>
                <a href="{{ route('admin.reservasi.permintaan') }}" class="btn btn-outline-secondary px-4">
                    Kembali
                </a>
            </div>
        </form>
    </div>
    @else
    <a href="{{ route('admin.reservasi.permintaan') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
    </a>
    @endif
</div>
@endsection
