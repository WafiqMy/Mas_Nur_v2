@extends('layouts.publikasi')
@section('title', 'Publikasi - ' . ($profil->nama_masjid ?? 'Masjid Nurul Huda'))

@push('styles')
<style>
html, body { margin: 0; padding: 0; background: #000; overflow-x: hidden; }

/* ===== SETIAP POSTER = FULL LAYAR ===== */
.poster-slide {
    width: 100vw;
    height: calc(100vh - 62px); /* tinggi layar dikurangi navbar */
    position: relative;
    overflow: hidden;
    cursor: pointer;
    background: #000;
}

.poster-slide img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* tampilkan poster utuh tanpa crop */
    display: block;
    transition: transform 0.4s ease;
}

.poster-slide:hover img {
    transform: scale(1.02);
}

/* Overlay info di bawah poster */
.poster-info {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%);
    color: white;
    padding: 3rem 2rem 1.5rem;
    opacity: 0;
    transition: opacity 0.3s;
}
.poster-slide:hover .poster-info { opacity: 1; }
.poster-info .p-title { font-weight: 700; font-size: 1.1rem; margin-bottom: 0.3rem; font-family: 'Poppins', sans-serif; }
.poster-info .p-desc  { font-size: 0.88rem; opacity: 0.85; font-family: 'Poppins', sans-serif; }

/* Nomor poster */
.poster-num {
    position: absolute;
    top: 14px; right: 16px;
    background: rgba(0,0,0,0.5);
    color: white; font-size: 0.8rem; font-weight: 600;
    padding: 4px 10px; border-radius: 20px;
    font-family: 'Poppins', sans-serif;
}

/* Divider antar poster */
.poster-divider {
    width: 100%; height: 4px;
    background: linear-gradient(135deg, #1e3a5f, #2563eb);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    width: 100vw; height: calc(100vh - 62px);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    color: #9ca3af; background: #f8f9ff;
    font-family: 'Poppins', sans-serif;
}

/* ===== LIGHTBOX ===== */
.lightbox-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.97); z-index: 9999;
    align-items: center; justify-content: center;
}
.lightbox-overlay.show { display: flex; }
.lightbox-inner {
    max-width: 95vw; max-height: 95vh;
    display: flex; flex-direction: column; align-items: center;
}
.lightbox-inner img {
    max-width: 100%; max-height: 88vh;
    object-fit: contain;
    border-radius: 4px;
}
.lightbox-caption {
    color: white; margin-top: 0.75rem;
    font-size: 1rem; font-weight: 600;
    font-family: 'Poppins', sans-serif; text-align: center;
}
.lightbox-close {
    position: fixed; top: 16px; right: 20px;
    color: white; font-size: 2.5rem; cursor: pointer;
    z-index: 10000; line-height: 1; font-family: sans-serif;
    transition: transform 0.2s;
}
.lightbox-close:hover { transform: scale(1.2); }
.lightbox-nav {
    position: fixed; top: 50%; transform: translateY(-50%);
    color: white; background: rgba(255,255,255,0.15);
    border: none; width: 52px; height: 52px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; cursor: pointer; z-index: 10000;
    transition: background 0.2s;
}
.lightbox-nav:hover { background: rgba(255,255,255,0.3); }
.lightbox-prev { left: 12px; }
.lightbox-next { right: 12px; }
</style>
@endpush

@section('content')

@if($posters->count() > 0)
    @foreach($posters as $i => $poster)

        {{-- Setiap poster full layar --}}
        <div class="poster-slide" onclick="openLightbox({{ $i }})">
            <img src="{{ $poster->foto_url }}"
                 alt="{{ $poster->judul }}"
                 loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                 onerror="this.src='https://via.placeholder.com/800x1000?text=No+Image'">

            <span class="poster-num">{{ $i + 1 }} / {{ $posters->count() }}</span>

            <div class="poster-info">
                <div class="p-title">{{ $poster->judul }}</div>
                @if($poster->keterangan)
                    <div class="p-desc">{{ $poster->keterangan }}</div>
                @endif
            </div>
        </div>

        @if(!$loop->last)
            <div class="poster-divider"></div>
        @endif

    @endforeach
@else
    <div class="empty-state">
        <i class="bi bi-megaphone" style="font-size:4rem;margin-bottom:1rem;opacity:0.4;"></i>
        <h5 style="font-weight:600;">Belum Ada Publikasi</h5>
        <p style="font-size:0.9rem;margin-top:0.5rem;">Informasi dan poster akan ditampilkan di sini.</p>
    </div>
@endif

{{-- LIGHTBOX --}}
<div class="lightbox-overlay" id="lightbox" onclick="handleOverlayClick(event)">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation();prevPoster()">
        <i class="bi bi-chevron-left"></i>
    </button>
    <div class="lightbox-inner">
        <img src="" id="lightboxImg" alt="">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
    <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation();nextPoster()">
        <i class="bi bi-chevron-right"></i>
    </button>
</div>

@endsection

@push('scripts')
<script>
const posters = @json($posters->map(fn($p) => ['src' => $p->foto_url, 'judul' => $p->judul]));
let current = 0;

function openLightbox(index) {
    current = index;
    showPoster();
    document.getElementById('lightbox').classList.add('show');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('show');
    document.body.style.overflow = '';
}
function showPoster() {
    document.getElementById('lightboxImg').src = posters[current].src;
    document.getElementById('lightboxCaption').textContent = posters[current].judul;
}
function prevPoster() {
    current = (current - 1 + posters.length) % posters.length;
    showPoster();
}
function nextPoster() {
    current = (current + 1) % posters.length;
    showPoster();
}
function handleOverlayClick(e) {
    if (e.target === document.getElementById('lightbox')) closeLightbox();
}
document.addEventListener('keydown', e => {
    if (!document.getElementById('lightbox').classList.contains('show')) return;
    if (e.key === 'Escape')     closeLightbox();
    if (e.key === 'ArrowLeft')  prevPoster();
    if (e.key === 'ArrowRight') nextPoster();
});
</script>
@endpush
