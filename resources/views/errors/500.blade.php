@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="text-center py-5">
    <div class="mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 rounded-circle"
             style="width:120px;height:120px">
            <i class="bi bi-exclamation-triangle text-danger" style="font-size:3.5rem"></i>
        </div>
    </div>
    <h1 class="display-4 fw-bold text-danger mb-3">500</h1>
    <h4 class="fw-semibold mb-2">Server Error</h4>
    <p class="text-muted mb-4">Something went wrong on our end. Please try again later.</p>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-house"></i> Home
        </a>
        <a href="{{ route('shop.products') }}" class="btn btn-outline-primary">
            <i class="bi bi-bag"></i> Browse Products
        </a>
    </div>
</div>
@endsection
