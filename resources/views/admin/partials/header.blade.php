<header class="admin-navbar">
    <div class="d-flex align-items-center gap-3">
        <button class="sidebar-toggle d-md-none" type="button">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="badge bg-danger">Admin</span>
        <span class="text-muted small">{{ auth()->user()->name }}</span>
    </div>
</header>
