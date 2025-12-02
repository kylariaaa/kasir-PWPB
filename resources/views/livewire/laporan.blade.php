<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="p-4 rounded-4 shadow-sm border border-primary">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="fw-bold text-primary m-0">Laporan Transaksi</h3>

                    <a href="{{ url('/cetak') }}" target="_blank"
                        class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        Cetak Laporan
                    </a>
                </div>

                <div class="table-responsive rounded-3 border">
                    <table class="table table-hover table-bordered m-0 align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th style="width: 200px;">Tanggal</th>
                                <th>No Invoice</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($semuaTransaksi as $transaksi)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->created_at->format('d-m-Y / H:i') }}</td>
                                    <td class="fw-bold text-primary">{{ $transaksi->kode }}</td>
                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted fs-5">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</div>
