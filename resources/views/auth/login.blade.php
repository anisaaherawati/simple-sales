<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Halus Ciptanadi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="bg-white w-full max-w-md p-8 rounded-xl shadow">

            <div class="mb-8 text-center">

                <h1 class="text-2xl font-bold text-gray-800">
                    Halus Ciptanadi
                </h1>

                <p class="text-gray-500 mt-2">
                    Sistem Informasi Penjualan
                </p>

            </div>

            @if ($errors->has('login'))

                <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ $errors->first('login') }}
                </div>

            @endif

            <form action="{{ route('login.process') }}" method="POST">

                @csrf

                <div class="mb-4">

                    <label class="block text-gray-700 mb-2">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-800"
                        placeholder="Masukkan username"
                    >

                    @error('username')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                <div class="mb-6">

                    <label class="block text-gray-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-800"
                        placeholder="Masukkan password"
                    >

                    @error('password')

                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                <button
                    type="submit"
                    class="w-full bg-gray-900 text-white py-3 rounded-lg hover:bg-gray-800"
                >
                    Login
                </button>

            </form>

        </div>

    </div>

</body>
</html>