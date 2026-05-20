@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="text-center py-5">
    <div class="mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle"
             style="width:96px;height:96px">
            <i class="bi bi-check-circle text-success" style="font-size:3rem"></i>
        </div>
    </div>
    <h2 class="fw-bold mb-2">Order Placed Successfully!</h2>
    <p class="text-muted mb-1">Thank you for your purchase, <strong>{{ $order->customer_name }}</strong>.</p>
    <p class="text-muted mb-4">Your order number is <strong class="text-primary">#{{ $order->id }}</strong>.</p>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm text-start">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted d-block">Order Status</small>
                        <span class="badge bg-warning text-dark fs-6">Pending</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Payment Method</small>
                        <span class="fw-semibold">{{ $order->payment->payment_method }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Shipping Address</small>
                        <span class="fw-semibold">{{ $order->shipping_address }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Order Date</small>
                        <span class="fw-semibold">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                    </div>
                    <hr>
                    <h6 class="fw-bold mb-3">Items Ordered</h6>
                    @foreach($order->orderItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span>{{ $item->product->name ?? 'Product' }}</span>
                            <small class="text-muted d-block">Qty: {{ $item->quantity }} × {{ format_currency($item->price) }}</small>
                        </div>
                        <span class="fw-semibold">{{ format_currency($item->price * $item->quantity) }}</span>
                    </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold fs-5">Total Paid</span>
                        <span class="fw-bold fs-5 text-primary">{{ format_currency($order->total_price) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('shop.products') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-bag-check"></i> Continue Shopping
        </a>
        @auth
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-person"></i> My Dashboard
        </a>
        @endauth
    </div>
</div>
@endsection
