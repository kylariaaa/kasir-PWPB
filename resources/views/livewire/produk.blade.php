<div class="container py-4">

    {{-- MENU BUTTONS --}}
    <div class="d-flex gap-2 mb-3">
        <button wire:click="pilihMenu('lihat')"
            class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 fw-semibold">
            Semua Produk
        </button>

        <button wire:click="pilihMenu('tambah')"
            class="btn {{ $pilihanMenu == 'tambah' ? 'btn-primary' : 'btn-outline-primary' }} rounded-pill px-4 fw-semibold">
            Tambah Produk
        </button>

        <button wire:loading class="btn btn-info rounded-pill px-4 fw-semibold">
            Loading...
        </button>
    </div>


    {{-- ====================== MENU LIHAT ====================== --}}
    @if ($pilihanMenu == 'lihat')
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold fs-5  ">
            Semua Produk
        </div>

        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($semuaProduk as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $produk->kode }}</td>
                        <td>{{ $produk->nama }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->stok }}</td>

                        <td class="text-center">
                            <button wire:click="pilihEdit({{ $produk->id }})"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Edit
                            </button>

                            <button wire:click="pilihHapus({{ $produk->id }})"
                                class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>



    {{-- ====================== MENU TAMBAH ====================== --}}
    @elseif ($pilihanMenu == 'tambah')
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold fs-5 border-0">Tambah Produk</div>

        <div class="card-body">

            <form wire:submit.prevent="simpan" class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control rounded-3" wire:model="nama">
                    @error('nama') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kode</label>
                    <input type="text" class="form-control rounded-3" wire:model="kode">
                    @error('kode') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control rounded-3" wire:model="harga">
                    @error('harga') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control rounded-3" wire:model="stok">
                    @error('stok') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-12">
                    <button class="btn btn-primary rounded-pill px-4 fw-semibold">Simpan</button>
                </div>

            </form>
        </div>
    </div>




    {{-- ====================== MENU EDIT ====================== --}}
    @elseif ($pilihanMenu == 'edit')
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white fw-bold fs-5 border-0">Edit Produk</div>

        <div class="card-body">

            <form wire:submit="simpanEdit" class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control rounded-3" wire:model="nama">
                    @error('nama') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kode</label>
                    <input type="text" class="form-control rounded-3" wire:model="kode">
                    @error('kode') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control rounded-3" wire:model="harga">
                    @error('harga') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Stok</label>
                    <input type="number" class="form-control rounded-3" wire:model="stok">
                    @error('stok') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="col-12 mt-2">
                    <button class="btn btn-primary rounded-pill px-4 fw-semibold">Simpan Perubahan</button>
                </div>

            </form>
        </div>
    </div>



    {{-- ====================== MENU HAPUS ====================== --}}
    @elseif ($pilihanMenu == 'hapus')
    <div class="card shadow-sm border-danger rounded-3">
        <div class="card-header bg-danger text-white fw-semibold fs-5">Hapus Produk</div>

        <div class="card-body">

            <p class="mb-1">Yakin ingin menghapus produk ini?</p>

            <div class="p-3 border rounded-3 bg-light mb-3">
                <p class="m-0"><strong>Kode:</strong> {{ $produkTerpilih->kode }}</p>
                <p class="m-0"><strong>Nama:</strong> {{ $produkTerpilih->nama }}</p>
            </div>

            <button class="btn btn-danger rounded-pill px-4" wire:click="hapus">Hapus</button>
            <button class="btn btn-secondary rounded-pill px-4" wire:click="batal">Batal</button>

        </div>
    </div>
    @endif

</div>
