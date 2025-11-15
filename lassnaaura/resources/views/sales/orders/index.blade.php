@extends('layouts.app')

@section('title', 'Sales Orders - Business Management System')
@section('page-title', 'Sales Orders')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-shopping-cart"></i>
                    Sales Orders
                </h2>
                <p class="page-header-subtitle">Manage customer sales orders</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('sales.orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    New Sales Order
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalOrders ?? 0 }}</h3>
                <p class="stat-card-label">Total Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $pendingOrders ?? 0 }}</h3>
                <p class="stat-card-label">Pending Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p class="stat-card-label">Total Revenue</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $completedOrders ?? 0 }}</h3>
                <p class="stat-card-label">Completed</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="orderSearch" placeholder="Search by order number or customer...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="statusFilter">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            
            <input type="date" class="form-control" id="dateFrom">
            <input type="date" class="form-control" id="dateTo">
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Sales Orders List
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $order)
                        <tr>
                            <td><strong class="text-primary">#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->order_date->format('M d, Y') }}</td>
                            <td>{{ $order->items_count }} items</td>
                            <td><strong class="text-success">${{ number_format($order->total, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'info') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('sales.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sales.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="printOrder({{ $order->id }})" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h4>No Sales Orders Found</h4>
                                    <p class="text-muted">Create your first sales order</p>
                                    <a href="{{ route('sales.orders.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        New Sales Order
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($orders) && $orders->hasPages())
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function printOrder(id) {
        window.open(`/sales/orders/${id}/print`, '_blank');
    }
    
    function resetFilters() {
        document.getElementById('orderSearch').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
    }
</script>
@endpush
@endsection
