@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('header', 'Detail Transaksi')

@section('content')

<div class="max-w-5xl">

    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Detail Transaksi
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $transaksi->nomor_penjualan }}
            </p>
        </div>

        @if($transaksi->status_penjualan === 'menunggu_validasi')

            <form
                action="{{ route('transaksi.validasi', $transaksi) }}"
                method="POST"
                onsubmit="return confirm('Validasi transaksi ini? Stok produk akan dikurangi.')"
            >

                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700"
                >
                    Validasi Transaksi
                </button>

            </form>

        @endif

    </div>

    @if(session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5">
            {{ session('success') }}
        </div>

    @endif

    @if($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5">

            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif

    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-sm text-gray-500">
                    Nomor Transaksi
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->nomor_penjualan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Tanggal
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->tanggal_penjualan->format('d/m/Y') }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Sales
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->user->nama_user }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Status
                </p>

                <p class="font-medium mt-1">
                    {{ ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $transaksi->status_penjualan
                        )
                    ) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Pelanggan
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->pelanggan->nama_pelanggan }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">
                    Nama Toko
                </p>

                <p class="font-medium mt-1">
                    {{ $transaksi->pelanggan->nama_toko }}
                </p>
            </div>

        </div>

    </div>


    {{-- TIMELINE STATUS TRANSAKSI --}}
