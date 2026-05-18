@extends('layouts.app')

@section('title', 'Profil Masjid - Masjid Nurul Huda')

@push('styles')
<style>
    /* ===== HERO ===== */
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
    .pm-hero .breadcrumb-item, .pm-hero .breadcrumb-item a { color: rgba(255,255,255,0.75); font-size: 0.9rem; }
    .pm-hero .breadcrumb-item.active { color: white; }
    .pm-hero .breadcrumb-divider { color: rgba(255,255,255,0.5); }

    /* ===== SECTION TITLE ===== */
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

    /* ===== SEJARAH ===== */
    .pm-sejarah-text {
        font-size: 1rem;
        line-height: 1.9;
        color: #374151;
    }
    .pm-sejarah-img {
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(37,99,235,0.15);
        width: 100%;
        object-fit: cover;
        max-height: 420px;
    }

    /* ===== STATS ===== */
    .pm-stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        border: 1px solid #e5e7eb;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .pm-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(37,99,235,0.12);
    }
    .pm-stat-icon {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: #2563eb;
    }
    .pm-stat-value { font-size: 1.75rem; font-weight: 800; color: #1f2937; }
    .pm-stat-label { font-size: 0.875rem; color: #6b7280; font-weight: 500; }

    /* ===== KONTAK ===== */
    .pm-kontak-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.07);
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: transform 0.3s;
    }
    .pm-kontak-card:hover { transform: translateY(-3px); }
    .pm-kontak-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .pm-kontak-label { font-size: 0.8rem; color: #9ca3af; font-weight: 500; margin-bottom: 0.2rem; }
    .pm-kontak-value { font-weight: 700; color: #1f2937; font-size: 0.95rem; }

    /* ===== LOKASI ===== */
    .pm-map-wrapper {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        border: 3px solid #e5e7eb;
    }

    /* ===== ADMIN BANNER ===== */
    .pm-admin-bar {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        border: 1px solid #f59e0b;
        border-radius: 12px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .pm-hero h1 { font-size: 2rem; }
        .pm-nav .nav-link { padding: 0.75rem 1rem; font-size: 0.9rem; }
    }
</style>
@endpush

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';

    $namaProf     = $profil?->nama_masjid      ?? 'Masjid Nurul Huda';
    $alamat       = $profil?->alamat            ?? 'Nganjuk, Jawa Timur';
    $deskripsi    = $profil?->deskripsi         ?? '';
    $sejarah      = $profil?->sejarah_masjid    ?? '';
    $judulSejarah = 'Sejarah Masjid';
    $telepon      = $profil?->telepon           ?? null;
    $email        = $profil?->email             ?? null;
    $website      = $profil?->website           ?? null;

    $gambarSejarah = $profil?->gambar_sejarah_url ?? '';
    $gambarSampul  = $profil?->gambar_sampul_url  ?? '';
@endphp

{{-- HERO --}}
<section class="pm-hero">
    <div class="container pm-hero-content">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active">Profil Masjid</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <h1 class="text-white mb-2" data-aos="fade-up">{{ $namaProf }}</h1>
                <p class="text-white opacity-75 mb-0 fs-5" data-aos="fade-up" data-aos-delay="100">
                    <i class="bi bi-geo-alt me-2"></i>{{ $alamat }}
                </p>
            </div>
            @if($isAdmin)
            <div data-aos="fade-up" data-aos-delay="150">
                <a href="{{ route('admin.profil-masjid.edit') }}" class="btn btn-light fw-semibold">
                    <i class="bi bi-pencil me-2"></i>Edit Profil
                </a>
                <a href="{{ route('admin.profil-masjid.edit-struktur') }}" class="btn btn-outline-light fw-semibold ms-2">
                    <i class="bi bi-diagram-3 me-2"></i>Edit Struktur
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- NAV TABS - DIHAPUS --}}

