@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="text-center py-5">
    <div class="mb-4">
        <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 rounded-circle"
             style="width:120px;height:120px">
            <i class="bi bi-emoji-frown text-warning" style="font-size:3.5rem"></i>
        </div>
    </div>
    <h1 class="display-4 fw-bold text-warning mb-3">404</h1>
    <h4 class="fw-semibold mb-2">Page Not Found</h4>
    <p class="text-muted mb-4">The page you are looking for does not exist or has been moved.</p>
    <div class="d-flex justify-content-center gap-3">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Go Back
        </a>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-house"></i> Home
        </a>
        <a href="{{ route('shop.products') }}" class="btn btn-outline-primary">
            <i class="bi bi-bag"></i> Shop
        </a>
    </div>
</div>
@endsection
