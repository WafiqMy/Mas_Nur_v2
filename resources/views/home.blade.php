<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="SFf9IfYkvhoDvlB42HUUemqfBzdjFCpHFQUirFRj">
    <title>Beranda - Masjid Nurul Huda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --brand-color: #2563eb;
            --brand-hover: #1d4ed8;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #f8f9fa;
        }
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 76px;
            background-color: #fff;
            overflow-x: hidden;
        }
        .navbar-brand img { height: 40px; }
        .nav-link { font-weight: 500; color: var(--text-dark) !important; transition: color 0.2s; }
        .nav-link:hover, .nav-link.active { color: var(--brand-color) !important; }
        .btn-brand { background-color: var(--brand-color); color: #fff; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 600; transition: all 0.2s; }
        .btn-brand:hover { background-color: var(--brand-hover); color: #fff; transform: translateY(-1px); }
        .notif-badge { position: absolute; top: -4px; right: -4px; background: #ef4444; color: #fff; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; }
        .alert-flash { position: fixed; top: 90px; right: 20px; z-index: 9999; min-width: 300px; animation: slideIn 0.3s ease; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>

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
            /* Gradasi linear horizontal (ke kanan), dari biru semi-transparan ke transparan penuh */
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
    </style>
</head>
<body>

@php
    $sessionUser = session('user');
    $isLoggedIn  = !empty($sessionUser);
    $isAdmin     = $isLoggedIn && strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';
    $namaUser    = $sessionUser['nama'] ?? '';
    $usernameUser = $sessionUser['username'] ?? '';

    // URL gambar profil (dari API)
    $fotoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($namaUser) . '&background=2563eb&color=fff&size=64';
@endphp

@include('layouts.navbar')

<style>
    /* 1. Menghapus paksa celah putih (padding) yang datang dari file navbar */
    body {
        padding-top: 0 !important;
        margin: 0 !important;
    }

    /* 2. Memastikan Hero Section menempel ke atas dan memenuhi layar */
    .hero-section {
        margin-top: 0 !important;
        height: 100vh !important; /* Foto akan setinggi layar monitor */
        display: flex;
        align-items: center;
    }

    /* 3. Menghaluskan gradasi agar foto masjid lebih terlihat natural */
    .hero-overlay {
        background: linear-gradient(to right, rgba(30, 64, 175, 0.7) 0%, transparent 100%) !important;
    }
</style>

<main>

    <section class="hero-section" style="background-image: url('http://127.0.0.1:8000/img/ms3.png');">
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
                        <a href="http://127.0.0.1:8000/profil-masjid" class="btn btn-light btn-lg fw-semibold px-4">
                            <i class="bi bi-building me-2"></i>Profil Masjid
                        </a>
                        <a href="http://127.0.0.1:8000/reservasi" class="btn btn-outline-light btn-lg fw-semibold px-4">
                            <i class="bi bi-calendar-check me-2"></i>Sewa Fasilitas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Section Component -->
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
                    <a href="https://www.youtube.com/@masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 10px; background: #FF0000; color: white; padding: 12px 28px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255,0,0,0.3); border: none; cursor: pointer;">
                        <i class="bi bi-youtube" style="font-size: 1.2rem;"></i> BERLANGGANAN
                    </a>
                </div>
                <div class="col-lg-7 col-md-12" data-aos="fade-left" data-aos-duration="900">
                    <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(37,99,235,0.2); border: 3px solid rgba(37,99,235,0.1);">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/yRQYiEcEsqU" title="Video Masjid Nurul Huda" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen style="border:0;"></iframe>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-top: 16px; padding: 12px 16px; background: #f8f9ff; border-radius: 12px;">
                        <i class="bi bi-youtube" style="color: #FF0000; font-size: 1.5rem;"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem; color: #1a1a2e;">Masjid Besar Nurul Huda Official</div>
                            <div style="font-size: 0.78rem; color: #6b7280;">youtube.com/@masjidnurulhudanganjuk</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Instagram Section Component -->
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
                    <div style="display: flex; gap: 24px; margin-bottom: 28px; padding: 16px 0; border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;">
                        <div style="text-align: center;">
                            <div style="font-size: 1.4rem; font-weight: 800; color: #e1306c;">2rb+</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">Pengikut</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 1.4rem; font-weight: 800; color: #e1306c;">Reels</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">& Feed</div>
                        </div>
                        <div style="text-align: center;">
                            <div style="font-size: 1.4rem; font-weight: 800; color: #e1306c;">✓</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">Konten Islami</div>
                        </div>
                    </div>
                    <a href="https://www.instagram.com/masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: white; padding: 12px 28px; border-radius: 50px; font-weight: 700; font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220,39,67,0.3); border: none; cursor: pointer;">
                        <i class="bi bi-instagram" style="font-size: 1.2rem;"></i> IKUTI KAMI
                    </a>
                    <div style="margin-top: 14px;">
                        <a href="https://www.instagram.com/masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer" style="color: #6b7280; font-size: 0.82rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="bi bi-at"></i> @masjidnurulhudanganjuk
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12" data-aos="fade-right" data-aos-duration="900">
                    <div style="border-radius: 20px; overflow: hidden; width: 100%; height: 480px; background: white; box-shadow: 0 20px 60px rgba(220,39,67,0.12); border: 3px solid rgba(220,39,67,0.08);">
                        <iframe src="https://www.instagram.com/p/DRVVWDGk6IB/embed" width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true" loading="lazy" title="Instagram Masjid Nurul Huda" style="border: none; overflow: hidden;"></iframe>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-top: 16px; padding: 12px 16px; background: #fff8f9; border-radius: 12px;">
                        <i class="bi bi-instagram" style="background: linear-gradient(45deg,#f09433,#bc1888); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.5rem;"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.9rem; color: #1a1a2e;">@masjidnurulhudanganjuk</div>
                            <div style="font-size: 0.78rem; color: #6b7280;">2.368 pengikut · instagram.com</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
                <div>
                    <h2 class="section-title mb-1">Berita <span>Terbaru</span></h2>
                    <p class="text-muted mb-0">Informasi terkini dari Masjid Nurul Huda</p>
                </div>
                <a href="http://127.0.0.1:8000/berita" class="btn btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="card card-news h-100">
                        <img src="https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/berita/berita_1777253068_4261.png" alt="Buka Bersama" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                        <div class="card-body p-4">
                            <p class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> 27 Apr 2026</p>
                            <h5 class="fw-bold mb-2" style="line-height:1.4;">Buka Bersama</h5>
                            <p class="text-muted small">Buka Bersama Di Halaman Masjid</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <a href="http://127.0.0.1:8000/berita/228" class="btn btn-sm btn-primary">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-news h-100">
                        <img src="https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/berita/BRT_1764757737_9232.jpg" alt="kajian rutin" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                        <div class="card-body p-4">
                            <p class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> 24 Apr 2026</p>
                            <h5 class="fw-bold mb-2" style="line-height:1.4;">kajian rutin</h5>
                            <p class="text-muted small">Ribuan warga antusias menyambut peresmian Masjid Raya Nurul Iman yang megah diresmikan hari ini, Kam...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <a href="http://127.0.0.1:8000/berita/225" class="btn btn-sm btn-primary">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-news h-100">
                        <img src="https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/berita/berita_1764782356_9505.png" alt="Gelar seni budaya" onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                        <div class="card-body p-4">
                            <p class="text-muted small mb-2"><i class="bi bi-calendar3 me-1"></i> 04 Dec 2025</p>
                            <h5 class="fw-bold mb-2" style="line-height:1.4;">Gelar seni budaya</h5>
                            <p class="text-muted small">Ribuan warga antusias menyambut peresmian Masjid Raya Nurul Huda yang megah diresmikan hari ini, Kam...</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <a href="http://127.0.0.1:8000/berita/226" class="btn btn-sm btn-primary">
                                Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== BLOK SEWA FASILITAS DIPINDAH KE SINI (DI ATAS ACARA & KEGIATAN) ====== -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <h2 class="fw-bold mb-3">Sewa Fasilitas Masjid</h2>
                    <p class="opacity-85 fs-5 mb-4">
                        Masjid Nurul Huda menyediakan berbagai fasilitas yang dapat disewa oleh jamaah dan masyarakat umum,
                        mulai dari gedung, alat multimedia, hingga alat banjari.
                    </p>
                    <a href="http://127.0.0.1:8000/reservasi" class="btn btn-light btn-lg fw-semibold px-4">
                        <i class="bi bi-calendar-check me-2"></i>Lihat Fasilitas
                    </a>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0" data-aos="fade-left">
                  <img src="/img/kamera.png" alt="Fasilitas" class="img-fluid rounded-3 shadow" style="max-height: 300px; object-fit: cover;" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </section>

    <!-- ====== BLOK ACARA & KEGIATAN BERADA DI BAWAHNYA ====== -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
                <div>
                    <h2 class="section-title mb-1">Acara & <span>Kegiatan</span></h2>
                    <p class="text-muted mb-0">Jadwal kegiatan masjid</p>
                </div>
                <a href="http://127.0.0.1:8000/acara" class="btn btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="card card-event h-100">
                        <div class="position-relative">
                            <img src="https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/kegiatan/main_1764782528_799.png" class="card-img-top" alt="pengajian rutin" onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                            <span class="badge-tanggal position-absolute bottom-0 start-0 m-3"><i class="bi bi-calendar3 me-1"></i>04 Dec 2025</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2">pengajian rutin</h5>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>serambi masjid</p>
                            <p class="text-muted small">pengajian rutin hari ahad pagi</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <a href="http://127.0.0.1:8000/acara/49" class="btn btn-sm btn-outline-primary">Detail Acara <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-event h-100">
                        <div class="position-relative">
                            <img src="https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/kegiatan/main_1764029667_822.png" class="card-img-top" alt="buka bersama" onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                            <span class="badge-tanggal position-absolute bottom-0 start-0 m-3"><i class="bi bi-calendar3 me-1"></i>26 Nov 2025</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2">buka bersama</h5>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>serambi masjid</p>
                            <p class="text-muted small">ayo mokel</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <a href="http://127.0.0.1:8000/acara/18" class="btn btn-sm btn-outline-primary">Detail Acara <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-event h-100">
                        <div class="position-relative">
                            <img src="https://masnurhudanganjuk.pbltifnganjuk.com/API/uploads/kegiatan/main_edit_1764184976_143.jpg" class="card-img-top" alt="bukber (buka bersama)" onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                            <span class="badge-tanggal position-absolute bottom-0 start-0 m-3"><i class="bi bi-calendar3 me-1"></i>26 Nov 2025</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2">bukber (buka bersama)</h5>
                            <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>Tanjunganom</p>
                            <p class="text-muted small">buka bersama</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <a href="http://127.0.0.1:8000/acara/26" class="btn btn-sm btn-outline-primary">Detail Acara <i class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .footer-section {
        background-color: #548CFF;
        background: linear-gradient(135deg, #4a85ff 0%, #2563eb 100%);
        color: white;
        padding: 60px 0 30px 0;
        font-family: 'Poppins', sans-serif;
        width: 100%;
    }
    .footer-logo {
        height: 60px;
        filter: brightness(0) invert(1);
        margin-bottom: 15px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .footer-desc { font-size: 0.9rem; line-height: 1.7; opacity: 0.9; margin-bottom: 20px; }
    .social-btn {
        display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px;
        border: 2px solid rgba(255,255,255,0.6); border-radius: 50%; color: white; font-size: 1rem;
        text-decoration: none; transition: all 0.3s ease; background: transparent;
    }
    .social-btn:hover { background-color: white; color: #4a85ff; border-color: white; transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }
    .footer-heading { font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; color: white; display: inline-block; }
    .footer-map { width: 100%; height: 200px; background-color: #e9ecef; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.2); border: 2px solid rgba(255,255,255,0.3); }
    .footer-map iframe { width: 100%; height: 100%; border: 0; display: block; }
    .sponsor-wrapper { background: white; padding: 15px 25px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; gap: 20px; margin-top: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .sponsor-logo { height: 45px; width: auto; object-fit: contain; transition: transform 0.3s ease; }
    .sponsor-logo:hover { transform: scale(1.08); }
    .copyright-bar { background-color: #4270cc; color: rgba(255,255,255,0.85); padding: 15px 0; font-size: 0.85rem; font-family: 'Poppins', sans-serif; width: 100%; text-align: center; }
    @media (max-width: 768px) {
        .footer-section { padding: 40px 0 20px 0; }
        .social-btn { width: 36px; height: 36px; font-size: 0.9rem; }
        .sponsor-wrapper { flex-wrap: wrap; gap: 15px; padding: 12px 20px; }
        .sponsor-logo { height: 40px; }
    }
</style>

<footer class="footer-section">
    <div class="container">
        <div class="row gy-5 justify-content-between align-items-start">
            <div class="col-lg-4 col-md-6 text-center">
                <img src="http://127.0.0.1:8000/img/logo_masjid.png" alt="Logo Masjid Nurul Huda" class="footer-logo" onerror="this.style.display='none'">
                <p class="footer-desc">Website resmi Masjid besar Nurul Huda.<br>Pusat informasi kegiatan, layanan umat, dan dakwah digital.</p>
                <div style="display: flex; justify-content: center; gap: 8px; margin-top: 12px;">
                    <a href="https://www.facebook.com/masjidnurulhudatanjunganom/" target="_blank" rel="noopener noreferrer" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.youtube.com/@masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer" class="social-btn"><i class="bi bi-youtube"></i></a>
                    <a href="https://www.instagram.com/masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tiktok.com/@masjidnurulhudanganjuk" target="_blank" rel="noopener noreferrer" class="social-btn"><i class="bi bi-tiktok"></i></a>
                    <a href="https://wa.me/6285808441941" target="_blank" rel="noopener noreferrer" class="social-btn"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 text-center">
                <h6 class="footer-heading">Lokasi</h6>
               <div class="footer-map">
    <iframe
        src="https://maps.google.com/maps?q=Masjid+Besar+Nurul+Huda,+Tanjunganom,+Nganjuk&t=&z=17&ie=UTF8&iwloc=&output=embed"
        allowfullscreen=""
        loading="lazy"
        title="Lokasi Masjid Nurul Huda"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
            </div>
            <div class="col-lg-4 col-md-12 text-center">
                <h6 class="footer-heading">Didukung Oleh:</h6>
                <div class="sponsor-wrapper">
                    <img src="http://127.0.0.1:8000/img/logo_polije.png" alt="Politeknik Negeri Jember" class="sponsor-logo" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/0/09/Politeknik_Negeri_Jember.png'">
                    <img src="http://127.0.0.1:8000/img/logo_blu_speed.png" alt="BLU Speed" class="sponsor-logo" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="copyright-bar">
    &copy; 2026 Masjid Nurul Huda by: Bewan. All Rights Reserved.
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true });
    // Auto-dismiss flash alerts
    setTimeout(() => {
        document.querySelectorAll('.alert-flash').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 4000);
</script>
<script async defer src="https://www.instagram.com/embed.js"></script>
</body>
</html>
