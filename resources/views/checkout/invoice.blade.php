@extends('layouts.customer')

@section('title', 'Invoice Pesanan')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="bg-white rounded-xl shadow p-6">

        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold">Invoice Pesanan</h1>
                <p class="text-gray-600 mt-1">
                    {{ $order->invoice_number }}
                </p>
            </div>

            <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded font-bold">
                {{ strtoupper($order->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-gray-500">Nama Pelanggan</p>
                <p class="font-bold">{{ $order->customer_name }}</p>
            </div>

            <div>
                <p class="text-gray-500">Nomor WhatsApp</p>
                <p class="font-bold">{{ $order->phone }}</p>
            </div>

            <div>
                <p class="text-gray-500">Metode Pembayaran</p>
                <p class="font-bold">{{ $order->payment_method }}</p>
            </div>

            <div>
                <p class="text-gray-500">Tanggal</p>
                <p class="font-bold">{{ $order->created_at->format('d-m-Y H:i') }}</p>
            </div>
        </div>

        <table class="w-full border-collapse mb-6">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3 border">Produk</th>
                    <th class="p-3 border">Qty</th>
                    <th class="p-3 border">Harga</th>
                    <th class="p-3 border">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="p-3 border">
                            {{ $item->product_name }}
                            -
                            {{ $item->product_specification }}
                        </td>

                        <td class="p-3 border">
                            {{ $item->quantity }}
                        </td>

                        <td class="p-3 border">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>

                        <td class="p-3 border">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right">
            <p class="text-2xl font-bold">
                Total:
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </p>
        </div>

        @if($order->note)
            <div class="mt-6 bg-gray-100 p-4 rounded">
                <p class="font-bold">Catatan:</p>
                <p>{{ $order->note }}</p>
            </div>
        @endif

        <div class="mt-8 flex gap-3">
            <a href="{{ route('diy.index') }}"
               class="bg-blue-600 text-white px-5 py-2 rounded">
                Kembali ke Panduan DIY
            </a>

            <button onclick="window.print()"
                    class="bg-gray-800 text-white px-5 py-2 rounded">
                Cetak Invoice
            </button>
        </div>

    </div>

</div>

@endsection