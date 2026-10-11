@extends('layouts.app')

@section('title', 'Detail Order')

@section('header', 'Detail Order')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-5">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-5">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-5xl">

    <div class="flex justify-between items-start mb-6">

        <div>
            <h1 class="text-2xl font-bold">
                Detail Order
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $order->nomor_penjualan }}
            </p>
        </div>

        <button
            onclick="window.print()"
            class="bg-slate-900 text-white px-5 py-2.5 rounded-lg"
        >
            Cetak Nota
        </button>

    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-500">
                    Tanggal
                </p>

                <p class="font-medium mt-1">
                    {{ $order->tanggal_penjualan->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Status
                </p>

                <p class="font-medium mt-1">
                    {{ str_replace('_', ' ', ucfirst($order->status_penjualan)) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Pelanggan
                </p>

                <p class="font-medium mt-1">
                    {{ $order->pelanggan->nama_pelanggan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Toko
                </p>

                <p class="font-medium mt-1">
                    {{ $order->pelanggan->nama_toko }}
                </p>
            </div>

        </div>

    </div>


    {{-- TIMELINE STATUS ORDER --}}
@php
    $status = $order->status_penjualan;

    $validasiSelesai = in_array($status, [
        'tervalidasi',
        'dikirim',
        'menunggu_konfirmasi',
        'selesai'
    ]);

    $pengantaranDimulai = in_array($status, [
        'dikirim',
        'menunggu_konfirmasi',
        'selesai'
    ]);

    $buktiTerupload = $order->buktiPenyerahans->isNotEmpty()
        || !empty($order->foto_bukti_penyerahan);

    $pesananSelesai = $status === 'selesai';
@endphp

<div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">
    <h2 class="text-lg font-bold mb-6">Status Pesanan</h2>

    <div class="relative">
        <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-gray-200"></div>

        {{-- ORDER DIBUAT --}}
        <div class="relative flex gap-4 mb-7">
            <div class="relative z-10 w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white">
                ✓
            </div>
            <div>
                <p class="font-semibold">Order Dibuat</p>
                <p class="text-sm text-gray-500">
                    {{ $order->tanggal_penjualan->format('d/m/Y') }}
                </p>
            </div>
        </div>

        {{-- VALIDASI ADMIN --}}
        <div class="relative flex gap-4 mb-7">
            <div class="relative z-10 w-10 h-10 rounded-full {{ $validasiSelesai ? 'bg-green-500 text-white' : 'bg-yellow-400 text-white' }} flex items-center justify-center">
                {{ $validasiSelesai ? '✓' : '2' }}
            </div>
            <div>
                <p class="font-semibold">Validasi Admin</p>
                <p class="text-sm {{ $validasiSelesai ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ $validasiSelesai ? 'Pesanan telah divalidasi admin' : 'Menunggu validasi admin' }}
                </p>
            </div>
        </div>

        {{-- NOTA WHATSAPP --}}
        <div class="relative flex gap-4 mb-7">
            <div class="relative z-10 w-10 h-10 rounded-full {{ $validasiSelesai ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }} flex items-center justify-center">
                {{ $validasiSelesai ? '✓' : '3' }}
            </div>
            <div>
                <p class="font-semibold">Nota WhatsApp</p>
                <p class="text-sm {{ $validasiSelesai ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $validasiSelesai ? 'Pesanan telah divalidasi untuk pengiriman nota' : 'Menunggu validasi transaksi' }}
                </p>
            </div>
        </div>

        {{-- PESANAN DIANTAR --}}
        <div class="relative flex gap-4 mb-7">
            <div class="relative z-10 w-10 h-10 rounded-full {{ $pengantaranDimulai ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }} flex items-center justify-center">
                {{ $pengantaranDimulai ? '✓' : '4' }}
            </div>
            <div>
                <p class="font-semibold">Pesanan Diantar</p>
                <p class="text-sm {{ $pengantaranDimulai ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $pengantaranDimulai ? 'Pengantaran telah dimulai' : 'Menunggu pesanan diantar' }}
                </p>
            </div>
        </div>

        {{-- BUKTI PENYERAHAN --}}
        <div class="relative flex gap-4 mb-7">
            <div class="relative z-10 w-10 h-10 rounded-full {{ $buktiTerupload ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }} flex items-center justify-center">
                {{ $buktiTerupload ? '✓' : '5' }}
            </div>
            <div>
                <p class="font-semibold">Bukti Penyerahan</p>

                @if($status === 'menunggu_konfirmasi')
                    <p class="text-sm text-yellow-600">Menunggu konfirmasi admin</p>
                @elseif($buktiTerupload && $status === 'dikirim')
                    <p class="text-sm text-orange-600">Bukti ditolak atau perlu diunggah ulang</p>
                @elseif($buktiTerupload && $pesananSelesai)
                    <p class="text-sm text-green-600">Bukti penyerahan telah dikonfirmasi</p>
                @else
                    <p class="text-sm text-gray-500">Menunggu upload bukti penyerahan</p>
                @endif
            </div>
        </div>

        {{-- PESANAN SELESAI --}}
        <div class="relative flex gap-4">
            <div class="relative z-10 w-10 h-10 rounded-full {{ $pesananSelesai ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-500' }} flex items-center justify-center">
                {{ $pesananSelesai ? '✓' : '6' }}
            </div>
            <div>
                <p class="font-semibold">Pesanan Selesai</p>
                <p class="text-sm {{ $pesananSelesai ? 'text-green-600' : 'text-gray-500' }}">
                    {{ $pesananSelesai ? 'Pesanan telah selesai diserahkan kepada pelanggan' : 'Menunggu konfirmasi bukti penyerahan' }}
                </p>
            </div>
        </div>
    </div>
</div>
    
    @if($order->alasan_penolakan)

        <div class="bg-red-50 border border-red-200 rounded-xl p-5 mb-5">

            <div class="flex items-start gap-3">

                <div class="w-9 h-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                    !
                </div>

                <div>
                    <p class="font-semibold text-red-700">
                        Bukti Penyerahan Ditolak
                    </p>

                    <p class="text-sm text-red-600 mt-1">
                        Admin meminta Anda mengupload ulang bukti penyerahan.
                    </p>

                    <p class="text-sm text-gray-700 mt-3">
                        <span class="font-medium">
                            Alasan:
                        </span>

                        {{ $order->alasan_penolakan }}
                    </p>

                </div>

            </div>

        </div>

    @endif

        {{-- AKSI PENGANTARAN --}}

    @if($order->status_penjualan === 'tervalidasi')

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <h2 class="text-lg font-bold mb-2">
                Pengantaran Pesanan
            </h2>

            <p class="text-sm text-gray-500 mb-5">
                Pesanan sudah divalidasi admin dan siap diantar ke pelanggan.
            </p>

            <form
                action="{{ route('order.dikirim', $order) }}"
                method="POST"
            >
                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800"
                >
                    Mulai Antar Pesanan
                </button>

            </form>

        </div>

    @endif


    @if($order->status_penjualan === 'dikirim')

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <h2 class="text-lg font-bold mb-2">
                Selesaikan Pesanan
            </h2>

            <p class="text-sm text-gray-500 mb-5">
                Upload foto bukti bahwa pesanan sudah diterima pelanggan.
            </p>

            <form
                action="{{ route('order.selesaikan', $order) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mb-5">

                    <label class="block text-sm font-medium mb-2">
                        Bukti Penyerahan
                    </label>

                    <input
                        type="file"
                        name="foto_bukti_penyerahan"
                        accept="image/jpeg,image/png"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    >

                    @error('foto_bukti_penyerahan')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <button
                    type="submit"
                    class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700"
                >
                    Upload Bukti Penyerahan
                </button>

            </form>

        </div>

    @endif


    @if($order->status_penjualan === 'selesaikan' && $order->foto_bukti_penyerahan)

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <h2 class="text-lg font-bold mb-4">
                Bukti Penyerahan
            </h2>

            <img
                src="{{ asset('uploads/bukti-penyerahan/' . $order->foto_bukti_penyerahan) }}"
                alt="Bukti Penyerahan"
                class="max-w-md rounded-xl border border-gray-200"
            >

            <p class="text-sm text-gray-500 mt-3">
                Pesanan selesai pada
                {{ $order->tanggal_selesai
                    ? $order->tanggal_selesai->format('d/m/Y')
                    : '-' }}
            </p>

        </div>

    @endif
    
    @if(auth()->user()->role === 'sales' && $order->status_penjualan === 'tervalidasi')

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <h2 class="text-lg font-bold mb-2">
                Penyelesaian Order
            </h2>

            <p class="text-sm text-gray-500 mb-5">
                Upload foto sebagai bukti bahwa pesanan sudah diserahkan kepada pelanggan.
            </p>

            <form
                action="{{ route('order.selesaikan', $order) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="mb-5">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Bukti Penyerahan
                    </label>

                    <input
                        type="file"
                        name="foto_bukti_penyerahan"
                        accept="image/*"
                        capture="environment"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3"
                    >

                </div>

                <button
                    type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg"
                >
                    Tandai Pesanan Selesai
                </button>

            </form>

        </div>

    @endif


    {{-- BUKTI PENYERAHAN --}}
    @if($order->foto_bukti_penyerahan)

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <div class="mb-4">
                <h2 class="text-lg font-bold">
                    Bukti Penyerahan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Bukti foto saat pesanan diserahkan kepada pelanggan.
                </p>
            </div>

            <div class="mb-4">
                <img
                    src="{{ asset('storage/' . $order->foto_bukti_penyerahan) }}"
                    alt="Bukti Penyerahan"
                    class="max-w-md w-full rounded-xl border border-gray-200"
                >
            </div>

            @if($order->tanggal_selesai)
                <p class="text-sm text-gray-500">
                    Diselesaikan pada
                    <span class="font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($order->tanggal_selesai)->format('d/m/Y') }}
                    </span>
                </p>
            @endif

        </div>

    @endif


    {{-- TABEL PRODUK --}}

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        <table class="w-full text-sm">  

            <thead class="bg-gray-50">

                <tr>
                    <th class="text-left px-5 py-4">
                        Produk
                    </th>

                    <th class="text-left px-5 py-4">
                        Harga
                    </th>

                    <th class="text-left px-5 py-4">
                        Jumlah
                    </th>

                    <th class="text-left px-5 py-4">
                        Subtotal
                    </th>
                </tr>

            </thead>

            <tbody class="divide-y">

                @foreach($order->detailPenjualan as $detail)

                    <tr>

                        <td class="px-5 py-4">
                            {{ $detail->produk->nama_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $detail->jumlah_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot class="bg-gray-50">

                <tr>

                    <td
                        colspan="3"
                        class="px-5 py-4 font-bold text-right"
                    >
                        Total
                    </td>

                    <td class="px-5 py-4 font-bold">
                        Rp {{ number_format($order->total_penjualan, 0, ',', '.') }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    <div class="mt-6">

        <a
            href="{{ route('order.index') }}"
            class="bg-gray-100 px-5 py-2.5 rounded-lg"
        >
            Kembali
        </a>

    </div>

</div>

@endsection