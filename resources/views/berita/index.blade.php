@extends('layouts.app')

@section('title', 'Berita - Masjid Nurul Huda')

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
                        <li class="breadcrumb-item active text-white">Berita</li>
                    </ol>
                </nav>
                <h1 class="fw-800 mb-1" style="font-size:2.5rem;font-weight:800;">Berita Masjid</h1>
                <p class="mb-0" style="opacity:0.85;">Informasi terkini dari Masjid Nurul Huda</p>
            </div>
            @if($isAdmin)
            <a href="{{ route('admin.berita.create') }}" class="btn btn-light fw-semibold">
                <i class="bi bi-plus-circle me-2"></i>Tambah Berita
            </a>
            @endif
        </div>
    </div>
</section>

<div class="container mb-5">
    @if($berita->count() > 0)
    <div class="row g-4">
        @foreach($berita as $b)
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden"
                 style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <img src="{{ $b->foto_url }}" class="card-img-top" alt="{{ $b->judul_berita }}"
                     style="height: 200px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                <div class="card-body p-4">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ $b->tanggal_berita ? $b->tanggal_berita->format('d M Y') : '-' }}
                        <span class="ms-2">
                            <i class="bi bi-person me-1"></i>{{ $b->username ?? 'Admin' }}
                        </span>
                    </p>
                    <h5 class="fw-bold mb-2">
                        {{ \Illuminate\Support\Str::limit($b->judul_berita, 65) }}
                    </h5>
                    <p class="text-muted small">
                        {{ \Illuminate\Support\Str::limit(strip_tags($b->isi_berita), 100) }}
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('berita.show', $b->id) }}" class="btn btn-sm btn-primary">
                        Baca Selengkapnya
                    </a>
                    @if($isAdmin)
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.berita.edit', $b->id) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.berita.destroy', $b->id) }}" method="POST"
                              onsubmit="return confirm('Hapus berita ini?')">
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
        <i class="bi bi-newspaper display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada berita yang dipublikasikan.</p>
    </div>
    @endif
</div>
@endsection
