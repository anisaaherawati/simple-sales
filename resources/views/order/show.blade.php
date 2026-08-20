@extends('layouts.app')

@section('title', 'Detail Order')

@section('header', 'Detail Order')

@section('content')

<div class="max-w-5xl">

    <div class="flex justify-between items-start mb-6">

        <div>
            <h1 class="text-2xl font-bold">
                Detail Order
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $order->nomor_penjualan }}
            </p>
        </div>

        <button
            onclick="window.print()"
            class="bg-slate-900 text-white px-5 py-2.5 rounded-lg"
        >
            Cetak Nota
        </button>

    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-500">
                    Tanggal
                </p>

                <p class="font-medium mt-1">
                    {{ $order->tanggal_penjualan->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Status
                </p>

                <p class="font-medium mt-1">
                    {{ str_replace('_', ' ', ucfirst($order->status_penjualan)) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Pelanggan
                </p>

                <p class="font-medium mt-1">
                    {{ $order->pelanggan->nama_pelanggan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Toko
                </p>

                <p class="font-medium mt-1">
                    {{ $order->pelanggan->nama_toko }}
                </p>
            </div>

        </div>

    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50">

                <tr>
                    <th class="text-left px-5 py-4">
                        Produk
                    </th>

                    <th class="text-left px-5 py-4">
                        Harga
                    </th>

                    <th class="text-left px-5 py-4">
                        Jumlah
                    </th>

                    <th class="text-left px-5 py-4">
                        Subtotal
                    </th>
                </tr>

            </thead>

            <tbody class="divide-y">

                @foreach($order->detailPenjualan as $detail)

                    <tr>

                        <td class="px-5 py-4">
                            {{ $detail->produk->nama_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $detail->jumlah_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot class="bg-gray-50">

                <tr>

                    <td
                        colspan="3"
                        class="px-5 py-4 font-bold text-right"
                    >
                        Total
                    </td>

                    <td class="px-5 py-4 font-bold">
                        Rp {{ number_format($order->total_penjualan, 0, ',', '.') }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    <div class="mt-6">

        <a
            href="{{ route('order.index') }}"
            class="bg-gray-100 px-5 py-2.5 rounded-lg"
        >
            Kembali
        </a>

    </div>

</div>

@endsection