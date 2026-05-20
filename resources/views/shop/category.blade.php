@extends('layouts.app')

@section('title', $category->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('shop.products') }}">Products</a></li>
        <li class="breadcrumb-item active">{{ $category->name }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">{{ $category->name }}</h4>
        <p class="text-muted mb-0">{{ $category->products->where('status', true)->count() }} products</p>
    </div>
    <a href="{{ route('shop.products') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-grid"></i> All Products
    </a>
</div>

<div class="row g-4">
    @forelse($products as $product)
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm h-100 hover-shadow" style="transition:transform 0.15s"
             onmouseover="this.style.transform='translateY(-3px)'"
             onmouseout="this.style.transform=''">
            <a href="{{ route('shop.product-detail', $product->slug) }}" class="text-decoration-none">
                <div class="ratio ratio-1x1 bg-light">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="card-img-top" style="object-fit:cover">
                    @else
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                    @endif
                </div>
            </a>
            <div class="card-body d-flex flex-column">
                <a href="{{ route('shop.product-detail', $product->slug) }}"
                   class="text-decoration-none text-dark">
                    <h6 class="fw-semibold mb-2">{{ $product->name }}</h6>
                </a>
                <div class="mt-auto">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-primary fs-5">${{ number_format($product->price, 2) }}</span>
                        @if($product->isOutOfStock())
                            <span class="badge bg-danger">Out of Stock</span>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary w-100 btn-sm"
                                @if($product->isOutOfStock()) disabled @endif>
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5 text-muted">
            <i class="bi bi-box-seam d-block fs-1 mb-2"></i>
            No products in this category yet.
        </div>
    </div>
    @endforelse
</div>

@if($products->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>
@endif
@endsection
