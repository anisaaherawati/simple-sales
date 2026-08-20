@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('header', 'Tambah Produk')

@section('content')

<div class="max-w-3xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Tambah Data Produk
        </h1>

        <p class="text-gray-500 mt-1">
            Masukkan informasi produk baru.
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">

        <form action="{{ route('produk.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Kode Produk
                    </label>

                    <input
                        type="text"
                        name="kode_produk"
                        value="{{ old('kode_produk') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Contoh: PRD001"
                    >

                    @error('kode_produk')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Produk
                    </label>

                    <input
                        type="text"
                        name="nama_produk"
                        value="{{ old('nama_produk') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Nama produk"
                    >

                    @error('nama_produk')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Kategori Produk
                    </label>

                    <input
                        type="text"
                        name="kategori_produk"
                        value="{{ old('kategori_produk') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Kategori produk"
                    >

                    @error('kategori_produk')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Harga Produk
                    </label>

                    <input
                        type="number"
                        name="harga_produk"
                        value="{{ old('harga_produk') }}"
                        min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="0"
                    >

                    @error('harga_produk')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Stok Produk
                    </label>

                    <input
                        type="number"
                        name="stok_produk"
                        value="{{ old('stok_produk') }}"
                        min="0"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="0"
                    >

                    @error('stok_produk')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Satuan Produk
                    </label>

                    <input
                        type="text"
                        name="satuan_produk"
                        value="{{ old('satuan_produk') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Contoh: pcs, box, dus"
                    >

                    @error('satuan_produk')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="flex gap-3 mt-6">

                <a
                    href="{{ route('produk.index') }}"
                    class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800"
                >
                    Simpan Produk
                </button>

            </div>

        </form>

    </div>

</div>

@endsection