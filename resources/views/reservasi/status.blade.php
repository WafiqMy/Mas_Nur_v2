@extends('layouts.app')

@section('title', 'Status Pemesanan - Masjid Nurul Huda')

@section('content')
<div class="container py-5" style="max-width: 900px;">

    <h2 class="fw-bold mb-1">Riwayat Pemesanan</h2>
    <p class="text-muted mb-4">Pantau status pengajuan fasilitas masjid Anda.</p>

    @if(!empty($pesanan))
        @foreach($pesanan as $p)
        @php
            $status = $p['status_reservasi'] ?? 'Menunggu';
            $statusLower = strtolower($status);
            $badgeClass = 'bg-warning text-dark';
            if (str_contains($statusLower, 'setuju')) $badgeClass = 'bg-success';
            elseif (str_contains($statusLower, 'tolak') || str_contains($statusLower, 'batal')) $badgeClass = 'bg-danger';
        @endphp
        <div class="card border-0 shadow-sm rounded-3 mb-3 p-4"
             style="border-left: 5px solid #2563eb !important;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-1 text-capitalize">{{ $p['nama_barang'] ?? '-' }}</h5>
                    <div class="d-flex flex-wrap gap-3 text-muted small">
                        <span>
                            <i class="bi bi-calendar4-week me-1"></i>
                            {{ isset($p['tanggal_mulai_reservasi']) ? date('d M Y', strtotime($p['tanggal_mulai_reservasi'])) : '-' }}
                        </span>
                        <span><i class="bi bi-person me-1"></i>{{ $p['nama_pengguna'] ?? '-' }}</span>
                        <span><i class="bi bi-telephone me-1"></i>{{ $p['no_tlp_pengguna'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">
                        {{ strtoupper($status) }}
                    </span>
                    <button class="btn btn-sm btn-outline-primary"
                            onclick="showDetail({{ json_encode($p) }})">
                        Detail <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="text-center py-5 bg-light rounded-3">
        <i class="bi bi-calendar-x display-1 text-muted opacity-25"></i>
        <p class="text-muted mt-3 mb-4">Belum ada riwayat pesanan.</p>
        <a href="{{ route('reservasi.index') }}" class="btn btn-primary px-4">Buat Pesanan Baru</a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function showDetail(item) {
        const harga = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.total_harga || 0);
        let notesRow = '';
        if (item.status_reservasi === 'Ditolak' && item.notes) {
            notesRow = `<tr><td class="fw-bold text-danger pt-2">Alasan Penolakan</td><td class="text-danger pt-2">: ${item.notes}</td></tr>`;
        } else if (item.notes) {
            notesRow = `<tr><td class="fw-bold text-success pt-2">Catatan Admin</td><td class="text-success pt-2">: ${item.notes}</td></tr>`;
        }

        Swal.fire({
            title: 'Detail Pesanan',
            html: `
                <div class="text-start p-2" style="font-size: 0.95rem;">
                    <table class="table table-borderless mb-0">
                        <tr><td class="fw-bold" width="40%">Barang</td><td>: ${item.nama_barang || '-'}</td></tr>
                        <tr><td class="fw-bold">Jumlah</td><td>: ${item.total_peminjaman || 1} Unit</td></tr>
                        <tr><td class="fw-bold">Tgl Mulai</td><td>: ${item.tanggal_mulai_reservasi || '-'}</td></tr>
                        <tr><td class="fw-bold">Tgl Selesai</td><td>: ${item.tanggal_selesai_reservasi || '-'}</td></tr>
                        <tr><td class="fw-bold">Keperluan</td><td>: ${item.keperluan || '-'}</td></tr>
                        <tr><td class="fw-bold border-top pt-2">Total Biaya</td><td class="fw-bold border-top pt-2">: ${harga}</td></tr>
                        ${notesRow}
                    </table>
                </div>
            `,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#64748b',
            width: '500px',
        });
    }
</script>
@endpush
