<footer class="bg-dark text-white mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <img src="{{ asset('img/logo_masjid.png') }}" alt="Logo" height="30" class="me-2" onerror="this.style.display='none'">
                    Masjid Nurul Huda
                </h5>
                <p class="text-white-50 small">
                    Sistem Digital Masjid Nurul Huda Nganjuk. Memakmurkan masjid melalui layanan digital yang modern dan transparan.
                </p>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="mb-1"><a href="{{ route('profil-masjid.show') }}" class="text-white-50 text-decoration-none">Profil Masjid</a></li>
                    <li class="mb-1"><a href="{{ route('berita.index') }}" class="text-white-50 text-decoration-none">Berita</a></li>
                    <li class="mb-1"><a href="{{ route('event.index') }}" class="text-white-50 text-decoration-none">Acara</a></li>
                    <li class="mb-1"><a href="{{ route('reservasi.index') }}" class="text-white-50 text-decoration-none">Sewa Fasilitas</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Kontak</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Nganjuk, Jawa Timur</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i>-</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@masjidnurulhuda.com</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary mt-4">
        <div class="text-center text-white-50 small">
            &copy; {{ date('Y') }} Masjid Nurul Huda. Dibuat dengan ❤️ menggunakan Laravel.
        </div>
    </div>
</footer>
