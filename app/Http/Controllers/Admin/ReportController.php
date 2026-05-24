<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $query = Order::with('items')
            ->whereIn('status', ['confirmed', 'completed', 'closed']);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->latest()->get();

        $totalRevenue = $orders->sum('total_price');

        $totalTransactions = $orders->count();

        $totalItemsSold = $orders->flatMap(function ($order) {
            return $order->items;
        })->sum('quantity');

        $productSummary = $orders->flatMap(function ($order) {
            return $order->items;
        })->groupBy(function ($item) {
            return $item->product_name . ' - ' . $item->product_specification;
        })->map(function ($items) {
            return [
                'product_name' => $items->first()->product_name,
                'specification' => $items->first()->product_specification,
                'total_quantity' => $items->sum('quantity'),
                'total_sales' => $items->sum('subtotal'),
            ];
        });

        return view('admin.reports.sales', compact(
            'orders',
            'totalRevenue',
            'totalTransactions',
            'totalItemsSold',
            'productSummary'
        ));
    }
}