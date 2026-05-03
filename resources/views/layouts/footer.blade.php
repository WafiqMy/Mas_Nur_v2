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

    .footer-desc {
        font-size: 0.9rem;
        line-height: 1.7;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .social-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 2px solid rgba(255,255,255,0.6);
        border-radius: 50%;
        color: white;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        background: transparent;
    }

    .social-btn:hover {
        background-color: white;
        color: #4a85ff;
        border-color: white;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .footer-heading {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: white;
        display: inline-block;
    }

    .footer-map {
        width: 100%;
        height: 200px;
        background-color: #e9ecef;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        border: 2px solid rgba(255,255,255,0.3);
    }

    .footer-map iframe {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }

    .sponsor-wrapper {
        background: white;
        padding: 15px 25px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .sponsor-logo {
        height: 45px;
        width: auto;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .sponsor-logo:hover {
        transform: scale(1.08);
    }

    .copyright-bar {
        background-color: #4270cc;
        color: rgba(255,255,255,0.85);
        padding: 15px 0;
        font-size: 0.85rem;
        font-family: 'Poppins', sans-serif;
        width: 100%;
        text-align: center;
    }

    @media (max-width: 768px) {
        .footer-section {
            padding: 40px 0 20px 0;
        }
        
        .social-btn {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .sponsor-wrapper {
            flex-wrap: wrap;
            gap: 15px;
            padding: 12px 20px;
        }

        .sponsor-logo {
            height: 40px;
        }
    }
</style>

<footer class="footer-section">
    <div class="container">
        <div class="row gy-5 justify-content-between align-items-start">

            <!-- COLUMN 1: Brand, Description, Social -->
            <div class="col-lg-4 col-md-6 text-center">
                <!-- Logo -->
                <img src="{{ asset('img/logo_masjid.png') }}" 
                     alt="Logo Masjid Nurul Huda"
                     class="footer-logo"
                     onerror="this.style.display='none'">

                <!-- Description -->
                <p class="footer-desc">
                    Website resmi Masjid Nurul Huda.<br>
                    Pusat informasi kegiatan, layanan umat, dan dakwah digital.
                </p>

                <!-- Social Media Icons -->
                <div style="display: flex; justify-content: center; gap: 8px; margin-top: 12px;">
                    <a href="{{ config('masjid.sosial.facebook') }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="social-btn" 
                       aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ config('masjid.sosial.youtube') }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="social-btn" 
                       aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="{{ config('masjid.sosial.instagram') }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="social-btn" 
                       aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="{{ config('masjid.sosial.tiktok') }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="social-btn" 
                       aria-label="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    <a href="{{ config('masjid.sosial.whatsapp') }}" 
                       target="_blank" rel="noopener noreferrer"
                       class="social-btn" 
                       aria-label="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- COLUMN 2: Google Maps Lokasi -->
            <div class="col-lg-4 col-md-6 text-center">
                <h6 class="footer-heading">Lokasi</h6>
                <div class="footer-map">
                    <iframe
                        src="{{ config('masjid.maps.embed_url') }}"
                        allowfullscreen=""
                        loading="lazy"
                        title="Lokasi Masjid Nurul Huda"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- COLUMN 3: Sponsor / Didukung Oleh -->
            <div class="col-lg-4 col-md-12 text-center">
                <h6 class="footer-heading">Didukung Oleh:</h6>
                <div class="sponsor-wrapper">
                    <img src="{{ asset('img/logo_polije.png') }}" 
                         alt="Politeknik Negeri Jember"
                         class="sponsor-logo"
                         onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/0/09/Politeknik_Negeri_Jember.png'">
                    <img src="{{ asset('img/logo_blu_speed.png') }}"
                         alt="BLU Speed"
                         class="sponsor-logo"
                         onerror="this.style.display='none'">
                </div>
            </div>

        </div>
    </div>
</footer>

<div class="copyright-bar">
    &copy; 2026 Masjid Nurul Huda by: Bewan. All Rights Reserved.
</div>


