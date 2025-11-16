<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <span>LassanaAura ERP</span>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section-title">Main</div>
        
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-section-title">Sales</div>
        
        <div class="nav-item">
            <a href="{{ route('customers.index') }}" class="nav-link nav-customer {{ request()->routeIs('customers.*') ? 'active' : '' }}" aria-label="Customers">
                <span class="nav-icon">
                    <i class="fas fa-users" aria-hidden="true"></i>
                </span>
                <span>
                    Customers
                    <small class="nav-note">Manage contacts</small>
                </span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('sales.quotes.index') }}" class="nav-link {{ request()->routeIs('sales.quotes.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
                <span>Sales Quotes</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('sales.orders.index') }}" class="nav-link {{ request()->routeIs('sales.orders.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                <span>Sales Orders</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-file-invoice"></i></span>
                <span>Invoices</span>
            </a>
        </div>
        
        <div class="nav-section-title">Purchases</div>
        
        <div class="nav-item">
            <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-truck"></i></span>
                <span>Suppliers</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('purchases.orders.index') }}" class="nav-link {{ request()->routeIs('purchases.orders.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-receipt"></i></span>
                <span>Purchase Orders</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-money-bill-wave"></i></span>
                <span>Expenses</span>
            </a>
        </div>
        
        <div class="nav-section-title">Inventory</div>
        
        <div class="nav-item nav-product-group">
            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-box"></i></span>
                <span>
                    Products
                    <small class="nav-note">Catalog & Inventory</small>
                </span>
            </a>
            <div class="nav-product-sub">
                <a href="{{ route('products.index') }}" class="sub-link {{ request()->routeIs('products.index') ? 'active' : '' }}">View Products</a>
                <a href="{{ route('products.create') }}" class="sub-link {{ request()->routeIs('products.create') ? 'active' : '' }}">Add Product</a>
            </div>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('inventory.index') }}" class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-warehouse"></i></span>
                <span>Stock Management</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="/warehouses" class="nav-link {{ request()->is('warehouses*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-building"></i></span>
                <span>Warehouses</span>
            </a>
        </div>
        
        <div class="nav-section-title">Finance</div>
        
        <div class="nav-item">
            <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-credit-card"></i></span>
                <span>Payments</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                <span>Reports</span>
            </a>
        </div>
        
        <div class="nav-section-title">System</div>
        
        <div class="nav-item">
            <a href="/users" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                <span>Users</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="/settings" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-cog"></i></span>
                <span>Settings</span>
            </a>
        </div>
    </nav>
</aside>

@push('styles')
<style>
    .nav-product-group { display:block; padding-bottom:6px; }
    .nav-product-group .nav-link { display:flex; align-items:center; gap:8px; justify-content:space-between; }
    .nav-product-group .nav-note { display:block; font-size:0.72rem; color:#98a0a6; }
    .nav-actions .btn { padding:4px 8px; border-radius:6px; }
    .nav-product-sub { display:flex; flex-direction:column; gap:4px; padding:6px 16px; }
    .nav-product-sub .sub-link { color:#556; font-size:0.92rem; text-decoration:none; padding:6px 8px; border-radius:6px; }
    .nav-product-sub .sub-link.active, .nav-product-sub .sub-link:hover { background:#f2f7f2; color:#2d8a3a; }
</style>
@endpush


