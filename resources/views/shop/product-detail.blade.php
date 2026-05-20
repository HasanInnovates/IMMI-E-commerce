@extends('layouts.app')

@section('title', $product->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.products') }}">Products</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="ratio ratio-1x1 bg-light">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                         class="card-img-top" style="object-fit:cover">
                @else
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-image text-muted" style="font-size:4rem"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
                <h2 class="fw-bold mb-2">{{ $product->name }}</h2>

                <div class="mb-3">
                    <span class="fs-3 fw-bold text-primary">{{ format_currency($product->price) }}</span>
                </div>

                <p class="text-muted mb-4">{{ $product->description ?? 'No description available.' }}</p>

                <div class="mb-4">
                    @if($product->isOutOfStock())
                        <span class="badge bg-danger fs-6">Out of Stock</span>
                    @elseif($product->isLowStock())
                        <span class="badge bg-warning text-dark fs-6">Only {{ $product->stock }} left in stock</span>
                    @else
                        <span class="badge bg-success fs-6">
                            <i class="bi bi-check-circle"></i> In Stock ({{ $product->stock }} available)
                        </span>
                    @endif
                </div>

                @if(!$product->isOutOfStock())
                <form method="POST" action="{{ route('cart.add') }}" class="row g-2 align-items-end">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="col-auto">
                        <label class="form-label small text-muted">Quantity</label>
                        <div class="input-group" style="width:140px">
                            <button type="button" class="btn btn-outline-secondary" onclick="decQty()">−</button>
                            <input type="number" id="qty" name="quantity" class="form-control text-center"
                                   value="1" min="1" max="{{ $product->stock }}">
                            <button type="button" class="btn btn-outline-secondary" onclick="incQty()">+</button>
                        </div>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </form>
                @else
                <button class="btn btn-secondary btn-lg w-100" disabled>
                    <i class="bi bi-x-circle"></i> Unavailable
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($relatedProducts->isNotEmpty())
<section>
    <h4 class="fw-bold mb-3">Related Products</h4>
    <div class="row g-4">
        @foreach($relatedProducts as $related)
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition:transform 0.15s"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform=''">
                <a href="{{ route('shop.product-detail', $related->slug) }}" class="text-decoration-none">
                    <div class="ratio ratio-1x1 bg-light">
                        @if($related->image_url)
                            <img src="{{ $related->image_url }}" alt="{{ $related->name }}"
                                 class="card-img-top" style="object-fit:cover">
                        @else
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-image text-muted fs-1"></i>
                            </div>
                        @endif
                    </div>
                </a>
                <div class="card-body">
                    <h6 class="fw-semibold mb-1">{{ $related->name }}</h6>
                    <span class="fw-bold text-primary">{{ format_currency($related->price) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
    const qty = document.getElementById('qty');
    const max = parseInt(qty.max);
    function decQty() { if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1; }
    function incQty() { if (parseInt(qty.value) < max) qty.value = parseInt(qty.value) + 1; }
</script>
@endpush
