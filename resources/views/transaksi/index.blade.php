@extends('layouts.app')

@section('title', 'Transaksi Penjualan')

@section('header', 'Transaksi Penjualan')

@section('content')

<div class="mb-6">

    <h1 class="text-2xl font-bold text-gray-900">
        Transaksi Penjualan
    </h1>

    <p class="text-gray-500 mt-1">
        Kelola dan validasi transaksi penjualan dari Sales.
    </p>

</div>


@if(session('success'))

    <div
        class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5"
    >
        {{ session('success') }}
    </div>

@endif


<div class="bg-white border border-gray-200 rounded-xl">

    <div class="p-5 border-b border-gray-200">

        <form
            action="{{ route('transaksi.index') }}"
            method="GET"
            class="flex flex-col lg:flex-row gap-3"
        >

            <input
                type="text"
                name="cari"
                value="{{ $cari }}"
                placeholder="Cari nomor transaksi, pelanggan, toko, atau sales..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5"
            >

            <select
                name="status"
                class="border border-gray-300 rounded-lg px-4 py-2.5"
            >

                <option value="">
                    Semua Status
                </option>

                <option
                    value="menunggu_validasi"
                    {{ $status === 'menunggu_validasi' ? 'selected' : '' }}
                >
                    Menunggu Validasi
                </option>

                <option
                    value="tervalidasi"
                    {{ $status === 'tervalidasi' ? 'selected' : '' }}
                >
                    Tervalidasi
                </option>

                <option
                    value="diproses"
                    {{ $status === 'diproses' ? 'selected' : '' }}
                >
                    Diproses
                </option>

                <option
                    value="dikirim"
                    {{ $status === 'dikirim' ? 'selected' : '' }}
                >
                    Dikirim
                </option>

                <option
                    value="selesai"
                    {{ $status === 'selesai' ? 'selected' : '' }}
                >
                    Selesai
                </option>

            </select>

            <button
                type="submit"
                class="bg-slate-900 text-white px-5 py-2.5 rounded-lg"
            >
                Cari
            </button>

            @if($cari || $status)

                <a
                    href="{{ route('transaksi.index') }}"
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

                    <th class="text-left px-5 py-4">
                        No
                    </th>

                    <th class="text-left px-5 py-4">
                        Nomor Transaksi
                    </th>

                    <th class="text-left px-5 py-4">
                        Tanggal
                    </th>

                    <th class="text-left px-5 py-4">
                        Sales
                    </th>

                    <th class="text-left px-5 py-4">
                        Pelanggan
                    </th>

                    <th class="text-left px-5 py-4">
                        Total
                    </th>

                    <th class="text-left px-5 py-4">
                        Status
                    </th>

                    <th class="text-left px-5 py-4">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-100">

                @forelse($transaksi as $item)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4">
                            {{ $transaksi->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-medium">
                            {{ $item->nomor_penjualan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->tanggal_penjualan->format('d/m/Y') }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->user->nama_user }}
                        </td>

                        <td class="px-5 py-4">

                            {{ $item->pelanggan->nama_pelanggan }}

                            <p class="text-xs text-gray-500">
                                {{ $item->pelanggan->nama_toko }}
                            </p>

                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format(
                                $item->total_penjualan,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="px-5 py-4">

                            <span
                                class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs"
                            >
                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $item->status_penjualan
                                    )
                                ) }}
                            </span>

                        </td>

                        <td class="px-5 py-4">

                            <a
                                href="{{ route('transaksi.show', $item) }}"
                                class="bg-blue-100 text-blue-700 px-3 py-2 rounded-lg hover:bg-blue-200"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center text-gray-500 px-5 py-10"
                        >
                            Data transaksi belum tersedia.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    @if($transaksi->hasPages())

        <div class="p-5 border-t border-gray-200">
            {{ $transaksi->links() }}
        </div>

    @endif

</div>

@endsection