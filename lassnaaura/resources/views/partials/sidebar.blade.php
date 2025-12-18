<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="fas fa-gem"></i>
            </div>
            <span>✨ Aura ERP</span>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-item">
            <a href="{{ route('aura.dashboard') }}" class="nav-link {{ request()->routeIs('aura.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('aura.products') }}" class="nav-link {{ request()->routeIs('aura.products') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-box"></i></span>
                <span>Add Product Details</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('aura.customers.add') }}" class="nav-link {{ request()->routeIs('aura.customers.add') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-user-plus"></i></span>
                <span>Add Customer</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('aura.orders') }}" class="nav-link {{ request()->routeIs('aura.orders') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                <span>Orders</span>
            </a>
        </div>
    </nav>
</aside>

@push('styles')
<style>
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 260px;
        height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px 0;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }
    
    .sidebar-header {
        padding: 0 30px 30px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        margin-bottom: 30px;
    }
    
    .sidebar-logo span {
        color: white;
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }
    
    .sidebar-logo-icon {
        display: none;
    }
    
    .sidebar-nav {
        padding: 0 15px;
    }
    
    .nav-item {
        margin-bottom: 8px;
    }
    
    .nav-link {
        display: flex;
        align-items: center;
        padding: 14px 15px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.3s ease;
        font-size: 15px;
        font-weight: 500;
    }
    
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        transform: translateX(5px);
    }
    
    .nav-link.active {
        background: white;
        color: #667eea;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .nav-icon {
        margin-right: 12px;
        font-size: 20px;
        width: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush
        font-weight: 600;
    }
    
    .nav-product-sub .sub-link.active::before {
        color: white;
        content: '→';
    }
</style>
@endpush


