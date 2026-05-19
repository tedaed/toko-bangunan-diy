@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold">Data Produk</h3>
            <p class="text-sm text-gray-500">
                Kelola produk, stok, harga, dan spesifikasi barang.
            </p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Kategori</th>
                    <th class="p-3 border">Spesifikasi</th>
                    <th class="p-3 border">Harga</th>
                    <th class="p-3 border">Stok</th>
                    <th class="p-3 border">Satuan</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="p-3 border font-semibold">
                            {{ $product->name }}
                        </td>

                        <td class="p-3 border">
                            {{ $product->category }}
                        </td>

                        <td class="p-3 border">
                            {{ $product->specification ?? '-' }}
                        </td>

                        <td class="p-3 border">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <td class="p-3 border">
                            @if($product->stock <= 10)
                                <span class="text-red-600 font-bold">
                                    {{ $product->stock }}
                                </span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>

                        <td class="p-3 border">
                            {{ $product->unit }}
                        </td>

                        <td class="p-3 border">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            Belum ada data produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection