@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('header', 'Tambah Pelanggan')

@section('content')

<div class="max-w-3xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Tambah Data Pelanggan
        </h1>

        <p class="text-gray-500 mt-1">
            Masukkan informasi pelanggan baru.
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">

        <form action="{{ route('pelanggan.store') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Kode Pelanggan
                    </label>

                    <input
                        type="text"
                        name="kode_pelanggan"
                        value="{{ old('kode_pelanggan') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Contoh: PLG001"
                    >

                    @error('kode_pelanggan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Pelanggan
                    </label>

                    <input
                        type="text"
                        name="nama_pelanggan"
                        value="{{ old('nama_pelanggan') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Nama pelanggan"
                    >

                    @error('nama_pelanggan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Toko
                    </label>

                    <input
                        type="text"
                        name="nama_toko"
                        value="{{ old('nama_toko') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Nama toko"
                    >

                    @error('nama_toko')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nomor WhatsApp
                    </label>

                    <input
                        type="text"
                        name="no_wa"
                        value="{{ old('no_wa') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="08xxxxxxxxxx"
                    >

                    @error('no_wa')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2">

                    <label class="block text-sm font-medium mb-2">
                        Alamat Pelanggan
                    </label>

                    <textarea
                        name="alamat_pelanggan"
                        rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Alamat pelanggan"
                    >{{ old('alamat_pelanggan') }}</textarea>

                    @error('alamat_pelanggan')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            <div class="flex gap-3 mt-6">

                <a
                    href="{{ route('pelanggan.index') }}"
                    class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800"
                >
                    Simpan Pelanggan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection