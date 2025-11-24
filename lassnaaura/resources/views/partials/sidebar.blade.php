<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-gem"></i>
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
    .nav-product-group { 
        display: block; 
        padding-bottom: 8px; 
    }
    
    .nav-product-group .nav-link { 
        display: flex; 
        align-items: center; 
        gap: 1rem; 
        justify-content: space-between; 
    }
    
    .nav-product-sub { 
        display: flex; 
        flex-direction: column; 
        gap: 6px; 
        padding: 10px 1rem 10px 3.5rem; 
        margin-top: 6px;
        background: rgba(255, 113, 154, 0.05);
        border-radius: 12px;
        border-left: 3px solid var(--primary-pink-light);
    }
    
    .nav-product-sub .sub-link { 
        color: var(--text-primary); 
        font-size: 0.88rem; 
        text-decoration: none; 
        padding: 0.65rem 1rem; 
        border-radius: 10px;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 2rem;
        font-weight: 500;
    }
    
    .nav-product-sub .sub-link::before {
        content: '•';
        position: absolute;
        left: 0.8rem;
        color: var(--primary-pink);
        transition: all 0.3s ease;
        font-size: 1.2rem;
    }
    
    .nav-product-sub .sub-link:hover {
        background: linear-gradient(135deg, rgba(255, 113, 154, 0.15) 0%, rgba(255, 113, 154, 0.08) 100%);
        color: var(--primary-pink-darker);
        transform: translateX(3px);
        box-shadow: 0 2px 8px rgba(255, 113, 154, 0.15);
    }
    
    .nav-product-sub .sub-link:hover::before {
        color: var(--primary-pink-darker);
        transform: scale(1.2);
    }
    
    .nav-product-sub .sub-link.active { 
        background: linear-gradient(135deg, var(--primary-pink) 0%, var(--primary-pink-darker) 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(255, 113, 154, 0.3);
        font-weight: 600;
    }
    
    .nav-product-sub .sub-link.active::before {
        color: white;
        content: '→';
    }
</style>
@endpush


