@extends('layouts.app')

@section('title', 'Notifikasi - Masjid Nurul Huda')

@push('styles')
<style>
    .notif-card { background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; border-left: 5px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: 0.3s; text-decoration: none; color: inherit; display: block; }
    .notif-card:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); color: inherit; }
    .status-Menunggu { border-left-color: #ffc107; }
    .status-Disetujui { border-left-color: #198754; }
    .status-Ditolak { border-left-color: #dc3545; }
    .notif-title { font-weight: 700; font-size: 1.05rem; color: #333; margin-bottom: 5px; }
    .notif-time { font-size: 0.8rem; color: #888; margin-bottom: 8px; display: block; }
    .notif-msg { font-size: 0.9rem; color: #555; line-height: 1.6; }
</style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 800px;">

    <h2 class="fw-bold mb-1">Notifikasi</h2>
    <p class="text-muted mb-4">Pemberitahuan terbaru untuk Anda</p>

    @if(!empty($notifikasi))
        @foreach($notifikasi as $n)
        @php
            $statusBadge = $n['status_badge'] ?? 'Menunggu';
            $link = $n['link'] ?? '#';
            // Pastikan link adalah URL absolut atau route yang valid
            if ($link && !str_starts_with($link, 'http') && !str_starts_with($link, '/')) {
                $link = '/' . $link;
            }
        @endphp
        <a href="{{ $link }}" class="notif-card status-{{ $statusBadge }}">
            <div class="d-flex justify-content-between align-items-start">
                <h5 class="notif-title">{{ $n['judul'] ?? '' }}</h5>
                @if(!empty($n['is_new']))
                <span class="badge bg-danger rounded-pill" style="font-size: 0.65rem;">BARU</span>
                @endif
            </div>
            <span class="notif-time">
                <i class="bi bi-clock me-1"></i>{{ $n['waktu'] ?? '' }}
            </span>
            <div class="notif-msg">{!! $n['pesan'] ?? '' !!}</div>
        </a>
        @endforeach
    @else
    <div class="text-center py-5">
        <i class="bi bi-bell-slash display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada notifikasi baru.</p>
    </div>
    @endif
</div>
@endsection
