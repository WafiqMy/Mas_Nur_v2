@extends('layouts.app')

@section('title', 'Berita - Masjid Nurul Huda')

@section('content')
@php
    $sessionUser = session('user');
    $isAdmin = ($sessionUser['role'] ?? '') === 'admin';
    $BASE_IMG = config('app.api_base_url');
@endphp

<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Berita Masjid</h2>
                <p class="text-muted mb-0">Informasi terkini dari Masjid Nurul Huda</p>
            </div>
            @if($isAdmin)
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Berita
            </a>
            @endif
        </div>
    </div>
</div>

<div class="container mb-5">
    @if(!empty($berita))
    <div class="row g-4">
        @foreach($berita as $b)
        @php
            $foto = $b['foto_berita'] ?? '';
            if ($foto && !str_starts_with($foto, 'http')) {
                $foto = $BASE_IMG . '/uploads/berita/' . $foto;
            }
            $foto = $foto ?: 'https://via.placeholder.com/400x200?text=No+Image';
            $idBerita = $b['id_berita'] ?? 0;
        @endphp
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden"
                 style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <img src="{{ $foto }}" class="card-img-top" alt="{{ $b['judul_berita'] ?? '' }}"
                     style="height: 200px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/400x200?text=No+Image'">
                <div class="card-body p-4">
                    <p class="text-muted small mb-2">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ isset($b['tanggal_berita']) ? date('d M Y', strtotime($b['tanggal_berita'])) : '-' }}
                        <span class="ms-2">
                            <i class="bi bi-person me-1"></i>{{ $b['username'] ?? 'Admin' }}
                        </span>
                    </p>
                    <h5 class="fw-bold mb-2">
                        {{ \Illuminate\Support\Str::limit($b['judul_berita'] ?? '', 65) }}
                    </h5>
                    <p class="text-muted small">
                        {{ \Illuminate\Support\Str::limit(strip_tags($b['isi_berita'] ?? ''), 100) }}
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('berita.show', $idBerita) }}" class="btn btn-sm btn-primary">
                        Baca Selengkapnya
                    </a>
                    @if($isAdmin)
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.berita.edit', $idBerita) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.berita.destroy', $idBerita) }}" method="POST"
                              onsubmit="return confirm('Hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-newspaper display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada berita yang dipublikasikan.</p>
    </div>
    @endif
</div>
@endsection
