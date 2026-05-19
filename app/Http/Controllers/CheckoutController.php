<?php

namespace App\Http\Controllers;

use App\Models\DiyRecipe;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        $checkout = session('checkout');

        if (!$checkout || empty($checkout['items'])) {
            return redirect()
                ->route('diy.index')
                ->with('error', 'Belum ada item yang dipilih untuk checkout.');
        }

        $recipe = DiyRecipe::find($checkout['recipe_id']);

        $items = collect($checkout['items'])->map(function ($item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                return null;
            }

            $quantity = (int) $item['quantity'];
            $subtotal = $product->price * $quantity;

            return [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'stock_enough' => $product->stock >= $quantity,
            ];
        })->filter();

        $total = $items->sum('subtotal');

        return view('checkout.create', compact('recipe', 'items', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'payment_method' => 'required|string|max:50',
            'note' => 'nullable|string',
        ]);

        $checkout = session('checkout');

        if (!$checkout || empty($checkout['items'])) {
            return redirect()
                ->route('diy.index')
                ->with('error', 'Belum ada item yang dipilih untuk checkout.');
        }

        $items = collect($checkout['items'])->map(function ($item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                return null;
            }

            $quantity = (int) $item['quantity'];
            $subtotal = $product->price * $quantity;

            return [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        })->filter();

        if ($items->isEmpty()) {
            return redirect()
                ->route('diy.index')
                ->with('error', 'Item checkout tidak valid.');
        }

        $total = $items->sum('subtotal');

        $order = DB::transaction(function () use ($validated, $items, $total) {
            $order = Order::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis'),
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'payment_method' => $validated['payment_method'],
                'total_price' => $total,
                'status' => 'pending',
                'note' => $validated['note'] ?? null,
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
            }

            return $order;
        });

        session()->forget('checkout');

        return redirect()->route('checkout.invoice', $order->id);
    }

    public function invoice(Order $order)
    {
        $order->load('items');

        return view('checkout.invoice', compact('order'));
    }
}