@extends('layouts.app')
@section('title', 'Status Pemesanan - Masjid Nurul Huda')

@section('content')
<div class="container py-5" style="max-width: 900px;">

    <h2 class="fw-bold mb-1">Riwayat Pemesanan</h2>
    <p class="text-muted mb-4">Pantau status pengajuan fasilitas masjid Anda.</p>

    {{-- Banner pengingat WA — selalu tampil --}}
    <div class="rounded-3 p-3 mb-4 d-flex align-items-center gap-3 flex-wrap"
         style="background:#f0fdf4;border:1.5px solid #86efac;">
        <div style="width:44px;height:44px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-whatsapp text-white fs-5"></i>
        </div>
        <div class="flex-grow-1">
            <div class="fw-semibold" style="color:#166534;">Konfirmasi via WhatsApp</div>
            <div class="small" style="color:#15803d;">
                Setelah mengirim permintaan, segera hubungi admin agar lebih cepat diproses.
            </div>
        </div>
        <a href="{{ $waUrl }}" target="_blank"
           class="btn btn-sm fw-semibold flex-shrink-0"
           style="background:#25d366;color:white;border-radius:8px;padding:8px 16px;">
            <i class="bi bi-whatsapp me-1"></i>Hubungi Admin
        </a>
    </div>

    {{-- Alert sukses setelah kirim --}}
    @if(session('success'))
    <div class="alert border-0 rounded-3 shadow-sm mb-4 p-4"
         style="background:#dbeafe;border-left:4px solid #2563eb !important;">
        <div class="d-flex align-items-start gap-3">
            <i class="bi bi-check-circle-fill text-primary fs-4 mt-1"></i>
            <div>
                <div class="fw-semibold mb-1" style="color:#1e3a5f;">{{ session('success') }}</div>
                <p class="mb-2 small text-muted">
                    <i class="bi bi-exclamation-circle me-1 text-warning"></i>
                    <strong>Penting:</strong> Segera hubungi admin via WhatsApp untuk konfirmasi dan mempercepat proses persetujuan.
                </p>
                <a href="{{ $waUrl }}" target="_blank"
                   class="btn btn-sm fw-semibold"
                   style="background:#25d366;color:white;border-radius:8px;">
                    <i class="bi bi-whatsapp me-1"></i>Hubungi Admin Sekarang
                </a>
            </div>
        </div>
    </div>
    @endif

    @if($pesanan->count() > 0)

        {{-- Menunggu dulu --}}
        @php $menunggu = $pesanan->where('status_reservasi', 'Menunggu'); @endphp
        @if($menunggu->count() > 0)
            <h6 class="fw-semibold text-warning mb-2">
                <i class="bi bi-hourglass-split me-1"></i>Menunggu Konfirmasi ({{ $menunggu->count() }})
            </h6>
            @foreach($menunggu as $p)
                @include('reservasi._card-status', ['p' => $p])
            @endforeach
        @endif

        {{-- Sudah diproses --}}
        @php $selesai = $pesanan->whereNotIn('status_reservasi', ['Menunggu']); @endphp
        @if($selesai->count() > 0)
            <h6 class="fw-semibold text-muted mb-2 mt-4">
                <i class="bi bi-clock-history me-1"></i>Sudah Diproses ({{ $selesai->count() }})
            </h6>
            @foreach($selesai as $p)
                @include('reservasi._card-status', ['p' => $p])
            @endforeach
        @endif

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
    if (typeof item === 'string') item = JSON.parse(item);
    const harga = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.total_harga || 0);
    let notesRow = '';
    if (item.notes) {
        const cls   = (item.status_reservasi === 'Ditolak') ? 'text-danger' : 'text-success';
        const label = (item.status_reservasi === 'Ditolak') ? 'Alasan Penolakan' : 'Catatan Admin';
        notesRow = `<tr><td class="fw-bold ${cls} pt-2">${label}</td><td class="${cls} pt-2">: ${item.notes}</td></tr>`;
    }
    Swal.fire({
        title: 'Detail Pesanan',
        html: `
            <div class="text-start p-2" style="font-size:0.95rem;">
                <table class="table table-borderless mb-0">
                    <tr><td class="fw-bold" width="40%">Barang</td><td>: ${item.nama_barang || '-'}</td></tr>
                    <tr><td class="fw-bold">Jumlah</td><td>: ${item.total_peminjaman || 1} Unit</td></tr>
                    <tr><td class="fw-bold">Tgl Mulai</td><td>: ${item.tanggal_mulai_reservasi || '-'}</td></tr>
                    <tr><td class="fw-bold">Tgl Selesai</td><td>: ${item.tanggal_selesai_reservasi || '-'}</td></tr>
                    <tr><td class="fw-bold">Keperluan</td><td>: ${item.keperluan || '-'}</td></tr>
                    <tr><td class="fw-bold border-top pt-2">Total Biaya</td><td class="fw-bold border-top pt-2">: ${harga}</td></tr>
                    ${notesRow}
                </table>
            </div>`,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#64748b',
        width: '500px',
    });
}

// Popup pengingat WA jika baru kirim permintaan
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: 'Permintaan Terkirim!',
            html: `
                <p class="mb-3">Permintaan reservasi Anda sudah dikirim ke admin.</p>
                <p class="mb-3" style="color:#dc6803;">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <strong>Jangan lupa!</strong> Hubungi admin via WhatsApp untuk konfirmasi agar lebih cepat diproses.
                </p>`,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-whatsapp me-1"></i> Hubungi Admin',
            cancelButtonText: 'Nanti Saja',
            confirmButtonColor: '#25d366',
            cancelButtonColor: '#64748b',
        }).then((result) => {
            if (result.isConfirmed) {
                window.open('{{ $waUrl }}', '_blank');
            }
        });
    }, 500);
});
@endif
</script>
@endpush
