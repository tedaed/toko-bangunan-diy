@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')

    <div class="bg-blue-600 text-white py-16 text-center">
        <h1 class="text-4xl font-bold">Pesanan Saya</h1>
        <p class="mt-4">Lihat riwayat dan status pesanan Anda.</p>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-10">

        {{-- CARD PESANAN BELANJA --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold mb-6">Daftar Pesanan Belanja</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Invoice</th>
                            <th class="p-3 border">Tanggal</th>
                            <th class="p-3 border">Metode</th>
                            <th class="p-3 border">Total</th>
                            <th class="p-3 border">Status</th>
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
                                    {{ $order->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="p-3 border">
                                    {{ $order->payment_method }}
                                </td>

                                <td class="p-3 border">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>

                                <td class="p-3 border">
                                    <span
                                        class="px-3 py-1 rounded text-sm font-bold
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status === 'closed' ? 'bg-gray-200 text-gray-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>

                                <td class="p-3 border">
                                    <a href="{{ route('customer.orders.show', $order->id) }}"
                                        class="bg-blue-600 text-white px-3 py-1 rounded">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">
                                    Belum ada pesanan belanja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CARD PERMINTAAN CUSTOM --}}
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h2 class="text-2xl font-bold mb-6">Permintaan Custom Saya</h2>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Tanggal</th>
                            <th class="p-3 border">Project</th>
                            <th class="p-3 border">Ukuran</th>
                            <th class="p-3 border">Kualitas</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Catatan Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($customRequests as $customRequest)
                            <tr>
                                <td class="p-3 border">
                                    {{ $customRequest->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="p-3 border">
                                    {{ $customRequest->project->name ?? '-' }}
                                </td>

                                <td class="p-3 border">
                                    {{ $customRequest->length }} x {{ $customRequest->width }}

                                    @if ($customRequest->height)
                                        x {{ $customRequest->height }}
                                    @endif

                                    cm
                                </td>

                                <td class="p-3 border">
                                    {{ $customRequest->quality ?? '-' }}
                                </td>

                                <td class="p-3 border">
                                    <span
                                        class="px-3 py-1 rounded text-sm font-bold
                                        {{ $customRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $customRequest->status === 'processed' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $customRequest->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $customRequest->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                                        {{ strtoupper($customRequest->status) }}
                                    </span>
                                </td>

                                <td class="p-3 border">
                                    {{ $customRequest->status_note ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">
                                    Belum ada permintaan custom.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection