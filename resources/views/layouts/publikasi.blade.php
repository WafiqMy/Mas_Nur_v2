<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Publikasi - Masjid Nurul Huda')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9ff;
            margin: 0; padding: 0;
        }

        /* ===== NAVBAR ===== */
        .pub-navbar {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            padding: 0.9rem 0;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .pub-navbar .brand {
            display: flex; align-items: center; gap: 12px; text-decoration: none;
        }
        .pub-navbar .brand img {
            height: 42px; filter: brightness(0) invert(1);
        }
        .pub-navbar .brand-text {
            color: white; line-height: 1.2;
        }
        .pub-navbar .brand-text .name {
            font-weight: 800; font-size: 1rem; display: block;
        }
        .pub-navbar .brand-text .sub {
            font-size: 0.72rem; opacity: 0.85; display: block;
        }
        .pub-navbar .back-btn {
            color: rgba(255,255,255,0.85); text-decoration: none;
            font-size: 0.85rem; font-weight: 500;
            display: flex; align-items: center; gap: 6px;
            transition: color 0.2s;
        }
        .pub-navbar .back-btn:hover { color: white; }

        /* ===== HERO ===== */
        .pub-hero {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            color: white; text-align: center; padding: 4rem 1rem 3rem;
        }
        .pub-hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; }
        .pub-hero p  { font-size: 1.05rem; opacity: 0.9; max-width: 500px; margin: 0 auto; }

        /* ===== FOOTER ===== */
        .pub-footer {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            color: white; padding: 3rem 0 1.5rem;
            margin-top: 4rem;
        }
        .pub-footer .footer-logo {
            height: 50px; filter: brightness(0) invert(1); margin-bottom: 12px;
        }
        .pub-footer .footer-desc {
            font-size: 0.88rem; opacity: 0.9; line-height: 1.7;
        }
        .pub-footer .social-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 38px; height: 38px; border: 2px solid rgba(255,255,255,0.5);
            border-radius: 50%; color: white; text-decoration: none;
            transition: all 0.3s; font-size: 0.95rem;
        }
        .pub-footer .social-btn:hover {
            background: white; color: #2563eb; border-color: white;
            transform: translateY(-3px);
        }
        .pub-footer .footer-heading {
            font-weight: 700; font-size: 1rem; margin-bottom: 1rem; color: white;
        }
        .pub-footer .footer-map {
            width: 100%; height: 180px; border-radius: 10px; overflow: hidden;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .pub-footer .footer-map iframe { width: 100%; height: 100%; border: 0; }
        .pub-footer .sponsor-wrapper {
            background: white; padding: 12px 20px; border-radius: 12px;
            display: inline-flex; align-items: center; gap: 16px;
        }
        .pub-footer .sponsor-logo { height: 40px; object-fit: contain; }
        .pub-copyright {
            background: rgba(0,0,0,0.2); color: rgba(255,255,255,0.8);
            text-align: center; padding: 12px; font-size: 0.82rem;
        }
    </style>

    @stack('styles')
    <style>
        /* Pastikan konten publikasi benar-benar full width */
        html, body { margin: 0; padding: 0; overflow-x: hidden; }
        body { padding-top: 0 !important; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="pub-navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ route('publikasi.page') }}" class="brand">
            <img src="{{ asset('img/logo_masjid.png') }}" alt="Logo"
                 onerror="this.style.display='none'">
            <div class="brand-text">
                <span class="name">{{ $profil->nama_masjid ?? 'Masjid Nurul Huda' }}</span>
                <span class="sub">Portal Publikasi Resmi</span>
            </div>
        </a>
        <a href="{{ url('/') }}" class="back-btn">
            <i class="bi bi-house-door"></i>
            <span class="d-none d-sm-inline">Website Utama</span>
        </a>
    </div>
</nav>

{{-- CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="pub-footer">
    <div class="container">
        <div class="row gy-4 justify-content-between align-items-start">

            <div class="col-lg-4 col-md-6 text-center">
                <img src="{{ asset('img/logo_masjid.png') }}" alt="Logo" class="footer-logo"
                     onerror="this.style.display='none'">
                <p class="footer-desc">
                    Portal publikasi resmi {{ $profil->nama_masjid ?? 'Masjid Nurul Huda' }}.<br>
                    Informasi kegiatan, acara, dan pengumuman masjid.
                </p>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <a href="{{ config('masjid.sosial.facebook') }}" target="_blank" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="{{ config('masjid.sosial.youtube') }}" target="_blank" class="social-btn"><i class="bi bi-youtube"></i></a>
                    <a href="{{ config('masjid.sosial.instagram') }}" target="_blank" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="{{ config('masjid.sosial.tiktok') }}" target="_blank" class="social-btn"><i class="bi bi-tiktok"></i></a>
                    <a href="{{ $waUrl }}" target="_blank" class="social-btn"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 text-center">
                <p class="footer-heading">Lokasi</p>
                <div class="footer-map">
                    <iframe src="{{ config('masjid.maps.embed_url') }}"
                            allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 text-center">
                <p class="footer-heading">Didukung Oleh:</p>
                <div class="sponsor-wrapper">
                    <img src="{{ asset('img/logo_polije.png') }}" alt="Polije" class="sponsor-logo"
                         onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/0/09/Politeknik_Negeri_Jember.png'">
                </div>
            </div>

        </div>
    </div>
</footer>
<div class="pub-copyright">
    &copy; {{ date('Y') }} {{ $profil->nama_masjid ?? 'Masjid Nurul Huda' }} — Portal Publikasi
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 700, once: true });</script>
@stack('scripts')
</body>
</html>
