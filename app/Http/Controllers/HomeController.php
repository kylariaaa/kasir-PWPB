<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Mengambil data transaksi yang 'selesai' dan mengirimkannya ke view 'cetak'.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function cetak()
    {
        // Ambil semua transaksi dengan status 'selesai'
        $semuaTransaksi = Transaksi::where('status', 'selesai')->get();

        // Tampilkan view 'cetak' dengan data transaksi
        return view('cetak')->with([
            'semuaTransaksi' => $semuaTransaksi
        ]);
    }
}
