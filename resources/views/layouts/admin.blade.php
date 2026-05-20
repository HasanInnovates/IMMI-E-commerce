<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ website_setting('website_name', config('app.name')) }}</title>
    <x-seo title="{{ (View::hasSection('title') ? View::getSection('title') . ' - ' : '') . 'Admin - ' . website_setting('website_name', config('app.name')) }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; margin: 0; }
        .admin-wrapper { display: flex; height: 100vh; }
        .admin-sidebar {
            width: 260px; min-width: 260px;
            background: #1e293b; color: #cbd5e1;
            display: flex; flex-direction: column;
            transition: margin-left 0.3s;
        }
        .admin-sidebar .brand {
            padding: 1rem 1.25rem; font-size: 1.25rem; font-weight: 700;
            border-bottom: 1px solid #334155; color: #fff;
        }
        .admin-sidebar .nav-link {
            color: #94a3b8; padding: 0.65rem 1.25rem; font-size: 0.9rem;
            display: flex; align-items: center; gap: 0.75rem;
            border-left: 3px solid transparent; transition: all 0.15s;
        }
        .admin-sidebar .nav-link:hover {
            background: #334155; color: #e2e8f0;
        }
        .admin-sidebar .nav-link.active {
            background: #334155; color: #fff;
            border-left-color: #3b82f6;
        }
        .admin-sidebar .nav-link i { width: 1.25rem; text-align: center; }
        .admin-sidebar .nav-section-label {
            padding: 1rem 1.25rem 0.35rem; font-size: 0.7rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.08em; color: #64748b;
        }
        .admin-content {
            flex: 1; display: flex; flex-direction: column; min-width: 0;
            background: #f1f5f9;
        }
        .admin-navbar {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem; display: flex; align-items: center;
            justify-content: space-between;
        }
        .admin-navbar .sidebar-toggle {
            background: none; border: none; font-size: 1.25rem;
            color: #475569; cursor: pointer;
        }
        .admin-main { flex: 1; overflow-y: auto; padding: 1.5rem; }
        .sidebar-overlay { display: none; }
        @media (max-width: 768px) {
            .admin-sidebar {
                position: fixed; top: 0; left: 0; z-index: 1040;
                height: 100vh; margin-left: -260px;
            }
            .admin-sidebar.show { margin-left: 0; }
            .sidebar-overlay {
                display: none; position: fixed; inset: 0; z-index: 1039;
                background: rgba(0,0,0,0.5);
            }
            .sidebar-overlay.show { display: block; }
            .admin-navbar .sidebar-toggle { display: inline-block; }
        }
        .admin-footer {
            border-top: 1px solid #e2e8f0; padding: 0.75rem 1.5rem;
            background: #fff; font-size: 0.85rem; color: #64748b;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        @include('admin.partials.sidebar')
        <div class="admin-content">
            @include('admin.partials.header')
            <main class="admin-main">
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
            </main>
            @include('admin.partials.footer')
        </div>
    </div>
    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.admin-sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        });
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.querySelector('.admin-sidebar').classList.remove('show');
            this.classList.remove('show');
        });
    </script>
    @stack('scripts')
</body>
</html>
