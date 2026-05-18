@extends('layouts.app')

@section('title', ($barang['nama_barang'] ?? 'Detail Barang') . ' - Sewa Fasilitas')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
@endpush

@section('content')
@php
    $sessionUser = session('user');
    $isLoggedIn  = !empty($sessionUser);
    $BASE_IMG    = config('app.api_base_url');

    $gambar = $barang->gambar_url;

    $idBarang   = $barang['id_persewaan'] ?? $barang['id'] ?? 0;
    $namaBarang = $barang['nama_barang'] ?? '';
    $jenis      = $barang['Jenis'] ?? $barang['jenis'] ?? '';
    $harga      = (float)($barang['harga'] ?? 0);
    $jumlah     = (int)($barang['jumlah'] ?? 1);
@endphp

<div class="container py-5" style="max-width: 1000px;">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('reservasi.index') }}">Sewa Fasilitas</a></li>
            <li class="breadcrumb-item active">{{ $namaBarang }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        {{-- Detail Barang --}}
        <div class="col-md-5">
            <img src="{{ $gambar }}" alt="{{ $namaBarang }}"
                 class="img-fluid rounded-3 w-100 mb-3"
                 style="max-height: 300px; object-fit: cover;"
                 onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'">

            <h2 class="fw-bold mb-2">{{ $namaBarang }}</h2>
            <p class="text-primary fw-bold fs-4 mb-3">
                Rp {{ number_format($harga, 0, ',', '.') }}
                <small class="text-muted fs-6 fw-normal">/hari</small>
            </p>

            <div class="mb-3">
                <span class="badge bg-light text-dark border me-2">
                    <i class="bi bi-tag me-1"></i>{{ $jenis }}
                </span>
                <span class="badge bg-light text-dark border">
                    <i class="bi bi-box-seam me-1"></i>Stok: {{ $jumlah }}
                </span>
            </div>

            @if(!empty($barang['deskripsi']))
            <div class="mb-3">
                <h6 class="fw-bold">Deskripsi</h6>
                <p class="text-muted small">{{ $barang['deskripsi'] }}</p>
            </div>
            @endif

            @if(!empty($barang['spesifikasi']))
            <div class="mb-3">
                <h6 class="fw-bold">Spesifikasi</h6>
                <p class="text-muted small">{{ $barang['spesifikasi'] }}</p>
            </div>
            @endif

            @if(!empty($barang['fasilitas']))
            <div class="mb-3">
                <h6 class="fw-bold">Fasilitas</h6>
                <p class="text-muted small">{{ $barang['fasilitas'] }}</p>
            </div>
            @endif
        </div>

        {{-- Kalender & Form --}}
        <div class="col-md-7">

            {{-- Kalender --}}
            <div class="card border-0 shadow-sm rounded-3 p-3 mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-calendar3 me-2"></i>Jadwal Pemesanan</h6>
                <div id="calendar"></div>
                <div class="d-flex gap-3 mt-2 small">
                    <span><span class="badge" style="background:#ffc107;">&nbsp;&nbsp;</span> Menunggu</span>
                    <span><span class="badge" style="background:#198754;">&nbsp;&nbsp;</span> Disetujui</span>
                </div>
            </div>

            {{-- Form Reservasi --}}
            @if($isLoggedIn && strtolower($sessionUser['role'] ?? '') !== 'admin')
            <div class="card border-0 shadow-sm rounded-3 p-4">
                {{-- form reservasi --}}
                <h6 class="fw-bold mb-3"><i class="bi bi-calendar-check me-2"></i>Buat Reservasi</h6>

                <form action="{{ route('reservasi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_persewaan" value="{{ $idBarang }}">
                    <input type="hidden" name="nama_barang" value="{{ $namaBarang }}">
                    <input type="hidden" name="jenis" value="{{ $jenis }}">
                    <input type="hidden" name="harga_satuan" value="{{ $harga }}">
                    <input type="hidden" name="total_harga" id="inputTotalHarga" value="0">

                    {{-- Data Pemesan (dari session) --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold small">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pengguna" class="form-control"
                                   value="{{ $sessionUser['nama'] ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">No. WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_tlp_pengguna" class="form-control"
                                   value="{{ $sessionUser['no_telpon'] ?? '' }}"
                                   placeholder="08xxxxxxxxxx" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email_pengguna" class="form-control"
                                   value="{{ $sessionUser['email'] ?? '' }}" required>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tanggal Mulai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar3"></i></span>
                                <input type="date" name="tanggal_mulai_reservasi" class="form-control"
                                       min="{{ date('Y-m-d') }}" required id="tglMulai"
                                       placeholder="Pilih tanggal mulai">
                            </div>
                            <div class="date-helper"><i class="bi bi-info-circle me-1"></i>Klik untuk memilih tanggal</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tanggal Selesai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white"><i class="bi bi-calendar3"></i></span>
                                <input type="date" name="tanggal_selesai_reservasi" class="form-control"
                                       min="{{ date('Y-m-d') }}" required id="tglSelesai"
                                       placeholder="Pilih tanggal selesai">
                            </div>
                            <div class="date-helper"><i class="bi bi-info-circle me-1"></i>Klik untuk memilih tanggal</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Jumlah Unit <span class="text-danger">*</span></label>
                            <input type="number" name="total_peminjaman" class="form-control"
                                   min="1" max="{{ $jumlah }}" value="1" required id="jumlahUnit">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Estimasi Total</label>
                            <div class="form-control bg-light fw-bold text-primary" id="estimasiHarga">
                                Rp 0
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Keperluan <span class="text-danger">*</span></label>
                            <textarea name="keperluan" class="form-control" rows="3"
                                      placeholder="Jelaskan keperluan peminjaman..." required maxlength="500"></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 fw-semibold">
                        <i class="bi bi-send me-2"></i>Kirim Permintaan Reservasi
                    </button>
                </form>
            </div>
            @elseif($isLoggedIn && strtolower($sessionUser['role'] ?? '') === 'admin')
            <div class="card border-0 shadow-sm rounded-3 p-4 text-center"
                 style="background:#f0f9ff;border:1.5px solid #bae6fd !important;">
                <i class="bi bi-shield-check display-4 text-primary opacity-75 mb-3"></i>
                <h6 class="fw-bold text-primary">Mode Admin</h6>
                <p class="text-muted small mb-3">
                    Admin tidak dapat membuat reservasi. Gunakan menu
                    <strong>Permintaan Sewa</strong> untuk mengelola reservasi dari pengguna.
                </p>
                <a href="{{ route('admin.reservasi.permintaan') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-clipboard-check me-1"></i>Lihat Permintaan Sewa
                </a>
            </div>
            @else
            <div class="card border-0 shadow-sm rounded-3 p-4 text-center">
                <i class="bi bi-lock display-4 text-muted opacity-25 mb-3"></i>
                <p class="text-muted mb-3">Silakan login untuk membuat reservasi.</p>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login Sekarang
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    const hargaSatuan = {{ $harga }};

    // Kalender
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            height: 350,
            events: '{{ route("api.kalender-reservasi", $idBarang) }}',
            eventClick: function(info) {
                const p = info.event.extendedProps;
                Swal.fire({
                    title: info.event.title,
                    html: `<p><strong>Status:</strong> ${p.status}</p><p><strong>Keperluan:</strong> ${p.keperluan || '-'}</p>`,
                    icon: 'info',
                    confirmButtonColor: '#2563eb'
                });
            }
        });
        calendar.render();
    });

    // Hitung estimasi harga
    function hitungEstimasi() {
        const mulai   = document.getElementById('tglMulai').value;
        const selesai = document.getElementById('tglSelesai').value;
        const jumlah  = parseInt(document.getElementById('jumlahUnit').value) || 1;

        if (mulai && selesai) {
            const d1   = new Date(mulai);
            const d2   = new Date(selesai);
            const hari = Math.max(1, Math.round((d2 - d1) / (1000 * 60 * 60 * 24)) + 1);
            const total = hargaSatuan * jumlah * hari;
            document.getElementById('estimasiHarga').textContent =
                'Rp ' + total.toLocaleString('id-ID');
            // Update hidden input total_harga
            const inputHarga = document.getElementById('inputTotalHarga');
            if (inputHarga) inputHarga.value = total;
        }
    }

    document.getElementById('tglMulai')?.addEventListener('change', hitungEstimasi);
    document.getElementById('tglSelesai')?.addEventListener('change', hitungEstimasi);
    document.getElementById('jumlahUnit')?.addEventListener('input', hitungEstimasi);
</script>
@endpush
