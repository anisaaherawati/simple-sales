@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('header', 'Detail Transaksi')

@section('content')

<div class="max-w-5xl">

    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Detail Transaksi
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $transaksi->nomor_penjualan }}
            </p>
        </div>

        @if($transaksi->status_penjualan === 'menunggu_validasi')

            <form
                action="{{ route('transaksi.validasi', $transaksi) }}"
                method="POST"
                onsubmit="return confirm('Validasi transaksi ini? Stok produk akan dikurangi.')"
            >

                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700"
                >
                    Validasi Transaksi
                </button>

            </form>

        @endif

    </div>

    @if(session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5">
            {{ session('success') }}
        </div>

    @endif

    @if($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5">

            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif

    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-500">
                    Nomor Transaksi
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->nomor_penjualan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Tanggal
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->tanggal_penjualan->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Sales
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->user->nama_user }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Status
                </p>

                <p class="font-medium mt-1">
                    {{ ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $transaksi->status_penjualan
                        )
                    ) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Pelanggan
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->pelanggan->nama_pelanggan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Nama Toko
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->pelanggan->nama_toko }}
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

                @foreach($transaksi->detailPenjualan as $detail)

                    <tr>

                        <td class="px-5 py-4">
                            {{ $detail->produk->nama_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format(
                                $detail->harga_satuan,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $detail->jumlah_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format(
                                $detail->subtotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot class="bg-gray-50">

                <tr>

                    <td
                        colspan="3"
                        class="text-right px-5 py-4 font-bold"
                    >
                        Total
                    </td>

                    <td class="px-5 py-4 font-bold">
                        Rp {{ number_format(
                            $transaksi->total_penjualan,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    <div class="mt-6">

        <a
            href="{{ route('transaksi.index') }}"
            class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg"
        >
            Kembali
        </a>

    </div>

</div>

@endsection