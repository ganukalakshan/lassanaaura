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
            <input type="text" id="productSearch" placeholder="Search products by name, SKU, or description..." onkeyup="filterProducts()">
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
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Products Grid/Table Toggle -->
    <div class="view-toggle mb-3">
        <button class="btn btn-sm btn-secondary active" onclick="switchView('table')">
            <i class="fas fa-list"></i> Table View
        </button>
        <button class="btn btn-sm btn-secondary" onclick="switchView('grid')">
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
                    <div class="product-card-footer">
                        <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                        <div class="product-card-stock">
                            Stock: <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}">{{ $product->stock }}</span>
                        </div>
                    </div>
                    <div class="product-card-actions">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
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
    .product-image {
        width: 50px;
        height: 50px;
        border-radius: 0.375rem;
        overflow: hidden;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-image-placeholder {
        width: 50px;
        height: 50px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        border-radius: 0.375rem;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .product-card {
        background: white;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    
    .product-card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    
    .product-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-image-placeholder-large {
        width: 100%;
        height: 100%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: #dee2e6;
    }
    
    .product-card-badges {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }
    
    .product-card-body {
        padding: 1rem;
    }
    
    .product-card-category {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }
    
    .product-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }
    
    .product-card-sku {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 1rem;
    }
    
    .product-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .product-card-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #28a745;
    }
    
    .product-card-stock {
        font-size: 0.875rem;
    }
    
    .product-card-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .product-card-actions .btn {
        flex: 1;
    }
    
    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }
    
    .view-toggle .btn.active {
        background: #667eea;
        color: white;
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
