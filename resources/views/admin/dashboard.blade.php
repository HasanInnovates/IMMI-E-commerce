@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded">
                    <i class="bi bi-people fs-3 text-primary"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Users</p>
                    <h4 class="mb-0">{{ $totalUsers }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 p-3 rounded">
                    <i class="bi bi-cart-check fs-3 text-success"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Orders</p>
                    <h4 class="mb-0">{{ $totalOrders }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded">
                    <i class="bi bi-box-seam fs-3 text-warning"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Total Products</p>
                    <h4 class="mb-0">{{ $totalProducts }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 p-3 rounded">
                    <i class="bi bi-currency-dollar fs-3 text-info"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Revenue</p>
                    <h4 class="mb-0">{{ format_currency($totalRevenue) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? $order->customer_name }}</td>
                            <td>{{ format_currency($order->total_price) }}</td>
                            <td>
                                @php
                                    $map = ['pending'=>'warning','confirmed'=>'info','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                                @endphp
                                <span class="badge bg-{{ $map[$order->status] ?? 'secondary' }}">{{ ucfirst($order->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">No orders yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Low Stock Products</h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td><span class="badge bg-danger">{{ $product->stock }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-3 text-muted">All products well stocked.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Messages</h5>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>From</th>
                            <th>Subject</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentMessages as $msg)
                        <tr>
                            <td>{{ $msg->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($msg->subject, 25) }}</td>
                            <td>
                                @if(!$msg->is_read)
                                    <span class="badge bg-warning text-dark">New</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">No messages yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($unreadMessages > 0)
            <div class="card-footer bg-white text-end">
                <small class="text-muted">{{ $unreadMessages }} unread message(s)</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
