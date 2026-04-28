<div class="col">
    <div class="card card-barang h-100">
        <img src="{{ $barang->gambar_url }}" alt="{{ $barang->nama_barang }}"
             onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
        <div class="card-body px-4 py-4 d-flex flex-column">
            <h5 class="card-title fw-bold mb-2 text-capitalize">{{ $barang->nama_barang }}</h5>
            <div class="d-flex justify-content-between align-items-center small text-muted mb-3">
                <span><i class="bi bi-box-seam me-1"></i>Stok: {{ $barang->jumlah }}</span>
                <span class="price-tag">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span>
            </div>
            <div class="mt-auto d-grid">
                <a href="{{ route('reservasi.barang.show', $barang->id) }}" class="btn btn-sm btn-sewa text-white">
                    Detail & Sewa
                </a>
            </div>
        </div>
    </div>
</div>
