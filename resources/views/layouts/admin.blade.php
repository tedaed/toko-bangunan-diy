<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Toko Bangunan XYZ')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-900 text-white hidden md:block">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-xl font-bold">Admin XYZ</h1>
                <p class="text-sm text-gray-400 mt-1">Dashboard Toko</p>
            </div>

            <nav class="p-4 space-y-2">

                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded font-semibold
       {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="block px-4 py-3 rounded font-semibold
       {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}">
                    Produk
                </a>

                <a href="{{ route('admin.recipes.index') }}"
                    class="block px-4 py-3 rounded font-semibold
       {{ request()->routeIs('admin.recipes.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}">
                    Resep DIY
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="block px-4 py-3 rounded font-semibold
   {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}">
                    Pesanan
                </a>

                <a href="{{ route('admin.custom-requests.index') }}"
                    class="block px-4 py-3 rounded font-semibold
   {{ request()->routeIs('admin.custom-requests.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}">
                    Permintaan Custom
                </a>

              <a href="{{ route('admin.pos.index') }}"
   class="block px-4 py-3 rounded font-semibold
   {{ request()->routeIs('admin.pos.*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800' }}">
    POS Kasir
</a>

                <a href="#" class="block px-4 py-3 rounded hover:bg-gray-800">
                    Laporan Penjualan
                </a>

            </nav>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col">

            <!-- TOPBAR -->
            <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg">@yield('page-title', 'Dashboard')</h2>
                    <p class="text-sm text-gray-500">Sistem manajemen Toko Bangunan XYZ</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/" class="text-sm text-blue-600 font-semibold hover:underline">
                        Lihat Website
                    </a>

                    <button class="bg-gray-900 text-white px-4 py-2 rounded">
                        Admin
                    </button>
                </div>
            </header>

            <!-- CONTENT -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>
