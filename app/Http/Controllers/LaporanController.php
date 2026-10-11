<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LaporanController extends Controller
{
    public function direktur(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $query = Penjualan::with('pelanggan')
            ->where('status_penjualan', 'tervalidasi');

        if ($tanggalMulai) {
            $query->whereDate('tanggal_penjualan', '>=', $tanggalMulai);
        }

        if ($tanggalSelesai) {
            $query->whereDate('tanggal_penjualan', '<=', $tanggalSelesai);
        }

        $totalTransaksi = (clone $query)->count();

        $totalOmzet = (clone $query)->sum('total_penjualan');

        $totalPelanggan = (clone $query)
            ->distinct('id_pelanggan')
            ->count('id_pelanggan');

        $produkTerlaris = DB::table('detail_penjualan')
            ->join(
                'penjualan',
                'detail_penjualan.id_penjualan',
                '=',
                'penjualan.id_penjualan'
            )
            ->join(
                'produk',
                'detail_penjualan.id_produk',
                '=',
                'produk.id_produk'
            )
            ->where('penjualan.status_penjualan', 'tervalidasi')
            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate(
                    'penjualan.tanggal_penjualan',
                    '>=',
                    $tanggalMulai
                );
            })
            ->when($tanggalSelesai, function ($query) use ($tanggalSelesai) {
                $query->whereDate(
                    'penjualan.tanggal_penjualan',
                    '<=',
                    $tanggalSelesai
                );
            })
            ->select(
                'produk.nama_produk',
                DB::raw('SUM(detail_penjualan.jumlah_produk) as total_terjual')
            )
            ->groupBy(
                'produk.id_produk',
                'produk.nama_produk'
            )
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $penjualan = $query
            ->orderByDesc('tanggal_penjualan')
            ->orderByDesc('id_penjualan')
            ->paginate(10)
            ->withQueryString();

        return view('laporan.direktur', compact(
            'tanggalMulai',
            'tanggalSelesai',
            'totalTransaksi',
            'totalOmzet',
            'totalPelanggan',
            'produkTerlaris',
            'penjualan'
        ));
    }

    public function stok(Request $request)
    {
        $status = $request->status;

        $produk = Produk::query()
            ->when($status, function ($query) use ($status) {
                $query->where('status_produk', $status);
            })
            ->orderBy('stok_produk', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalProduk = Produk::where('status_produk', 'aktif')->count();

        $stokRendah = Produk::where('status_produk', 'aktif')
            ->where('stok_produk', '<=', 10)
            ->count();

        $stokHabis = Produk::where('status_produk', 'aktif')
            ->where('stok_produk', '<=', 0)
            ->count();

        $totalStok = Produk::where('status_produk', 'aktif')
            ->sum('stok_produk');

        return view('laporan.stok', compact(
            'produk',
            'status',
            'totalProduk',
            'stokRendah',
            'stokHabis',
            'totalStok'
        ));
    }
}