@extends('layouts.app')

@section('title', 'Purchase Orders - Business Management System')
@section('page-title', 'Purchase Orders')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-receipt"></i>
                    Purchase Orders
                </h2>
                <p class="page-header-subtitle">Manage supplier purchase orders</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('purchases.orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    New Purchase Order
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-receipt"></i>
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
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $receivedOrders ?? 0 }}</h3>
                <p class="stat-card-label">Received</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalSpent ?? 0, 2) }}</h3>
                <p class="stat-card-label">Total Spent</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search purchase orders...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control">
                <option value="">All Status</option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="confirmed">Confirmed</option>
                <option value="received">Received</option>
                <option value="cancelled">Cancelled</option>
            </select>
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Purchase Orders Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Purchase Orders List
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>PO #</th>
                            <th>Supplier</th>
                            <th>Order Date</th>
                            <th>Expected Date</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseOrders ?? [] as $order)
                        <tr>
                            <td><strong class="text-primary">#{{ $order->po_number }}</strong></td>
                            <td>{{ $order->supplier->company_name }}</td>
                            <td>{{ $order->order_date->format('M d, Y') }}</td>
                            <td>{{ $order->expected_date->format('M d, Y') }}</td>
                            <td>{{ $order->items_count }} items</td>
                            <td><strong class="text-danger">${{ number_format($order->total, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $order->status === 'received' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('purchases.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('purchases.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                    <h4>No Purchase Orders Found</h4>
                                    <a href="{{ route('purchases.orders.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        New Purchase Order
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
