@extends('layouts.app')

@section('title', 'Order Penjualan')

@section('header', 'Order Penjualan')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Order Penjualan
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola order penjualan Anda.
        </p>
    </div>

    <a
        href="{{ route('order.create') }}"
        class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 text-center"
    >
        Tambah Order
    </a>

</div>

@if(session('success'))

    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5">
        {{ session('success') }}
    </div>

@endif

<div class="bg-white border border-gray-200 rounded-xl">

    <div class="p-5 border-b border-gray-200">

        <form
            action="{{ route('order.index') }}"
            method="GET"
            class="flex flex-col sm:flex-row gap-3"
        >

            <input
                type="text"
                name="cari"
                value="{{ $cari }}"
                placeholder="Cari nomor order, pelanggan, atau toko..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5"
            >

            <button
                type="submit"
                class="bg-slate-900 text-white px-5 py-2.5 rounded-lg"
            >
                Cari
            </button>

            @if($cari)

                <a
                    href="{{ route('order.index') }}"
                    class="bg-gray-100 px-5 py-2.5 rounded-lg text-center"
                >
                    Reset
                </a>

            @endif

        </form>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600">

                <tr>
                    <th class="text-left px-5 py-4">No</th>
                    <th class="text-left px-5 py-4">Nomor Order</th>
                    <th class="text-left px-5 py-4">Tanggal</th>
                    <th class="text-left px-5 py-4">Pelanggan</th>
                    <th class="text-left px-5 py-4">Toko</th>
                    <th class="text-left px-5 py-4">Total</th>
                    <th class="text-left px-5 py-4">Status</th>
                    <th class="text-left px-5 py-4">Aksi</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($order as $item)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4">
                            {{ $order->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-medium">
                            {{ $item->nomor_penjualan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->tanggal_penjualan->format('d/m/Y') }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->pelanggan->nama_pelanggan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->pelanggan->nama_toko }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($item->total_penjualan, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4">

                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                                {{ str_replace('_', ' ', ucfirst($item->status_penjualan)) }}
                            </span>

                        </td>
                        <td class="px-5 py-4">

                            <div class="flex gap-2">

                                <a
                                    href="{{ route('order.show', $item) }}"
                                    class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200"
                                >
                                    Detail
                                </a>

                                @if($item->status_penjualan === 'menunggu_validasi')

                                    <a
                                        href="{{ route('order.edit', $item) }}"
                                        class="bg-amber-100 text-amber-700 px-3 py-2 rounded-lg hover:bg-amber-200"
                                    >
                                        Ubah
                                    </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="8"
                            class="text-center text-gray-500 px-5 py-10"
                        >
                            Order penjualan belum tersedia.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($order->hasPages())

        <div class="p-5 border-t">
            {{ $order->links() }}
        </div>

    @endif

</div>

@endsection