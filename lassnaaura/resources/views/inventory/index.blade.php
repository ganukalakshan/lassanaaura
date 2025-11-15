@extends('layouts.app')

@section('title', 'Inventory Management - Business Management System')
@section('page-title', 'Inventory')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-warehouse"></i>
                    Inventory Management
                </h2>
                <p class="page-header-subtitle">Monitor and manage stock levels</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('inventory.adjust') }}" class="btn btn-primary">
                    <i class="fas fa-sliders-h"></i>
                    Stock Adjustment
                </a>
                <a href="{{ route('inventory.transfer') }}" class="btn btn-secondary">
                    <i class="fas fa-exchange-alt"></i>
                    Transfer Stock
                </a>
                <button class="btn btn-secondary">
                    <i class="fas fa-download"></i>
                    Export
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
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $inStockProducts ?? 0 }}</h3>
                <p class="stat-card-label">In Stock</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $lowStockProducts ?? 0 }}</h3>
                <p class="stat-card-label">Low Stock Alert</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $outOfStockProducts ?? 0 }}</h3>
                <p class="stat-card-label">Out of Stock</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-grid mb-4">
        <a href="{{ route('inventory.movements') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #667eea;">
                <i class="fas fa-history"></i>
            </div>
            <div class="quick-action-content">
                <h4>Stock Movements</h4>
                <p>View all stock movement history</p>
            </div>
        </a>
        
        <a href="{{ route('inventory.adjust') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #43e97b;">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div class="quick-action-content">
                <h4>Adjust Stock</h4>
                <p>Make inventory adjustments</p>
            </div>
        </a>
        
        <a href="{{ route('inventory.transfer') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: #4facfe;">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="quick-action-content">
                <h4>Transfer Stock</h4>
                <p>Move stock between warehouses</p>
            </div>
        </a>
        
        <a href="#" class="quick-action-card">
            <div class="quick-action-icon" style="background: #fa709a;">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="quick-action-content">
                <h4>Inventory Report</h4>
                <p>Generate detailed reports</p>
            </div>
        </a>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="inventorySearch" placeholder="Search by product name or SKU...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="warehouseFilter">
                <option value="">All Warehouses</option>
                @foreach($warehouses ?? [] as $warehouse)
                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @endforeach
            </select>
            
            <select class="form-control" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <select class="form-control" id="stockStatusFilter">
                <option value="">All Stock Status</option>
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

    <!-- Inventory Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Inventory Stock Levels
            </h3>
            <div class="card-actions">
                <span class="badge badge-primary">{{ $inventoryItems->total() ?? 0 }} items</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Warehouse</th>
                            <th>Current Stock</th>
                            <th>Reserved</th>
                            <th>Available</th>
                            <th>Reorder Level</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventoryItems ?? [] as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <div class="product-image-small">
                                        @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                        @else
                                        <i class="fas fa-box"></i>
                                        @endif
                                    </div>
                                    <strong>{{ $item->product->name }}</strong>
                                </div>
                            </td>
                            <td><span class="badge badge-secondary">{{ $item->product->sku }}</span></td>
                            <td>{{ $item->product->category->name ?? 'Uncategorized' }}</td>
                            <td>{{ $item->warehouse->name ?? 'Main' }}</td>
                            <td><strong>{{ $item->quantity }}</strong></td>
                            <td>{{ $item->reserved_quantity ?? 0 }}</td>
                            <td><strong class="text-success">{{ $item->quantity - ($item->reserved_quantity ?? 0) }}</strong></td>
                            <td>{{ $item->product->low_stock_threshold }}</td>
                            <td>
                                @php
                                    $available = $item->quantity - ($item->reserved_quantity ?? 0);
                                    $threshold = $item->product->low_stock_threshold;
                                    $status = $available <= 0 ? 'out' : ($available <= $threshold ? 'low' : 'good');
                                @endphp
                                <span class="badge badge-{{ $status === 'out' ? 'danger' : ($status === 'low' ? 'warning' : 'success') }}">
                                    @if($status === 'out')
                                        <i class="fas fa-times-circle"></i> Out of Stock
                                    @elseif($status === 'low')
                                        <i class="fas fa-exclamation-triangle"></i> Low Stock
                                    @else
                                        <i class="fas fa-check-circle"></i> In Stock
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" onclick="viewStockHistory({{ $item->product->id }})">
                                        <i class="fas fa-history"></i>
                                    </button>
                                    <a href="{{ route('inventory.adjust') }}?product={{ $item->product->id }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-sliders-h"></i>
                                    </a>
                                    <button class="btn btn-sm btn-secondary" onclick="printLabel({{ $item->product->id }})">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                                    <h4>No Inventory Items Found</h4>
                                    <p class="text-muted">Add products to start managing inventory</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($inventoryItems) && $inventoryItems->hasPages())
        <div class="card-footer">
            {{ $inventoryItems->links() }}
        </div>
        @endif
    </div>

    <!-- Low Stock Alert -->
    @if(isset($lowStockItems) && count($lowStockItems) > 0)
    <div class="card border-warning mt-4">
        <div class="card-header bg-warning text-white">
            <h3 class="card-title">
                <i class="fas fa-exclamation-triangle"></i>
                Low Stock Alerts
            </h3>
        </div>
        <div class="card-body">
            <div class="alert-list">
                @foreach($lowStockItems as $lowItem)
                <div class="alert-item">
                    <div>
                        <strong>{{ $lowItem->product->name }}</strong> ({{ $lowItem->product->sku }})
                    </div>
                    <div>
                        <span class="text-danger">Current: {{ $lowItem->quantity }} units</span>
                        <span class="text-muted ml-2">Reorder at: {{ $lowItem->product->low_stock_threshold }}</span>
                    </div>
                    <a href="#" class="btn btn-sm btn-primary">Create Purchase Order</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .quick-action-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    
    .quick-action-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .quick-action-content h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }
    
    .quick-action-content p {
        margin: 0;
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .product-image-small {
        width: 40px;
        height: 40px;
        border-radius: 0.375rem;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-image-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .alert-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .alert-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #fff3cd;
        border-radius: 0.375rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function viewStockHistory(productId) {
        window.location.href = `/inventory/movements?product=${productId}`;
    }
    
    function printLabel(productId) {
        window.open(`/products/${productId}/label`, '_blank');
    }
    
    function resetFilters() {
        document.getElementById('inventorySearch').value = '';
        document.getElementById('warehouseFilter').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('stockStatusFilter').value = '';
    }
</script>
@endpush
@endsection