<div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

    <h2 class="text-lg font-bold mb-6">
        Status Pesanan
    </h2>

    <div class="relative">

        <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-gray-200"></div>

        {{-- 1. ORDER DIBUAT --}}
        <div class="relative flex gap-4 mb-7">

            <div class="relative z-10 w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center">
                ✓
            </div>

            <div>
                <p class="font-semibold">Order Dibuat</p>

                <p class="text-sm text-gray-500">
                    {{ $transaksi->tanggal_penjualan->format('d/m/Y') }}
                </p>
            </div>

        </div>


        {{-- 2. VALIDASI ADMIN --}}
        <div class="relative flex gap-4 mb-7">

            <div class="relative z-10 w-10 h-10 rounded-full
                {{ $transaksi->tanggal_validasi
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-300 text-gray-500' }}
                flex items-center justify-center">

                {{ $transaksi->tanggal_validasi ? '✓' : '2' }}

            </div>

            <div>

                <p class="font-semibold">
                    Validasi Admin
                </p>

                @if($transaksi->tanggal_validasi)

                    <p class="text-sm text-green-600">
                        Transaksi telah divalidasi admin
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_validasi)->format('d/m/Y') }}
                    </p>

                @else

                    <p class="text-sm text-yellow-600">
                        Menunggu validasi admin
                    </p>

                @endif

            </div>

        </div>


        {{-- 3. WHATSAPP --}}
        <div class="relative flex gap-4 mb-7">

            <div class="relative z-10 w-10 h-10 rounded-full
                {{ $transaksi->status_wa === 'terkirim'
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-300 text-gray-500' }}
                flex items-center justify-center">

                {{ $transaksi->status_wa === 'terkirim' ? '✓' : '3' }}

            </div>

            <div>

                <p class="font-semibold">
                    Nota WhatsApp
                </p>

                @if($transaksi->status_wa === 'terkirim')

                    <p class="text-sm text-green-600">
                        Nota berhasil dikirim ke WhatsApp pelanggan
                    </p>

                @elseif($transaksi->status_wa === 'gagal')

                    <p class="text-sm text-red-600">
                        Nota gagal dikirim ke WhatsApp pelanggan
                    </p>

                @else

                    <p class="text-sm text-gray-500">
                        Menunggu pengiriman WhatsApp
                    </p>

                @endif

            </div>

        </div>


        {{-- 4. DIKIRIM --}}
        <div class="relative flex gap-4 mb-7">

            <div class="relative z-10 w-10 h-10 rounded-full
                {{ in_array($transaksi->status_penjualan, [
                    'dikirim',
                    'menunggu_konfirmasi',
                    'selesai'
                ])
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-300 text-gray-500' }}
                flex items-center justify-center">

                {{ in_array($transaksi->status_penjualan, [
                    'dikirim',
                    'menunggu_konfirmasi',
                    'selesai'
                ]) ? '✓' : '4' }}

            </div>

            <div>

                <p class="font-semibold">
                    Pesanan Diantar
                </p>

                @if(in_array($transaksi->status_penjualan, [
                    'dikirim',
                    'menunggu_konfirmasi',
                    'selesai'
                ]))

                    <p class="text-sm text-green-600">
                        Pesanan sedang atau telah diantar oleh sales
                    </p>

                @else

                    <p class="text-sm text-gray-500">
                        Menunggu pesanan diantar
                    </p>

                @endif

            </div>

        </div>


        {{-- 5. BUKTI PENYERAHAN --}}
        <div class="relative flex gap-4 mb-7">

            <div class="relative z-10 w-10 h-10 rounded-full
                {{ in_array($transaksi->status_penjualan, [
                    'menunggu_konfirmasi',
                    'selesai'
                ])
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-300 text-gray-500' }}
                flex items-center justify-center">

                {{ in_array($transaksi->status_penjualan, [
                    'menunggu_konfirmasi',
                    'selesai'
                ]) ? '✓' : '5' }}

            </div>

            <div>

                <p class="font-semibold">
                    Bukti Penyerahan
                </p>

                @if($transaksi->status_penjualan === 'menunggu_konfirmasi')

                    <p class="text-sm text-yellow-600">
                        Bukti telah diupload dan menunggu konfirmasi admin
                    </p>

                @elseif($transaksi->status_penjualan === 'selesai')

                    <p class="text-sm text-green-600">
                        Bukti penyerahan telah dikonfirmasi admin
                    </p>

                @else

                    <p class="text-sm text-gray-500">
                        Menunggu sales mengupload bukti
                    </p>

                @endif

            </div>

        </div>


        {{-- 6. SELESAI --}}
        <div class="relative flex gap-4">

            <div class="relative z-10 w-10 h-10 rounded-full
                {{ $transaksi->status_penjualan === 'selesai'
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-300 text-gray-500' }}
                flex items-center justify-center">

                {{ $transaksi->status_penjualan === 'selesai' ? '✓' : '6' }}

            </div>

            <div>

                <p class="font-semibold">
                    Pesanan Selesai
                </p>

                @if($transaksi->status_penjualan === 'selesai')

                    <p class="text-sm text-green-600">
                        Pesanan telah selesai diserahkan kepada pelanggan
                    </p>

                    @if($transaksi->tanggal_selesai)

                        <p class="text-xs text-gray-500 mt-1">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}
                        </p>

                    @endif

                @else

                    <p class="text-sm text-gray-500">
                        Menunggu konfirmasi admin
                    </p>

                @endif

            </div>

        </div>

    </div>

</div>

    {{-- BUKTI PENYERAHAN --}}
    @if($transaksi->foto_bukti_penyerahan)

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <h2 class="text-lg font-bold">
                Bukti Penyerahan
            </h2>

            <p class="text-sm text-gray-500 mt-1 mb-5">
                Foto bukti penyerahan yang diupload oleh sales.
            </p>

            <img
                src="{{ asset('storage/' . $transaksi->foto_bukti_penyerahan) }}"
                alt="Bukti Penyerahan"
                class="max-w-lg w-full rounded-xl border border-gray-200"
            >

            @if($transaksi->status_penjualan === 'menunggu_konfirmasi')

                <div class="mt-5">

                    <p class="text-sm text-yellow-600 mb-3">
                        Bukti penyerahan menunggu konfirmasi admin.
                    </p>

                    <div class="flex gap-3">

                            <form
                                action="{{ route('order.konfirmasiSelesai', $transaksi) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg"
                                >
                                    Konfirmasi Penyerahan
                                </button>
                            </form>


                            <form action="{{ route('order.tolakBukti', $transaksi) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <input
                                    type="text"
                                    name="alasan_penolakan"
                                    placeholder="Alasan penolakan"
                                    required
                                    class="border border-gray-300 rounded-lg px-4 py-2.5"
                                >

                                <button
                                    type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg"
                                >
                                    Tolak Bukti
                                </button>
                            </form>

                        </div>

                </div>

            @elseif($transaksi->status_penjualan === 'selesai')

                <p class="text-sm text-green-600 mt-4">
                    ✓ Bukti penyerahan telah dikonfirmasi admin.
                </p>

            @endif

            @if($transaksi->tanggal_selesai)

                <p class="text-sm text-gray-500 mt-3">
                    Diselesaikan pada
                    <span class="font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d/m/Y') }}
                    </span>
                </p>

            @endif

        </div>

    @endif

    {{-- RIWAYAT BUKTI PENYERAHAN --}}
    @if($transaksi->buktiPenyerahans->count() > 0)

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <h2 class="text-lg font-bold mb-5">
                Riwayat Bukti Penyerahan
            </h2>

            <div class="space-y-4">

                @foreach($transaksi->buktiPenyerahans->sortByDesc('created_at') as $bukti)

                    <div class="border border-gray-200 rounded-xl p-4">

                        <div class="flex justify-between items-center mb-3">

                            <div>
                                <p class="font-medium">
                                    Bukti #{{ $loop->iteration }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $bukti->tanggal_upload
                                        ? $bukti->tanggal_upload->format('d/m/Y H:i')
                                        : $bukti->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            @if($bukti->status === 'diterima')

                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">
                                    Diterima
                                </span>

                            @elseif($bukti->status === 'ditolak')

                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">
                                    Ditolak
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">
                                    Menunggu Konfirmasi
                                </span>

                            @endif

                        </div>

                        <img
                            src="{{ asset('storage/' . $bukti->foto) }}"
                            class="w-full max-w-md rounded-lg border"
                            alt="Bukti Penyerahan"
                        >

                        @if($bukti->status === 'ditolak' && $bukti->alasan_penolakan)

                            <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3">

                                <p class="text-sm font-medium text-red-700">
                                    Alasan Penolakan
                                </p>

                                <p class="text-sm text-red-600 mt-1">
                                    {{ $bukti->alasan_penolakan }}
                                </p>

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    @endif

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

                @foreach($transaksi->detailPenjualan as $detail)

                    <tr>

                        <td class="px-5 py-4">
                            {{ $detail->produk->nama_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format(
                                $detail->harga_satuan,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                        <td class="px-5 py-4">
                            {{ $detail->jumlah_produk }}
                        </td>

                        <td class="px-5 py-4">
                            Rp {{ number_format(
                                $detail->subtotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot class="bg-gray-50">

                <tr>

                    <td
                        colspan="3"
                        class="text-right px-5 py-4 font-bold"
                    >
                        Total
                    </td>

                    <td class="px-5 py-4 font-bold">
                        Rp {{ number_format(
                            $transaksi->total_penjualan,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                </tr>

            </tfoot>

        </table>

    </div>

    <div class="mt-6">

        <a
            href="{{ route('transaksi.index') }}"
            class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg"
        >
            Kembali
        </a>

    </div>

</div>

@endsection