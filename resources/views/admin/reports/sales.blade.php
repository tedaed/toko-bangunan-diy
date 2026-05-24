@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')

    <div class="bg-white rounded-xl shadow p-6 mb-6">

        <div class="mb-6">
            <h3 class="text-xl font-bold">Filter Laporan</h3>
            <p class="text-sm text-gray-500">
                Laporan menghitung transaksi dengan status confirmed, completed, dan closed.
            </p>
        </div>

        <form method="GET" action="{{ route('admin.reports.sales') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block font-semibold mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border rounded p-2">
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-semibold">
                    Filter
                </button>

                <a href="{{ route('admin.reports.sales') }}" class="bg-gray-600 text-white px-5 py-2 rounded">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm">Total Omzet</p>
            <h3 class="text-3xl font-bold mt-2">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h3>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm">Jumlah Transaksi</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $totalTransactions }}
            </h3>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500 text-sm">Total Item Terjual</p>
            <h3 class="text-3xl font-bold mt-2">
                {{ $totalItemsSold }}
            </h3>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-4">Daftar Transaksi</h3>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Invoice</th>
                            <th class="p-3 border">Pelanggan</th>
                            <th class="p-3 border">Tanggal</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border">Total</th>
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
                                    {{ $order->created_at->format('d-m-Y H:i') }}
                                </td>

                                <td class="p-3 border">
                                    <span
                                        class="px-3 py-1 rounded text-sm font-bold
                                        {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status === 'closed' ? 'bg-gray-200 text-gray-800' : '' }}">
                                        {{ strtoupper($order->status) }}
                                        </span>
                                </td>

                                <td class="p-3 border">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">
                                    Belum ada transaksi penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-4">Rekap Produk Terjual</h3>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Produk</th>
                            <th class="p-3 border">Qty Terjual</th>
                            <th class="p-3 border">Total Penjualan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($productSummary as $summary)
                            <tr>
                                <td class="p-3 border">
                                    {{ $summary['product_name'] }}
                                    -
                                    {{ $summary['specification'] }}
                                </td>

                                <td class="p-3 border">
                                    {{ $summary['total_quantity'] }}
                                </td>

                                <td class="p-3 border">
                                    Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-500">
                                    Belum ada produk terjual.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection
