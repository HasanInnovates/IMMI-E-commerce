@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Shopping Cart</h4>
    @if($items->isNotEmpty())
    <form method="POST" action="{{ route('cart.clear') }}"
          onsubmit="return confirm('Clear your entire cart?')">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-trash"></i> Clear Cart
        </button>
    </form>
    @endif
</div>

@if($items->isEmpty())
<div class="text-center py-5">
    <i class="bi bi-cart3 d-block fs-1 text-muted mb-3"></i>
    <h5 class="text-muted">Your cart is empty</h5>
    <p class="text-muted mb-4">Browse our products and add items to your cart.</p>
    <a href="{{ route('shop.products') }}" class="btn btn-primary">
        <i class="bi bi-bag-check"></i> Start Shopping
    </a>
</div>
@else
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px">Product</th>
                            <th>Name</th>
                            <th style="width:100px">Price</th>
                            <th style="width:140px">Quantity</th>
                            <th style="width:100px">Subtotal</th>
                            <th style="width:50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                @if($item['image_url'])
                                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}"
                                         class="rounded" width="60" height="60" style="object-fit:cover">
                                @else
                                    <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                                         style="width:60px;height:60px">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('shop.product-detail', $item['slug']) }}"
                                   class="text-decoration-none fw-semibold text-dark">
                                    {{ $item['name'] }}
                                </a>
                                @if($item['quantity'] > $item['stock'])
                                    <br><small class="text-danger">Only {{ $item['stock'] }} available</small>
                                @endif
                            </td>
                            <td>{{ format_currency($item['price']) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.update') }}" class="d-flex align-items-center gap-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <div class="input-group input-group-sm" style="width:110px">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="this.parentElement.querySelector('input').stepDown(); this.form.submit()">−</button>
                                        <input type="number" name="quantity"
                                               class="form-control text-center"
                                               value="{{ min($item['quantity'], $item['stock']) }}"
                                               min="1" max="{{ $item['stock'] }}"
                                               onchange="this.form.submit()">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="this.parentElement.querySelector('input').stepUp(); this.form.submit()">+</button>
                                    </div>
                                </form>
                            </td>
                            <td class="fw-semibold">{{ format_currency($item['price'] * $item['quantity']) }}</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove') }}"
                                      onsubmit="return confirm('Remove &quot;{{ $item['name'] }}&quot; from cart?')">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold">{{ format_currency($total) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Items</span>
                    <span class="fw-semibold">{{ \App\Services\CartService::countItems($items) }} items</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold fs-5 text-primary">{{ format_currency($total) }}</span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg">
                    <i class="bi bi-credit-card"></i> Proceed to Checkout
                </a>
                <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
