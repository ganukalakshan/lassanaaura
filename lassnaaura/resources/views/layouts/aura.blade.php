<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aura ERP') - Modern Business Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fb;
            color: #1e293b;
            overflow-x: hidden;
        }
        
        /* Side Menu */
        .aura-sidebar {
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
        
        .aura-logo {
            padding: 0 30px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }
        
        .aura-logo h1 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .aura-logo p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            margin-top: 5px;
        }
        
        .aura-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .aura-menu-item {
            margin-bottom: 8px;
        }
        
        .aura-menu-link {
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
        
        .aura-menu-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
        }
        
        .aura-menu-link.active {
            background: white;
            color: #667eea;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .aura-menu-link i {
            margin-right: 12px;
            font-size: 20px;
        }
        
        /* Main Content */
        .aura-main {
            margin-left: 260px;
            min-height: 100vh;
        }
        
        .aura-header {
            background: white;
            padding: 20px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .aura-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .aura-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .aura-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }
        
        .aura-content {
            padding: 40px;
        }
        
        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .alert i {
            font-size: 20px;
        }
        
        /* Logout Button */
        .aura-user {
            position: relative;
            cursor: pointer;
        }
        
        .aura-user-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 8px;
            min-width: 180px;
            display: none;
            z-index: 1000;
        }
        
        .aura-user:hover .aura-user-menu {
            display: block;
        }
        
        .aura-user-menu-item {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #64748b;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .aura-user-menu-item:hover {
            background: #f1f5f9;
            color: #667eea;
        }
        
        .aura-user-menu-item i {
            font-size: 18px;
        }
        
        /* Logout Modal */
        .logout-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }
        
        .logout-modal.active {
            display: flex;
        }
        
        .logout-modal-content {
            background: white;
            border-radius: 16px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .logout-modal-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .logout-modal-icon i {
            font-size: 30px;
            color: white;
        }
        
        .logout-modal h3 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 10px;
            color: #1e293b;
        }
        
        .logout-modal p {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }
        
        .logout-modal-buttons {
            display: flex;
            gap: 12px;
        }
        
        .logout-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .logout-btn-cancel {
            background: #f1f5f9;
            color: #64748b;
        }
        
        .logout-btn-cancel:hover {
            background: #e2e8f0;
        }
        
        .logout-btn-confirm {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .logout-btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="aura-sidebar">
        <div class="aura-logo">
            <h1>✨ Aura ERP</h1>
            <p>Modern Business Suite</p>
        </div>
        
        <ul class="aura-menu">
            <li class="aura-menu-item">
                <a href="{{ route('aura.dashboard') }}" class="aura-menu-link {{ request()->routeIs('aura.dashboard') ? 'active' : '' }}">
                    <i class="ri-dashboard-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="aura-menu-item">
                <a href="{{ route('aura.products') }}" class="aura-menu-link {{ request()->routeIs('aura.products') ? 'active' : '' }}">
                    <i class="ri-box-3-line"></i>
                    <span>Add Product Details</span>
                </a>
            </li>
            <li class="aura-menu-item">
                <a href="{{ route('aura.customers.add') }}" class="aura-menu-link {{ request()->routeIs('aura.customers.add') ? 'active' : '' }}">
                    <i class="ri-user-add-line"></i>
                    <span>Add Customer</span>
                </a>
            </li>
            <li class="aura-menu-item">
                <a href="{{ route('aura.orders') }}" class="aura-menu-link {{ request()->routeIs('aura.orders') ? 'active' : '' }}">
                    <i class="ri-add-circle-line"></i>
                    <span>Create Order</span>
                </a>
            </li>
            <li class="aura-menu-item">
                <a href="{{ route('aura.orders.complete') }}" class="aura-menu-link {{ request()->routeIs('aura.orders.complete') ? 'active' : '' }}">
                    <i class="ri-check-double-line"></i>
                    <span>Complete Orders</span>
                </a>
            </li>
            <li class="aura-menu-item">
                <a href="{{ route('aura.orders.pending') }}" class="aura-menu-link {{ request()->routeIs('aura.orders.pending') ? 'active' : '' }}">
                    <i class="ri-time-line"></i>
                    <span>Pending Orders</span>
                </a>
            </li>
            <li class="aura-menu-item">
                <a href="{{ route('aura.profit.analysis') }}" class="aura-menu-link {{ request()->routeIs('aura.profit.analysis') ? 'active' : '' }}">
                    <i class="ri-line-chart-line"></i>
                    <span>Profit & Loss</span>
                </a>
            </li>
        </ul>
    </aside>
    
    <!-- Main Content -->
    <main class="aura-main">
        <header class="aura-header">
            <h2>@yield('page-title', 'Dashboard')</h2>
            <div class="aura-user">
                <div class="aura-user-avatar">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <span>{{ auth()->user()->name ?? 'User' }}</span>
                <div class="aura-user-menu">
                    <div class="aura-user-menu-item" onclick="openLogoutModal()">
                        <i class="ri-logout-box-line"></i>
                        <span>Logout</span>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="aura-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="ri-checkbox-circle-line"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="ri-error-warning-line"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <!-- Logout Modal -->
    <div id="logoutModal" class="logout-modal">
        <div class="logout-modal-content">
            <div class="logout-modal-icon">
                <i class="ri-logout-box-line"></i>
            </div>
            <h3>Confirm Logout</h3>
            <p>Are you sure you want to logout from Aura ERP?</p>
            <div class="logout-modal-buttons">
                <button class="logout-btn logout-btn-cancel" onclick="closeLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('logout') }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="logout-btn logout-btn-confirm" style="width: 100%;">Yes, Logout</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
        }
        
        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }
        
        // Close modal when clicking outside
        document.getElementById('logoutModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
