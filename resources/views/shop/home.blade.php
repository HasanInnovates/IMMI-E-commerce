@extends('layouts.app')

@php
    $heroImage = website_setting_image('hero_image');
    $primaryColor = website_setting('primary_color', '#08a59b');
@endphp

@section('title', website_setting('hero_title', 'Home'))

@section('content')
<div class="text-white p-5 mb-5 w-100 text-center position-relative overflow-hidden"
     style="background: {{ $heroImage ? 'url(' . $heroImage . ') no-repeat center center / cover' : $primaryColor }}; min-height: 300px;">
    <div class="position-relative z-1">
        <h1 class="display-4 fw-bold mb-3">{{ website_setting('hero_title', 'Welcome to ' . website_setting('website_name', config('app.name'))) }}</h1>
        <p class="lead text-light mb-4">{{ website_setting('hero_subtitle', 'Discover amazing products at great prices.') }}</p>
        <a href="{{ route('shop.products') }}" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-bag-check"></i> Shop Now
        </a>
    </div>
    @if($heroImage)
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: {{ $primaryColor }}; opacity: 0.6; z-index: 0;"></div>
    @endif
</div>

@if($categories->isNotEmpty())
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Shop by Category</h4>
        <a href="{{ route('shop.products') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="row g-3">
        @foreach($categories as $cat)
        <div class="col-6 col-md-4 col-lg-2">
            <a href="{{ route('shop.category', $cat->slug) }}"
               class="card border-0 shadow-sm text-center text-decoration-none h-100 hover-shadow"
               style="transition:transform 0.15s"
               onmouseover="this.style.transform='translateY(-3px)'"
               onmouseout="this.style.transform=''">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:56px;height:56px">
                        <i class="bi bi-{{ $cat->slug === 'electronics' ? 'cpu' : ($cat->slug === 'clothing' ? 'handbag' : ($cat->slug === 'books' ? 'book' : ($cat->slug === 'home-garden' ? 'house' : ($cat->slug === 'sports' ? 'trophy' : 'tag')))) }} fs-4 text-primary"></i>
                    </div>
                    <h6 class="fw-semibold mb-1 text-dark">{{ $cat->name }}</h6>
                    <small class="text-muted">{{ $cat->products_count }} items</small>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif

<section>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Featured Products</h4>
        <a href="{{ route('shop.products') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="row g-4">
        @forelse($featuredProducts as $product)
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
                    <small class="text-muted mb-1">{{ $product->category->name }}</small>
                    <a href="{{ route('shop.product-detail', $product->slug) }}"
                       class="text-decoration-none text-dark">
                        <h6 class="fw-semibold mb-2">{{ $product->name }}</h6>
                    </a>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-primary fs-5">{{ format_currency($product->price) }}</span>
                        <form method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm btn-outline-primary"
                                    @if($product->isOutOfStock()) disabled @endif>
                                <i class="bi bi-cart-plus"></i>
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
                No products available yet.
            </div>
        </div>
        @endforelse
    </div>
</section>
@endsection
