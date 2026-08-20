@extends('layouts.app')

@section('title', 'Dashboard Sales')

@section('header', 'Dashboard Sales')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">
        Selamat datang, {{ auth()->user()->nama_user }}
    </h1>

    <p class="text-gray-500 mt-1">
        Kelola pelanggan dan order penjualan Anda.
    </p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Total Order
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $totalOrder }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Menunggu Validasi
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $orderMenunggu }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Dikirim
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $orderDikirim }}
        </p>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6">
        <p class="text-sm text-gray-500">
            Selesai
        </p>

        <p class="text-3xl font-bold mt-3">
            {{ $orderSelesai }}
        </p>
    </div>

</div>

@endsection