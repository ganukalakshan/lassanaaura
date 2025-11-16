@extends('layouts.app')

@section('title', 'Products - Business Management System')
@section('page-title', 'Products')

@section('content')
<div class="page-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-box"></i>
                    Product Management
                </h2>
                <p class="page-header-subtitle">Manage your product catalog and inventory</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Product
                </a>
                <button class="btn btn-secondary" onclick="exportProducts()">
                    <i class="fas fa-download"></i>
                    Export
                </button>
                <button class="btn btn-secondary">
                    <i class="fas fa-upload"></i>
                    Import
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalProducts ?? 0 }}</h3>
                <p class="stat-card-label">Total Products</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $activeProducts ?? 0 }}</h3>
                <p class="stat-card-label">Active Products</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $lowStockProducts ?? 0 }}</h3>
                <p class="stat-card-label">Low Stock Items</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalInventoryValue ?? 0, 2) }}</h3>
                <p class="stat-card-label">Inventory Value</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="productSearch" class="search-input" placeholder="Search products by name, SKU, or description..." onkeyup="filterProducts()">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="categoryFilter" onchange="filterProducts()">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <select class="form-control" id="statusFilter" onchange="filterProducts()">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            
            <select class="form-control" id="stockFilter" onchange="filterProducts()">
                <option value="">All Stock</option>
                <option value="in-stock">In Stock</option>
                <option value="low-stock">Low Stock</option>
                <option value="out-of-stock">Out of Stock</option>
            </select>
            
            <button class="btn btn-reset" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Products Grid/Table Toggle -->
    <div class="view-toggle mb-3">
        <button class="btn btn-sm btn-secondary view-btn active" onclick="switchView('table')">
            <i class="fas fa-list"></i> Table View
        </button>
        <button class="btn btn-sm btn-secondary view-btn" onclick="switchView('grid')">
            <i class="fas fa-th"></i> Grid View
        </button>
    </div>

    <!-- Products Table View -->
    <div class="card" id="tableView">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Product List
            </h3>
            <div class="card-actions">
                <span class="badge badge-primary">{{ $products->total() ?? 0 }} products</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="productsTable">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Image</th>
                            <th>SKU</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products ?? [] as $product)
                        <tr>
                            <td><input type="checkbox" class="product-checkbox" value="{{ $product->id }}"></td>
                            <td>
                                <div class="product-image">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td><span class="badge badge-secondary">{{ $product->sku }}</span></td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->description)
                                <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td><strong class="text-success">${{ number_format($product->price, 2) }}</strong></td>
                            <td>
                                @php
                                    $stockClass = $product->stock > $product->low_stock_threshold ? 'success' : ($product->stock > 0 ? 'warning' : 'danger');
                                @endphp
                                <span class="badge badge-{{ $stockClass }}">
                                    {{ $product->stock }} units
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteProduct({{ $product->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                    <h4>No Products Found</h4>
                                    <p class="text-muted">Start by adding your first product</p>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        Add Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($products) && $products->hasPages())
        <div class="card-footer">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- Products Grid View -->
    <div id="gridView" style="display: none;">
        <div class="products-grid">
            @forelse($products ?? [] as $product)
            <div class="product-card">
                <div class="product-card-image">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                    <div class="product-image-placeholder-large">
                        <i class="fas fa-box"></i>
                    </div>
                    @endif
                    <div class="product-card-badges">
                        <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                </div>
                <div class="product-card-body">
                    <div class="product-card-category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                    <h4 class="product-card-title">{{ $product->name }}</h4>
                    <p class="product-card-sku">SKU: {{ $product->sku }}</p>
                    <div class="product-card-meta">
                        @if(!empty($product->unit))
                        <span class="variant-badge">{{ $product->unit }}</span>
                        @endif
                        <span class="price-badge">৳ {{ number_format($product->price, 0) }}</span>
                    </div>
                    <div class="product-card-footer">
                        <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                        <div class="product-card-stock">
                            Stock: <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}">{{ $product->stock }}</span>
                        </div>
                    </div>
                    <div class="product-card-actions">
                        <a href="{{ route('products.show', $product->id) }}?highlight={{ $product->id }}" class="btn btn-sm btn-info {{ request('highlight') == $product->id ? 'btn-highlight' : '' }}">
                            <i class="fas fa-eye"></i> View Product
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="javascript:void(0)" class="btn btn-sm btn-add-cart">
                            ADD TO CART
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                <h4>No Products Found</h4>
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Compact product grid & cards for neat layout */
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 0.9rem; }

    .product-card { background: #fff; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,0.06); transition: transform 0.14s, box-shadow 0.14s; text-align:center; }
    .product-card:hover { transform: translateY(-2px); box-shadow: 0 6px 14px rgba(0,0,0,0.08); }

    .product-card-image { display:flex; align-items:center; justify-content:center; height:150px; background:#fff; }
    .product-card-image img { width:72%; height:120px; object-fit:contain; filter: drop-shadow(0 6px 10px rgba(0,0,0,0.06)); }
    .product-image-placeholder-large { width:100%; height:100%; background:#fbfbfb; display:flex; align-items:center; justify-content:center; color:#e6e6e6; font-size:2.25rem; }

    .product-card-body { padding:0.65rem 0.75rem; }
    .product-card-category { font-size:0.72rem; color:#7a7f84; text-transform:uppercase; margin-bottom:4px; }
    .product-card-title { font-size:0.98rem; font-weight:600; margin:0 0 4px 0; }
    .product-card-sku { font-size:0.78rem; color:#8b9196; margin-bottom:6px; }

    .product-card-meta { display:flex; justify-content:center; gap:6px; align-items:center; margin-bottom:6px; }
    .variant-badge { background:#f1fbf1; color:#2f8a37; padding:4px 8px; border-radius:12px; font-size:0.8rem; }
    .price-badge { background:#f6fbf6; color:#2f8a37; padding:5px 10px; border-radius:16px; font-weight:700; font-size:0.9rem; }

    .product-card-footer { display:flex; justify-content:space-between; align-items:center; padding-top:6px; padding-bottom:6px; border-top:1px solid #f1f2f3; margin-top:8px; }
    .product-card-price { color:#28a745; font-weight:700; }
    .product-card-stock { font-size:0.82rem; }

    .product-card-actions { display:flex; gap:0.45rem; margin-top:8px; }
    .product-card-actions .btn { padding:6px 8px; font-size:0.82rem; border-radius:14px; }
    .btn-add-cart { background:#6dbf3a; color:#fff; font-weight:700; padding:6px 10px; border-radius:18px; }
    .btn-add-cart:hover { background:#59a82f; }
    .btn-sm.btn-info { background:#2b9b3e; border-color:#2b9b3e; }
    .btn-highlight { box-shadow:0 0 0 3px rgba(102,187,106,0.14); border-color:#28a745; }

    /* Compact table spacing */
    .table th, .table td { padding:6px 8px; vertical-align:middle; }

    /* Header, stats and filters compact */
    .page-header { margin-bottom:10px; }
    .page-header-content { display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
    .stats-grid { gap:10px; margin-bottom:10px; }
    .filter-section { display:flex; gap:8px; align-items:center; margin-bottom:10px; flex-wrap:wrap; }
    .search-box { min-width:220px; padding:6px 10px; }
    .filter-controls .form-control { min-width:120px; padding:6px 8px; }

    /* New styling to match provided ecommerce layout */
    .product-card-image { display:flex; align-items:center; justify-content:center; background: #fff; }
    .product-card-image img { width: 70%; height: 140px; object-fit: contain; filter: drop-shadow(0 6px 10px rgba(0,0,0,0.08)); }
    .product-card { text-align: center; padding-bottom: 12px; }
    .product-card-meta { display:flex; justify-content:center; gap:8px; align-items:center; margin-bottom:8px; }
    .variant-badge { background:#e6f4ea; color:#2d8a3a; padding:4px 8px; border-radius:14px; font-size:0.82rem; }
    .price-badge { background:#e9f7ef; color:#1f8a37; padding:6px 10px; border-radius:18px; font-weight:700; font-size:0.95rem; }
    .product-card-price { display:none; }
    .btn-add-cart { background:#6dbf3a; color:white; border-radius:20px; padding:8px 12px; font-weight:700; }
    .btn-add-cart:hover { background:#5aa92f; }
    .btn-highlight { box-shadow: 0 0 0 3px rgba(102, 187, 106, 0.18); border-color:#28a745; }
    .btn-sm.btn-info { background:#2b9b3e; border-color:#2b9b3e; }
    .btn-sm.btn-info:hover { background:#238032; }
    
    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }
    
    /* Search & filter controls styling */
    .search-box { display:flex; align-items:center; gap:8px; background:#fff; border:1px solid #e9ecef; padding:8px 10px; border-radius:10px; min-width:220px; }
    .search-box i { color:#9aa0a6; font-size:16px; }
    .search-box .search-input { border:0; outline:none; padding:6px 0; width:320px; font-size:0.95rem; }
    .filter-controls { display:flex; gap:8px; align-items:center; }
    .filter-controls .form-control { min-width:150px; padding:8px 10px; border-radius:10px; border:1px solid #e9ecef; background:#fff; }
    .btn-reset { background: #fff; border: 1.5px solid rgba(255,99,120,0.25); color:#ff6b81; padding:8px 12px; border-radius:10px; display:flex; align-items:center; gap:6px; }
    .btn-reset i { color:#ff6b81; }

    /* View toggle */
    .view-toggle .view-btn { border-radius:10px; padding:6px 10px; border:1px solid #e6e6e6; background:#fff; color:#556; }
    .view-toggle .view-btn.active { background: linear-gradient(90deg,#ff7a9a,#ffd1d8); color:#6b0b2b; border-color:transparent; }
    .view-toggle .view-btn i { margin-right:6px; }

    @media (max-width:900px) {
        .search-box .search-input { width:160px; }
        .filter-controls { width:100%; gap:6px; }
        .filter-controls .form-control { min-width:120px; }
    }
</style>
@endpush

@push('scripts')
<script>
    function switchView(view) {
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');
        const buttons = document.querySelectorAll('.view-toggle .btn');
        
        buttons.forEach(btn => btn.classList.remove('active'));
        
        if (view === 'table') {
            tableView.style.display = 'block';
            gridView.style.display = 'none';
            buttons[0].classList.add('active');
        } else {
            tableView.style.display = 'none';
            gridView.style.display = 'block';
            buttons[1].classList.add('active');
        }
    }
    
    function filterProducts() {
        // Filter implementation
    }
    
    function resetFilters() {
        document.getElementById('productSearch').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('stockFilter').value = '';
        filterProducts();
    }
    
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/products/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function exportProducts() {
        window.location.href = '/products/export';
    }
</script>
@endpush
@endsection
