<?php

namespace App\Livewire;

use App\Models\DetilTransaksi;
use App\Models\Transaksi as ModelsTransaksi; // Alias untuk menghindari konflik dengan nama komponen
use Livewire\Component;
use App\Models\Produk;

class Transaksi extends Component
{
    // Properti publik untuk binding data
    public $kode, $total, $kembalian, $totalSemuaBelanja = 0;
    public $bayar = 0; // Tambahkan inisialisasi untuk bayar agar tidak ada error undefined
    public ModelsTransaksi $transaksiAktif;

    /**
     * Membuat transaksi baru (memulai sesi transaksi).
     *
     * @return void
     */
    public function transaksiBaru()
    {
        $this->reset();
        $this->transaksiAktif = new ModelsTransaksi();
        $this->transaksiAktif->kode = 'INV/' . date('YmdHis');
        $this->transaksiAktif->total = 0;
        $this->transaksiAktif->status = 'pending';
        $this->transaksiAktif->save();
    }


    public function tambahProduk($produkId)
    {
        if (!isset($this->transaksiAktif)) {
            return;
        }

        $produk = Produk::find($produkId);

        if (!$produk || $produk->stok <= 0) {
            return;
        }

        // Cari detail transaksi
        $detil = DetilTransaksi::firstOrNew([
            'transaksi_id' => $this->transaksiAktif->id,
            'produk_id' => $produk->id
        ]);

        $detil->jumlah += 1;
        $detil->save();

        // Kurangi stok
        $produk->stok -= 1;
        $produk->save();
    }


    /**
     * Menghapus produk dari detail transaksi dan mengembalikan stok.
     *
     * @param int $id ID dari DetilTransaksi yang akan dihapus.
     * @return void
     */
    public function hapusProduk($id)
    {
        $detil = DetilTransaksi::find($id);

        if ($detil) {
            $produk = Produk::find($detil->produk_id);

            if ($produk) {
                // Kembalikan stok produk
                $produk->stok += $detil->jumlah;
                $produk->save();
            }

            // Hapus detail transaksi
            $detil->delete();
        }
    }

    /**
     * Menyelesaikan transaksi: update total, status, dan reset state.
     *
     * @return void
     */
    public function transaksiSelesai()
    {
        $this->transaksiAktif->total = $this->totalSemuaBelanja;
        $this->transaksiAktif->status = 'selesai';
        $this->transaksiAktif->save();
        $this->reset();

        session()->flash('sukses', 'Pembayaran berhasil diselesaikan.');
        $this->bayar = null;
    }

    /**
     * Membatalkan transaksi: menghapus semua detail, mengembalikan stok, dan menghapus transaksi aktif.
     *
     * @return void
     */
    public function batalTransaksi()
    {
        if (isset($this->transaksiAktif)) {
            // Ambil dan hapus semua detail transaksi
            $detilTransaksis = DetilTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();

            foreach ($detilTransaksis as $detil) {
                $produk = Produk::find($detil->produk_id);

                if ($produk) {
                    // Kembalikan stok produk
                    $produk->stok += $detil->jumlah;
                    $produk->save();
                }

                $detil->delete();
            }

            // Hapus transaksi aktif itu sendiri
            $this->transaksiAktif->delete();
        }

        $this->reset();
    }

    /**
     * Hook yang dipanggil saat properti $kode diupdate (misalnya saat scanning barcode).
     * Menambahkan produk ke detail transaksi atau menambah jumlahnya.
     *
     * @return void
     */
    public function updatedKode()
    {
        // Cari produk berdasarkan kode
        $produk = Produk::where('kode', $this->kode)->first();

        // Pastikan ada transaksi aktif dan produk ditemukan dan stok > 0
        if (isset($this->transaksiAktif) && $produk && $produk->stok > 0) {
            // Cari detail transaksi yang sudah ada atau buat yang baru
            $detil = DetilTransaksi::firstOrNew([
                'transaksi_id' => $this->transaksiAktif->id,
                'produk_id' => $produk->id
            ]);

            // Tambah jumlah produk di detail transaksi
            $detil->jumlah += 1;
            $detil->save();

            // Kurangi stok produk
            $produk->stok -= 1;
            $produk->save();
        }

        // Reset kode setelah diproses (untuk input berikutnya)
        $this->reset('kode');
    }

    /**
     * Hook yang dipanggil saat properti $bayar diupdate.
     * Menghitung kembalian.
     *
     * @return void
     */
    public function updatedBayar()
    {
        if ($this->bayar >= 0) {
            $this->kembalian = $this->bayar - $this->totalSemuaBelanja;
        }
    }

    /**
     * Metode render untuk menampilkan view dan menghitung total belanja.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $semuaProduk = [];
        $this->totalSemuaBelanja = 0;

        if (isset($this->transaksiAktif)) {
            // Ambil semua detail transaksi berdasarkan transaksi aktif
            $semuaProduk = DetilTransaksi::with('produk')->where('transaksi_id', $this->transaksiAktif->id)->get();

            // Hitung total semua belanja
            $this->totalSemuaBelanja = $semuaProduk->sum(function ($detil) {
                // Pastikan relasi produk tersedia sebelum mengakses harga
                return $detil->produk->harga * $detil->jumlah;
            });
        }

        // Hitung ulang kembalian setiap kali render
        $this->updatedBayar();


        return view('livewire.transaksi')->with([
            'semuaProduk' => $semuaProduk
        ]);
    }
}
