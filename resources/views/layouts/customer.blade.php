<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Bangunan XYZ')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- LOGO -->
            <a href="/" class="flex items-center gap-2">
                <div class="bg-blue-600 text-white font-bold px-3 py-2 rounded">
                    TB
                </div>
                <span class="font-bold text-xl">
                    Toko Bangunan XYZ
                </span>
            </a>

            <!-- MENU -->
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="/" class="hover:text-blue-600">
                    Beranda
                </a>

                <a href="{{ route('catalog.index') }}" class="hover:text-blue-600">
                    Katalog Produk
                </a>

                <a href="{{ route('custom-requests.create', [], false) }}" class="hover:text-blue-600">
                    Permintaan Custom
                </a>

                @auth
                    <a href="{{ route('customer.orders.index', [], false) }}" class="hover:text-blue-600">
                        Pesanan Saya
                    </a>
                @endauth

                <a href="#" class="hover:text-blue-600">
                    Tentang Toko
                </a>
            </div>

            <!-- BUTTON -->
            <div>
                @auth
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold">
                            {{ Auth::user()->name }}
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button type="submit"
                                class="bg-gray-900 text-white px-5 py-2 rounded font-semibold hover:bg-gray-800">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700">
                        Login
                    </a>
                @endauth
            </div>

        </div>
    </nav>

    <!-- CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center">
            <p class="font-semibold">
                Toko Bangunan XYZ
            </p>
            <p class="text-gray-400 text-sm mt-2">
                Mulai Proyek DIY Kamu dengan lebih Mudah.
            </p>
        </div>
    </footer>

</body>

</html>
