<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function print(Order $order): View
    {
        $order->load('orderItems.product', 'payment', 'user');

        return view('admin.orders.invoice', compact('order'));
    }
}
