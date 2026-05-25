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
        if (in_array($order->status, ['closed', 'cancelled'])) {
            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('error', 'Pesanan sudah final dan tidak dapat diubah lagi.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,closed,cancelled',
            'status_note' => 'nullable|string|max:1000',
        ]);

        $newStatus = $validated['status'];

        if ($newStatus === 'closed' && $order->status !== 'completed') {
            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('error', 'Pesanan hanya dapat diubah menjadi closed setelah status completed.');
        }

        if ($newStatus === 'cancelled' && empty($validated['status_note'])) {
            return redirect()
                ->route('admin.orders.show', $order->id)
                ->with('error', 'Alasan pembatalan wajib diisi.');
        }

        try {
            DB::transaction(function () use ($order, $validated, $newStatus) {
                $order->load('items.product');

                if (
                    in_array($newStatus, ['confirmed', 'completed']) &&
                    $order->stock_reduced_at === null
                ) {
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

                if ($newStatus === 'cancelled' && $order->stock_reduced_at !== null) {
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }

                    $order->stock_reduced_at = null;
                }

                $order->status = $newStatus;
                $order->status_note = $validated['status_note'] ?? $order->status_note;
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
