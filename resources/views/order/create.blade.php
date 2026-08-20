@extends('layouts.app')

@section('title', 'Tambah Order')

@section('header', 'Tambah Order Penjualan')

@section('content')

<div class="max-w-5xl">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-900">
            Tambah Order Penjualan
        </h1>

        <p class="text-gray-500 mt-1">
            Pilih pelanggan dan produk yang akan dipesan.
        </p>

    </div>

    @if($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5">

            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach

        </div>

    @endif

    <form action="{{ route('order.store') }}" method="POST">

        @csrf

        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-5">

            <label class="block text-sm font-medium mb-2">
                Pelanggan
            </label>

            <select
                name="id_pelanggan"
                class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
            >

                <option value="">
                    Pilih pelanggan
                </option>

                @foreach($pelanggan as $item)

                    <option
                        value="{{ $item->id_pelanggan }}"
                        {{ old('id_pelanggan') == $item->id_pelanggan ? 'selected' : '' }}
                    >
                        {{ $item->nama_pelanggan }} - {{ $item->nama_toko }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="bg-white border border-gray-200 rounded-xl p-6">

            <div class="flex items-center justify-between mb-5">

                <div>
                    <h2 class="font-bold text-lg">
                        Produk
                    </h2>

                    <p class="text-sm text-gray-500">
                        Tambahkan produk yang dipesan.
                    </p>
                </div>

                <button
                    type="button"
                    id="tambah-produk"
                    class="bg-gray-100 px-4 py-2 rounded-lg"
                >
                    Tambah Produk
                </button>

            </div>

            <div id="produk-list" class="space-y-4">

                <div class="produk-row grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div class="md:col-span-2">

                        <select
                            name="produk[0][id_produk]"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        >

                            <option value="">
                                Pilih produk
                            </option>

                            @foreach($produk as $item)

                                <option value="{{ $item->id_produk }}">
                                    {{ $item->nama_produk }}
                                    |
                                    Stok {{ $item->stok_produk }} {{ $item->satuan_produk }}
                                    |
                                    Rp {{ number_format($item->harga_produk, 0, ',', '.') }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <input
                            type="number"
                            name="produk[0][jumlah]"
                            min="1"
                            placeholder="Jumlah"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                        >

                    </div>

                </div>

            </div>

            <div class="flex gap-3 mt-6">

                <a
                    href="{{ route('order.index') }}"
                    class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800"
                >
                    Simpan Order
                </button>

            </div>

        </div>

    </form>

</div>

<script>
    let indexProduk = 1;

    const produkOptions = @json($produkOptions);

    document
        .getElementById('tambah-produk')
        .addEventListener('click', function () {

            let options = `
                <option value="">
                    Pilih produk
                </option>
            `;

            produkOptions.forEach(function (produk) {

                const harga = new Intl.NumberFormat('id-ID').format(produk.harga);

                options += `
                    <option value="${produk.id}">
                        ${produk.nama}
                        | Stok ${produk.stok} ${produk.satuan}
                        | Rp ${harga}
                    </option>
                `;
            });

            const row = document.createElement('div');

            row.className =
                'produk-row grid grid-cols-1 md:grid-cols-3 gap-4';

            row.innerHTML = `

                <div class="md:col-span-2">

                    <select
                        name="produk[${indexProduk}][id_produk]"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                    >
                        ${options}
                    </select>

                </div>

                <div class="flex gap-2">

                    <input
                        type="number"
                        name="produk[${indexProduk}][jumlah]"
                        min="1"
                        placeholder="Jumlah"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5"
                    >

                    <button
                        type="button"
                        class="hapus-produk bg-red-100 text-red-700 px-4 rounded-lg"
                    >
                        Hapus
                    </button>

                </div>

            `;

            document
                .getElementById('produk-list')
                .appendChild(row);

            indexProduk++;
        });

    document
        .getElementById('produk-list')
        .addEventListener('click', function (event) {

            if (event.target.classList.contains('hapus-produk')) {

                event.target
                    .closest('.produk-row')
                    .remove();
            }
        });
</script>

@endsection