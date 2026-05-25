<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.pos.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.quantity' => 'nullable|integer|min:1',
        ]);

        $rows = collect($validated['items']);

        $partialRows = $rows->filter(function ($item) {
            $hasProduct = !empty($item['product_id']);
            $hasQuantity = !empty($item['quantity']);

            return ($hasProduct && !$hasQuantity) || (!$hasProduct && $hasQuantity);
        });

        if ($partialRows->isNotEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Setiap baris transaksi harus memiliki produk dan quantity.');
        }

        $selectedItems = $rows->filter(function ($item) {
            return !empty($item['product_id']) && !empty($item['quantity']);
        });

        if ($selectedItems->isEmpty()) {
            return back()
                ->withInput()
                ->with('error', 'Minimal pilih satu produk untuk transaksi POS.');
        }

        $groupedItems = $selectedItems
            ->groupBy('product_id')
            ->map(function ($items, $productId) {
                return [
                    'product_id' => $productId,
                    'quantity' => $items->sum(function ($item) {
                        return (int) $item['quantity'];
                    }),
                ];
            })
            ->values();

        try {
            $order = DB::transaction(function () use ($groupedItems, $validated) {
                $items = collect();
                $total = 0;

                foreach ($groupedItems as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                    $quantity = (int) $item['quantity'];

                    if ($product->stock <= 0) {
                        throw new \Exception(
                            'Stok produk ' . $product->name . ' - ' . $product->specification . ' sedang kosong.'
                        );
                    }

                    if ($product->stock < $quantity) {
                        throw new \Exception(
                            'Stok produk ' . $product->name . ' - ' . $product->specification .
                                ' tidak mencukupi. Diminta ' . $quantity . ', tersedia ' . $product->stock . '.'
                        );
                    }

                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;

                    $items->push([
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $subtotal,
                    ]);
                }

                $order = Order::create([
                    'invoice_number' => 'POS-' . now()->format('YmdHis'),
                    'customer_name' => $validated['customer_name'] ?? 'Pelanggan Toko',
                    'phone' => '-',
                    'payment_method' => 'POS Offline',
                    'total_price' => $total,
                    'status' => 'completed',
                    'stock_reduced_at' => now(),
                    'note' => 'Transaksi offline melalui POS kasir.',
                ]);

                foreach ($items as $item) {
                    $product = $item['product'];

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_specification' => $product->specification,
                        'quantity' => $item['quantity'],
                        'price' => $product->price,
                        'subtotal' => $item['subtotal'],
                    ]);

                    $product->decrement('stock', $item['quantity']);
                }

                return $order;
            });
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Transaksi POS berhasil disimpan dan stok produk telah diperbarui.');
    }
}
