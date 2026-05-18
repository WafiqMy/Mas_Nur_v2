@extends('layouts.app')

@section('title', 'Struktur Organisasi - Masjid Nurul Huda')

@push('styles')
<style>
    .pm-hero {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        padding: 5rem 0 4rem;
        position: relative;
        overflow: hidden;
    }
    .pm-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .pm-hero-content { position: relative; z-index: 1; }
    .pm-hero h1 { font-size: 3rem; font-weight: 800; letter-spacing: -1px; }

    .pm-section-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1f2937;
        position: relative;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .pm-section-title::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 48px; height: 4px;
        background: #2563eb;
        border-radius: 2px;
    }

    .struktur-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .struktur-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(37,99,235,0.12);
    }
    .struktur-card-header {
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .struktur-card-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .struktur-card-title { font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 0; }
    .struktur-card-subtitle { font-size: 0.85rem; color: #6b7280; margin: 0; }
    .struktur-card-img {
        width: 100%;
        display: block;
        border-top: 1px solid #f3f4f6;
    }

    @media (max-width: 768px) {
        .pm-hero h1 { font-size: 2rem; }
    }
</style>
@endpush

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';

    $gambarOrg   = $profil?->gambar_sampul_url        ?? '';
    $gambarRemas = $profil?->gambar_struktur_url       ?? '';
    $deskRemas   = $profil?->deskripsi_remas           ?? '';
@endphp

{{-- HERO --}}
<section class="pm-hero">
    <div class="container pm-hero-content">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.75);">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('profil-masjid.show') }}" class="text-decoration-none" style="color: rgba(255,255,255,0.75);">Profil Masjid</a>
                </li>
                <li class="breadcrumb-item active text-white">Struktur Organisasi</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h1 class="text-white mb-2" data-aos="fade-up">Struktur Organisasi</h1>
                <p class="text-white opacity-75 mb-0 fs-5" data-aos="fade-up" data-aos-delay="100">
                    <i class="bi bi-building me-2"></i>Masjid Nurul Huda Nganjuk
                </p>
            </div>
            @if($isAdmin)
            <div data-aos="fade-up" data-aos-delay="150">
                <a href="{{ route('admin.profil-masjid.edit-struktur') }}" class="btn btn-light fw-semibold">
                    <i class="bi bi-pencil me-2"></i>Edit Struktur
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

<div class="container py-5" style="max-width: 960px;">

    @if($gambarOrg || $gambarRemas)

        {{-- STRUKTUR PENGURUS --}}
        @if($gambarOrg)
        <div class="mb-5" data-aos="fade-up">
            <div class="struktur-card">
                <div class="struktur-card-header" style="background: linear-gradient(135deg, #dbeafe, #eff6ff);">
                    <div class="struktur-card-icon" style="background: #2563eb; color: white;">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div>
                        <p class="struktur-card-title">Struktur Pengurus</p>
                        <p class="struktur-card-subtitle">Susunan pengurus Masjid Nurul Huda</p>
                    </div>
                </div>
                <img src="{{ $gambarOrg }}" alt="Struktur Pengurus Masjid Nurul Huda"
                     class="struktur-card-img"
                     onerror="this.style.display='none'">
            </div>
        </div>
        @endif

        {{-- STRUKTUR REMAS --}}
        @if($gambarRemas)
        <div class="mb-5" data-aos="fade-up">
            <div class="struktur-card">
                <div class="struktur-card-header" style="background: linear-gradient(135deg, #d1fae5, #ecfdf5);">
                    <div class="struktur-card-icon" style="background: #059669; color: white;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <p class="struktur-card-title">Struktur Remaja Masjid</p>
                        <p class="struktur-card-subtitle">Susunan pengurus Remaja Masjid (REMAS)</p>
                    </div>
                </div>
                @if($deskRemas)
                <div class="px-4 py-3 border-top" style="background: #f9fafb;">
                    <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.7;">{{ $deskRemas }}</p>
                </div>
                @endif
                <img src="{{ $gambarRemas }}" alt="Struktur Remaja Masjid Nurul Huda"
                     class="struktur-card-img"
                     onerror="this.style.display='none'">
            </div>
        </div>
        @endif

    @else
        {{-- EMPTY STATE --}}
        <div class="text-center py-5" data-aos="fade-up">
            <div style="width: 100px; height: 100px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i class="bi bi-diagram-3 display-4 text-muted"></i>
            </div>
            <h4 class="text-muted fw-semibold mb-2">Struktur Belum Tersedia</h4>
            <p class="text-muted mb-4">Struktur organisasi belum diisi oleh admin.</p>
            @if($isAdmin)
            <a href="{{ route('admin.profil-masjid.edit-struktur') }}" class="btn btn-primary px-4">
                <i class="bi bi-pencil me-2"></i>Isi Struktur Sekarang
            </a>
            @endif
        </div>
    @endif

    {{-- BACK BUTTON --}}
    <div class="text-center mt-4" data-aos="fade-up">
        <a href="{{ route('profil-masjid.show') }}" class="btn btn-outline-primary px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Profil Masjid
        </a>
    </div>

</div>
@endsection
