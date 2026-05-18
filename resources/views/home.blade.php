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
        background: linear-gradient(to right, rgba(30,64,175,0.95) 0%, transparent 100%);
    }
    .hero-content { position: relative; z-index: 2; }
    .section-title { font-size: 2rem; font-weight: 700; color: #1e293b; }
    .section-title span { color: #000000ff; }
    .card-news { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
    .card-news:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
    .card-news img { height: 200px; object-fit: cover; }
    .card-event { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s; }
    .card-event:hover { transform: translateY(-5px); }
    .card-event img { height: 220px; object-fit: cover; }
    .badge-tanggal { background: #2563eb; color: #fff; border-radius: 8px; padding: 4px 12px; font-size: 0.8rem; font-weight: 600; }

    /* Food Court Section */
    .fc-home-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .fc-home-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(37,99,235,0.15);
    }
    .fc-home-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .fc-home-card-body {
        padding: 1rem;
        text-align: center;
    }
    .fc-home-card-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
    }
    .fc-home-card-desc {
        font-size: 0.8rem;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';
@endphp

{{-- HERO --}}
<section class="hero-section" style="background-image: url('{{ asset('img/ms3.png') }}');">
    <div class="hero-overlay"></div>
    <div class="container hero-content text-white">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right">
                <p class="mb-2 fw-semibold opacity-75" style="letter-spacing: 2px; text-transform: uppercase; font-size: 0.9rem;">
                    Selamat Datang di
                </p>
                <h1 class="display-4 fw-bold mb-3">Masjid Nurul Huda</h1>
                <p class="fs-5 mb-4 opacity-85" style="max-width: 550px; line-height: 1.7;">
                    Sistem digital untuk memakmurkan masjid dan mempererat ukhuwah islamiyah.
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

{{-- YOUTUBE --}}
<section style="padding: 80px 0; background: #ffffff;">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-lg-5 col-md-12" data-aos="fade-right" data-aos-duration="800">
                <span style="display: inline-block; background: #eef4ff; color: #2563eb; font-size: 0.78rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                    ▶ Subscribe
                </span>
                <h2 style="font-size: clamp(1.5rem, 2.5vw, 2rem); font-weight: 800; color: #1a1a2e; line-height: 1.3; margin-bottom: 16px;">
                    Video-video Masjid Nurul Huda<br> di Channel Youtube.
                </h2>
                <p style="color: #6b7280; line-height: 1.9; font-size: 0.95rem; margin-bottom: 28px;">
                    Ikuti terus tayangan terbaru dari channel Youtube Masjid Nurul Huda dengan cara berlangganan Gratis!
                </p>
                <div style="display: flex; gap: 24px; margin-bottom: 28px; padding: 16px 0; border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;">
                    <div style="text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 800; color: #2563eb;">8rb+</div>
                        <div style="font-size: 0.75rem; color: #9ca3af;">Subscribers</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 800; color: #2563eb;">100+</div>
                        <div style="font-size: 0.75rem; color: #9ca3af;">Video</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 1.4rem; font-weight: 800; color: #2563eb;">✓</div>
                        <div style="font-size: 0.75rem; color: #9ca3af;">Konten Islami</div>
                    </div>
                </div>
                <a href="https://www.youtube.com/@masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer"
                   style="display: inline-flex; align-items: center; gap: 10px; background: #FF0000; color: white; padding: 12px 28px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; text-decoration: none; box-shadow: 0 4px 15px rgba(255,0,0,0.3);">
                    <i class="bi bi-youtube" style="font-size: 1.2rem;"></i> BERLANGGANAN
                </a>
            </div>
            <div class="col-lg-7 col-md-12" data-aos="fade-left" data-aos-duration="900">
                <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(37,99,235,0.2); border: 3px solid rgba(37,99,235,0.1);">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/yRQYiEcEsqU" title="Video Masjid Nurul Huda"
                                loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen style="border:0;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- INSTAGRAM --}}
<section style="padding: 80px 0; background: linear-gradient(180deg, #f8f9ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="row align-items-center gy-5 flex-lg-row-reverse">
            <div class="col-lg-5 col-md-12" data-aos="fade-left" data-aos-duration="800">
                <span style="display: inline-block; background: #fff0f6; color: #e1306c; font-size: 0.78rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                    📸 Instagram
                </span>
                <h2 style="font-size: clamp(1.5rem, 2.5vw, 2rem); font-weight: 800; color: #1a1a2e; line-height: 1.3; margin-bottom: 16px;">
                    Follow Instagram<br>Masjid Nurul Huda.
                </h2>
                <p style="color: #6b7280; line-height: 1.9; font-size: 0.95rem; margin-bottom: 28px;">
                    Ikuti terus tayangan terbaru dari postingan reels, feeds, dan story Instagram Masjid Nurul Huda.
                </p>
                <a href="https://www.instagram.com/masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer"
                   style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: white; padding: 12px 28px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; text-decoration: none; box-shadow: 0 4px 15px rgba(220,39,67,0.3);">
                    <i class="bi bi-instagram" style="font-size: 1.2rem;"></i> IKUTI KAMI
                </a>
            </div>
            <div class="col-lg-7 col-md-12" data-aos="fade-right" data-aos-duration="900">
                <div style="border-radius: 20px; overflow: hidden; width: 100%; height: 480px; background: white; box-shadow: 0 20px 60px rgba(220,39,67,0.12); border: 3px solid rgba(220,39,67,0.08);">
                    <iframe src="https://www.instagram.com/p/DRVVWDGk6IB/embed" width="100%" height="100%"
                            frameborder="0" scrolling="no" allowtransparency="true" loading="lazy"
                            title="Instagram Masjid Nurul Huda" style="border: none; overflow: hidden;"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
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
            @forelse($berita as $index => $b)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="card card-news h-100">
                    <img src="{{ $b->foto_url }}" alt="{{ $b->judul_berita }}"
                         onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                    <div class="card-body p-4">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $b->tanggal_berita ? $b->tanggal_berita->format('d M Y') : '-' }}
                        </p>
                        <h5 class="fw-bold mb-2" style="line-height:1.4;">
                            {{ \Illuminate\Support\Str::limit($b->judul_berita, 60) }}
                        </h5>
                        <p class="text-muted small">
                            {{ \Illuminate\Support\Str::limit(strip_tags($b->isi_berita), 90) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('berita.show', $b->id) }}" class="btn btn-sm btn-primary">
                            Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        @if($isAdmin)
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.berita.edit', $b->id) }}" class="btn btn-sm btn-outline-warning">
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
            @empty
            <div class="col-12 text-center py-4 text-muted">Belum ada berita.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- FOOD COURT --}}
