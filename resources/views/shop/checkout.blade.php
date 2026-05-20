@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
        <li class="breadcrumb-item active">Checkout</li>
    </ol>
</nav>

<h4 class="fw-bold mb-4">Checkout</h4>

@auth
    <div class="alert alert-info d-flex justify-content-between align-items-center" role="alert">
        <span><i class="bi bi-person-circle"></i> Welcome back, <strong>{{ auth()->user()->name }}</strong>!</span>
        <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
@else
    <div class="alert alert-light d-flex justify-content-between align-items-center" role="alert">
        <span><i class="bi bi-person"></i> Checking out as a guest.</span>
        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-box-arrow-in-right"></i> Login
        </a>
    </div>
@endauth

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Customer Information</h5>
                <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" id="customer_name" name="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror"
                                   value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="customer_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="customer_email" name="customer_email"
                                   class="form-control @error('customer_email') is-invalid @enderror"
                                   value="{{ old('customer_email', auth()->user()->email ?? '') }}" required>
                            @error('customer_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" id="customer_phone" name="customer_phone"
                                   class="form-control @error('customer_phone') is-invalid @enderror"
                                   value="{{ old('customer_phone') }}" required>
                            @error('customer_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="customer_city" class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" id="customer_city" name="customer_city"
                                   class="form-control @error('customer_city') is-invalid @enderror"
                                   value="{{ old('customer_city') }}" required>
                            @error('customer_city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" id="postal_code" name="postal_code"
                                   class="form-control @error('postal_code') is-invalid @enderror"
                                   value="{{ old('postal_code') }}">
                            @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="delivery_area" class="form-label">Delivery Area <span class="text-danger">*</span></label>
                            <select id="delivery_area" name="delivery_area"
                                    class="form-select @error('delivery_area') is-invalid @enderror" required>
                                <option value="">Select delivery area</option>
                                @foreach($deliveryCharges as $dc)
                                    <option value="{{ $dc->area_name }}"
                                            data-charge="{{ $dc->charge }}"
                                            {{ old('delivery_area') === $dc->area_name ? 'selected' : '' }}>
                                        {{ $dc->area_name }} ({{ format_currency($dc->charge) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('delivery_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <input type="hidden" name="delivery_charge" id="delivery_charge_input"
                               value="{{ old('delivery_charge', 0) }}">

                        <div class="col-12">
                            <label for="customer_address" class="form-label">
                                Shipping Address <span class="text-danger">*</span>
                            </label>
                            <textarea id="customer_address" name="customer_address" rows="3"
                                      class="form-control @error('customer_address') is-invalid @enderror"
                                      placeholder="Street, building, apartment number"
                                      required>{{ old('customer_address') }}</textarea>
                            @error('customer_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4 mb-3">Payment Method</h5>

                    <div class="mb-3">
                        @php
                            $methods = [
                                'cod' => ['Cash on Delivery', 'Pay when you receive your order.'],
                                'card' => ['Credit Card', 'Pay securely with your credit card.'],
                                'bank_transfer' => ['Bank Transfer', 'Transfer to our bank account.'],
                            ];
                        @endphp
                        @foreach($methods as $val => [$label, $desc])
                        <div class="form-check mb-2">
                            <input type="radio" id="payment_{{ $val }}" name="payment_method"
                                   value="{{ $val }}"
                                   class="form-check-input @error('payment_method') is-invalid @enderror"
                                   {{ old('payment_method', 'cod') === $val ? 'checked' : '' }} required>
                            <label for="payment_{{ $val }}" class="form-check-label fw-medium">{{ $label }}</label>
                            <small class="d-block text-muted ms-4">{{ $desc }}</small>
                        </div>
                        @endforeach
                        @error('payment_method')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                            <i class="bi bi-check-lg"></i> Place Order
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left"></i> Back to Cart
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Order Summary</h5>

                @foreach($items as $item)
                <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                    @if($item['image_url'])
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}"
                             class="rounded" width="56" height="56" style="object-fit:cover">
                    @else
                        <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                             style="width:56px;height:56px">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="mb-0 text-truncate">{{ $item['name'] }}</h6>
                        <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                    </div>
                    <span class="fw-semibold text-nowrap">{{ format_currency($item['price'] * $item['quantity']) }}</span>
                </div>
                @endforeach

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold">{{ format_currency($total) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Shipping</span>
                    <span class="fw-semibold" id="shippingDisplay">{{ format_currency(0) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-0">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5 text-primary" id="totalDisplay">{{ format_currency($total) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliverySelect = document.getElementById('delivery_area');
    const chargeInput = document.getElementById('delivery_charge_input');
    const shippingDisplay = document.getElementById('shippingDisplay');
    const totalDisplay = document.getElementById('totalDisplay');
    const subtotal = {{ $total }};

    function updateDeliveryCharge() {
        const selected = deliverySelect.options[deliverySelect.selectedIndex];
        const charge = selected && selected.dataset.charge ? parseFloat(selected.dataset.charge) : 0;

        chargeInput.value = charge;
        shippingDisplay.textContent = '{{ config("app.currency_symbol", "৳") }}' + charge.toFixed(2);
        totalDisplay.textContent = '{{ config("app.currency_symbol", "৳") }}' + (subtotal + charge).toFixed(2);
    }

    deliverySelect.addEventListener('change', updateDeliveryCharge);
});
</script>
@endpush
