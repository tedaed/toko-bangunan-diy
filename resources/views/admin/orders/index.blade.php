@extends('layouts.admin')

@section('title', 'Pesanan Masuk')
@section('page-title', 'Pesanan Masuk')

@section('content')

<div class="bg-white rounded-xl shadow p-6">

    <div class="mb-6">
        <h3 class="text-xl font-bold">Data Pesanan</h3>
        <p class="text-sm text-gray-500">
            Verifikasi pesanan yang masuk dari pelanggan.
        </p>
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
                    <th class="p-3 border">Invoice</th>
                    <th class="p-3 border">Pelanggan</th>
                    <th class="p-3 border">WhatsApp</th>
                    <th class="p-3 border">Total</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Jumlah Item</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td class="p-3 border font-semibold">
                            {{ $order->invoice_number }}
                        </td>

                        <td class="p-3 border">
                            {{ $order->customer_name }}
                        </td>

                        <td class="p-3 border">
                            {{ $order->phone }}
                        </td>

                        <td class="p-3 border">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="p-3 border">
                            <span class="px-3 py-1 rounded text-sm font-bold
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>

                        <td class="p-3 border">
                            {{ $order->items_count }} item
                        </td>

                        <td class="p-3 border">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="bg-blue-600 text-white px-3 py-1 rounded">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection