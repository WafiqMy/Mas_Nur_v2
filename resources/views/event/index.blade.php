@extends('layouts.app')

@section('title', 'Acara & Kegiatan - Masjid Nurul Huda')

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';
@endphp

{{-- HERO HEADER BIRU --}}
<section style="background:linear-gradient(135deg,#1e3a5f 0%,#2563eb 100%);padding:3.5rem 0 2.5rem;color:white;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.5);">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active text-white">Acara & Kegiatan</li>
                    </ol>
                </nav>
                <h1 class="fw-800 mb-1" style="font-size:2.5rem;font-weight:800;">Acara & Kegiatan</h1>
                <p class="mb-0" style="opacity:0.85;">Jadwal kegiatan Masjid Nurul Huda</p>
            </div>
            @if($isAdmin)
            <a href="{{ route('admin.acara.create') }}" class="btn btn-light fw-semibold">
                <i class="bi bi-plus-circle me-2"></i>Tambah Acara
            </a>
            @endif
        </div>
    </div>
</section>

<div class="container mb-5">
    @if($events->count() > 0)
    <div class="row g-4">
        @foreach($events as $event)
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden"
                 style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="position-relative">
                    <img src="{{ $event->gambar_url }}" class="card-img-top" alt="{{ $event->nama_event }}"
                         style="height: 220px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                    @if($event->tanggal_event)
                    <span class="position-absolute bottom-0 start-0 m-3 badge bg-primary">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $event->tanggal_event->format('d M Y') }}
                    </span>
                    @endif
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">
                        {{ \Illuminate\Support\Str::limit($event->nama_event, 55) }}
                    </h5>
                    @if($event->lokasi_event)
                    <p class="text-muted small mb-2">
                        <i class="bi bi-geo-alt me-1"></i>{{ $event->lokasi_event }}
                    </p>
                    @endif
                    <p class="text-muted small">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event->deskripsi_event ?? ''), 90) }}
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('event.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                        Detail Acara
                    </a>
                    @if($isAdmin)
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.acara.edit', $event->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.acara.destroy', $event->id) }}" method="POST"
                              onsubmit="return confirm('Hapus acara ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-calendar-x display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada acara yang dijadwalkan.</p>
    </div>
    @endif
</div>
@endsection
