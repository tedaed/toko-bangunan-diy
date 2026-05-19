@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')

    <div class="max-w-5xl mx-auto px-6 py-10">

        <h1 class="text-3xl font-bold mb-6">Checkout Pesanan</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold mb-4">Data Pelanggan</h2>

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nama Pelanggan</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name') }}"
                            class="w-full border rounded p-2" placeholder="Masukkan nama lengkap">

                        @error('customer_name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded p-2"
                            placeholder="Contoh: 081234567890">

                        @error('phone')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Metode Pembayaran</label>
                        <select name="payment_method" class="w-full border rounded p-2">
                            <option value="QRIS">QRIS</option>
                            <option value="Bayar di Toko">Bayar di Toko</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Catatan</label>
                        <textarea name="note" rows="4" class="w-full border rounded p-2"
                            placeholder="Contoh: Tolong siapkan barang untuk diambil sore hari">{{ old('note') }}</textarea>
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded font-bold hover:bg-green-700">
                        Buat Invoice
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow p-6 h-fit">
                <h2 class="text-xl font-bold mb-4">Ringkasan Pesanan</h2>

                @if ($recipe)
                    <p class="text-gray-600 mb-4">
                        Resep: {{ $recipe->name }}
                    </p>
                @endif

                <div class="space-y-3">
                    @foreach ($items as $item)
                        <div class="border-b pb-3">
                            <p class="font-semibold">
                                {{ $item['product']->name }}
                                -
                                {{ $item['product']->specification }}
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ $item['quantity'] }} {{ $item['product']->unit }}
                                x
                                Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                            </p>

                            <p class="font-bold">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </p>

                            @if (!$item['stock_enough'])
                                <p class="text-red-600 text-sm font-bold">
                                    Stok kurang! Tersedia {{ $item['product']->stock }}.
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t">
                    <p class="text-lg font-bold">
                        Total:
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>
            </div>

        </div>

    </div>

@endsection
