@extends('layouts.app')

@section('title', 'Warehouses - Business Management System')
@section('page-title', 'Warehouses')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-warehouse"></i>
                    Warehouse Management
                </h2>
                <p class="page-header-subtitle">Manage warehouse locations and facilities</p>
            </div>
            <div class="page-header-actions">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addWarehouseModal">
                    <i class="fas fa-plus"></i>
                    Add Warehouse
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalWarehouses ?? 0 }}</h3>
                <p class="stat-card-label">Total Warehouses</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $activeWarehouses ?? 0 }}</h3>
                <p class="stat-card-label">Active Warehouses</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalProducts ?? 0 }}</h3>
                <p class="stat-card-label">Total Products Stored</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalValue ?? 0, 2) }}</h3>
                <p class="stat-card-label">Total Inventory Value</p>
            </div>
        </div>
    </div>

    <!-- Warehouses Grid -->
    <div class="warehouses-grid">
        @forelse($warehouses ?? [] as $warehouse)
        <div class="card warehouse-card">
            <div class="warehouse-card-header">
                <div class="warehouse-header-top">
                    <h3 class="warehouse-name">{{ $warehouse->name }}</h3>
                    <span class="badge badge-{{ $warehouse->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($warehouse->status) }}
                    </span>
                </div>
                <p class="warehouse-code">Code: {{ $warehouse->code }}</p>
            </div>
            
            <div class="warehouse-card-body">
                <div class="warehouse-info">
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Location</strong>
                            <p>{{ $warehouse->address }}, {{ $warehouse->city }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <strong>Manager</strong>
                            <p>{{ $warehouse->manager_name ?? 'Not assigned' }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Contact</strong>
                            <p>{{ $warehouse->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="warehouse-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ $warehouse->products_count ?? 0 }}</span>
                        <span class="stat-label">Products</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $warehouse->capacity ?? 0 }}m²</span>
                        <span class="stat-label">Capacity</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $warehouse->utilization ?? 0 }}%</span>
                        <span class="stat-label">Utilized</span>
                    </div>
                </div>
            </div>
            
            <div class="warehouse-card-footer">
                <button class="btn btn-sm btn-info" onclick="viewWarehouse({{ $warehouse->id }})">
                    <i class="fas fa-eye"></i> View Details
                </button>
                <button class="btn btn-sm btn-warning" onclick="editWarehouse({{ $warehouse->id }})">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-secondary" onclick="viewInventory({{ $warehouse->id }})">
                    <i class="fas fa-boxes"></i> Inventory
                </button>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                <h4>No Warehouses Found</h4>
                <p class="text-muted">Add your first warehouse to start managing inventory locations</p>
                <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addWarehouseModal">
                    <i class="fas fa-plus"></i>
                    Add Warehouse
                </button>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('styles')
<style>
    .warehouses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }
    
    .warehouse-card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .warehouse-card-header {
        padding: 1.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    
    .warehouse-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .warehouse-name {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }
    
    .warehouse-code {
        margin: 0;
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .warehouse-card-body {
        padding: 1.5rem;
        flex: 1;
    }
    
    .warehouse-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-item {
        display: flex;
        gap: 0.75rem;
    }
    
    .info-item i {
        width: 20px;
        color: #667eea;
        margin-top: 0.25rem;
    }
    
    .info-item strong {
        display: block;
        font-size: 0.813rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    
    .info-item p {
        margin: 0;
        font-size: 0.938rem;
    }
    
    .warehouse-stats {
        display: flex;
        justify-content: space-around;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.375rem;
    }
    
    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #667eea;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
    }
    
    .warehouse-card-footer {
        display: flex;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e9ecef;
    }
    
    .warehouse-card-footer .btn {
        flex: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    function viewWarehouse(id) {
        window.location.href = `/warehouses/${id}`;
    }
    
    function editWarehouse(id) {
        window.location.href = `/warehouses/${id}/edit`;
    }
    
    function viewInventory(id) {
        window.location.href = `/inventory?warehouse=${id}`;
    }
</script>
@endpush
@endsection
