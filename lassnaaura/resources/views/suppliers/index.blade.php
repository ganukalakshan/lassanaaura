@extends('layouts.app')

@section('title', 'Suppliers - Business Management System')
@section('page-title', 'Suppliers')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-truck"></i>
                    Supplier Management
                </h2>
                <p class="page-header-subtitle">Manage your supplier database</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Supplier
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
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalSuppliers ?? 0 }}</h3>
                <p class="stat-card-label">Total Suppliers</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $activeSuppliers ?? 0 }}</h3>
                <p class="stat-card-label">Active Suppliers</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalPurchases ?? 0 }}</h3>
                <p class="stat-card-label">Total Purchases</p>
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
            <input type="text" placeholder="Search suppliers...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Supplier List
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Supplier Code</th>
                            <th>Company Name</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Purchases</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers ?? [] as $supplier)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td><span class="badge badge-secondary">{{ $supplier->supplier_code }}</span></td>
                            <td><strong>{{ $supplier->company_name }}</strong></td>
                            <td>{{ $supplier->contact_name }}</td>
                            <td><i class="fas fa-envelope text-muted"></i> {{ $supplier->email }}</td>
                            <td><i class="fas fa-phone text-muted"></i> {{ $supplier->phone }}</td>
                            <td><strong class="text-success">${{ number_format($supplier->total_purchases ?? 0, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $supplier->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($supplier->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteSupplier({{ $supplier->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                                    <h4>No Suppliers Found</h4>
                                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        Add Supplier
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

@push('scripts')
<script>
    function deleteSupplier(id) {
        if (confirm('Are you sure you want to delete this supplier?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/suppliers/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
@endsection
