@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('header', 'Dashboard Admin')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">
        Selamat datang, {{ auth()->user()->nama_user }}
    </h1>

    <p class="text-gray-500 mt-1">
        Kelola data dan transaksi penjualan melalui dashboard.
    </p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

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
            Sales Aktif
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $totalSales }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Pelanggan Aktif
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $totalPelanggan }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Menunggu Validasi
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $transaksiMenunggu }}
        </p>
    </div>

</div>

@endsection