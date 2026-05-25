<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CustomRequest;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $customRequests = CustomRequest::with('project')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer_orders.index', compact('orders', 'customRequests'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items');

        return view('customer_orders.show', compact('order'));
    }
}
