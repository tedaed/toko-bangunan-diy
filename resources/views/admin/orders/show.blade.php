@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <div class="flex items-center justify-between border-b pb-4 mb-6">
                <div>
                    <h3 class="text-2xl font-bold">
                        {{ $order->invoice_number }}
                    </h3>

                    <p class="text-gray-500">
                        {{ $order->created_at->format('d-m-Y H:i') }}
                    </p>
                </div>

                <span
                    class="px-4 py-2 rounded font-bold
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                {{ $order->status === 'closed' ? 'bg-gray-200 text-gray-800' : '' }}
                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
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
                    <p class="text-gray-500">Stok Dikurangi</p>
                    <p class="font-bold">
                        {{ $order->stock_reduced_at ? $order->stock_reduced_at->format('d-m-Y H:i') : 'Belum' }}
                    </p>
                </div>
            </div>

            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3 border">Produk</th>
                        <th class="p-3 border">Qty</th>
                        <th class="p-3 border">Harga</th>
                        <th class="p-3 border">Subtotal</th>
                        <th class="p-3 border">Stok Saat Ini</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->items as $item)
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

                            <td class="p-3 border">
                                @if ($item->product)
                                    {{ $item->product->stock }}
                                @else
                                    Produk sudah dihapus
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-right mt-6">
                <p class="text-2xl font-bold">
                    Total:
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </p>
            </div>

            @if ($order->note)
                <div class="mt-6 bg-gray-100 p-4 rounded">
                    <p class="font-bold">Catatan:</p>
                    <p>{{ $order->note }}</p>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow p-6 h-fit">
            <h3 class="text-xl font-bold mb-4">Ubah Status Pesanan</h3>

            @if ($order->status === 'closed')
                <div class="bg-gray-100 text-gray-700 p-4 rounded">
                    <p class="font-bold">Transaksi sudah closed.</p>
                    <p class="text-sm mt-1">
                        Barang sudah diambil pelanggan dan status pesanan tidak dapat diubah lagi.
                    </p>
                </div>
            @else
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Status</label>

                        <select name="status" class="w-full border rounded p-2">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>
                                Confirmed
                            </option>

                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                            <option value="closed" {{ $order->status === 'closed' ? 'selected' : '' }}>
                                Closed
                            </option>

                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold">
                        Update Status
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.orders.index') }}" class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>

    </div>

@endsection
