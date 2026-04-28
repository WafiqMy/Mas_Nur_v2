@extends('layouts.app')

@section('title', 'Sewa Fasilitas - Masjid Nurul Huda')

@push('styles')
<style>
    .page-header { background-color: #f3f4f6; padding: 4rem 0; margin-bottom: 3rem; }
    .header-title { color: #1f2937; font-weight: 700; font-size: 3rem; line-height: 1.2; }
    .title-border { border-left: 6px solid #2563eb; padding-left: 25px; display: inline-block; }
    .section-heading { font-weight: 700; font-size: 1.1rem; color: #1f2937; letter-spacing: 1px; text-transform: uppercase; border-bottom: 2px solid #2563eb; display: inline-block; padding-bottom: 5px; margin-bottom: 20px; }
    .card-barang { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
    .card-barang:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
    .card-barang img { height: 200px; object-fit: cover; border-radius: 12px 12px 0 0; }
    .price-tag { color: #2563eb; font-weight: 700; font-size: 1.1rem; }
    .btn-sewa { background-color: #2563eb; border: none; border-radius: 8px; color: #fff; font-weight: 600; transition: background 0.3s; }
    .btn-sewa:hover { background-color: #1d4ed8; color: #fff; }
</style>
@endpush

@section('content')
@php
    $BASE_IMG = config('app.api_base_url');
@endphp

<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h2 class="header-title">
                    <span class="title-border">Penyewaan Fasilitas</span>
                </h2>
                <p class="text-muted fs-5 mt-3" style="max-width: 700px;">
                    Masjid Nurul Huda menyediakan berbagai fasilitas yang dapat disewa oleh jamaah dan masyarakat umum.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5" style="max-width: 1100px;">

    @foreach([['label' => 'Layanan Penyewaan Gedung', 'data' => $gedung], ['label' => 'Layanan Penyewaan Alat Multimedia', 'data' => $multimedia], ['label' => 'Layanan Penyewaan Alat Banjari', 'data' => $musik]] as $kategori)
    @if(!empty($kategori['data']))
    <div class="mb-5">
        <h3 class="section-heading">{{ $kategori['label'] }}</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($kategori['data'] as $b)
            @php
                $gambar = $b['gambar'] ?? '';
                if ($gambar && $gambar !== 'default.png' && !str_starts_with($gambar, 'http')) {
                    $gambar = $BASE_IMG . '/uploads/persewaan/' . $gambar;
                } elseif (!$gambar || $gambar === 'default.png') {
                    $gambar = 'https://via.placeholder.com/300x200?text=No+Image';
                }
                $idBarang = $b['id_persewaan'] ?? $b['id'] ?? 0;
            @endphp
            <div class="col">
                <div class="card card-barang h-100">
                    <img src="{{ $gambar }}" alt="{{ $b['nama_barang'] ?? '' }}"
                         onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    <div class="card-body px-4 py-4 d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2 text-capitalize">{{ $b['nama_barang'] ?? '' }}</h5>
                        <div class="d-flex justify-content-between align-items-center small text-muted mb-3">
                            <span><i class="bi bi-box-seam me-1"></i>Stok: {{ $b['jumlah'] ?? 0 }}</span>
                            <span class="price-tag">
                                Rp {{ number_format((float)($b['harga'] ?? 0), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-auto d-grid">
                            <a href="{{ route('reservasi.barang.show', $idBarang) }}"
                               class="btn btn-sm btn-sewa text-white">
                                Detail & Sewa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach

    @if(empty($gedung) && empty($multimedia) && empty($musik))
    <div class="text-center py-5">
        <i class="bi bi-box-seam display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada fasilitas yang tersedia.</p>
    </div>
    @endif

</div>
@endsection
