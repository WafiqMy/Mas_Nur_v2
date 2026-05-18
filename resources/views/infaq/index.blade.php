@extends('layouts.app')
@section('title', 'Infaq & Shadaqah - Masjid Nurul Huda')

@push('styles')
<style>
/* ===== HERO ===== */
.infaq-hero {
    background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
    padding: 5rem 0 4rem; text-align: center; color: white;
}
.infaq-hero h1 { font-size: 3rem; font-weight: 800; margin-bottom: 0.75rem; }
.infaq-hero p  { font-size: 1.15rem; opacity: 0.9; max-width: 520px; margin: 0 auto 1.5rem; }

/* ===== RINGKASAN ===== */
.summary-section { background: #f8f9ff; padding: 3.5rem 0; }
.summary-card {
    background: white; border-radius: 16px; padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07); text-align: center;
    border-top: 4px solid transparent; transition: transform 0.3s;
}
.summary-card:hover { transform: translateY(-5px); }
.summary-card.masuk  { border-color: #10b981; }
.summary-card.keluar { border-color: #ef4444; }
.summary-card.saldo  { border-color: #2563eb; }
.summary-icon {
    width: 64px; height: 64px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; margin: 0 auto 1rem;
}
.icon-masuk  { background: #d1fae5; color: #059669; }
.icon-keluar { background: #fee2e2; color: #dc2626; }
.icon-saldo  { background: #dbeafe; color: #2563eb; }
.summary-label { color: #6b7280; font-size: 0.9rem; margin-bottom: 0.4rem; }
.summary-value { font-size: 1.4rem; font-weight: 800; }

/* ===== LAPORAN ===== */
.laporan-section { padding: 4rem 0; background: white; }
.section-title {
    font-size: 1.8rem; font-weight: 800; color: #1f2937;
    text-align: center; margin-bottom: 0.5rem;
}
.section-title::after {
    content: ''; display: block; width: 50px; height: 4px;
    background: #2563eb; border-radius: 2px; margin: 0.75rem auto 0;
}

/* Tabs */
.laporan-tabs .nav-link {
    border-radius: 10px 10px 0 0; font-weight: 600; color: #6b7280;
    border: none; padding: 0.7rem 1.5rem; font-size: 0.95rem;
}
.laporan-tabs .nav-link.active { background: white; color: #2563eb; border-bottom: 3px solid #2563eb; }

/* Table */
.laporan-table { border-radius: 0 0 14px 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.07); }
.laporan-table table { width: 100%; border-collapse: collapse; }
.laporan-table thead { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%); color: white; }
.laporan-table th { padding: 1rem 1.25rem; font-weight: 700; text-align: left; }
.laporan-table td { padding: 1rem 1.25rem; border-bottom: 1px solid #f3f4f6; }
.laporan-table tbody tr:hover { background: #f8f9ff; }
.laporan-table tbody tr:last-child td { border-bottom: none; }

.badge-masuk  { background: #d1fae5; color: #065f46; padding: 5px 12px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; white-space: nowrap; }
.badge-keluar { background: #fee2e2; color: #991b1b; padding: 5px 12px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; white-space: nowrap; }

/* ===== REKENING ===== */
.rekening-section { background: #f8f9ff; padding: 4rem 0; }
.rekening-card {
    background: white; border-radius: 16px; padding: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;
    transition: all 0.3s;
}
.rekening-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(37,99,235,0.15); }
.bank-number {
    background: #f3f4f6; padding: 0.75rem 1rem; border-radius: 8px;
    font-weight: 700; font-size: 1.1rem; letter-spacing: 1px; margin: 0.75rem 0;
}
.btn-copy {
    background: #2563eb; color: white; border: none;
    padding: 0.5rem 1.2rem; border-radius: 8px; font-weight: 600;
    cursor: pointer; transition: all 0.2s; font-size: 0.9rem;
}
.btn-copy:hover { background: #1d4ed8; }
.btn-copy.copied { background: #10b981; }

/* ===== TATA CARA ===== */
.tatacara-section { padding: 4rem 0; background: white; }
.step-card {
    text-align: center; padding: 1.5rem 1rem;
}
.step-num {
    width: 44px; height: 44px; background: #2563eb; color: white;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.1rem; margin: 0 auto 0.75rem;
}
.step-icon {
    width: 80px; height: 80px; background: linear-gradient(135deg,#f59e0b,#fbbf24);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: white; margin: 0 auto 0.75rem;
    box-shadow: 0 6px 18px rgba(245,158,11,0.25);
}

@media (max-width: 576px) {
    .infaq-hero h1 { font-size: 2rem; }
    .summary-value { font-size: 1.1rem; }
    .laporan-table th, .laporan-table td { padding: 0.75rem; font-size: 0.85rem; }
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<section class="infaq-hero">
    <div class="container" data-aos="fade-up">
        <h1><i class="bi bi-heart-fill me-2"></i>Infaq & Shadaqah</h1>
        <p>Tunaikan infaq Anda, alirkan kebaikan untuk kemakmuran masjid</p>
        <a href="#rekening-section" class="btn btn-light fw-700 px-4 py-2 rounded-pill"
           onclick="event.preventDefault();document.getElementById('rekening-section').scrollIntoView({behavior:'smooth'})">
            <i class="bi bi-heart-fill me-2 text-danger"></i>Infaq Sekarang
        </a>
        @if(session('user') && strtolower(session('user')['role'] ?? '') === 'admin')
        <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">
            <a href="{{ route('admin.infaq.dana.index') }}" class="btn btn-warning btn-sm fw-semibold">
                <i class="bi bi-cash-coin me-1"></i>Kelola Laporan Dana
            </a>
            <a href="{{ route('admin.infaq.rekening.index') }}" class="btn btn-light btn-sm fw-semibold">
                <i class="bi bi-bank2 me-1"></i>Kelola Rekening
            </a>
        </div>
        @endif
    </div>
</section>

{{-- RINGKASAN DANA --}}
<section class="summary-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">RINGKASAN DANA INFAQ</h2>
        <p class="text-center text-muted mt-3 mb-4" data-aos="fade-up">
            Laporan keuangan infaq masjid yang transparan dan dapat dipertanggungjawabkan
        </p>
        <div class="row g-3 justify-content-center">
            <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="summary-card masuk">
                    <div class="summary-icon icon-masuk"><i class="bi bi-arrow-down-circle-fill"></i></div>
                    <div class="summary-label">Total Dana Masuk</div>
                    <div class="summary-value" style="color:#059669;">
                        Rp {{ number_format($totalMasuk,0,',','.') }}
                    </div>
                    <div class="text-muted small mt-1">Bulan ini: Rp {{ number_format($totalMasukBulan,0,',','.') }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="summary-card keluar">
                    <div class="summary-icon icon-keluar"><i class="bi bi-arrow-up-circle-fill"></i></div>
                    <div class="summary-label">Total Dana Digunakan</div>
                    <div class="summary-value" style="color:#dc2626;">
                        Rp {{ number_format($totalKeluar,0,',','.') }}
                    </div>
                    <div class="text-muted small mt-1">Bulan ini: Rp {{ number_format($totalKeluarBulan,0,',','.') }}</div>
                </div>
            </div>
            <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="summary-card saldo">
                    <div class="summary-icon icon-saldo"><i class="bi bi-wallet2"></i></div>
                    <div class="summary-label">Saldo Dana Saat Ini</div>
                    <div class="summary-value" style="color:#2563eb;">
                        Rp {{ number_format($saldo,0,',','.') }}
                    </div>
                    <div class="text-muted small mt-1">Dana yang tersedia</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAPORAN TRANSPARAN --}}
<section class="laporan-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">LAPORAN KEUANGAN INFAQ</h2>
        <p class="text-center text-muted mt-3 mb-4" data-aos="fade-up">
            Setiap rupiah yang masuk dan digunakan tercatat dengan jelas
        </p>

        <ul class="nav laporan-tabs border-bottom mb-0" data-aos="fade-up">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#publik-masuk">
                    <i class="bi bi-arrow-down-circle me-1 text-success"></i>Dana Masuk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#publik-keluar">
                    <i class="bi bi-arrow-up-circle me-1 text-danger"></i>Dana Digunakan
                </a>
            </li>
        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="100">

            {{-- Tab Dana Masuk --}}
            <div class="tab-pane fade show active" id="publik-masuk">
                @if($laporanMasuk->count() > 0)
                    <div class="laporan-table">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:30%">Tanggal</th>
                                    <th>Keterangan</th>
                                    <th style="width:30%" class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporanMasuk as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->tanggal->format('d M Y') }}</div>
                                        <div class="text-muted small">{{ $item->tanggal->translatedFormat('l') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->judul }}</div>
                                        @if($item->keterangan)
                                            <div class="text-muted small">{{ $item->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <span class="badge-masuk">+ Rp {{ number_format((float)$item->jumlah,0,',','.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-center text-muted small mt-3">Menampilkan 10 data terbaru</p>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox display-4 d-block mb-2 opacity-50"></i>
                        <p>Belum ada laporan dana masuk</p>
                    </div>
                @endif
            </div>

            {{-- Tab Dana Keluar --}}
            <div class="tab-pane fade" id="publik-keluar">
                @if($laporanKeluar->count() > 0)
                    <div class="laporan-table">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width:30%">Tanggal</th>
                                    <th>Digunakan Untuk</th>
                                    <th style="width:30%" class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporanKeluar as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $item->tanggal->format('d M Y') }}</div>
                                        <div class="text-muted small">{{ $item->tanggal->translatedFormat('l') }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->keperluan }}</div>
                                        @if($item->keterangan)
                                            <div class="text-muted small">{{ $item->keterangan }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <span class="badge-keluar">- Rp {{ number_format((float)$item->jumlah,0,',','.') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="text-center text-muted small mt-3">Menampilkan 10 data terbaru</p>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox display-4 d-block mb-2 opacity-50"></i>
                        <p>Belum ada laporan penggunaan dana</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- TATA CARA --}}
<section class="tatacara-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">TATA CARA BERINFAQ</h2>
        <div class="row g-3 mt-3 justify-content-center">
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="0">
                <div class="step-card">
                    <div class="step-num">1</div>
                    <div class="step-icon" style="background:linear-gradient(135deg,#f59e0b,#fbbf24);">
                        <i class="bi bi-credit-card-2-back"></i>
                    </div>
                    <div class="fw-700 mb-1" style="font-weight:700;">Pilih Metode</div>
                    <div class="text-muted small">Transfer bank atau scan QRIS</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card">
                    <div class="step-num">2</div>
                    <div class="step-icon" style="background:linear-gradient(135deg,#f59e0b,#fbbf24);">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div class="fw-700 mb-1" style="font-weight:700;">Transfer Dana</div>
                    <div class="text-muted small">Kirim sesuai jumlah yang diinginkan</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card">
                    <div class="step-num">3</div>
                    <div class="step-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="fw-700 mb-1" style="font-weight:700;">Konfirmasi</div>
                    <div class="text-muted small">Simpan bukti transfer Anda</div>
                </div>
            </div>
            <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card">
                    <div class="step-num">4</div>
                    <div class="step-icon" style="background:linear-gradient(135deg,#25d366,#128c7e);">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div class="fw-700 mb-1" style="font-weight:700;">Hubungi Admin</div>
                    <div class="text-muted small mb-2">Kirim bukti via WhatsApp agar dapat dicatat & dilaporkan</div>
                    <a href="{{ $waUrl }}"
                       target="_blank" rel="noopener noreferrer"
                       class="btn btn-sm"
                       style="background:#25d366;color:white;border-radius:20px;font-weight:600;font-size:0.8rem;padding:5px 14px;">
                        <i class="bi bi-whatsapp me-1"></i>Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- REKENING & QRIS --}}
<section class="rekening-section" id="rekening-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">CARA BERINFAQ</h2>
        <p class="text-center text-muted mt-3 mb-4" data-aos="fade-up">
            Transfer ke rekening resmi masjid atau scan QRIS di bawah ini
        </p>

        @if($rekenings->count() > 0)
            <div class="row g-3 justify-content-center">
                @foreach($rekenings as $rekening)
                <div class="col-md-5" data-aos="fade-up">
                    <div class="rekening-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:48px;height:48px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-bank2 text-primary fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-700 fs-6" style="font-weight:700;">{{ $rekening->nama_bank }}</div>
                                <div class="text-muted small">a.n. {{ $rekening->nama_pemilik }}</div>
                            </div>
                        </div>
                        <div class="bank-number">{{ $rekening->nomor_rekening }}</div>
                        <button class="btn-copy" onclick="copyToClipboard('{{ $rekening->nomor_rekening }}', this)">
                            <i class="bi bi-clipboard me-1"></i>Salin Nomor Rekening
                        </button>
                        @if($rekening->qris_url)
                            <div class="mt-3 text-center">
                                <p class="fw-semibold small mb-2">atau Scan QRIS:</p>
                                <img src="{{ $rekening->qris_url }}" alt="QRIS"
                                     style="max-width:200px;border-radius:10px;border:2px solid #e5e7eb;">
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center mt-3">
                <i class="bi bi-info-circle me-2"></i>Rekening infaq belum tersedia. Hubungi pengurus masjid.
            </div>
        @endif
    </div>
</section>



@endsection

@push('scripts')
<script>
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Tersalin!';
        btn.classList.add('copied');
        setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2000);
    });
}
</script>
@endpush
