<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('items')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->status === 'closed') {
            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('error', 'Pesanan sudah closed dan tidak dapat diubah lagi.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,closed,cancelled',
        ]);

        if ($validated['status'] === 'closed' && $order->status !== 'completed') {
            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('error', 'Pesanan hanya dapat diubah menjadi closed setelah status completed.');
        }

        try {
            DB::transaction(function () use ($order, $validated) {
                $newStatus = $validated['status'];

                if (
                    in_array($newStatus, ['confirmed', 'completed']) &&
                    $order->stock_reduced_at === null
                ) {
                    $order->load('items.product');

                    foreach ($order->items as $item) {
                        if ($item->product && $item->product->stock < $item->quantity) {
                            throw new \Exception(
                                'Stok produk ' . $item->product_name . ' tidak mencukupi.'
                            );
                        }
                    }

                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->decrement('stock', $item->quantity);
                        }
                    }

                    $order->stock_reduced_at = now();
                }

                $order->status = $newStatus;
                $order->save();
            });
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
