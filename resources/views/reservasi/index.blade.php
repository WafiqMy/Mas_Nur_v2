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
    $sessionUser = session('user');
    $isAdmin = strtolower(session('user')['role'] ?? '') === 'admin';
@endphp

<div class="page-header" style="background:linear-gradient(135deg,#1e3a5f 0%,#2563eb 100%);padding:3.5rem 0 2.5rem;color:white;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
            <div>
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,0.5);">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active text-white">Sewa Fasilitas</li>
                    </ol>
                </nav>
                <h1 style="font-size:2.5rem;font-weight:800;" class="mb-1">Penyewaan Fasilitas</h1>
                <p class="mb-0" style="opacity:0.85;">
                    Masjid Nurul Huda menyediakan berbagai fasilitas yang dapat disewa oleh jamaah dan masyarakat umum.
                </p>
            </div>
            @if(session('user') && strtolower(session('user')['role'] ?? '') === 'admin')
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.reservasi.index') }}" class="btn btn-light fw-semibold">
                    <i class="bi bi-box-seam me-1"></i>Kelola Barang
                </a>
                <a href="{{ route('admin.reservasi.create') }}" class="btn btn-light fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Barang
                </a>
                <a href="{{ route('admin.reservasi.permintaan') }}" class="btn btn-warning fw-semibold">
                    <i class="bi bi-clipboard-check me-1"></i>Permintaan Sewa
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="container mb-5" style="max-width: 1100px;">

    @foreach([
        ['label' => 'Layanan Penyewaan Gedung',        'data' => $gedung],
        ['label' => 'Layanan Penyewaan Alat Multimedia','data' => $multimedia],
        ['label' => 'Layanan Penyewaan Alat Banjari',  'data' => $musik]
    ] as $kategori)
    @if($kategori['data']->count() > 0)
    <div class="mb-5">
        <h3 class="section-heading">{{ $kategori['label'] }}</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($kategori['data'] as $b)
            @php
                $idBarang = $b->id;
                $gambar   = $b->gambar_url;
            @endphp
            <div class="col">
                <div class="card card-barang h-100">
                    <img src="{{ $gambar }}" alt="{{ $b->nama_barang }}"
                         onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                    <div class="card-body px-4 py-4 d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2 text-capitalize">{{ $b->nama_barang }}</h5>
                        <div class="d-flex justify-content-between align-items-center small text-muted mb-3">
                            <span><i class="bi bi-box-seam me-1"></i>Stok: {{ $b->jumlah }}</span>
                            <span class="price-tag">
                                Rp {{ number_format((float)$b->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-auto d-grid gap-2">
                            <a href="{{ route('reservasi.barang.show', $idBarang) }}"
                               class="btn btn-sm btn-sewa text-white">
                                Detail & Sewa
                            </a>
                            @if(session('user') && strtolower(session('user')['role'] ?? '') === 'admin')
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.reservasi.edit', $idBarang) }}"
                                   class="btn btn-sm btn-outline-warning flex-fill">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.reservasi.destroy', $idBarang) }}" method="POST"
                                      onsubmit="return confirm('Hapus barang ini?')" class="flex-fill">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                            @endif
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
