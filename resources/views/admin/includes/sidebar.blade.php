<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ getPath('admin') }}/img/64.png" alt="Z-Zone"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ getConstant('SITE_NAME') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a @class(['active' => request()->routeIs('users.*'), 'nav-link']) href="{{ route('users.index') }}">
                        <i class="fas fa-users nav-icon"></i>
                        <p>Clients</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a @class(['active' => request()->routeIs('products.*'), 'nav-link']) href="{{ route('products.index') }}">
                        <i class="fas fa-boxes nav-icon"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a @class(['active' => request()->routeIs('categories.*'), 'nav-link']) href="{{ route('categories.index') }}">
                        <i class="fas fa-shopping-bag nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
