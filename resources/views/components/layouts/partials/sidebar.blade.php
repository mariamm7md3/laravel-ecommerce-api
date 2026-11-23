<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

        <span class="app-brand-text demo menu-text fw-bold">Alheba</span>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div>{{ __('layout.home') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <a href="{{ route('profile') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-app-window"></i>
                <div>{{ __('layout.profile') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('products.index') ? 'active' : '' }}">
            <a href="{{ route('products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                <div>{{ __('layout.products') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
            <a href="{{ route('categories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-category"></i>
                <div>{{ __('layout.categories') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div>{{ __('layout.users') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('messages.index') ? 'active' : '' }}">
            <a href="{{ route('messages.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-mail"></i>
                <div>{{ __('layout.messages') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('sizes.index') ? 'active' : '' }}">
            <a href="{{ route('sizes.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-ruler-2"></i>
                <div>{{ __('layout.sizes') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('units.index') ? 'active' : '' }}">
            <a href="{{ route('units.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-weight"></i>
                <div>{{ __('layout.units') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('sales.index') ? 'active' : '' }}">
            <a href="{{ route('sales.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-discount"></i>
                <div>{{ __('layout.sales') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('orders.index') ? 'active' : '' }}">
            <a href="{{ route('orders.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-package"></i>
                <div>{{ __('layout.orders') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('branches.index') ? 'active' : '' }}">
            <a href="{{ route('branches.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-building-store"></i>
                <div>{{ __('layout.branches') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('industries.index') ? 'active' : '' }}">
            <a href="{{ route('industries.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-building-factory"></i>
                <div>{{ __('layout.industries') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('delivery-times.index') ? 'active' : '' }}">
            <a href="{{ route('delivery-times.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-clock"></i>
                <div>{{ __('layout.delivery-times') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('discount-codes.index') ? 'active' : '' }}">
            <a href="{{ route('discount-codes.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-ticket"></i>
                <div>{{ __('layout.discount-codes') }}</div>
            </a>
        </li>

    </ul>
</aside>
<!-- / Menu -->
