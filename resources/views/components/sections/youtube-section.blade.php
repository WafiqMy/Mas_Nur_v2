<!-- YouTube Section Component - Upgraded UI -->
<section style="padding: 80px 0; background: #ffffff;">
    <div class="container">
        <div class="row align-items-center gy-5">

            <!-- LEFT: Text Content -->
            <div class="col-lg-5 col-md-12" data-aos="fade-right" data-aos-duration="800">

                <!-- Decorative pill label -->
                <span style="
                    display: inline-block;
                    background: #eef4ff;
                    color: #2563eb;
                    font-size: 0.78rem;
                    font-weight: 700;
                    letter-spacing: 2px;
                    text-transform: uppercase;
                    padding: 6px 16px;
                    border-radius: 50px;
                    margin-bottom: 16px;">
                    ▶ Subscribe
                </span>

                <h2 style="
                    font-size: clamp(1.5rem, 2.5vw, 2rem);
                    font-weight: 800;
                    color: #1a1a2e;
                    line-height: 1.3;
                    margin-bottom: 16px;">
                    Video-video Masjid Nurul Huda<br>
                    di Channel Youtube.
                </h2>

                <p style="
                    color: #6b7280;
                    line-height: 1.9;
                    font-size: 0.95rem;
                    margin-bottom: 28px;">
                    Ikuti terus tayangan terbaru dari channel Youtube Masjid Nurul Huda dengan cara berlangganan Gratis!
                </p>

                <!-- Stats row (visual appeal) -->
                <div style="
                    display: flex;
                    gap: 24px;
                    margin-bottom: 28px;
                    padding: 16px 0;
                    border-top: 1px solid #f0f0f0;
                    border-bottom: 1px solid #f0f0f0;">
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

                <!-- YouTube Button -->
                <a href="{{ config('masjid.youtube.channel_url') }}"
                   target="_blank" rel="noopener noreferrer"
                   style="
                     display: inline-flex;
                     align-items: center;
                     gap: 10px;
                     background: #FF0000;
                     color: white;
                     padding: 12px 28px;
                     border-radius: 50px;
                     font-weight: 700;
                     font-size: 0.9rem;
                     text-decoration: none;
                     transition: all 0.3s ease;
                     box-shadow: 0 4px 15px rgba(255,0,0,0.3);
                     border: none;
                     cursor: pointer;">
                    <i class="bi bi-youtube" style="font-size: 1.2rem;"></i>
                    BERLANGGANAN
                </a>

            </div>

            <!-- RIGHT: Video Embed -->
            <div class="col-lg-7 col-md-12" data-aos="fade-left" data-aos-duration="900">
                <!-- Premium video frame with glow effect -->
                <div style="
                    position: relative;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 20px 60px rgba(37,99,235,0.2);
                    border: 3px solid rgba(37,99,235,0.1);">
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="{{ config('masjid.youtube.embed_url') }}"
                            title="{{ config('masjid.youtube.title') }}"
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                            style="border:0;">
                        </iframe>
                    </div>
                </div>
                <!-- Channel info below video -->
                <div style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-top: 16px;
                    padding: 12px 16px;
                    background: #f8f9ff;
                    border-radius: 12px;">
                    <i class="bi bi-youtube" style="color: #FF0000; font-size: 1.5rem;"></i>
                    <div>
                        <div style="font-weight: 700; font-size: 0.9rem; color: #1a1a2e;">
                            Masjid Besar Nurul Huda Official
                        </div>
                        <div style="font-size: 0.78rem; color: #6b7280;">
                            youtube.com/@masjidnurulhudanganjuk
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

