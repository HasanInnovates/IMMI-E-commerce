@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold">Categories</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('shop.products') }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !$categorySlug ? 'active' : '' }}">
                    All Products
                    <span class="badge bg-primary rounded-pill">{{ \App\Models\Product::where('status', true)->count() }}</span>
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('shop.products', ['category' => $cat->slug]) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                    <span class="badge bg-primary rounded-pill">{{ $cat->products_count }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <h4 class="fw-bold mb-0">
                @if($categorySlug)
                    {{ $categories->firstWhere('slug', $categorySlug)?->name ?? 'Products' }}
                @elseif($search)
                    Results for "{{ $search }}"
                @else
                    All Products
                @endif
            </h4>
            <form method="GET" action="{{ route('shop.products') }}" class="d-flex" role="search">
                @if($categorySlug)
                    <input type="hidden" name="category" value="{{ $categorySlug }}">
                @endif
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search..."
                           value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                    <a href="{{ route('shop.products', $categorySlug ? ['category' => $categorySlug] : []) }}"
                       class="btn btn-outline-danger">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-6 col-md-4">
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
                        <small class="text-muted mb-1">{{ $product->category->name }}</small>
                        <a href="{{ route('shop.product-detail', $product->slug) }}"
                           class="text-decoration-none text-dark">
                            <h6 class="fw-semibold mb-2">{{ $product->name }}</h6>
                        </a>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-primary fs-5">{{ format_currency($product->price) }}</span>
                                @if($product->isOutOfStock())
                                    <span class="badge bg-danger">Out of Stock</span>
                                @elseif($product->isLowStock())
                                    <span class="badge bg-warning text-dark">Only {{ $product->stock }} left</span>
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
                    <i class="bi bi-search d-block fs-1 mb-2"></i>
                    @if($search)
                        No products match "{{ $search }}".
                    @else
                        No products found in this category.
                    @endif
                </div>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
