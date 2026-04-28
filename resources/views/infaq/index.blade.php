@extends('layouts.app')

@section('title', 'Infaq & Shadaqah - Masjid Nurul Huda')

@push('styles')
<style>
    /* ===== HERO SECTION ===== */
    .infaq-hero {
        min-height: 85vh;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        overflow: hidden;
    }

    .infaq-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.85) 0%, rgba(59, 91, 219, 0.85) 100%);
        z-index: 1;
    }

    .infaq-hero-content {
        position: relative;
        z-index: 2;
        color: white;
        max-width: 600px;
    }

    .infaq-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.1;
        letter-spacing: -1px;
    }

    .infaq-hero p {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        line-height: 1.6;
    }

    .btn-infaq-cta {
        background: white;
        color: #2563eb;
        border: none;
        padding: 12px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        display: inline-block;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-infaq-cta:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        color: #2563eb;
    }

    /* ===== TATA CARA SECTION ===== */
    .infaq-tata-cara {
        padding: 5rem 0;
        background: #f8f9ff;
    }

    .section-title-infaq {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
        text-align: center;
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .section-title-infaq::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 4px;
        background: #2563eb;
        border-radius: 2px;
    }

    .section-desc {
        text-align: center;
        color: #6b7280;
        margin-bottom: 3rem;
        font-size: 1.05rem;
    }

    .step-container {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 3rem;
        position: relative;
        gap: 1.5rem;
    }

    .step-item {
        flex: 1;
        text-align: center;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .step-item:nth-child(1) { animation-delay: 0.1s; }
    .step-item:nth-child(2) { animation-delay: 0.2s; }
    .step-item:nth-child(3) { animation-delay: 0.3s; }
    .step-item:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .step-badge {
        width: 50px;
        height: 50px;
        background: #2563eb;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.3rem;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    }

    .step-icon-ring {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #F59E0B 0%, #FBBF24 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 1rem auto;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.25);
    }

    .step-icon-ring i {
        color: white;
        font-size: 2.5rem;
    }

    .step-label {
        font-weight: 700;
        color: #1f2937;
        font-size: 1.1rem;
    }

    .step-connector {
        position: absolute;
        top: 60px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(to right, transparent, #2563eb, #2563eb, transparent);
        z-index: 0;
    }

    @media (max-width: 768px) {
        .step-container {
            flex-wrap: wrap;
        }

        .step-item {
            flex: 0 0 48%;
        }

        .step-connector {
            display: none;
        }

        .infaq-hero h1 {
            font-size: 2rem;
        }

        .infaq-hero p {
            font-size: 1rem;
        }
    }

    /* ===== REKENING SECTION ===== */
    .infaq-rekening {
        padding: 5rem 0;
        background: white;
    }

    .rekening-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .rekening-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .rekening-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.15);
    }

    .qris-card {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
    }

    .qris-card:hover {
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.3);
    }

    .qris-image {
        width: 100%;
        max-width: 250px;
        height: auto;
        margin: 1rem auto;
        border-radius: 8px;
        background: white;
        padding: 1rem;
    }

    .qris-label {
        font-size: 0.9rem;
        font-weight: 600;
        opacity: 0.95;
        margin-top: 1rem;
        text-align: center;
    }

    .bank-logo {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .bank-name {
        font-weight: 700;
        font-size: 1.2rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .bank-account {
        background: #f3f4f6;
        padding: 1rem;
        border-radius: 8px;
        margin: 1rem 0;
        word-break: break-all;
        color: #1f2937;
        font-weight: 500;
    }

    .bank-owner {
        color: #6b7280;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .btn-copy {
        background: #2563eb;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
    }

    .btn-copy:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
    }

    .btn-copy.copied {
        background: #10b981;
    }

    /* ===== LAPORAN SECTION ===== */
    .infaq-laporan {
        padding: 5rem 0;
        background: #f8f9ff;
    }

    .laporan-table {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-top: 2rem;
    }

    .laporan-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .laporan-table thead {
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
    }

    .laporan-table th {
        padding: 1.2rem;
        text-align: left;
        font-weight: 700;
    }

    .laporan-table td {
        padding: 1.2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .laporan-table tbody tr:hover {
        background: #f8f9ff;
    }

    .total-row {
        background: #f0f4ff;
        font-weight: 700;
        color: #2563eb;
    }

    .jumlah-cell {
        color: #059669;
        font-weight: 700;
    }

    .btn-lihat-semua {
        background: #2563eb;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-top: 1.5rem;
    }

    .btn-lihat-semua:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        color: white;
    }

    /* ===== FIXED CTA BAR ===== */
    .infaq-cta-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, #3B5BDB 0%, #2563eb 100%);
        color: white;
        padding: 1rem;
        text-align: center;
        z-index: 1000;
        box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
        animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
        }
        to {
            transform: translateY(0);
        }
    }

    .infaq-cta-bar .btn {
        background: white;
        color: #2563eb;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }

    .infaq-cta-bar .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        color: #2563eb;
    }

    body {
        padding-bottom: 70px;
    }

    @media (max-width: 576px) {
        .infaq-cta-bar {
            padding: 0.75rem 0.5rem;
        }

        .infaq-cta-bar .btn {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }

        .section-title-infaq {
            font-size: 1.75rem;
        }

        .laporan-table th,
        .laporan-table td {
            padding: 0.75rem;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')

{{-- HERO SECTION --}}
<section class="infaq-hero" style="background-image: url('{{ asset('img/ms3.png') }}');">
    <div class="infaq-hero-content" data-aos="fade-up">
        <h1>Infaq & Shadaqah</h1>
        <p>Tunaikan Infaq Anda, Alirkan Kebaikan & Berkah</p>
        <button class="btn-infaq-cta" onclick="document.getElementById('rekening-section').scrollIntoView({behavior: 'smooth'});">
            <i class="bi bi-heart-fill me-2"></i>Infaq Sekarang
        </button>
    </div>
</section>

{{-- TATA CARA SECTION --}}
<section class="infaq-tata-cara">
    <div class="container">
        <h2 class="section-title-infaq" data-aos="fade-up">TATA CARA INFAQ</h2>
        <p class="section-desc" data-aos="fade-up" data-aos-delay="100">
            Ikuti langkah-langkah mudah berikut untuk menyalurkan kebaikan Anda
        </p>

        <div class="step-container" data-aos="fade-up" data-aos-delay="200">
            <div class="step-item">
                <div class="step-badge">1</div>
                <div class="step-icon-ring">
                    <i class="bi bi-credit-card-2-back"></i>
                </div>
                <p class="step-label">PILIH METODE</p>
            </div>

            <div class="step-item">
                <div class="step-badge">2</div>
                <div class="step-icon-ring">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <p class="step-label">TRANSFER DANA</p>
            </div>

            <div class="step-item">
                <div class="step-badge">3</div>
                <div class="step-icon-ring">
                    <i class="bi bi-smartphone"></i>
                </div>
                <p class="step-label">KONFIRMASI</p>
            </div>

            <div class="step-item">
                <div class="step-badge">4</div>
                <div class="step-icon-ring">
                    <i class="bi bi-hand-thumbs-up"></i>
                </div>
                <p class="step-label">DITERIMA</p>
            </div>

            <div class="step-connector"></div>
        </div>
    </div>
</section>

{{-- REKENING & QRIS SECTION --}}
<section class="infaq-rekening" id="rekening-section">
    <div class="container">
        <h2 class="section-title-infaq" data-aos="fade-up">REKENING & QRIS RESMI</h2>

        @if($rekenings->count() > 0)
            <div class="rekening-grid">
                {{-- QRIS CARD --}}
                @php
                    $qrisRekening = $rekenings->whereNotNull('qris_image')->first();
                @endphp

                @if($qrisRekening)
                    <div class="rekening-card qris-card" data-aos="fade-up">
                        <div style="text-align: center;">
                            <h3 style="font-weight: 700; margin-bottom: 1rem;">SCAN QRIS</h3>
                            @if($qrisRekening->qris_url)
                                <img src="{{ $qrisRekening->qris_url }}" alt="QRIS Code" class="qris-image">
                            @endif
                            <p class="qris-label">SCAN QRIS UNTUK INFAQ MUDAH</p>
                        </div>
                    </div>
                @endif

                {{-- BANK CARDS --}}
                @foreach($rekenings as $rekening)
                    <div class="rekening-card" data-aos="fade-up">
                        <div class="bank-logo text-center">
                            @if(str_contains($rekening->nama_bank, 'Mandiri'))
                                <i class="bi bi-bank2" style="color: #FFA600;"></i>
                            @elseif(str_contains($rekening->nama_bank, 'BSI'))
                                <i class="bi bi-bank2" style="color: #4285F4;"></i>
                            @else
                                <i class="bi bi-bank2" style="color: #2563eb;"></i>
                            @endif
                        </div>

                        <h3 class="bank-name">{{ $rekening->nama_bank }}</h3>

                        <div class="bank-account">
                            {{ $rekening->nomor_rekening }}
                        </div>

                        <button class="btn-copy" onclick="copyToClipboard('{{ $rekening->nomor_rekening }}', this)">
                            <i class="bi bi-clipboard me-1"></i>Salin No. Rek
                        </button>

                        <p class="bank-owner">
                            <i class="bi bi-person-circle me-1"></i>
                            Atas Nama: <strong>{{ $rekening->nama_pemilik }}</strong>
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mt-4" data-aos="fade-up">
                <i class="bi bi-info-circle me-2"></i>
                Rekening infaq belum tersedia. Silakan hubungi administrator.
            </div>
        @endif
    </div>
</section>

{{-- LAPORAN DANA SECTION --}}
<section class="infaq-laporan">
    <div class="container">
        <h2 class="section-title-infaq" data-aos="fade-up">LAPORAN DANA INFAQ</h2>

        {{-- SUMMARY CARDS --}}
        <div class="row mt-4">
            <div class="col-md-4 mb-3" data-aos="fade-up">
                <div class="card" style="border: none; border-radius: 16px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-check" style="font-size: 2rem; color: #2563eb;"></i>
                        <p class="text-muted small mt-2">Dana Bulan Ini</p>
                        <h3 style="color: #2563eb; font-weight: 700;">
                            Rp {{ number_format((float) $totalBulanIni, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card" style="border: none; border-radius: 16px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="card-body text-center">
                        <i class="bi bi-graph-up" style="font-size: 2rem; color: #059669;"></i>
                        <p class="text-muted small mt-2">Total Dana Keseluruhan</p>
                        <h3 style="color: #059669; font-weight: 700;">
                            Rp {{ number_format((float) $totalKeseluruhan, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card" style="border: none; border-radius: 16px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                    <div class="card-body text-center">
                        <i class="bi bi-hash" style="font-size: 2rem; color: #F59E0B;"></i>
                        <p class="text-muted small mt-2">Jumlah Transaksi</p>
                        <h3 style="color: #F59E0B; font-weight: 700;">{{ $jumlahTransaksi }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- LAPORAN TABLE --}}
        @if($laporanTerbaru->count() > 0)
            <div class="laporan-table" data-aos="fade-up" data-aos-delay="100">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporanTerbaru as $laporan)
                            <tr>
                                <td>{{ $laporan->tanggal->format('d M Y') }}</td>
                                <td>{{ $laporan->judul }}</td>
                                <td class="text-end jumlah-cell">Rp {{ number_format((float) $laporan->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <a href="#" class="btn-lihat-semua">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Lihat Laporan Lengkap
                </a>
            </div>
        @else
            <div class="alert alert-info mt-4" data-aos="fade-up">
                <i class="bi bi-info-circle me-2"></i>
                Belum ada laporan dana infaq.
            </div>
        @endif
    </div>
</section>

{{-- FIXED CTA BAR --}}
<div class="infaq-cta-bar">
    <button class="btn" onclick="document.getElementById('rekening-section').scrollIntoView({behavior: 'smooth'});">
        <i class="bi bi-heart-fill me-2"></i>INFAQ SEKARANG
    </button>
</div>

@endsection

@push('scripts')
<script>
    function copyToClipboard(text, button) {
        navigator.clipboard.writeText(text).then(function() {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check-circle me-1"></i>Tersalin!';
            button.classList.add('copied');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('copied');
            }, 2000);
        }).catch(function(err) {
            alert('Gagal menyalin: ' + err);
        });
    }
</script>
@endpush