<div class="container py-5">

    {{-- STATS --}}
    <div class="row g-4 mb-5" data-aos="fade-up">
        <div class="col-6 col-md-3">
            <div class="pm-stat-card">
                <div class="pm-stat-icon"><i class="bi bi-building"></i></div>
                <div class="pm-stat-value">1</div>
                <div class="pm-stat-label">Masjid Besar</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="pm-stat-card">
                <div class="pm-stat-icon"><i class="bi bi-people"></i></div>
                <div class="pm-stat-value">5000+</div>
                <div class="pm-stat-label">Kapasitas Jamaah</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="pm-stat-card">
                <div class="pm-stat-icon"><i class="bi bi-calendar-event"></i></div>
                <div class="pm-stat-value">50+</div>
                <div class="pm-stat-label">Kegiatan/Tahun</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="pm-stat-card">
                <div class="pm-stat-icon"><i class="bi bi-heart"></i></div>
                <div class="pm-stat-value">24/7</div>
                <div class="pm-stat-label">Layanan Umat</div>
            </div>
        </div>
    </div>

    {{-- DESKRIPSI / TENTANG MASJID --}}
    @if($deskripsi || $gambarSampul)
    <section class="mb-5" data-aos="fade-up">
        <div class="row g-4 align-items-center">
            @if($gambarSampul)
            <div class="col-md-5">
                <img src="{{ $gambarSampul }}" alt="{{ $namaProf }}"
                     class="pm-sejarah-img w-100"
                     onerror="this.style.display='none'">
            </div>
            @endif
            <div class="{{ $gambarSampul ? 'col-md-7' : 'col-12' }}">
                <h2 class="pm-section-title">Tentang {{ $namaProf }}</h2>
                @if($deskripsi)
                <div class="pm-sejarah-text">{!! nl2br(e($deskripsi)) !!}</div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- SEJARAH --}}
    @if($sejarah)
    <section id="sejarah" class="mb-5 pt-3">
        <div class="row justify-content-center">
            {{-- Gambar di atas --}}
            <div class="col-lg-10 mb-4" data-aos="fade-up">
                @if($gambarSejarah)
                <img src="{{ $gambarSejarah }}" alt="Sejarah {{ $namaProf }}"
                     class="pm-sejarah-img w-100"
                     style="max-height: 480px;"
                     onerror="this.style.display='none'">
                @elseif($gambarSampul)
                <img src="{{ $gambarSampul }}" alt="{{ $namaProf }}"
                     class="pm-sejarah-img w-100"
                     style="max-height: 480px;"
                     onerror="this.style.display='none'">
                @endif
            </div>
            {{-- Teks di bawah --}}
            <div class="col-lg-10" data-aos="fade-up">
                <h2 class="pm-section-title">{{ $judulSejarah }}</h2>
                <div class="pm-sejarah-text">
                    {!! nl2br(e($sejarah)) !!}
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- KONTAK --}}
    @if($telepon || $email || $website || $alamat)
    <section id="kontak" class="mb-5 pt-3">
        <h2 class="pm-section-title" data-aos="fade-up">Informasi Kontak</h2>
        <div class="row g-4">
            @if($alamat)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                <div class="pm-kontak-card">
                    <div class="pm-kontak-icon" style="background: #dbeafe; color: #2563eb;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <div class="pm-kontak-label">Alamat</div>
                        <div class="pm-kontak-value">{{ $alamat }}</div>
                    </div>
                </div>
            </div>
            @endif
            @if($telepon)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="pm-kontak-card">
                    <div class="pm-kontak-icon" style="background: #d1fae5; color: #059669;">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <div class="pm-kontak-label">Telepon</div>
                        <a href="tel:{{ $telepon }}" class="pm-kontak-value text-decoration-none">{{ $telepon }}</a>
                    </div>
                </div>
            </div>
            @endif
            @if($email)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="pm-kontak-card">
                    <div class="pm-kontak-icon" style="background: #fef3c7; color: #d97706;">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <div class="pm-kontak-label">Email</div>
                        <a href="mailto:{{ $email }}" class="pm-kontak-value text-decoration-none">{{ $email }}</a>
                    </div>
                </div>
            </div>
            @endif
            @if($website)
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="pm-kontak-card">
                    <div class="pm-kontak-icon" style="background: #ede9fe; color: #7c3aed;">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <div>
                        <div class="pm-kontak-label">Website</div>
                        <a href="{{ $website }}" target="_blank" class="pm-kontak-value text-decoration-none">
                            {{ str_replace(['https://', 'http://'], '', $website) }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- LOKASI / MAPS --}}
    <section class="mb-5 pt-3" data-aos="fade-up">
        <h2 class="pm-section-title">Lokasi Masjid</h2>
        <div class="pm-map-wrapper">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.0!2d111.9!3d-7.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sMasjid+Nurul+Huda+Nganjuk!5e0!3m2!1sid!2sid!4v1"
                width="100%" height="380" style="border:0; display:block;"
                allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </section>

    {{-- CTA STRUKTUR --}}
    <section data-aos="fade-up">
        <div class="rounded-3 p-5 text-center"
             style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
            <i class="bi bi-diagram-3 text-white display-4 mb-3 d-block"></i>
            <h3 class="text-white fw-bold mb-2">Struktur Organisasi</h3>
            <p class="text-white opacity-75 mb-4">Lihat susunan pengurus dan remaja masjid Nurul Huda</p>
            <a href="{{ route('profil-masjid.struktur') }}" class="btn btn-light btn-lg fw-semibold px-5">
                <i class="bi bi-arrow-right me-2"></i>Lihat Struktur
            </a>
        </div>
    </section>

</div>

@if(!$profil)
<div class="container py-5 text-center">
    <i class="bi bi-building display-1 text-muted opacity-25"></i>
    <p class="text-muted mt-3">Profil masjid belum diisi.</p>
    @if($isAdmin)
    <a href="{{ route('admin.profil-masjid.edit') }}" class="btn btn-primary mt-2">
        <i class="bi bi-pencil me-2"></i>Isi Profil Sekarang
    </a>
    @endif
</div>
@endif

@endsection

@push('scripts')
<script>
    // Tidak ada script tambahan
</script>
@endpush
