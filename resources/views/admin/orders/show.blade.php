@extends('layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Order #{{ $order->id }}</h4>
        <small class="text-muted">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="btn btn-outline-primary">
            <i class="bi bi-printer"></i> Invoice
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order Items</h5>
                <span class="badge bg-{{ \App\Helpers\OrderHelper::statusBadge($order->status) }} fs-6">
                    {{ \App\Helpers\OrderHelper::statusLabel($order->status) }}
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->product && $item->product->image_url)
                                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"
                                             class="rounded" width="40" height="40" style="object-fit:cover">
                                    @endif
                                    <div>
                                        <span class="fw-medium">{{ $item->product->name ?? 'Deleted Product' }}</span>
                                        @if($item->product && $item->product->category)
                                            <br><small class="text-muted">{{ $item->product->category->name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ format_currency($item->price) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-end fw-semibold">{{ format_currency($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        @if($order->delivery_charge > 0)
                        <tr>
                            <td colspan="3" class="text-end">Delivery Charge ({{ $order->delivery_area ?? 'N/A' }})</td>
                            <td class="text-end">{{ format_currency($order->delivery_charge) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-end fw-bold fs-5">{{ format_currency($order->total_price) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        @if($order->orderItems->isNotEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Payment Info</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Method</small>
                        <span class="fw-semibold">{{ $order->payment->payment_method ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Status</small>
                        @if($order->payment)
                            <span class="badge bg-{{ \App\Helpers\OrderHelper::paymentStatusBadge($order->payment->payment_status) }}">
                                {{ ucfirst($order->payment->payment_status) }}
                            </span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                    @if($order->payment && $order->payment->transaction_id)
                    <div class="col-md-4">
                        <small class="text-muted d-block">Transaction ID</small>
                        <span class="fw-semibold"><code>{{ $order->payment->transaction_id }}</code></span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Customer Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Name</small>
                    <span class="fw-semibold">{{ $order->customer_name ?? $order->user->name }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-semibold">{{ $order->customer_email ?? $order->user->email }}</span>
                </div>
                @if($order->customer_phone)
                <div class="mb-3">
                    <small class="text-muted d-block">Phone</small>
                    <span class="fw-semibold">{{ $order->customer_phone }}</span>
                </div>
                @endif
                @if($order->customer_city)
                <div class="mb-3">
                    <small class="text-muted d-block">City</small>
                    <span class="fw-semibold">{{ $order->customer_city }}</span>
                </div>
                @endif
                @if($order->postal_code)
                <div class="mb-3">
                    <small class="text-muted d-block">Postal Code</small>
                    <span class="fw-semibold">{{ $order->postal_code }}</span>
                </div>
                @endif
                @if($order->delivery_area)
                <div class="mb-3">
                    <small class="text-muted d-block">Delivery Area</small>
                    <span class="fw-semibold">{{ $order->delivery_area }}</span>
                </div>
                @endif
                <div>
                    <small class="text-muted d-block">Shipping Address</small>
                    <span class="fw-semibold">{{ $order->customer_address ?? $order->shipping_address }}</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Update Status</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
