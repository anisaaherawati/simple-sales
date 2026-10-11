@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('header', 'Laporan Penjualan')

@section('content')

<div class="space-y-6">

    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <form action="{{ route('laporan.direktur') }}" method="GET">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="tanggal_mulai"
                        value="{{ $tanggalMulai }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-800"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai
                    </label>

                    <input
                        type="date"
                        name="tanggal_selesai"
                        value="{{ $tanggalSelesai }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-slate-800"
                    >
                </div>

                <div class="flex gap-2">

                    <button
                        type="submit"
                        class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800"
                    >
                        Tampilkan
                    </button>

                    <a
                        href="{{ route('laporan.direktur') }}"
                        class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <p class="text-sm text-gray-500">
                Total Transaksi
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                {{ number_format($totalTransaksi, 0, ',', '.') }}
            </h3>

            <p class="text-sm text-gray-400 mt-2">
                Transaksi tervalidasi
            </p>

        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <p class="text-sm text-gray-500">
                Total Omzet
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                Rp {{ number_format($totalOmzet, 0, ',', '.') }}
            </h3>

            <p class="text-sm text-gray-400 mt-2">
                Dari transaksi tervalidasi
            </p>

        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <p class="text-sm text-gray-500">
                Pelanggan
            </p>

            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                {{ number_format($totalPelanggan, 0, ',', '.') }}
            </h3>

            <p class="text-sm text-gray-400 mt-2">
                Pelanggan yang melakukan transaksi
            </p>

        </div>

    </div>


    {{-- PRODUK TERLARIS --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="p-6 border-b border-gray-200">

            <h3 class="text-lg font-bold text-gray-800">
                Produk Terlaris
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                5 produk dengan jumlah penjualan terbanyak
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="text-left px-6 py-4 font-semibold text-gray-600">
                            No
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-600">
                            Produk
                        </th>

                        <th class="text-right px-6 py-4 font-semibold text-gray-600">
                            Jumlah Terjual
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($produkTerlaris as $index => $produk)

                        <tr class="border-t border-gray-100">

                            <td class="px-6 py-4">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $produk->nama_produk }}
                            </td>

                            <td class="px-6 py-4 text-right">
                                {{ number_format($produk->total_terjual, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="px-6 py-8 text-center text-gray-500"
                            >
                                Belum ada data penjualan.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- DETAIL PENJUALAN --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <div class="p-6 border-b border-gray-200">

            <h3 class="text-lg font-bold text-gray-800">
                Detail Penjualan
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Daftar transaksi yang sudah divalidasi Admin
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="text-left px-6 py-4 font-semibold text-gray-600">
                            No
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-600">
                            Nomor Transaksi
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-600">
                            Tanggal
                        </th>

                        <th class="text-left px-6 py-4 font-semibold text-gray-600">
                            Pelanggan
                        </th>

                        <th class="text-right px-6 py-4 font-semibold text-gray-600">
                            Total
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($penjualan as $index => $item)

                        <tr class="border-t border-gray-100">

                            <td class="px-6 py-4">
                                {{ $penjualan->firstItem() + $index }}
                            </td>

                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $item->nomor_penjualan }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->tanggal_penjualan?->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="font-medium">
                                    {{ $item->pelanggan->nama_pelanggan ?? '-' }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ $item->pelanggan->nama_toko ?? '-' }}
                                </div>

                            </td>

                            <td class="px-6 py-4 text-right font-medium">
                                Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-8 text-center text-gray-500"
                            >
                                Belum ada transaksi tervalidasi.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($penjualan->hasPages())

            <div class="p-6 border-t border-gray-200">
                {{ $penjualan->links() }}
            </div>

        @endif

    </div>

</div>

@endsection