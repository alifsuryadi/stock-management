<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_admins' => Admin::count(),
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'low_stock_products' => Product::where('stock', '<=', 10)->count(),
        ];

        $recent_transactions = Transaction::with(['admin', 'transactionDetails.product'])
            ->latest()
            ->take(5)
            ->get();

        $low_stock_products = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_transactions', 'low_stock_products'));
    }
}