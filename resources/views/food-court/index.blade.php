@extends('layouts.app')

@section('title', 'Food Court - Masjid Nurul Huda')

@push('styles')
<style>
    /* ===== HERO ===== */
   .fc-hero {
        background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
        /* UBAH PADDING INI: 9rem di atas (jarak untuk navbar), 0 kiri-kanan, 4rem bawah */
        padding: 9rem 0 4rem;
        text-align: center;
        color: white;
    }

    .fc-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 0.75rem;
    }

    .fc-hero p {
        font-size: 1.15rem;
        opacity: 0.9;
        max-width: 500px;
        margin: 0 auto;
    }

    /* ===== GRID MENU ===== */
    .fc-section {
        padding: 4rem 0 5rem;
        background: #f8f9ff;
    }

    .fc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.75rem;
        margin-top: 2.5rem;
    }

    .fc-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .fc-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.15);
    }

    .fc-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    .fc-card-body {
        padding: 1.25rem;
        text-align: center;
    }

    .fc-card-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .fc-card-desc {
        font-size: 0.875rem;
        color: #6b7280;
    }

    /* ===== EMPTY STATE ===== */
    .fc-empty {
        text-align: center;
        padding: 4rem 1rem;
        color: #9ca3af;
    }

    .fc-empty i {
        font-size: 4rem;
        margin-bottom: 1rem;
        display: block;
    }

    /* ===== SECTION TITLE ===== */
    .fc-section-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1f2937;
        text-align: center;
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .fc-section-title::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 56px;
        height: 4px;
        background: #2563eb;
        border-radius: 2px;
    }

    @media (max-width: 576px) {
        .fc-hero h1 { font-size: 2rem; }
        .fc-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
        .fc-card-img { height: 150px; }
    }
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="fc-hero">
    <div class="container" data-aos="fade-up">
        <h1><i class="bi bi-shop me-2"></i>Food Court</h1>
        <p>Nikmati berbagai pilihan menu lezat yang tersedia di area masjid</p>
        @if(session('user') && strtolower(session('user')['role'] ?? '') === 'admin')
        <div class="mt-3">
            <a href="{{ route('admin.food-court.index') }}" class="btn btn-warning fw-semibold">
                <i class="bi bi-gear me-1"></i>Kelola Menu Food Court
            </a>
        </div>
        @endif
    </div>
</section>

{{-- MENU GRID --}}
<section class="fc-section">
    <div class="container">
        <h2 class="fc-section-title" data-aos="fade-up">DAFTAR MENU</h2>

        @if($menus->count() > 0)
            <div class="fc-grid">
                @foreach($menus as $menu)
                    <div class="fc-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <img src="{{ $menu->gambar_url }}"
                             alt="{{ $menu->nama_menu }}"
                             class="fc-card-img"
                             onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">
                        <div class="fc-card-body">
                            <div class="fc-card-name">{{ $menu->nama_menu }}</div>
                            @if($menu->deskripsi)
                                <div class="fc-card-desc">{{ $menu->deskripsi }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="fc-empty" data-aos="fade-up">
                <i class="bi bi-cup-hot"></i>
                <p class="fw-semibold">Menu belum tersedia</p>
                <p class="small">Silakan kunjungi kembali nanti.</p>
            </div>
        @endif
    </div>
</section>

@endsection
