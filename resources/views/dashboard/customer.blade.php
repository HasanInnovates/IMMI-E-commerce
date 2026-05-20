@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-0">My Dashboard</h4>
        <small class="text-muted">Welcome back, {{ auth()->user()->name }}</small>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-success fs-6">Customer</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</div>

@php
    $userId = auth()->id();
    $totalOrders = \App\Models\Order::where('user_id', $userId)->count();
    $completedOrders = \App\Models\Order::where('user_id', $userId)->where('status', 'delivered')->count();
    $pendingOrders = \App\Models\Order::where('user_id', $userId)->whereIn('status', ['pending', 'confirmed', 'processing'])->count();
    $recentOrders = \App\Models\Order::with('orderItems.product')
                        ->where('user_id', $userId)
                        ->latest()
                        ->take(10)
                        ->get();
@endphp

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                    <i class="bi bi-bag fs-3 text-primary"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Orders</p>
                    <h4 class="mb-0">{{ $totalOrders }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 p-3 rounded">
                    <i class="bi bi-check-circle fs-3 text-success"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Delivered</p>
                    <h4 class="mb-0">{{ $completedOrders }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded">
                    <i class="bi bi-clock fs-3 text-warning"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Pending / Processing</p>
                    <h4 class="mb-0">{{ $pendingOrders }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Order History</h5>
        <a href="{{ route('shop.products') }}" class="btn btn-sm btn-outline-primary">Browse Products</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="fw-medium">#{{ $order->id }}</td>
                        <td>{{ $order->orderItems->sum('quantity') }} items</td>
                        <td>{{ format_currency($order->total_price) }}</td>
                        <td>
                            @php
                                $map = ['pending'=>'warning', 'confirmed'=>'info', 'processing'=>'info', 'shipped'=>'primary', 'delivered'=>'success', 'cancelled'=>'danger'];
                            @endphp
                            <span class="badge bg-{{ $map[$order->status] ?? 'secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('shop.confirmation', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No orders yet. <a href="{{ route('shop.products') }}">Start shopping</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-center">
    <a href="{{ route('shop.products') }}" class="btn btn-primary">
        <i class="bi bi-bag-check"></i> Browse Products
    </a>
</div>
@endsection
