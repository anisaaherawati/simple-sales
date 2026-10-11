<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

        return view(
            'transaksi.show',
            compact('transaksi')
        );
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
                    'transaksi' =>
                        'Transaksi ini sudah diproses sebelumnya.'
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


        /*
        |--------------------------------------------------------------------------
        | KIRIM WHATSAPP OTOMATIS
        |--------------------------------------------------------------------------
        */

        $transaksi->load([
            'pelanggan',
            'user',
            'detailPenjualan.produk'
        ]);

        $hasilWa = $this->kirimNotaOtomatis($transaksi);


        if ($hasilWa) {

            return redirect()
                ->route('transaksi.show', $transaksi)
                ->with(
                    'success',
                    'Transaksi berhasil divalidasi dan pesan WhatsApp berhasil dikirim ke customer.'
                );
        }


        return redirect()
            ->route('transaksi.show', $transaksi)
            ->with(
                'warning',
                'Transaksi berhasil divalidasi, tetapi pesan WhatsApp gagal dikirim.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FUNGSI KIRIM WHATSAPP
    |--------------------------------------------------------------------------
    */

    private function kirimNotaOtomatis(Penjualan $transaksi)
    {
        $transaksi->load('pelanggan');

        if (!$transaksi->pelanggan || !$transaksi->pelanggan->no_wa) {
            return false;
        }

        $nomor = $transaksi->pelanggan->no_wa;


        // Bersihkan nomor
        $nomor = preg_replace(
            '/[^0-9]/',
            '',
            $nomor
        );


        // Ubah 08xxx menjadi 628xxx
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }


        $namaPelanggan =
            $transaksi->pelanggan->nama_pelanggan;


        /*
        |--------------------------------------------------------------------------
        | PESAN WHATSAPP
        |--------------------------------------------------------------------------
        */

        $pesan =
            "Halo, {$namaPelanggan}.\n\n" .

            "Pesanan Anda dari PT Halus Ciptanadi " .
            "telah divalidasi.\n\n" .

            "Nomor transaksi: " .
            "{$transaksi->nomor_penjualan}\n" .

            "Total: Rp " .
            number_format(
                $transaksi->total_penjualan,
                0,
                ',',
                '.'
            ) .

            "\n\n" .

            "Terima kasih telah melakukan pemesanan " .
            "di PT Halus Ciptanadi.";


        /*
        |--------------------------------------------------------------------------
        | KIRIM KE FONNTE
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::timeout(15)
                ->withHeaders([
                    'Authorization' =>
                        config('services.fonnte.token'),
                ])
                ->asForm()
                ->post(
                    'https://api.fonnte.com/send',
                    [
                        'target' => $nomor,
                        'message' => $pesan,
                        'countryCode' => '62',
                    ]
                );


            /*
            |--------------------------------------------------------------------------
            | LOG RESPONSE FONNTE
            |--------------------------------------------------------------------------
            */

            \Log::info(
                'Response Fonnte',
                [
                    'transaksi' =>
                        $transaksi->nomor_penjualan,

                    'nomor' => $nomor,

                    'response' =>
                        $response->json(),
                ]
            );


            if ($response->successful() && $response->json('status') === true) {

                $transaksi->update([
                    'status_wa' => 'terkirim',
                ]);
            
                return true;
            }
            
            $transaksi->update([
                'status_wa' => 'gagal',
            ]);
            
            return false;   


        } catch (\Exception $e) {

            $transaksi->update([
                'status_wa' => 'gagal',
            ]);
        
            \Log::error(
                'Gagal mengirim WhatsApp Fonnte',
                [
                    'transaksi' => $transaksi->nomor_penjualan,
                    'nomor' => $nomor,
                    'error' => $e->getMessage(),
                ]
            );
        
            return false;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | KIRIM NOTA MANUAL
    |--------------------------------------------------------------------------
    */

    public function kirimNota(Penjualan $transaksi)
    {
        if (
            $transaksi->status_penjualan !==
            'tervalidasi'
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Nota hanya bisa dikirim setelah transaksi divalidasi.'
                );
        }


        $transaksi->load('pelanggan');


        if (!$transaksi->pelanggan) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Data pelanggan tidak ditemukan.'
                );
        }


        if (!$transaksi->pelanggan->no_wa) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Nomor WhatsApp pelanggan belum diisi.'
                );
        }


        $hasil = $this->kirimNotaOtomatis(
            $transaksi
        );


        if (!$hasil) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Gagal mengirim WhatsApp melalui Fonnte.'
                );
        }


        return redirect()
            ->back()
            ->with(
                'success',
                'Pesan WhatsApp berhasil dikirim ke customer.'
            );
    }
}