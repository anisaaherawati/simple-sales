@extends('layouts.app')

@section('title', 'Dashboard Direktur')

@section('header', 'Dashboard Direktur')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">
        Selamat datang, {{ auth()->user()->nama_user }}
    </h1>

    <p class="text-gray-500 mt-1">
        Pantau penjualan dan kondisi stok perusahaan.
    </p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Total Penjualan
        </p>

        <p class="text-2xl font-bold mt-3">
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Transaksi Selesai
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $totalTransaksi }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Produk Aktif
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $totalProduk }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Stok Rendah
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $stokRendah }}
        </p>
    </div>

</div>

@endsection