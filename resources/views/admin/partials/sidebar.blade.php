<aside class="admin-sidebar" id="adminSidebar">
    <div class="brand">
        @if($logo = website_setting_image('logo'))
            <img src="{{ $logo }}" alt="{{ website_setting('website_name', config('app.name')) }}" height="30">
        @else
            {{ website_setting('website_name', config('app.name')) }}
        @endif
    </div>
    <nav class="flex-grow-1 py-2">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.categories.index') }}"
           class="nav-link @if(request()->routeIs('admin.categories.*')) active @endif">
            <i class="bi bi-collection"></i> Category Management
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="nav-link @if(request()->routeIs('admin.products.*')) active @endif">
            <i class="bi bi-box-seam"></i> Product Management
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-link @if(request()->routeIs('admin.orders.*')) active @endif">
            <i class="bi bi-truck"></i> Orders
        </a>
        <a href="{{ route('admin.delivery-charges.index') }}"
           class="nav-link @if(request()->routeIs('admin.delivery-charges.*')) active @endif">
            <i class="bi bi-geo-alt"></i> Delivery Charges
        </a>
        <a href="{{ route('admin.contacts.index') }}"
           class="nav-link @if(request()->routeIs('admin.contacts.*')) active @endif">
            <i class="bi bi-envelope"></i> Contact Messages
        </a>
        <a href="{{ route('admin.settings.index') }}"
           class="nav-link @if(request()->routeIs('admin.settings.*')) active @endif">
            <i class="bi bi-gear"></i> Website Settings
        </a>
        <div class="nav-section-label">Access Control</div>
        <a href="{{ route('admin.users.index') }}"
           class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
            <i class="bi bi-people"></i> Users
        </a>
        <a href="{{ route('admin.roles.index') }}"
           class="nav-link @if(request()->routeIs('admin.roles.*')) active @endif">
            <i class="bi bi-person-badge"></i> Roles
        </a>
        <a href="{{ route('admin.permissions.index') }}"
           class="nav-link @if(request()->routeIs('admin.permissions.*')) active @endif">
            <i class="bi bi-shield-check"></i> Permissions
        </a>
    </nav>
    <div class="border-top border-secondary p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start" style="border-left:3px solid transparent;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</aside>
