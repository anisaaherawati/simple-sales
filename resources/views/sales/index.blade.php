@extends('layouts.app')

@section('title', 'Data Sales')

@section('header', 'Data Sales')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Data Sales
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola data sales perusahaan.
        </p>
    </div>

    <a
        href="{{ route('sales.create') }}"
        class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 text-center"
    >
        Tambah Sales
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
            action="{{ route('sales.index') }}"
            method="GET"
            class="flex flex-col sm:flex-row gap-3"
        >

            <input
                type="text"
                name="cari"
                value="{{ $cari }}"
                placeholder="Cari nama, username, atau nomor telepon..."
                class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-slate-900"
            >

            <button
                type="submit"
                class="bg-slate-900 text-white px-5 py-2.5 rounded-lg"
            >
                Cari
            </button>

            @if($cari)

                <a
                    href="{{ route('sales.index') }}"
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
                    <th class="text-left px-5 py-4">Nama Sales</th>
                    <th class="text-left px-5 py-4">Username</th>
                    <th class="text-left px-5 py-4">No. Telepon</th>
                    <th class="text-left px-5 py-4">Alamat</th>
                    <th class="text-left px-5 py-4">Status</th>
                    <th class="text-left px-5 py-4">Aksi</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100">

                @forelse($sales as $item)

                    <tr class="hover:bg-gray-50">

                        <td class="px-5 py-4">
                            {{ $sales->firstItem() + $loop->index }}
                        </td>

                        <td class="px-5 py-4 font-medium">
                            {{ $item->nama_user }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->username }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->no_telp }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $item->alamat }}
                        </td>

                        <td class="px-5 py-4">

                            @if($item->status_user === 'aktif')

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
                                    href="{{ route('sales.edit', $item) }}"
                                    class="bg-amber-100 text-amber-700 px-3 py-2 rounded-lg"
                                >
                                    Ubah
                                </a>

                                @if($item->status_user === 'aktif')

                                    <form
                                        action="{{ route('sales.nonaktifkan', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Nonaktifkan sales ini?')"
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

                                @else

                                    <form
                                        action="{{ route('sales.aktifkan', $item) }}"
                                        method="POST"
                                        onsubmit="return confirm('Aktifkan kembali sales ini?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="bg-green-100 text-green-700 px-3 py-2 rounded-lg"
                                        >
                                            Aktifkan
                                        </button>
                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="7"
                            class="text-center text-gray-500 px-5 py-10"
                        >
                            Data sales belum tersedia.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($sales->hasPages())

        <div class="p-5 border-t border-gray-200">
            {{ $sales->links() }}
        </div>

    @endif

</div>

@endsection