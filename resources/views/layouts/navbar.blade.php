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
    /* ===== CSS VARIABLES (DESIGN SYSTEM) ===== */
    :root {
        /* Colors - Minimalist Soft Palette */
        --color-primary: #2563eb;
        --color-primary-light: #1e40af;
        --color-primary-hover: rgba(37, 99, 235, 0.06);
        --color-text-primary: #475569;
        --color-text-secondary: #64748b;
        --color-text-active: #1e40af;
        --color-text-light: #94a3b8;
        --color-border: rgba(226, 232, 240, 0.8);
        --color-bg-light: rgba(255, 255, 255, 0.92);
        --color-bg-dropdown: rgba(255, 255, 255, 0.98);
        --color-danger: #dc2626;
        
        /* Spacing - 8px Grid */
        --spacing-xs: 0.25rem;
        --spacing-sm: 0.5rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        
        /* Typography */
        --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        --font-size-brand: 1.05rem;
        --font-size-link: 0.9rem;
        --font-size-dropdown: 0.85rem;
        --font-size-sm: 0.75rem;
        --font-weight-medium: 500;
        --font-weight-semibold: 600;
        
        /* Breakpoints */
        --breakpoint-mobile: 375px;
        --breakpoint-tablet: 768px;
        --breakpoint-desktop: 1100px;
        
        /* Border Radius */
        --radius-pill: 45px;
        --radius-md: 8px;
        --radius-sm: 6px;
        
        /* Shadows - Minimal */
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.03);
        --shadow-md: 0 4px 15px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.06);
        
        /* Transitions */
        --transition-fast: 0.15s ease;
        --transition-smooth: 0.2s ease-in-out;
        --transition-ease: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== BODY PADDING ===== */
    body {
        padding-top: 0 !important;
        font-family: var(--font-family);
        color: var(--color-text-primary);
    }

    /* ===== DESKTOP STYLES (1100px+) ===== */
    .navbar-floating {
        position: fixed;
        top: 20px;
        left: 50%;
        right: auto;
        transform: translateX(-50%);
        width: 90vw;
        max-width: 1100px;
        margin: 0;
        border-radius: var(--radius-pill);
        background: var(--color-bg-light);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: var(--shadow-sm), var(--shadow-md);
        border: 1px solid var(--color-border);
        padding: 0.4rem 1.2rem;
        z-index: 1050;
        transition: var(--transition-ease);
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .navbar-floating.scrolled {
        box-shadow: var(--shadow-sm), var(--shadow-lg);
        padding: 0.35rem 1.2rem;
    }

    /* Logo/Brand */
    .navbar-floating .navbar-brand {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        margin-bottom: 0;
        transition: var(--transition-fast);
    }

    .navbar-floating .navbar-brand img {
        height: 32px;
        width: auto;
        object-fit: contain;
    }

    .navbar-floating .navbar-brand span {
        font-size: var(--font-size-brand);
        font-weight: var(--font-weight-semibold);
        color: var(--color-primary);
        letter-spacing: -0.3px;
    }

    .navbar-floating .navbar-brand:hover span {
        color: var(--color-primary-light);
    }

    /* Navigation Links */
    .navbar-floating .nav-link {
        padding: 0.4rem 0.8rem !important;
        font-size: var(--font-size-link);
        font-weight: var(--font-weight-medium);
        color: var(--color-text-primary) !important;
        transition: var(--transition-smooth);
        border-radius: var(--radius-sm);
        white-space: nowrap;
    }

    .navbar-floating .nav-link:hover {
        color: var(--color-primary) !important;
        background: var(--color-primary-hover);
    }

    .navbar-floating .nav-link.active {
        color: var(--color-primary) !important;
        font-weight: var(--font-weight-semibold);
        background: var(--color-primary-hover);
    }

    /* Navbar Collapse */
    .navbar-floating .collapse {
        flex-basis: auto;
        flex-grow: 1;
        justify-content: flex-end;
    }

    .navbar-floating .navbar-nav {
        gap: var(--spacing-lg);
        align-items: center;
    }

    /* Dropdown Menu */
    .navbar-floating .dropdown-menu {
        background: var(--color-bg-dropdown);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-lg);
        padding: 0.5rem 0;
        min-width: 200px;
        margin-top: 8px;
    }

    .navbar-floating .dropdown-item {
        padding: 0.35rem 0.75rem;
        font-size: var(--font-size-dropdown);
        color: var(--color-text-primary);
        border-radius: var(--radius-sm);
        transition: var(--transition-fast);
        margin: 0.25rem;
    }

    .navbar-floating .dropdown-item:hover {
        background: var(--color-primary-hover);
        color: var(--color-text-active);
    }

    .navbar-floating .dropdown-item.text-danger:hover {
        background: rgba(220, 38, 38, 0.08);
        color: var(--color-danger);
    }

    .navbar-floating .dropdown-header {
        padding: 0.35rem 0.75rem;
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-semibold);
        color: var(--color-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Button Login */
    .navbar-floating .btn-primary {
        padding: 0.35rem 1rem;
        font-size: var(--font-size-dropdown);
        font-weight: var(--font-weight-medium);
        border-radius: var(--radius-sm);
        background: var(--color-primary);
        border: none;
        color: white;
        transition: var(--transition-fast);
    }

    .navbar-floating .btn-primary:hover {
        background: var(--color-primary-light);
        color: white;
        transform: translateY(-1px);
    }

    /* User Profile Section */
    .navbar-floating .navbar-brand.profile-link {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.3rem 0.6rem;
        border-radius: var(--radius-sm);
        transition: var(--transition-fast);
    }

    .navbar-floating img.rounded-circle {
        width: 34px;
        height: 34px;
        object-fit: cover;
    }

    .navbar-floating span.fw-semibold {
        font-size: var(--font-size-dropdown);
        color: var(--color-text-primary);
    }

    /* Notification Badge */
    .navbar-floating .notif-badge {
        background: var(--color-danger);
        width: 18px;
        height: 18px;
        font-size: var(--font-size-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        font-weight: var(--font-weight-semibold);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    /* ===== TABLET STYLES (768px - 1099px) ===== */
    @media (max-width: 1099px) {
        .navbar-floating {
            width: 92vw;
            padding: 0.35rem 1rem;
            height: 60px;
            max-width: 1000px;
        }

        .navbar-floating .nav-link {
            padding: 0.35rem 0.7rem !important;
            font-size: 0.85rem;
        }

        .navbar-floating .navbar-nav {
            gap: 1.2rem;
        }

        .navbar-floating span.fw-semibold {
            font-size: 0.8rem;
        }

        .navbar-floating .navbar-brand span {
            font-size: 0.98rem;
        }
    }

    /* ===== MOBILE STYLES (<768px) ===== */
    @media (max-width: 767px) {
        .navbar-floating {
            width: 94vw;
            padding: 0.3rem 0.8rem;
            height: 55px;
            max-width: 100%;
            max-width: calc(100vw - 1rem);
        }

        .navbar-floating .navbar-brand img {
            height: 28px;
        }

        .navbar-floating .navbar-brand span {
            font-size: 0.95rem;
        }

        .navbar-floating .nav-link {
            padding: 0.3rem 0.6rem !important;
            font-size: 0.85rem;
        }

        .navbar-floating .navbar-nav {
            gap: 0.5rem;
            width: 100%;
        }

        /* Hide username on mobile */
        .navbar-floating span.d-none.d-lg-inline {
            display: none !important;
        }

        .navbar-floating .dropdown-menu {
            min-width: 180px;
        }

        .navbar-floating .btn-primary {
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
        }

        /* Ensure full width for collapse */
        .navbar-floating .collapse {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            background: var(--color-bg-light);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 0.5rem;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
        }

        .navbar-floating .collapse.show {
            display: flex;
        }
    }

    /* ===== TABLET HORIZONTAL LAYOUT (<1100px) ===== */
    @media (max-width: 991px) {
        .navbar-toggler {
            border: none;
            outline: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
        }
    }

    /* ===== SCROLL EFFECT ===== */
    @media (min-width: 768px) {
        .navbar-floating {
            transition: var(--transition-ease);
        }
    }

    /* ===== FOCUS STATES (ACCESSIBILITY) ===== */
    .navbar-floating .nav-link:focus-visible,
    .navbar-floating .btn-primary:focus-visible {
        outline: 2px solid var(--color-primary);
        outline-offset: 2px;
    }

    .navbar-floating .dropdown-item:focus-visible {
        outline: 1px solid var(--color-primary);
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
    // ===== NAVBAR SCROLL EFFECT =====
    let lastScrollY = 0;
    const navbar = document.querySelector('.navbar-floating');
    
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }, { passive: true });
    }

    // ===== NOTIFICATION BADGE =====
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

    // ===== PROFILE PHOTO =====
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
