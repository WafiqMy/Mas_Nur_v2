@extends('layouts.app')

@section('title', ($event['nama_event'] ?? 'Acara') . ' - Masjid Nurul Huda')

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = ($sessionUser['role'] ?? '') === 'admin';
    $BASE_IMG = config('app.api_base_url');
    $idEvent = $event['id_event'] ?? 0;

    $gambar = $event['gambar_event'] ?? '';
    if ($gambar && !str_starts_with($gambar, 'http')) {
        $gambar = $BASE_IMG . '/uploads/kegiatan/' . $gambar;
    }

    // Parse dokumentasi (bisa JSON array atau comma-separated string)
    $dokList = [];
    $rawDok = $event['dokumentasi'] ?? '';
    if (is_array($rawDok)) {
        $dokList = $rawDok;
    } elseif (is_string($rawDok) && !empty($rawDok)) {
        $decoded = json_decode($rawDok, true);
        if (is_array($decoded)) {
            $dokList = $decoded;
        } else {
            $dokList = array_filter(array_map('trim', explode(',', $rawDok)));
        }
    }
    // Buat URL lengkap untuk dokumentasi
    $dokUrls = array_map(function($f) use ($BASE_IMG) {
        if (str_starts_with($f, 'http')) return $f;
        return $BASE_IMG . '/uploads/kegiatan/' . $f;
    }, $dokList);

    // Parse video_urls
    $videoUrls = $event['video_urls'] ?? [];
    if (is_string($videoUrls)) {
        $videoUrls = json_decode($videoUrls, true) ?? [];
    }
@endphp

<div class="container py-5" style="max-width: 900px;">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('event.index') }}">Acara</a></li>
            <li class="breadcrumb-item active">
                {{ \Illuminate\Support\Str::limit($event['nama_event'] ?? '', 40) }}
            </li>
        </ol>
    </nav>

    <h1 class="fw-bold mb-3">{{ $event['nama_event'] ?? '' }}</h1>

    <div class="d-flex flex-wrap gap-3 text-muted small mb-4">
        @if(!empty($event['tanggal_event']))
        <span><i class="bi bi-calendar3 me-1"></i>
            {{ date('d F Y, H:i', strtotime($event['tanggal_event'])) }} WIB
        </span>
        @endif
        @if(!empty($event['lokasi_event']))
        <span><i class="bi bi-geo-alt me-1"></i>{{ $event['lokasi_event'] }}</span>
        @endif
    </div>

    @if($gambar)
    <img src="{{ $gambar }}" alt="{{ $event['nama_event'] ?? '' }}"
         class="img-fluid rounded-3 mb-4 w-100"
         style="max-height: 450px; object-fit: cover;"
         onerror="this.style.display='none'">
    @endif

    @if(!empty($event['deskripsi_event']))
    <div class="mb-4" style="line-height: 1.9; font-size: 1.05rem; color: #374151;">
        {!! nl2br(e($event['deskripsi_event'])) !!}
    </div>
    @endif

    {{-- Dokumentasi --}}
    @if(!empty($dokUrls))
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Dokumentasi</h5>
        <div class="row g-3">
            @foreach($dokUrls as $dok)
            <div class="col-md-4 col-6">
                <a href="{{ $dok }}" target="_blank">
                    <img src="{{ $dok }}" alt="Dokumentasi"
                         class="img-fluid rounded-2 w-100"
                         style="height: 180px; object-fit: cover;"
                         onerror="this.style.display='none'">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Video --}}
    @if(!empty($videoUrls))
    <div class="mb-4">
        <h5 class="fw-bold mb-3">Video</h5>
        @foreach($videoUrls as $url)
        @if($url)
        <div class="mb-2">
            <a href="{{ $url }}" target="_blank" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-play-circle me-2"></i>{{ $url }}
            </a>
        </div>
        @endif
        @endforeach
    </div>
    @endif

    <hr class="my-4">

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('event.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Acara
        </a>
        @if($isAdmin)
        <div class="d-flex gap-2">
            <a href="{{ route('admin.acara.edit', $idEvent) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <form action="{{ route('admin.acara.destroy', $idEvent) }}" method="POST"
                  onsubmit="return confirm('Hapus acara ini?')">
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
