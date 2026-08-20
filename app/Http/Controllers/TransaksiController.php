<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $status = $request->status;

        $transaksi = Penjualan::with([
                'pelanggan',
                'user'
            ])
            ->when($cari, function ($query, $cari) {

                $query->where(function ($q) use ($cari) {

                    $q->where(
                        'nomor_penjualan',
                        'like',
                        "%{$cari}%"
                    )
                    ->orWhereHas(
                        'pelanggan',
                        function ($pelanggan) use ($cari) {

                            $pelanggan
                                ->where(
                                    'nama_pelanggan',
                                    'like',
                                    "%{$cari}%"
                                )
                                ->orWhere(
                                    'nama_toko',
                                    'like',
                                    "%{$cari}%"
                                );
                        }
                    )
                    ->orWhereHas(
                        'user',
                        function ($user) use ($cari) {

                            $user->where(
                                'nama_user',
                                'like',
                                "%{$cari}%"
                            );
                        }
                    );
                });
            })

            ->when($status, function ($query, $status) {

                $query->where(
                    'status_penjualan',
                    $status
                );
            })

            ->orderBy('id_penjualan', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'transaksi.index',
            compact(
                'transaksi',
                'cari',
                'status'
            )
        );
    }

    public function show(Penjualan $transaksi)
    {
        $transaksi->load([
            'pelanggan',
            'user',
            'detailPenjualan.produk'
        ]);

        return view('transaksi.show', compact('transaksi'));
    }

    public function validasi(Penjualan $transaksi)
    {
        DB::transaction(function () use ($transaksi) {

            $transaksi = Penjualan::where(
                'id_penjualan',
                $transaksi->id_penjualan
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($transaksi->status_penjualan !== 'menunggu_validasi') {
                throw ValidationException::withMessages([
                    'transaksi' => 'Transaksi ini sudah diproses sebelumnya.'
                ]);
            }

            $transaksi->load('detailPenjualan');

            foreach ($transaksi->detailPenjualan as $detail) {

                $produk = Produk::where(
                    'id_produk',
                    $detail->id_produk
                )
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($produk->stok_produk < $detail->jumlah_produk) {

                    throw ValidationException::withMessages([
                        'stok' =>
                            "Stok {$produk->nama_produk} tidak mencukupi."
                    ]);
                }

                $produk->decrement(
                    'stok_produk',
                    $detail->jumlah_produk
                );
            }

            $transaksi->update([
                'status_penjualan' => 'tervalidasi',
                'tanggal_validasi' => now()->toDateString(),
            ]);
        });

        return redirect()
            ->route('transaksi.show', $transaksi)
            ->with('success', 'Transaksi berhasil divalidasi.');
    }
}