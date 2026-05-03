<!-- Instagram Section Component - Upgraded UI -->
<section style="padding: 80px 0; background: linear-gradient(180deg, #f8f9ff 0%, #ffffff 100%);">
    <div class="container">
        <div class="row align-items-center gy-5 flex-lg-row-reverse">

            <!-- RIGHT: Text Content (appears RIGHT on desktop) -->
            <div class="col-lg-5 col-md-12" data-aos="fade-left" data-aos-duration="800">

                <span style="
                    display: inline-block;
                    background: #fff0f6;
                    color: #e1306c;
                    font-size: 0.78rem;
                    font-weight: 700;
                    letter-spacing: 2px;
                    text-transform: uppercase;
                    padding: 6px 16px;
                    border-radius: 50px;
                    margin-bottom: 16px;">
                    📸 Instagram
                </span>

                <h2 style="
                    font-size: clamp(1.5rem, 2.5vw, 2rem);
                    font-weight: 800;
                    color: #1a1a2e;
                    line-height: 1.3;
                    margin-bottom: 16px;">
                    Follow Instagram<br>Masjid Nurul Huda.
                </h2>

                <p style="
                    color: #6b7280;
                    line-height: 1.9;
                    font-size: 0.95rem;
                    margin-bottom: 28px;">
                    Ikuti terus tayangan terbaru dari postingan reels, feeds, dan story Instagram Masjid Nurul Huda.
                </p>

                <!-- Stats row -->
                <div style="
                    display: flex;
                    gap: 24px;
                    margin-bottom: 28px;
                    padding: 16px 0;
                    border-top: 1px solid #f0f0f0;
                    border-bottom: 1px solid #f0f0f0;">
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

                <!-- Instagram gradient button -->
                <a href="{{ config('masjid.instagram.profile_url') }}"
                   target="_blank" rel="noopener noreferrer"
                   style="
                     display: inline-flex;
                     align-items: center;
                     gap: 10px;
                     background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
                     color: white;
                     padding: 12px 28px;
                     border-radius: 50px;
                     font-weight: 700;
                     font-size: 0.9rem;
                     text-decoration: none;
                     transition: all 0.3s ease;
                     box-shadow: 0 4px 15px rgba(220,39,67,0.3);
                     border: none;
                     cursor: pointer;">
                    <i class="bi bi-instagram" style="font-size: 1.2rem;"></i>
                    IKUTI KAMI
                </a>

                <!-- Username badge -->
                <div style="margin-top: 14px;">
                    <a href="{{ config('masjid.instagram.profile_url') }}"
                       target="_blank" rel="noopener noreferrer"
                       style="
                         color: #6b7280;
                         font-size: 0.82rem;
                         text-decoration: none;
                         display: inline-flex;
                         align-items: center;
                         gap: 6px;">
                        <i class="bi bi-at"></i>
                        {{ config('masjid.instagram.username') }}
                    </a>
                </div>

            </div>

            <!-- LEFT: Instagram Embed (appears LEFT on desktop) -->
            <div class="col-lg-7 col-md-12" data-aos="fade-right" data-aos-duration="900">
                <div style="
                    border-radius: 20px;
                    overflow: hidden;
                    width: 100%;
                    height: 480px;
                    background: white;
                    box-shadow: 0 20px 60px rgba(220,39,67,0.12);
                    border: 3px solid rgba(220,39,67,0.08);">
                    <iframe
                        src="{{ config('masjid.instagram.embed_url') }}"
                        width="100%"
                        height="100%"
                        frameborder="0"
                        scrolling="no"
                        allowtransparency="true"
                        loading="lazy"
                        title="Instagram Masjid Nurul Huda"
                        style="border: none; overflow: hidden;">
                    </iframe>
                </div>
                <!-- Instagram profile chip below embed -->
                <div style="
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-top: 16px;
                    padding: 12px 16px;
                    background: #fff8f9;
                    border-radius: 12px;">
                    <i class="bi bi-instagram" style="
                       background: linear-gradient(45deg,#f09433,#bc1888);
                       background-clip: text;
                       -webkit-background-clip: text;
                       -webkit-text-fill-color: transparent;
                       font-size: 1.5rem;"></i>
                    <div>
                        <div style="font-weight: 700; font-size: 0.9rem; color: #1a1a2e;">
                            {{ config('masjid.instagram.username') }}
                        </div>
                        <div style="font-size: 0.78rem; color: #6b7280;">
                            2.368 pengikut · instagram.com
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script async defer src="https://www.instagram.com/embed.js"></script>
@endpush

