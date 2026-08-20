@extends('layouts.app')

@section('title', 'Ubah Sales')

@section('header', 'Ubah Sales')

@section('content')

<div class="max-w-3xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Ubah Data Sales
        </h1>

        <p class="text-gray-500 mt-1">
            Ubah informasi sales yang dipilih.
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">

        <form action="{{ route('sales.update', $sales) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Nama Sales
                    </label>

                    <input
                        type="text"
                        name="nama_user"
                        value="{{ old('nama_user', $sales->nama_user) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                    >

                    @error('nama_user')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username', $sales->username) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                    >

                    @error('username')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        placeholder="Kosongkan jika tidak ingin mengganti"
                    >

                    @error('password')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">
                        No. Telepon
                    </label>

                    <input
                        type="text"
                        name="no_telp"
                        value="{{ old('no_telp', $sales->no_telp) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                    >

                    @error('no_telp')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="md:col-span-2">

                    <label class="block text-sm font-medium mb-2">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                    >{{ old('alamat', $sales->alamat) }}</textarea>

                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            <div class="flex gap-3 mt-6">

                <a
                    href="{{ route('sales.index') }}"
                    class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection