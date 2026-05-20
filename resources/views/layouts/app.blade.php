<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', website_setting('website_name', config('app.name')))</title>
    <x-seo :title="View::hasSection('title') ? View::getSection('title') . ' - ' . website_setting('website_name', config('app.name')) : website_setting('website_name', config('app.name'))" />
    @if($favicon = website_setting_image('favicon'))
    <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg text-white sticky-top" style="background-color: {{ website_setting('primary_color', '#08a59b') }};">
        <div class="container">
            <a class="navbar-brand fw-bolder text-white" href="{{ route('home') }}" style="margin-right: 100px; ">
                @if($logo = website_setting_image('logo'))
                    <img src="{{ $logo }}" alt="{{ website_setting('website_name', config('app.name')) }}" height="40">
                @else
                    {{ website_setting('website_name', config('app.name')) }}
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto fw-bold">
                    <li class="nav-item ">
                        <a class="nav-link text-white {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                           <i class="fa-solid fa-house"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('shop.products') ? 'active' : '' }}" href="{{ route('shop.products') }}">
                            <i class="fa-solid fa-shop"></i> Shop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                            <i class="fa-solid fa-envelope"></i> Contact
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-person"></i> Dashboard
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-shield-lock"></i> Admin
                            </a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="fa-solid fa-right-to-bracket"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white  text-white fw-bold {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">
                               <i class="fa-solid fa-user-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link text-white fw-bold position-relative {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="fa-solid fa-cart-shopping"></i> Your Cart
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem">
                                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-decoration-none text-white">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container py-3">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @isset($errors)
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
            @endisset
            @yield('content')
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-1">{!! website_setting('footer_text', '&copy; ' . date('Y') . ' ' . website_setting('website_name', config('app.name')) . '. All rights reserved.') !!}</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
