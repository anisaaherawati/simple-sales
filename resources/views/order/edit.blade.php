@extends('layouts.app')

@section('title', 'Ubah Order')

@section('header', 'Ubah Order Penjualan')

@section('content')

@php
    $produkForm = old('produk', $detailOrder->toArray());
@endphp

<div class="max-w-5xl">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-900">
            Ubah Order Penjualan
        </h1>

        <p class="text-gray-500 mt-1">
            Ubah pelanggan atau produk pada order
            {{ $order->nomor_penjualan }}.
        </p>

    </div>


    @if($errors->any())

        <div
            class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5"
        >

            @foreach($errors->all() as $error)

                <p>
                    {{ $error }}
                </p>

            @endforeach

        </div>

    @endif


    <form
        action="{{ route('order.update', $order) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        <!-- PELANGGAN -->
        <div
            class="bg-white border border-gray-200 rounded-xl p-6 mb-5"
        >

            <label
                class="block text-sm font-medium mb-2"
            >
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
                        {{ old(
                            'id_pelanggan',
                            $order->id_pelanggan
                        ) == $item->id_pelanggan
                            ? 'selected'
                            : ''
                        }}
                    >

                        {{ $item->nama_pelanggan }}
                        -
                        {{ $item->nama_toko }}

                    </option>

                @endforeach

            </select>

            @error('id_pelanggan')

                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>

            @enderror

        </div>


        <!-- PRODUK -->
        <div
            class="bg-white border border-gray-200 rounded-xl p-6"
        >

            <div
                class="flex items-center justify-between gap-4 mb-5"
            >

                <div>

                    <h2 class="font-bold text-lg">
                        Produk
                    </h2>

                    <p class="text-sm text-gray-500">
                        Ubah produk atau jumlah yang dipesan.
                    </p>

                </div>

                <button
                    type="button"
                    id="tambah-produk"
                    class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg"
                >
                    Tambah Produk
                </button>

            </div>


            <div
                id="produk-list"
                class="space-y-4"
            >

                @foreach($produkForm as $index => $detail)

                    <div
                        class="produk-row grid grid-cols-1 md:grid-cols-3 gap-4"
                    >

                        <div class="md:col-span-2">

                            <select
                                name="produk[{{ $index }}][id_produk]"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                            >

                                <option value="">
                                    Pilih produk
                                </option>

                                @foreach($produk as $item)

                                    <option
                                        value="{{ $item->id_produk }}"
                                        {{ (string) $detail['id_produk'] ===
                                            (string) $item->id_produk
                                            ? 'selected'
                                            : ''
                                        }}
                                    >

                                        {{ $item->nama_produk }}

                                        |

                                        Stok
                                        {{ $item->stok_produk }}
                                        {{ $item->satuan_produk }}

                                        |

                                        Rp
                                        {{ number_format(
                                            $item->harga_produk,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="flex gap-2">

                            <input
                                type="number"
                                name="produk[{{ $index }}][jumlah]"
                                value="{{ $detail['jumlah'] }}"
                                min="1"
                                placeholder="Jumlah"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5"
                            >

                            <button
                                type="button"
                                class="hapus-produk bg-red-100 text-red-700 hover:bg-red-200 px-4 rounded-lg"
                            >
                                Hapus
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>


            <div
                class="flex flex-wrap gap-3 mt-6"
            >

                <a
                    href="{{ route('order.index') }}"
                    class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg hover:bg-gray-200"
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

        </div>

    </form>

</div>


<script>

    let indexProduk = {{ count($produkForm) }};

    const produkOptions = @json($produkOptions);


    function buatPilihanProduk()
    {
        let options = `
            <option value="">
                Pilih produk
            </option>
        `;

        produkOptions.forEach(function (produk) {

            const harga =
                new Intl.NumberFormat('id-ID')
                    .format(produk.harga);

            options += `
                <option value="${produk.id}">
                    ${produk.nama}
                    | Stok ${produk.stok} ${produk.satuan}
                    | Rp ${harga}
                </option>
            `;
        });

        return options;
    }


    document
        .getElementById('tambah-produk')
        .addEventListener('click', function () {

            const row =
                document.createElement('div');

            row.className =
                'produk-row grid grid-cols-1 md:grid-cols-3 gap-4';

            row.innerHTML = `

                <div class="md:col-span-2">

                    <select
                        name="produk[${indexProduk}][id_produk]"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5"
                    >

                        ${buatPilihanProduk()}

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
                        class="hapus-produk bg-red-100 text-red-700 hover:bg-red-200 px-4 rounded-lg"
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

            if (
                event.target.classList.contains(
                    'hapus-produk'
                )
            ) {

                const jumlahBaris =
                    document.querySelectorAll(
                        '.produk-row'
                    ).length;

                if (jumlahBaris <= 1) {

                    alert(
                        'Order harus memiliki minimal satu produk.'
                    );

                    return;
                }

                event.target
                    .closest('.produk-row')
                    .remove();

            }

        });

</script>

@endsection