<div class="container py-4">

    {{-- NOTIFIKASI PEMBAYARAN SELESAI --}}
    @if (session()->has('sukses'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-3" role="alert">
            Pembayaran berhasil diselesaikan.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- BUTTON HEADER --}}
    <div class="d-flex gap-2 mb-4">
        @if(!$transaksiAktif)
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm"
                wire:click="transaksiBaru">
                Transaksi Baru
            </button>
        @else
            <button class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm"
                wire:click='batalTransaksi'>
                Batalkan Transaksi
            </button>
        @endif

        <button class="btn btn-info rounded-pill px-4" wire:loading>Loading...</button>
    </div>



    @if ($transaksiAktif)

    <div class="row g-4">

        {{-- ======================= INVOICE SECTION ======================= --}}
        <div class="col-12">
            <div class="p-4 border border-primary rounded-4 shadow-sm">

                <h4 class="fw-bold text-primary mb-3">🧾 Informasi Invoice</h4>

                <div class="row">
                    <div class="col-md-4">
                        <p class="fw-semibold mb-1">Scan / Masukkan Kode Produk</p>
                        <input type="text" class="form-control form-control-lg rounded-3"
                            wire:model.live.debounce.500ms="kode"
                            placeholder="Contoh: BRG001">
                    </div>

                    <div class="col-md-4">
                        <p class="fw-semibold mb-1">Invoice Saat Ini</p>
                        <div class="p-3 bg-light rounded-3 fw-bold fs-5 border border-primary">
                            {{ $transaksiAktif->kode }}
                        </div>
                    </div>
                </div>

            </div>
        </div>



        {{-- ======================= PRODUK TERSEDIA ======================= --}}
        <div class="col-12">
            <div class="p-4 border border-dark rounded-4 shadow-sm mb-2">

                <h4 class="fw-bold mb-3 text-dark">🛒Atau Pilih Produk</h4>

                <div class="row g-3">
                    @foreach(\App\Models\Produk::all() as $item)
                    <div class="col-md-3">
                        <div class="border border-secondary rounded-3 p-3 shadow-sm h-100">

                            <h6 class="fw-bold">{{ $item->nama }}</h6>
                            <p class="mb-1 text-muted">{{ $item->kode }}</p>
                            <p class="fw-bold text-success">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>

                            <p class="text-muted small mb-2">Stok: {{ $item->stok }}</p>

                            <button class="btn btn-primary w-100 rounded-pill"
                                wire:click="tambahProduk({{ $item->id }})"
                                @if($item->stok <= 0) disabled @endif>
                                Tambah
                            </button>

                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>



        {{-- ======================= LIST PRODUK (KERANJANG) ======================= --}}
        <div class="col-lg-8">

            <div class="p-4 border border-info rounded-4 shadow-sm">

                <h4 class="fw-bold text-info mb-3">📦 Barang yang Dibeli</h4>

                <table class="table table-bordered align-middle">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($semuaProduk as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $produk->produk->kode }}</td>
                            <td>{{ $produk->produk->nama }}</td>
                            <td>Rp {{ number_format($produk->produk->harga, 0, ',', '.') }}</td>

                            <td>
                                <span class="badge bg-primary px-3 py-2 fs-6">
                                    {{ $produk->jumlah }}
                                </span>
                            </td>

                            <td class="fw-bold text-success">
                                Rp {{ number_format($produk->produk->harga * $produk->jumlah, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                    wire:click='hapusProduk({{ $produk->id }})'>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>




        {{-- ======================= RINGKASAN PEMBAYARAN ======================= --}}
        <div class="col-lg-4">

            {{-- TOTAL BELANJA --}}
            <div class="p-4 mb-3 border border-success rounded-4 shadow-sm">

                <h5 class="fw-bold text-success">💰 Total Belanja</h5>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="text-muted">Total:</span>
                    <span class="fw-bold fs-3 text-success">
                        Rp {{ number_format($totalSemuaBelanja, 0, ',', '.') }}
                    </span>
                </div>

            </div>


            {{-- INPUT BAYAR --}}
            <div class="p-4 mb-3 border border-warning rounded-4 shadow-sm">

                <h5 class="fw-bold text-warning">💵 Masukkan Uang Bayar</h5>

                <input type="number" class="form-control form-control-lg rounded-3 mt-2"
                    placeholder="Contoh: 100000"
                    wire:model.live="bayar">

            </div>


            {{-- KEMBALIAN --}}
            <div class="p-4 mb-3 border border-danger rounded-4 shadow-sm">

                <h5 class="fw-bold text-danger">💸 Kembalian</h5>

                <div class="d-flex justify-content-between mt-2">
                    <span>Rp</span>
                    <span class="fw-bold fs-3 text-danger">
                        Rp {{ number_format($kembalian, 0, ',', '.') }}
                    </span>
                </div>

            </div>


            {{-- TOMBOL PEMBAYARAN --}}
            @if($bayar)
                @if ($kembalian < 0)
                    <div class="alert alert-danger rounded-3">
                        Uang kurang
                    </div>
                @else
                    <button class="btn btn-success w-100 py-3 fs-5 fw-bold rounded-pill shadow-sm"
                        wire:click="transaksiSelesai"
                        @if($totalSemuaBelanja <= 0) disabled @endif>
                        Selesaikan Pembayaran
                    </button>
                @endif
            @endif

        </div>

    </div>

    @endif
</div>
