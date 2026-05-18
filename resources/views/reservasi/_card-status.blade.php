@php
    $status     = $p->status_reservasi ?? 'Menunggu';
    $badgeClass = match(strtolower($status)) {
        'disetujui'        => 'bg-success',
        'ditolak', 'batal' => 'bg-danger',
        default            => 'bg-warning text-dark',
    };
    $borderColor = match(strtolower($status)) {
        'disetujui'        => '#198754',
        'ditolak', 'batal' => '#dc3545',
        default            => '#ffc107',
    };

    // Buat link WA ke admin dengan pesan otomatis
    $pesanWa = 'Halo Admin, saya ' . ($p->nama_pengguna ?? '') . ' ingin konfirmasi permintaan sewa ' . ($p->nama_barang ?? '') . ' pada tanggal ' . ($p->tanggal_mulai_reservasi?->format('d M Y') ?? '-') . '. Mohon segera diproses. Terima kasih.';
@endphp

<div class="card border-0 shadow-sm rounded-3 mb-3 p-4"
     style="border-left: 5px solid {{ $borderColor }} !important;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div class="flex-grow-1">
            <h5 class="fw-bold mb-1 text-capitalize">{{ $p->nama_barang }}</h5>
            <div class="d-flex flex-wrap gap-3 text-muted small">
                <span><i class="bi bi-calendar4-week me-1"></i>
                    {{ $p->tanggal_mulai_reservasi?->format('d M Y') ?? '-' }}
                    @if($p->tanggal_selesai_reservasi)
                        – {{ $p->tanggal_selesai_reservasi->format('d M Y') }}
                    @endif
                </span>
                <span><i class="bi bi-box-seam me-1"></i>{{ $p->total_peminjaman }} Unit</span>
                <span><i class="bi bi-cash me-1"></i>
                    Rp {{ number_format((float)$p->total_harga, 0, ',', '.') }}
                </span>
            </div>
            @if($p->notes)
            <div class="mt-1 small {{ strtolower($status) === 'ditolak' ? 'text-danger' : 'text-success' }}">
                <i class="bi bi-chat-left-text me-1"></i>{{ $p->notes }}
            </div>
            @endif
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">
                {{ strtoupper($status) }}
            </span>
            {{-- Tombol WA ke admin --}}
            <a href="{{ $waUrl }}?text={{ urlencode($pesanWa) }}"
               target="_blank"
               class="btn btn-sm fw-semibold"
               style="background:#25d366;color:white;border-radius:8px;"
               title="Hubungi Admin via WhatsApp">
                <i class="bi bi-whatsapp"></i>
            </a>
            <button class="btn btn-sm btn-outline-primary"
                    onclick="showDetail({{ $p->toJson() }})"
                    style="border-radius:8px;">
                Detail <i class="bi bi-arrow-right ms-1"></i>
            </button>
        </div>
    </div>
</div>
