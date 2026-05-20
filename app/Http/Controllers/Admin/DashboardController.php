<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data = [
            'totalUsers' => User::count(),
            'totalOrders' => Order::count(),
            'totalProducts' => Product::count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total_price'),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
            'lowStockProducts' => Product::where('stock', '<', 10)->where('status', true)->get(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
