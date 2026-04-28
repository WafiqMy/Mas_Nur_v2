@extends('layouts.app')

@section('title', 'Acara & Kegiatan - Masjid Nurul Huda')

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
                <h2 class="fw-bold mb-1">Acara & Kegiatan</h2>
                <p class="text-muted mb-0">Jadwal kegiatan Masjid Nurul Huda</p>
            </div>
            @if($isAdmin)
            <a href="{{ route('admin.acara.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Acara
            </a>
            @endif
        </div>
    </div>
</div>

<div class="container mb-5">
    @if(!empty($events))
    <div class="row g-4">
        @foreach($events as $event)
        @php
            $gambar = $event['gambar_event'] ?? '';
            if ($gambar && !str_starts_with($gambar, 'http')) {
                $gambar = $BASE_IMG . '/uploads/kegiatan/' . $gambar;
            }
            $gambar = $gambar ?: 'https://via.placeholder.com/400x220?text=No+Image';
            $idEvent = $event['id_event'] ?? 0;
        @endphp
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden"
                 style="transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="position-relative">
                    <img src="{{ $gambar }}" class="card-img-top" alt="{{ $event['nama_event'] ?? '' }}"
                         style="height: 220px; object-fit: cover;"
                         onerror="this.src='https://via.placeholder.com/400x220?text=No+Image'">
                    @if(!empty($event['tanggal_event']))
                    <span class="position-absolute bottom-0 start-0 m-3 badge bg-primary">
                        <i class="bi bi-calendar3 me-1"></i>
                        {{ date('d M Y', strtotime($event['tanggal_event'])) }}
                    </span>
                    @endif
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">
                        {{ \Illuminate\Support\Str::limit($event['nama_event'] ?? '', 55) }}
                    </h5>
                    @if(!empty($event['lokasi_event']))
                    <p class="text-muted small mb-2">
                        <i class="bi bi-geo-alt me-1"></i>{{ $event['lokasi_event'] }}
                    </p>
                    @endif
                    <p class="text-muted small">
                        {{ \Illuminate\Support\Str::limit(strip_tags($event['deskripsi_event'] ?? ''), 90) }}
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-4 d-flex justify-content-between align-items-center">
                    <a href="{{ route('event.show', $idEvent) }}" class="btn btn-sm btn-outline-primary">
                        Detail Acara
                    </a>
                    @if($isAdmin)
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.acara.edit', $idEvent) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.acara.destroy', $idEvent) }}" method="POST"
                              onsubmit="return confirm('Hapus acara ini?')">
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
        <i class="bi bi-calendar-x display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada acara yang dijadwalkan.</p>
    </div>
    @endif
</div>
@endsection
