@extends('layouts.admin')

@section('title', 'POS Kasir')
@section('page-title', 'POS Kasir')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow p-6">

    <div class="mb-6">
        <h3 class="text-xl font-bold">Transaksi POS Offline</h3>
        <p class="text-sm text-gray-500">
            Catat transaksi langsung di toko dan kurangi stok produk secara otomatis.
        </p>
    </div>

    <form action="{{ route('admin.pos.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label class="block font-semibold mb-1">
                Nama Pelanggan
            </label>

            <input type="text"
                   name="customer_name"
                   value="{{ old('customer_name') }}"
                   class="w-full md:w-1/2 border rounded p-2"
                   placeholder="Opsional, contoh: Pelanggan Toko">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Produk</th>
                        <th class="p-3 border">Stok</th>
                        <th class="p-3 border">Harga</th>
                        <th class="p-3 border">Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @for($i = 0; $i < 5; $i++)
                        <tr>
                            <td class="p-3 border">
                                <select name="items[{{ $i }}][product_id]"
                                        class="w-full border rounded p-2">
                                    <option value="">-- Pilih Produk --</option>

                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old("items.$i.product_id") == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                            -
                                            {{ $product->specification }}
                                            |
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                            |
                                            Stok: {{ $product->stock }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="p-3 border text-gray-500">
                                Lihat di dropdown
                            </td>

                            <td class="p-3 border text-gray-500">
                                Otomatis dari produk
                            </td>

                            <td class="p-3 border">
                                <input type="number"
                                       name="items[{{ $i }}][quantity]"
                                       value="{{ old("items.$i.quantity") }}"
                                       min="1"
                                       class="w-32 border rounded p-2"
                                       placeholder="Qty">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded font-bold hover:bg-blue-700">
                Simpan Transaksi POS
            </button>
        </div>

    </form>

</div>

@endsection