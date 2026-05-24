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

        if ($items->isEmpty()) {
            return redirect()
                ->route('diy.index')
                ->with('error', 'Item checkout tidak valid.');
        }

        // CEGAH USER MASUK CHECKOUT KALAU STOK KURANG / HABIS
        $hasStockIssue = $items->contains(function ($item) {
            return !$item['stock_enough'];
        });

        if ($hasStockIssue) {
            if ($recipe) {
                return redirect()
                    ->route('diy.recipe', $recipe->id)
                    ->with('error', 'Checkout tidak dapat dilanjutkan karena terdapat stok produk yang kurang atau habis.');
            }

            return redirect()
                ->route('diy.index')
                ->with('error', 'Checkout tidak dapat dilanjutkan karena terdapat stok produk yang kurang atau habis.');
        }

        $total = $items->sum('subtotal');

        return view('checkout.create', compact('recipe', 'items', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'payment_method' => 'required|string|max:50',
            'note' => 'nullable|string',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.regex' => 'Nomor WhatsApp harus berupa angka 10 sampai 15 digit.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
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

        // PROTEKSI BACKEND: CEGAH ORDER KALAU STOK KURANG / HABIS
        foreach ($items as $item) {
            if ($item['product']->stock < $item['quantity']) {
                return redirect()
                    ->route('checkout.create')
                    ->with('error', 'Stok produk ' . $item['product']->name . ' - ' . $item['product']->specification . ' tidak mencukupi.');
            }
        }

        $total = $items->sum('subtotal');

        $order = DB::transaction(function () use ($validated, $items, $total) {
            $order = Order::create([
                'user_id' => auth()->id(),
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