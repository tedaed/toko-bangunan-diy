@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Produk</p>
        <h3 class="text-3xl font-bold mt-2">{{ $totalProducts }}</h3>
        <p class="text-sm text-gray-400 mt-2">Produk tersedia di sistem</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Project DIY</p>
        <h3 class="text-3xl font-bold mt-2">{{ $totalProjects }}</h3>
        <p class="text-sm text-gray-400 mt-2">Kategori proyek DIY</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500 text-sm">Total Resep DIY</p>
        <h3 class="text-3xl font-bold mt-2">{{ $totalRecipes }}</h3>
        <p class="text-sm text-gray-400 mt-2">Varian ukuran/resep</p>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold mb-4">Stok Produk Rendah</h3>

        @if($lowStockProducts->isEmpty())
            <p class="text-green-600 font-semibold">
                Semua stok produk masih aman.
            </p>
        @else
            <div class="space-y-3">
                @foreach($lowStockProducts as $product)
                    <div class="border rounded p-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold">
                                {{ $product->name }} - {{ $product->specification }}
                            </h4>
                            <p class="text-sm text-gray-500">
                                Kategori: {{ $product->category }}
                            </p>
                        </div>

                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded font-bold">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-xl font-bold mb-4">Menu Cepat</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="#"
               class="border rounded p-4 hover:bg-blue-50">
                <h4 class="font-bold">Kelola Produk</h4>
                <p class="text-sm text-gray-500 mt-1">
                    Tambah, edit, dan update stok produk.
                </p>
            </a>

            <a href="#"
               class="border rounded p-4 hover:bg-blue-50">
                <h4 class="font-bold">Kelola Resep DIY</h4>
                <p class="text-sm text-gray-500 mt-1">
                    Atur resep, komponen, dan opsi produk.
                </p>
            </a>

            <a href="#"
               class="border rounded p-4 hover:bg-blue-50">
                <h4 class="font-bold">Pesanan Masuk</h4>
                <p class="text-sm text-gray-500 mt-1">
                    Verifikasi pesanan pelanggan.
                </p>
            </a>

            <a href="#"
               class="border rounded p-4 hover:bg-blue-50">
                <h4 class="font-bold">POS Kasir</h4>
                <p class="text-sm text-gray-500 mt-1">
                    Catat transaksi offline toko.
                </p>
            </a>
        </div>
    </div>

</div>

@endsection