@php
    $menuFoodCourt = \App\Models\FoodCourt::orderBy('created_at', 'desc')->limit(4)->get();
@endphp
@if($menuFoodCourt->count() > 0)
<section class="py-5" style="background: #f8f9ff;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <div>
                <h2 class="section-title mb-1">Food <span>Court</span></h2>
                <p class="text-muted mb-0">Menu lezat yang tersedia di area masjid</p>
            </div>
            <a href="{{ route('food-court.index') }}" class="btn btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="row g-4">
            @foreach($menuFoodCourt as $index => $menu)
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}">
                <div class="fc-home-card">
                    <img src="{{ $menu->gambar_url }}" alt="{{ $menu->nama_menu }}"
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                    <div class="fc-home-card-body">
                        <div class="fc-home-card-name">{{ $menu->nama_menu }}</div>
                        @if($menu->deskripsi)
                        <div class="fc-home-card-desc">{{ $menu->deskripsi }}</div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- SEWA FASILITAS --}}
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
            <div class="col-lg-5 text-center mt-4 mt-lg-0" data-aos="fade-left">
                <img src="{{ asset('img/kamera.png') }}" alt="Fasilitas"
                     class="img-fluid rounded-3 shadow" style="max-height: 300px; object-fit: cover;"
                     onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>

{{-- ACARA & KEGIATAN --}}
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
            @forelse($acara as $index => $event)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="card card-event h-100">
                    <div class="position-relative">
                        <img src="{{ $event->gambar_url }}" class="card-img-top" alt="{{ $event->nama_event }}"
                             onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                        @if($event->tanggal_event)
                        <span class="badge-tanggal position-absolute bottom-0 start-0 m-3">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $event->tanggal_event->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-2">{{ \Illuminate\Support\Str::limit($event->nama_event, 50) }}</h5>
                        @if($event->lokasi_event)
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $event->lokasi_event }}</p>
                        @endif
                        <p class="text-muted small">
                            {{ \Illuminate\Support\Str::limit(strip_tags($event->deskripsi_event ?? ''), 80) }}
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('event.show', $event->id) }}" class="btn btn-sm btn-outline-primary">
                            Detail Acara <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        @if($isAdmin)
                        <div class="d-flex gap-1">
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
            @empty
            <div class="col-12 text-center py-4 text-muted">Belum ada acara.</div>
            @endforelse
        </div>
    </div>
</section>

@endsection
