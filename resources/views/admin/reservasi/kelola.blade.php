@extends('layouts.app')

@section('title', 'Kelola Barang - Admin')

@section('content')
@php $BASE_IMG = config('app.api_base_url'); @endphp

<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Kelola Barang Persewaan</h2>
                <p class="text-muted mb-0">Manajemen inventaris fasilitas masjid</p>
            </div>
            <a href="{{ route('admin.reservasi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Tambah Barang
            </a>
        </div>
    </div>
</div>

<div class="container mb-5">
    @if(!empty($barang))
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Harga/Hari</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang as $b)
                @php
                    $gambar = $b['gambar'] ?? '';
                    if ($gambar && $gambar !== 'default.png' && !str_starts_with($gambar, 'http')) {
                        $gambar = $BASE_IMG . '/uploads/persewaan/' . $gambar;
                    } elseif (!$gambar || $gambar === 'default.png') {
                        $gambar = 'https://via.placeholder.com/60?text=N/A';
                    }
                    $idBarang = $b['id_persewaan'] ?? $b['id'] ?? 0;
                @endphp
                <tr>
                    <td>
                        <img src="{{ $gambar }}" alt="{{ $b['nama_barang'] ?? '' }}"
                             class="rounded-2" width="60" height="60" style="object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/60?text=N/A'">
                    </td>
                    <td class="fw-semibold">{{ $b['nama_barang'] ?? '-' }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $b['Jenis'] ?? $b['jenis'] ?? '-' }}</span></td>
                    <td>Rp {{ number_format((float)($b['harga'] ?? 0), 0, ',', '.') }}</td>
                    <td>{{ $b['jumlah'] ?? 0 }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('reservasi.barang.show', $idBarang) }}"
                               class="btn btn-sm btn-outline-info" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.reservasi.edit', $idBarang) }}"
                               class="btn btn-sm btn-outline-warning" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.reservasi.destroy', $idBarang) }}" method="POST"
                                  onsubmit="return confirm('Hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="text-center py-5">
        <i class="bi bi-box-seam display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3">Belum ada barang yang ditambahkan.</p>
    </div>
    @endif
</div>
@endsection
