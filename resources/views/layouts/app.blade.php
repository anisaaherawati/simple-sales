<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | Halus Ciptanadi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-800">

    <div class="min-h-screen flex">

        <aside class="hidden lg:flex lg:w-64 bg-[#6f0f10] text-white flex-col fixed inset-y-0 left-0">

            <div class="px-6 py-7 border-b border-slate-800">
                <h1 class="text-xl font-bold">
                    Halus Ciptanadi
                </h1>

                <p class="text-sm text-white mt-1">
                    Sistem Penjualan
                </p>
            </div>

            <nav class="flex-1 px-4 py-6">

                <p class="text-xs text-white-500 px-3 mb-3 font-semibold">
                    MENU UTAMA
                </p>

                <div class="space-y-1">

                    <a 
                        href="{{ route('dashboard') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('dashboard')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black hover:block px-7 py-3'  }}"
                    >
                        Dashboard
                    </a>

                    @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('produk.index') }}"
                        class="block px-7 py-3 rounded-lg
                        {{ request()->routeIs('produk.*')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black' }}"
                    >
                        Data Produk
                    </a>

                    <a
                        href="{{ route('sales.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('sales.*')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black' }}"
                    >
                        Data Sales
                    </a>

                    <a
                        href="{{ route('pelanggan.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('pelanggan.*')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black' }}"
                    >
                        Data Pelanggan
                    </a>

                    <a
                        href="{{ route('transaksi.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('transaksi.*')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black' }}"
                    >
                        Transaksi Penjualan
                    </a>

                    @endif

                    @if(auth()->user()->role === 'sales')

                        <a
                            href="{{ route('pelanggan.index') }}"
                            class="block px-7 py-3 rounded-lg
                            {{ request()->routeIs('pelanggan.*')
                                ? 'bg-slate-800 text-white'
                                : 'text-white hover:bg-slate-800 hover:text-white' }}"
                        >
                            Data Pelanggan
                        </a>

                        <a
                            href="{{ route('order.index') }}"
                            class="block px-4 py-3 rounded-lg
                            {{ request()->routeIs('order.*')
                                ? 'bg-slate-800 text-white'
                                : 'text-white hover:bg-slate-800 hover:text-white' }}"
                        >
                            Order Penjualan
                        </a>

                    @endif

                    @if(auth()->user()->role === 'direktur')

                    <a
                        href="{{ route('laporan.direktur') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('laporan.direktur')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black' }}"
                    >
                        Laporan Penjualan
                    </a>

                    <a
                        href="{{ route('laporan.stok') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('laporan.stok')
                            ? 'bg-white text-black'
                            : 'text-white hover:bg-white hover:text-black' }}"
                    >
                        Laporan Stok
                    </a>

                    @endif

                </div>
            </nav>

            <div class="p-4 border-t border-slate-800">

                <div class="px-3 mb-4">

                    <p class="font-semibold">
                        {{ auth()->user()->nama_user }}
                    </p>

                    <p class="text-sm text-slate-400 capitalize">
                        {{ auth()->user()->role }}
                    </p>

                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="block w-full text-left px-4 py-3 rounded-lg
                        text-white hover:bg-white hover:text-black"
                    >
                        Logout
                    </button>
                </form>

            </div>

        </aside>

        <div class="flex-1 lg:ml-64">

            <header class="bg-[#6f0f10] border-b border-gray-200">

                <div class="px-6 lg:px-8 py-5 flex justify-between items-center">

                    <div>
                        <h2 class="text-xl text-white font-bold">
                            @yield('header')
                        </h2>

                        <p class="text-sm text-white">
                            Sistem Informasi Penjualan
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-white text-sm">
                            {{ auth()->user()->nama_user }}
                        </p>

                        <p class="text-xs text-white capitalize">
                            {{ auth()->user()->role }}
                        </p>
                    </div>

                </div>

            </header>

            <main class="p-6 lg:p-8">
                @yield('content')
            </main>

        </div>

    </div>

</body>
</html>