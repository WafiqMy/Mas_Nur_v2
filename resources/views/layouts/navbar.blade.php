@php
    $sessionUser = session('user');
    $isLoggedIn  = !empty($sessionUser);
    $isAdmin     = $isLoggedIn && ($sessionUser['role'] ?? '') === 'admin';
    $namaUser    = $sessionUser['nama'] ?? '';
    $usernameUser = $sessionUser['username'] ?? '';

    // URL gambar profil (dari API)
    $fotoUrl = 'https://ui-avatars.com/api/?name=' . urlencode($namaUser) . '&background=2563eb&color=fff&size=64';
@endphp

<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom shadow-sm" style="z-index: 1030;">
    <div class="container">

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
                    <a class="nav-link {{ request()->routeIs('reservasi.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('reservasi.index') }}">Sewa Fasilitas</a>
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
