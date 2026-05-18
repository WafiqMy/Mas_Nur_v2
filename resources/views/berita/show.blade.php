@extends('layouts.app')

@section('title', $berita->judul_berita . ' - Masjid Nurul Huda')

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';
@endphp

<div class="container py-5" style="max-width: 860px;">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
            <li class="breadcrumb-item active">
                {{ \Illuminate\Support\Str::limit($berita->judul_berita, 40) }}
            </li>
        </ol>
    </nav>

    <article>
        <h1 class="fw-bold mb-3" style="line-height: 1.4;">{{ $berita->judul_berita }}</h1>

        <div class="d-flex align-items-center gap-3 text-muted small mb-4">
            <span>
                <i class="bi bi-calendar3 me-1"></i>
                {{ $berita->tanggal_berita ? $berita->tanggal_berita->format('d F Y') : '-' }}
            </span>
            <span><i class="bi bi-person me-1"></i>{{ $berita->username ?? 'Admin' }}</span>
        </div>

        @if($berita->foto_berita)
        <img src="{{ $berita->foto_url }}" alt="{{ $berita->judul_berita }}"
             class="img-fluid rounded-3 mb-4 w-100"
             style="max-height: 450px; object-fit: cover;"
             onerror="this.style.display='none'">
        @endif

        <div style="line-height: 1.9; font-size: 1.05rem; color: #374151;">
            {!! nl2br(e($berita->isi_berita)) !!}
        </div>
    </article>

    <hr class="my-5">

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Berita
        </a>
        @if($isAdmin)
        <div class="d-flex gap-2">
            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST"
                  onsubmit="return confirm('Hapus berita ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>Hapus
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
