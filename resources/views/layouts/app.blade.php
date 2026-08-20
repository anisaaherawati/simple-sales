<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | Halus Ciptanadi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex">

        <aside class="hidden lg:flex lg:w-64 bg-slate-900 text-white flex-col fixed inset-y-0 left-0">

            <div class="px-6 py-7 border-b border-slate-800">
                <h1 class="text-xl font-bold">
                    Halus Ciptanadi
                </h1>

                <p class="text-sm text-slate-400 mt-1">
                    Sistem Penjualan
                </p>
            </div>

            <nav class="flex-1 px-4 py-6">

                <p class="text-xs text-slate-500 px-3 mb-3 font-semibold">
                    MENU UTAMA
                </p>

                <div class="space-y-1">

                    <a 
                        href="{{ route('dashboard') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('dashboard')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >
                        Dashboard
                    </a>

                    @if(auth()->user()->role === 'admin')

                    <a
                        href="{{ route('produk.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('produk.*')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >
                        Data Produk
                    </a>

                    <a
                        href="{{ route('sales.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('sales.*')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >
                        Data Sales
                    </a>

                    <a
                        href="{{ route('pelanggan.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('pelanggan.*')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >
                        Data Pelanggan
                    </a>

                    <a
                        href="{{ route('transaksi.index') }}"
                        class="block px-4 py-3 rounded-lg
                        {{ request()->routeIs('transaksi.*')
                            ? 'bg-slate-800 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >
                        Transaksi Penjualan
                    </a>

                        <a
                            href="#"
                            class="block px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white"
                        >
                            Laporan
                        </a>

                    @endif

                    @if(auth()->user()->role === 'sales')

                        <a
                            href="#"
                            class="block px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white"
                        >
                            Data Pelanggan
                        </a>

                        <a
                            href="{{ route('order.index') }}"
                            class="block px-4 py-3 rounded-lg
                            {{ request()->routeIs('order.*')
                                ? 'bg-slate-800 text-white'
                                : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                        >
                            Order Penjualan
                        </a>

                    @endif

                    @if(auth()->user()->role === 'direktur')

                        <a
                            href="#"
                            class="block px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white"
                        >
                            Laporan Penjualan
                        </a>

                        <a
                            href="#"
                            class="block px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white"
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
                        class="w-full bg-slate-800 hover:bg-slate-700 px-4 py-2.5 rounded-lg text-left"
                    >
                        Logout
                    </button>
                </form>

            </div>

        </aside>

        <div class="flex-1 lg:ml-64">

            <header class="bg-white border-b border-gray-200">

                <div class="px-6 lg:px-8 py-5 flex justify-between items-center">

                    <div>
                        <h2 class="text-xl font-bold">
                            @yield('header')
                        </h2>

                        <p class="text-sm text-gray-500">
                            Sistem Informasi Penjualan
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-sm">
                            {{ auth()->user()->nama_user }}
                        </p>

                        <p class="text-xs text-gray-500 capitalize">
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