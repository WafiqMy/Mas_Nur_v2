@extends('layouts.app')

@section('title', 'Struktur Organisasi - Masjid Nurul Huda')

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = ($sessionUser['role'] ?? '') === 'admin';
    $BASE_IMG = config('app.api_base_url');

    $gambarOrg   = $struktur['gambar_struktur_organisasi_url'] ?? $struktur['gambar_struktur_organisasi'] ?? '';
    $gambarRemas = $struktur['gambar_struktur_remas_url'] ?? $struktur['gambar_struktur_remas'] ?? '';

    if ($gambarOrg && !str_starts_with($gambarOrg, 'http')) {
        $gambarOrg = $BASE_IMG . '/uploads/profil_masjid/' . $gambarOrg;
    }
    if ($gambarRemas && !str_starts_with($gambarRemas, 'http')) {
        $gambarRemas = $BASE_IMG . '/uploads/profil_masjid/' . $gambarRemas;
    }
@endphp

<div class="bg-primary text-white py-4 mb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold mb-1">Struktur Organisasi</h1>
                <p class="opacity-85 mb-0">Remaja Masjid Nurul Huda</p>
            </div>
            @if($isAdmin)
            <a href="{{ route('admin.profil-masjid.edit-struktur') }}" class="btn btn-light fw-semibold">
                <i class="bi bi-pencil me-2"></i>Edit Struktur
            </a>
            @endif
        </div>
    </div>
</div>

<div class="container pb-5" style="max-width: 900px;">

    @if($gambarOrg)
    <div class="mb-5" data-aos="fade-up">
        <h4 class="fw-bold mb-3">Struktur Pengurus</h4>
        <img src="{{ $gambarOrg }}" alt="Struktur Pengurus"
             class="img-fluid rounded-3 shadow w-100"
             onerror="this.style.display='none'">
    </div>
    @endif

    @if($gambarRemas)
    <div data-aos="fade-up">
        <h4 class="fw-bold mb-3">Struktur Remaja Masjid</h4>
        <img src="{{ $gambarRemas }}" alt="Struktur Remas"
             class="img-fluid rounded-3 shadow w-100"
             onerror="this.style.display='none'">
    </div>
    @endif

    @if(!$gambarOrg && !$gambarRemas)
    <div class="text-center py-5">
        <i class="bi bi-diagram-3 display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Struktur organisasi belum diisi.</p>
        @if($isAdmin)
        <a href="{{ route('admin.profil-masjid.edit-struktur') }}" class="btn btn-primary mt-2">
            Isi Struktur Sekarang
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
