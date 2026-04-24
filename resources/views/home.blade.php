@extends('layouts.app')

@section('title', 'Beranda - Masjid Nurul Huda')

@push('styles')
<style>
    .hero-section {
        min-height: 90vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        display: flex;
        align-items: center;
    }
    .hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(30,64,175,0.85) 0%, rgba(37,99,235,0.7) 100%);
    }
    .hero-content { position: relative; z-index: 2; }
    .section-title { font-size: 2rem; font-weight: 700; color: #1e293b; }
    .section-title span { color: #2563eb; }
    .card-news { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
    .card-news:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
    .card-news img { height: 200px; object-fit: cover; }
    .card-event { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s; }
    .card-event:hover { transform: translateY(-5px); }
    .card-event img { height: 220px; object-fit: cover; }
    .badge-tanggal { background: #2563eb; color: #fff; border-radius: 8px; padding: 4px 12px; font-size: 0.8rem; font-weight: 600; }
</style>
@endpush

@section('content')

@php
    $BASE_IMG = config('app.api_base_url');
    $namaProf = $profil['nama_masjid'] ?? 'Masjid Nurul Huda';
    $deskProf = $profil['deskripsi'] ?? 'Sistem digital untuk memakmurkan masjid dan mempererat ukhuwah islamiyah.';
    $heroImg  = $profil['gambar_sampul'] ?? asset('img/ms3.png');
@endphp

{{-- HERO --}}
<section class="hero-section" style="background-image: url('{{ $heroImg }}');">
    <div class="hero-overlay"></div>
    <div class="container hero-content text-white">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <p class="mb-2 fw-semibold opacity-75" style="letter-spacing: 2px; text-transform: uppercase; font-size: 0.9rem;">
                    Selamat Datang di
                </p>
                <h1 class="display-4 fw-bold mb-3">{{ $namaProf }}</h1>
                <p class="fs-5 mb-4 opacity-85" style="max-width: 550px; line-height: 1.7;">
                    {{ $deskProf }}
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('profil-masjid.show') }}" class="btn btn-light btn-lg fw-semibold px-4">
                        <i class="bi bi-building me-2"></i>Profil Masjid
                    </a>
                    <a href="{{ route('reservasi.index') }}" class="btn btn-outline-light btn-lg fw-semibold px-4">
                        <i class="bi bi-calendar-check me-2"></i>Sewa Fasilitas
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
@if(!empty($berita))
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-1">Berita <span>Terbaru</span></h2>
                <p class="text-muted mb-0">Informasi terkini dari Masjid Nurul Huda</p>
            </div>
            <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="row g-4">
            @foreach(array_slice($berita, 0, 3) as $b)
            @php
                $fotoBerita = $b['foto_berita'] ?? '';
                // Jika sudah URL lengkap, pakai langsung; jika tidak, tambah base URL
                if ($fotoBerita && !str_starts_with($fotoBerita, 'http')) {
                    $fotoBerita = $BASE_IMG . '/uploads/berita/' . $fotoBerita;
                }
                $fotoBerita = $fotoBerita ?: 'https://via.placeholder.com/400x200?text=No+Image';
            @endphp
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card card-news h-100">
                    <img src="{{ $fotoBerita }}" alt="{{ $b['judul_berita'] ?? '' }}"
                         onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                    <div class="card-body p-4">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ isset($b['tanggal_berita']) ? date('d M Y', strtotime($b['tanggal_berita'])) : '-' }}
                        </p>
                        <h5 class="fw-bold mb-2" style="line-height:1.4;">
                            {{ \Illuminate\Support\Str::limit($b['judul_berita'] ?? '', 60) }}
                        </h5>
                        <p class="text-muted small">
                            {{ \Illuminate\Support\Str::limit(strip_tags($b['isi_berita'] ?? ''), 100) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-4 pb-4">
                        <a href="{{ route('berita.show', $b['id_berita'] ?? 0) }}" class="btn btn-sm btn-primary">
                            Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ACARA --}}
@if(!empty($acara))
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-1">Acara & <span>Kegiatan</span></h2>
                <p class="text-muted mb-0">Jadwal kegiatan masjid</p>
            </div>
            <a href="{{ route('event.index') }}" class="btn btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="row g-4">
            @foreach(array_slice($acara, 0, 3) as $a)
            @php
                $gambarAcara = $a['gambar_event'] ?? '';
                if ($gambarAcara && !str_starts_with($gambarAcara, 'http')) {
                    $gambarAcara = $BASE_IMG . '/uploads/kegiatan/' . $gambarAcara;
                }
                $gambarAcara = $gambarAcara ?: 'https://via.placeholder.com/400x220?text=No+Image';
            @endphp
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card card-event h-100">
                    <div class="position-relative">
                        <img src="{{ $gambarAcara }}" class="card-img-top" alt="{{ $a['nama_event'] ?? '' }}"
                             onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                        @if(!empty($a['tanggal_event']))
                        <span class="badge-tanggal position-absolute bottom-0 start-0 m-3">
                            <i class="bi bi-calendar3 me-1"></i>{{ date('d M Y', strtotime($a['tanggal_event'])) }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-2">{{ \Illuminate\Support\Str::limit($a['nama_event'] ?? '', 50) }}</h5>
                        @if(!empty($a['lokasi_event']))
                        <p class="text-muted small mb-2">
                            <i class="bi bi-geo-alt me-1"></i>{{ $a['lokasi_event'] }}
                        </p>
                        @endif
                        <p class="text-muted small">
                            {{ \Illuminate\Support\Str::limit(strip_tags($a['deskripsi_event'] ?? ''), 80) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-4 pb-4">
                        <a href="{{ route('event.show', $a['id_event'] ?? 0) }}" class="btn btn-sm btn-outline-primary">
                            Detail Acara <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- LAYANAN SEWA --}}
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <h2 class="fw-bold mb-3">Sewa Fasilitas Masjid</h2>
                <p class="opacity-85 fs-5 mb-4">
                    Masjid Nurul Huda menyediakan berbagai fasilitas yang dapat disewa oleh jamaah dan masyarakat umum,
                    mulai dari gedung, alat multimedia, hingga alat banjari.
                </p>
                <a href="{{ route('reservasi.index') }}" class="btn btn-light btn-lg fw-semibold px-4">
                    <i class="bi bi-calendar-check me-2"></i>Lihat Fasilitas
                </a>
            </div>
            @if($layanan)
            @php
                $gambarLayanan = $layanan['gambar'] ?? '';
                if ($gambarLayanan && !str_starts_with($gambarLayanan, 'http')) {
                    $gambarLayanan = $BASE_IMG . '/uploads/persewaan/' . $gambarLayanan;
                }
            @endphp
            <div class="col-lg-5 text-center mt-4 mt-lg-0" data-aos="fade-left">
                @if($gambarLayanan)
                <img src="{{ $gambarLayanan }}" alt="Fasilitas"
                     class="img-fluid rounded-3 shadow" style="max-height: 300px; object-fit: cover;"
                     onerror="this.style.display='none'">
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

@endsection
