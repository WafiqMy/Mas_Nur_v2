@extends('layouts.app')

@section('title', 'Profil Masjid - Masjid Nurul Huda')

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = ($sessionUser['role'] ?? '') === 'admin';
    $BASE_IMG = config('app.api_base_url');

    $namaProf    = $profil['nama_masjid'] ?? 'Masjid Nurul Huda';
    $alamat      = $profil['alamat'] ?? 'Nganjuk, Jawa Timur';
    $sejarah     = $profil['sejarah_masjid'] ?? $profil['deskripsi_sejarah'] ?? '';
    $judulSejarah = $profil['judul_sejarah'] ?? 'Sejarah Masjid';
    $telepon     = $profil['telepon'] ?? null;
    $email       = $profil['email'] ?? null;
    $website     = $profil['website'] ?? null;

    // Gambar sejarah
    $gambarSejarah = $profil['gambar_sejarah'] ?? $profil['gambar_sejarah_masjid'] ?? '';
    if ($gambarSejarah && !str_starts_with($gambarSejarah, 'http')) {
        $gambarSejarah = $BASE_IMG . '/uploads/profil_masjid/' . $gambarSejarah;
    }
@endphp

{{-- Hero --}}
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="fw-bold display-5 mb-2">{{ $namaProf }}</h1>
                <p class="opacity-85 fs-5 mb-0">{{ $alamat }}</p>
            </div>
            @if($isAdmin)
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('admin.profil-masjid.edit') }}" class="btn btn-light fw-semibold">
                    <i class="bi bi-pencil me-2"></i>Edit Profil
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="container py-5">

    {{-- Sejarah --}}
    @if($sejarah)
    <div class="row align-items-center g-5 mb-5">
        <div class="col-lg-6" data-aos="fade-right">
            <h2 class="fw-bold mb-3">{{ $judulSejarah }}</h2>
            <div style="line-height: 1.9; color: #374151;">
                {!! nl2br(e($sejarah)) !!}
            </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            @if($gambarSejarah)
            <img src="{{ $gambarSejarah }}" alt="Sejarah Masjid"
                 class="img-fluid rounded-3 shadow"
                 onerror="this.style.display='none'">
            @endif
        </div>
    </div>
    @endif

    {{-- Kontak --}}
    @if($telepon || $email || $website)
    <div class="bg-light rounded-3 p-4 mb-5" data-aos="fade-up">
        <h4 class="fw-bold mb-3">Informasi Kontak</h4>
        <div class="row g-3">
            @if($telepon)
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-telephone text-primary fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Telepon</p>
                        <p class="fw-semibold mb-0">{{ $telepon }}</p>
                    </div>
                </div>
            </div>
            @endif
            @if($email)
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-envelope text-primary fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Email</p>
                        <p class="fw-semibold mb-0">{{ $email }}</p>
                    </div>
                </div>
            </div>
            @endif
            @if($website)
            <div class="col-md-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-globe text-primary fs-5"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Website</p>
                        <a href="{{ $website }}" target="_blank" class="fw-semibold">{{ $website }}</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if(!$profil)
    <div class="text-center py-5">
        <i class="bi bi-building display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Profil masjid belum diisi.</p>
        @if($isAdmin)
        <a href="{{ route('admin.profil-masjid.edit') }}" class="btn btn-primary mt-2">
            Isi Profil Sekarang
        </a>
        @endif
    </div>
    @endif
</div>
@endsection
