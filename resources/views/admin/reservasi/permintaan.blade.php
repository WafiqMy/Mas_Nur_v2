@extends('layouts.app')
@section('title', 'Permintaan Reservasi - Admin')

@push('styles')
<style>
.res-header {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    color: white; padding: 2rem; border-radius: 14px; margin-bottom: 2rem;
    box-shadow: 0 8px 24px rgba(37,99,235,0.2);
}
.res-header h1 { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.2rem; }

.res-tabs .nav-link {
    border-radius: 10px 10px 0 0; font-weight: 600; color: #6b7280;
    border: none; padding: 0.7rem 1.5rem;
}
.res-tabs .nav-link.active { background: white; color: #2563eb; border-bottom: 3px solid #2563eb; }

.res-card {
    background: white; border-radius: 12px; padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07); margin-bottom: 0.75rem;
    border-left: 5px solid #ffc107;
    transition: box-shadow 0.2s;
}
.res-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.1); }
.res-card.disetujui { border-left-color: #198754; }
.res-card.ditolak   { border-left-color: #dc3545; }
.res-card.batal     { border-left-color: #6c757d; }
.res-card.menunggu  { border-left-color: #ffc107; }

.badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 mb-3">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="res-header">
        <h1><i class="bi bi-clipboard-check me-2"></i>Permintaan Reservasi</h1>
        <p style="opacity:0.9;margin:0;">Kelola persetujuan peminjaman fasilitas masjid</p>
    </div>

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        @php
            $menunggu   = $permintaan->where('status_reservasi', 'Menunggu')->count();
            $disetujui  = $permintaan->where('status_reservasi', 'Disetujui')->count();
            $ditolak    = $permintaan->whereIn('status_reservasi', ['Ditolak','Batal'])->count();
        @endphp
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-3 shadow-sm text-center p-3">
                <div style="font-size:1.8rem;font-weight:800;color:#ffc107;">{{ $menunggu }}</div>
                <div class="text-muted small">Menunggu</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-3 shadow-sm text-center p-3">
                <div style="font-size:1.8rem;font-weight:800;color:#198754;">{{ $disetujui }}</div>
                <div class="text-muted small">Disetujui</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-3 shadow-sm text-center p-3">
                <div style="font-size:1.8rem;font-weight:800;color:#dc3545;">{{ $ditolak }}</div>
                <div class="text-muted small">Ditolak / Batal</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-3 shadow-sm text-center p-3">
                <div style="font-size:1.8rem;font-weight:800;color:#2563eb;">{{ $permintaan->count() }}</div>
                <div class="text-muted small">Total</div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav res-tabs border-bottom mb-0" id="resTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-masuk">
                <i class="bi bi-inbox me-1"></i>Permintaan Masuk
                @if($menunggu > 0)
                    <span class="badge bg-warning text-dark ms-1">{{ $menunggu }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-riwayat">
                <i class="bi bi-clock-history me-1"></i>Riwayat
            </a>
        </li>
    </ul>

    <div class="tab-content bg-white rounded-bottom p-3" style="box-shadow:0 4px 15px rgba(0,0,0,0.07);">

        {{-- TAB PERMINTAAN MASUK --}}
        <div class="tab-pane fade show active" id="tab-masuk">
            <div class="pt-2">
                @php $masuk = $permintaan->where('status_reservasi', 'Menunggu'); @endphp
                @if($masuk->count() > 0)
                    @foreach($masuk as $r)
                    @include('admin.reservasi._card-permintaan', ['r' => $r])
                    @endforeach
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox display-4 d-block mb-2 opacity-50"></i>
                    <p>Tidak ada permintaan yang menunggu.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- TAB RIWAYAT --}}
        <div class="tab-pane fade" id="tab-riwayat">
            <div class="pt-2">
                @php $selesai = $permintaan->whereNotIn('status_reservasi', ['Menunggu']); @endphp
                @if($selesai->count() > 0)
                    @foreach($selesai as $r)
                    @include('admin.reservasi._card-permintaan', ['r' => $r])
                    @endforeach
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-clock-history display-4 d-block mb-2 opacity-50"></i>
                    <p>Belum ada riwayat reservasi.</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
