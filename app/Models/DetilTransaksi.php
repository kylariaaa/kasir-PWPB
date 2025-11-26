<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetilTransaksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'jumlah',
    ];

    /**
     * Get the Transaksi that owns the DetilTransaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Get the Produk that belongs to the DetilTransaksi.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}

// Pastikan Anda juga memiliki import model yang diperlukan di bagian atas file:
// use App\Models\Transaksi;
// use App\Models\Produk;
// Karena dalam gambar, kode aslinya menggunakan:
// use App\Models\Transaksi;
// use App\Models\Produk;
