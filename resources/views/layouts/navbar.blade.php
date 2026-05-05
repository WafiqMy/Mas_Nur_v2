@php
    $sessionUser = session('user');
    $isLoggedIn  = !empty($sessionUser);
    $isAdmin     = $isLoggedIn && strtolower(trim((string) ($sessionUser['role'] ?? ''))) === 'admin';
    $namaUser    = $sessionUser['nama'] ?? '';
    $usernameUser = $sessionUser['username'] ?? '';

    // URL gambar profil (dari API)
    $fotoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($namaUser) . '&background=2563eb&color=fff&size=64';
@endphp

<style>
    /* 1. FLOATING PILL NAVBAR - UKURAN ABSOLUT */
    .navbar-floating {
        position: fixed !important;
        top: 25px !important;
        left: 50% !important;
        right: auto !important;
        transform: translateX(-50%) !important;
        width: 90vw !important;
        max-width: 1100px !important;
        margin: 0 !important;
        border-radius: 50px !important;
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(12px) !important;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0,0,0,0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.8) !important;
        padding: 0.7rem 1.8rem !important;
        z-index: 1050 !important;
        transition: all 0.3s ease;
    }

    /* 2. POP-UP SUPER MINIMALIST & TRANSPARAN */
    .nav-popup {
        position: absolute;
        top: calc(100% + 15px);
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background: rgba(31, 41, 55, 0.85) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        border-radius: 8px !important;
        padding: 6px 14px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        z-index: 9999;
        white-space: nowrap;
    }

    /* Panah Pop-up minimalis */
    .nav-popup-arrow {
        position: absolute;
        top: -5px;
        left: 50%;
        transform: translateX(-50%) rotate(45deg);
        width: 10px;
        height: 10px;
        background: rgba(31, 41, 55, 0.85);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        border-left: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Sembunyikan elemen berlebih, sisakan judul saja */
    .nav-popup-icon, .nav-popup-desc { display: none !important; }
    .nav-popup-title {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: #ffffff !important;
        margin: 0 !important;
        letter-spacing: 0.5px;
    }

    /* Hover Trigger */
    .nav-item:hover .nav-popup {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    /* Adjust body padding untuk floating navbar */
    body {
        padding-top: 0px !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light navbar-floating">

        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('img/logo_masjid.png') }}" alt="Logo" height="38"
                 onerror="this.style.display='none'">
            <span class="fw-bold" style="color: #2563eb; font-size: 1.1rem;">Mas Nur</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}"
                       href="{{ route('home') }}">Beranda</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('profil-masjid.*') ? 'active fw-semibold' : '' }}"
                       href="#" data-bs-toggle="dropdown">Profil</a>
                    <ul class="dropdown-menu shadow border-0 mt-2 p-2">
                        <li><a class="dropdown-item rounded py-2" href="{{ route('profil-masjid.show') }}">
                            <i class="bi bi-building me-2 text-primary"></i>Profil Masjid</a></li>
                        <li><a class="dropdown-item rounded py-2" href="{{ route('profil-masjid.struktur') }}">
                            <i class="bi bi-diagram-3 me-2 text-primary"></i>Struktur Organisasi</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('berita.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('berita.index') }}">Berita</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('event.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('event.index') }}">Acara</a>
                </li>

                <li class="nav-item">

                    <a class="nav-link {{ request()->routeIs('infaq.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('infaq.index') }}">Infaq</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reservasi.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('reservasi.index') }}">Sewa Fasilitas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('food-court.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('food-court.index') }}">Food Court</a>
                </li>

                @if(!$isLoggedIn)
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                        </a>
                    </li>
                @else
                    {{-- Notifikasi --}}
                    <li class="nav-item">
                        <a href="{{ route('notifikasi.index') }}" class="nav-link position-relative px-2"
                           title="Notifikasi">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="notif-badge" id="notif-count" style="display:none;">0</span>
                        </a>
                    </li>

                    {{-- Dropdown User --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" data-bs-toggle="dropdown">
                            <img src="{{ $fotoUrl }}" alt="Foto"
                                 class="rounded-circle" width="32" height="32"
                                 style="object-fit:cover;"
                                 id="navbarFoto">
                            <span class="d-none d-lg-inline fw-semibold" style="font-size:0.9rem;">
                                {{ $namaUser }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="min-width:220px;">

                            @if($isAdmin)
                                <li><h6 class="dropdown-header text-primary small fw-bold">MENU ADMIN</h6></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.berita.index') }}">
                                    <i class="bi bi-newspaper me-2 text-muted"></i>Kelola Berita</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.acara.index') }}">
                                    <i class="bi bi-calendar-event me-2 text-muted"></i>Kelola Acara</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.reservasi.index') }}">
                                    <i class="bi bi-box-seam me-2 text-muted"></i>Kelola Barang</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.reservasi.permintaan') }}">
                                    <i class="bi bi-clipboard-check me-2 text-muted"></i>Permintaan Sewa</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.infaq.dana.index') }}">
                                    <i class="bi bi-cash-coin me-2 text-muted"></i>Kelola Infaq</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.infaq.rekening.index') }}">
                                    <i class="bi bi-bank2 me-2 text-muted"></i>Kelola Rekening & QRIS</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.food-court.index') }}">
                                    <i class="bi bi-shop me-2 text-muted"></i>Kelola Food Court</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('admin.profil-masjid.edit') }}">
                                    <i class="bi bi-building me-2 text-muted"></i>Edit Profil Masjid</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                            @endif

                            <li><a class="dropdown-item rounded py-2" href="{{ route('profil-user.show') }}">
                                <i class="bi bi-person me-2 text-muted"></i>Profil Saya</a></li>
                            <li><a class="dropdown-item rounded py-2" href="{{ route('reservasi.status') }}">
                                <i class="bi bi-receipt me-2 text-muted"></i>Status Pemesanan</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
</nav>

@if($isLoggedIn)
<script>
    // Cek notifikasi baru
    fetch('{{ route("notifikasi.count") }}')
        .then(r => r.json())
        .then(data => {
            if (data.count > 0) {
                const badge = document.getElementById('notif-count');
                if (badge) {
                    badge.textContent = data.count > 9 ? '9+' : data.count;
                    badge.style.display = 'flex';
                }
            }
        }).catch(() => {});

    // Load foto profil dari API
    fetch('{{ config("app.api_base_url") }}/api_get_profile.php?username={{ $usernameUser }}')
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success' && data.data.gambar_url) {
                const img = document.getElementById('navbarFoto');
                if (img) img.src = data.data.gambar_url;
            }
        }).catch(() => {});
</script>
@endif
