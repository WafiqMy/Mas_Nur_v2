@php
    $status     = $r->status_reservasi ?? 'Menunggu';
    $statusLower = strtolower($status);
    $badgeClass = match($statusLower) {
        'disetujui'        => 'bg-success',
        'ditolak', 'batal' => 'bg-danger',
        default            => 'bg-warning text-dark',
    };
    $cardClass = match($statusLower) {
        'disetujui'        => 'disetujui',
        'ditolak'          => 'ditolak',
        'batal'            => 'batal',
        default            => 'menunggu',
    };
@endphp

<div class="res-card {{ $cardClass }}">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                <h6 class="fw-bold mb-0">{{ $r->nama_barang }}</h6>
                <span class="badge {{ $badgeClass }} badge-status">{{ strtoupper($status) }}</span>
            </div>
            <div class="d-flex flex-wrap gap-3 text-muted small">
                <span><i class="bi bi-person me-1"></i>{{ $r->nama_pengguna }}</span>
                <span><i class="bi bi-telephone me-1"></i>{{ $r->no_tlp_pengguna }}</span>
                <span><i class="bi bi-calendar me-1"></i>
                    {{ $r->tanggal_mulai_reservasi?->format('d M Y') }}
                    – {{ $r->tanggal_selesai_reservasi?->format('d M Y') }}
                </span>
                <span><i class="bi bi-cash me-1"></i>
                    Rp {{ number_format((float)$r->total_harga, 0, ',', '.') }}
                </span>
            </div>
            @if($r->notes)
            <div class="mt-1 small {{ $statusLower === 'ditolak' ? 'text-danger' : 'text-success' }}">
                <i class="bi bi-chat-left-text me-1"></i>{{ $r->notes }}
            </div>
            @endif
        </div>
        <div class="d-flex gap-2 flex-wrap">
            {{-- Tombol WA ke peminjam --}}
            @php
                $noWa = preg_replace('/[^0-9]/', '', $r->no_tlp_pengguna ?? '');
                if (str_starts_with($noWa, '0')) $noWa = '62' . substr($noWa, 1);
                $waLink = 'https://wa.me/' . $noWa . '?text=' . urlencode('Halo ' . $r->nama_pengguna . ', terkait permintaan sewa ' . $r->nama_barang . ' di Masjid Nurul Huda.');
            @endphp
            <a href="{{ $waLink }}" target="_blank"
               class="btn btn-sm"
               style="background:#25d366;color:white;border-radius:8px;font-weight:600;">
                <i class="bi bi-whatsapp me-1"></i>WA
            </a>
            <a href="{{ route('admin.reservasi.detail-permintaan', $r->id) }}"
               class="btn btn-sm btn-primary fw-semibold" style="border-radius:8px;">
                Detail <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
