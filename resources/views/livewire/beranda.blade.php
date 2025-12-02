<div class="container py-4">

    <h2 class="fw-bold mb-4">Dashboard</h2>

    <div class="row g-4">

        <!-- Total User -->
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0" style="border-radius: 12px;">
                <h6 class="text-muted">Total User</h6>
                <h3 class="fw-bold">{{ $totalUser }}</h3>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0" style="border-radius: 12px;">
                <h6 class="text-muted">Total Produk</h6>
                <h3 class="fw-bold">{{ $totalProduk }}</h3>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0" style="border-radius: 12px;">
                <h6 class="text-muted">Total Transaksi</h6>
                <h3 class="fw-bold">{{ $totalTransaksi }}</h3>
            </div>
        </div>

        <!-- Total Stok Barang -->
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0" style="border-radius: 12px;">
                <h6 class="text-muted">Total Stok Barang</h6>
                <h3 class="fw-bold">{{ $totalStok }}</h3>
            </div>
        </div>

    </div>

</div>
