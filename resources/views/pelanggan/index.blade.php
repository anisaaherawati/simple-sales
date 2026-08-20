@extends('layouts.app')

@section('title', 'Data Pelanggan')

@section('header', 'Data Pelanggan')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Data Pelanggan
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola data pelanggan.
        </p>
    </div>

    <a
        href="{{ route('pelanggan.create') }}"
        class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 text-center"
    >
        Tambah Pelanggan
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
            action="{{ route('pelanggan.index') }}"
            method="GET"
            class="flex flex-col sm:flex-row gap-3"
        >

            <input
                type="text"
                name="cari"
                value="{{ $cari }}"
                placeholder="Cari pelanggan, toko, kode, atau WhatsApp..."
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
                    href="{{ route('pelanggan.index') }}"
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
                    <th class="text-left px-5 py-4">Kode</th>
                    <th class="text-left px-5 py-4">Nama Pelanggan</th>
                    <th class="text-left px-5 py-4">Nama Toko</th>
                    <th class="text-left px-5 py-4">WhatsApp</th>
                    <th class="text-left px-5 py-4">Alamat</th>
                    <th class="text-left px-5 py-4">Status</th>
                    <th class="text-left px-5 py-4">Aksi</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($pelanggan as $item)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4">
                            {{ $pelanggan->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->kode_pelanggan }}
                        </td>

                        <td class="px-5 py-4 font-medium">
                            {{ $item->nama_pelanggan }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->nama_toko }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->no_wa }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->alamat_pelanggan }}
                        </td>

                        <td class="px-5 py-4">

                            @if($item->status_pelanggan === 'aktif')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Aktif
                                </span>

                            @else

                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
                                    Nonaktif
                                </span>

                            @endif

                        </td>

                        <td class="px-5 py-4">

                            <div class="flex gap-2">

                                <a
                                    href="{{ route('pelanggan.edit', $item) }}"
                                    class="bg-amber-100 text-amber-700 px-3 py-2 rounded-lg"
                                >
                                    Ubah
                                </a>

                                @if($item->status_pelanggan === 'aktif')

                                    <form
                                        action="{{ route('pelanggan.nonaktifkan', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Nonaktifkan pelanggan ini?')"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="bg-red-100 text-red-700 px-3 py-2 rounded-lg"
                                        >
                                            Nonaktifkan
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center text-gray-500 px-5 py-10">
                            Data pelanggan belum tersedia.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($pelanggan->hasPages())

        <div class="p-5 border-t">
            {{ $pelanggan->links() }}
        </div>

    @endif

</div>

@endsection