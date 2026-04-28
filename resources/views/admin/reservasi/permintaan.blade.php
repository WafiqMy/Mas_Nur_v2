@extends('layouts.app')

@section('title', 'Permintaan Reservasi - Admin')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <h2 class="fw-bold mb-1">Daftar Permintaan Masuk</h2>
        <p class="text-muted mb-0">Kelola persetujuan peminjaman fasilitas masjid</p>
    </div>
</div>

<div class="container mb-5">
    @if(!empty($permintaan))
    <div class="d-flex flex-column gap-3">
        @foreach($permintaan as $r)
        @php
            // Data bisa dari extendedProps (format kalender) atau langsung
            $props = $r['extendedProps'] ?? $r;
            $status = $props['status'] ?? $r['status_reservasi'] ?? 'Menunggu';
            $statusLower = strtolower($status);
            $badgeClass = 'bg-warning text-dark';
            if (str_contains($statusLower, 'setuju')) $badgeClass = 'bg-success';
            elseif (str_contains($statusLower, 'tolak') || str_contains($statusLower, 'batal')) $badgeClass = 'bg-danger';

            $namaBarang   = $r['nama_barang'] ?? ($props['barang'] ?? '-');
            $namaPeminjam = $r['nama_pengguna'] ?? ($props['peminjam'] ?? '-');
            $telepon      = $r['no_tlp_pengguna'] ?? ($props['telepon'] ?? '-');
            $tglMulai     = $r['tanggal_mulai_reservasi'] ?? ($r['start'] ?? '-');
            $idReservasi  = $r['id_reservasi'] ?? ($r['id'] ?? 0);
        @endphp
        <div class="card border-0 shadow-sm rounded-3 p-4"
             style="border-left: 5px solid #1b6b6a !important;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0">
                            {{ $namaBarang }}
                            <small class="text-muted fw-normal">({{ $namaPeminjam }})</small>
                        </h5>
                        <span class="badge {{ $badgeClass }} ms-2">{{ strtoupper($status) }}</span>
                    </div>
                    <div class="row text-muted small">
                        <div class="col-md-4 mb-1">
                            <i class="bi bi-calendar-check me-1 text-primary"></i>
                            {{ $tglMulai !== '-' ? date('d F Y', strtotime($tglMulai)) : '-' }}
                        </div>
                        <div class="col-md-4 mb-1">
                            <i class="bi bi-person-circle me-1 text-primary"></i>{{ $namaPeminjam }}
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-telephone me-1 text-primary"></i>{{ $telepon }}
                        </div>
                    </div>
                </div>
                <div class="ms-md-4">
                    <a href="{{ route('admin.reservasi.detail-permintaan', $idReservasi) }}"
                       class="btn btn-success fw-bold">
                        Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-inbox display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada permintaan pemesanan yang masuk.</p>
    </div>
    @endif
</div>
@endsection
