@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('header', 'Laporan Stok')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Laporan Stok Produk
        </h1>

        <p class="text-gray-500 mt-1">
            Informasi stok produk PT Halus Ciptanadi
        </p>
    </div>


    {{-- RINGKASAN --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- TOTAL PRODUK --}}

        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500">
                Total Produk Aktif
            </p>

            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ $totalProduk }}
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Produk yang masih aktif
            </p>

        </div>


        {{-- TOTAL STOK --}}

        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500">
                Total Stok
            </p>

            <h2 class="text-3xl font-bold text-gray-800 mt-2">
                {{ number_format($totalStok, 0, ',', '.') }}
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Jumlah seluruh stok produk
            </p>

        </div>


        {{-- STOK RENDAH --}}

        <div class="bg-white rounded-xl shadow-sm border p-6">

            <p class="text-sm text-gray-500">
                Stok Rendah
            </p>

            <h2 class="text-3xl font-bold mt-2
                {{ $stokRendah > 0
                    ? 'text-red-600'
                    : 'text-green-600' }}">

                {{ $stokRendah }}

            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Produk dengan stok ≤ 10
            </p>

        </div>

    </div>


    {{-- TABEL STOK --}}

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="px-6 py-5 border-b">

            <h2 class="font-bold text-gray-800">
                Data Stok Produk
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Daftar stok seluruh produk
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Kode Produk
                        </th>

                        <th class="px-6 py-4 text-left">
                            Nama Produk
                        </th>

                        <th class="px-6 py-4 text-left">
                            Kategori
                        </th>

                        <th class="px-6 py-4 text-left">
                            Satuan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Stok
                        </th>

                        <th class="px-6 py-4 text-left">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($produk as $item)

                        <tr class="hover:bg-gray-50">

                            {{-- NO --}}

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            {{-- KODE PRODUK --}}

                            <td class="px-6 py-4 font-medium">
                                {{ $item->kode_produk ?? '-' }}
                            </td>


                            {{-- NAMA PRODUK --}}

                            <td class="px-6 py-4">
                                {{ $item->nama_produk }}
                            </td>


                            {{-- KATEGORI --}}

                            <td class="px-6 py-4">
                                {{ $item->kategori_produk ?? '-' }}
                            </td>


                            {{-- SATUAN --}}

                            <td class="px-6 py-4">
                                {{ $item->satuan_produk ?? '-' }}
                            </td>


                            {{-- STOK --}}

                            <td class="px-6 py-4">

                                @if($item->stok_produk <= 10)

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">

                                        {{ number_format($item->stok_produk, 0, ',', '.') }}

                                    </span>

                                @elseif($item->stok_produk <= 20)

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">

                                        {{ number_format($item->stok_produk, 0, ',', '.') }}

                                    </span>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                                        {{ number_format($item->stok_produk, 0, ',', '.') }}

                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td class="px-6 py-4">

                                @if($item->status_produk === 'aktif')

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">

                                        Aktif

                                    </span>

                                @else

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">

                                        Nonaktif

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-10 text-center text-gray-500"
                            >
                                Belum ada data produk.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection