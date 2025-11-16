@extends('layouts.app')

@section('title', 'Customers - Business Management System')
@section('page-title', 'Customers')

@section('content')
<div class="page-container">
    <!-- Page Header with Actions -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-users"></i>
                    Customer Management
                </h2>
                <p class="page-header-subtitle">Manage your customer database and relationships</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Customer
                </a>
                <button class="btn btn-secondary" onclick="exportCustomers()">
                    <i class="fas fa-download"></i>
                    Export
                </button>
                <button class="btn btn-secondary" onclick="printCustomers()">
                    <i class="fas fa-print"></i>
                    Print
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon stat-purple">
                <i class="fas fa-users" aria-hidden="true"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalCustomers ?? 0 }}</h3>
                <p class="stat-card-label">Total Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon stat-pink">
                <i class="fas fa-user-check" aria-hidden="true"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $activeCustomers ?? 0 }}</h3>
                <p class="stat-card-label">Active Customers</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon stat-blue">
                <i class="fas fa-dollar-sign" aria-hidden="true"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p class="stat-card-label">Total Revenue</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-icon stat-green">
                <i class="fas fa-receipt" aria-hidden="true"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalOrders ?? 0 }}</h3>
                <p class="stat-card-label">Total Orders</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="customerSearch" placeholder="Search customers by name, email, or phone..." onkeyup="filterCustomers()">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="statusFilter" onchange="filterCustomers()">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            
            <select class="form-control" id="typeFilter" onchange="filterCustomers()">
                <option value="">All Types</option>
                <option value="individual">Individual</option>
                <option value="business">Business</option>
            </select>
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Customer List
            </h3>
            <div class="card-actions">
                <span class="badge badge-primary">{{ $customers->total() ?? 0 }} customers</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="customersTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                            </th>
                            <th onclick="sortTable(1)">
                                Customer ID
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(2)">
                                Name
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(3)">
                                Email
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(4)">
                                Phone
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(5)">
                                Type
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(6)">
                                Total Orders
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(7)">
                                Total Spent
                                <i class="fas fa-sort"></i>
                            </th>
                            <th onclick="sortTable(8)">
                                Status
                                <i class="fas fa-sort"></i>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers ?? [] as $customer)
                        <tr>
                            <td>
                                <input type="checkbox" class="customer-checkbox" value="{{ $customer->id }}">
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">#{{ $customer->customer_number }}</span>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $customer->name }}</strong>
                                        @if($customer->company_name)
                                        <br><small class="text-muted">{{ $customer->company_name }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-envelope text-muted"></i>
                                {{ $customer->email }}
                            </td>
                            <td>
                                <i class="fas fa-phone text-muted"></i>
                                {{ $customer->phone }}
                            </td>
                            <td>
                                <span class="badge badge-{{ $customer->type === 'business' ? 'info' : 'secondary' }}">
                                    {{ ucfirst($customer->type) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <strong>{{ $customer->orders_count ?? 0 }}</strong>
                            </td>
                            <td>
                                <strong class="text-success">${{ number_format($customer->total_spent ?? 0, 2) }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-{{ $customer->status === 'active' ? 'success' : 'danger' }}">
                                    <i class="fas fa-circle"></i>
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteCustomer({{ $customer->id }})" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <h4>No Customers Found</h4>
                                    <p class="text-muted">Start by adding your first customer</p>
                                    <a href="{{ route('customers.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        Add Customer
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($customers) && $customers->hasPages())
        <div class="card-footer">
            <div class="pagination-wrapper">
                {{ $customers->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    /* Container and header */
    .page-container { padding: 16px; }
    .page-header { margin-bottom: 12px; }
    .page-header-content { display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .page-header-left h2 { margin: 0; font-size: 1.05rem; }
    .page-header-subtitle { margin: 0; color: #6c757d; font-size: 0.9rem; }
    .page-header-actions .btn { margin-left: 6px; padding: 8px 12px; }

    /* Stats grid compact */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 12px; }
    .stat-card { display: flex; gap: 10px; align-items: center; padding: 12px; border-radius: 10px; background: #fff; border: 1px solid #eef0f3; }
    .stat-card-icon { width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; }
    .stat-card-value { margin: 0; font-size: 1.05rem; }
    .stat-card-label { margin: 0; color: #757575; font-size: 0.85rem; }

    /* Filters and search - inline and compact */
    .filter-section { display: flex; gap: 10px; align-items: center; margin-bottom: 12px; flex-wrap: wrap; }
    .search-box { display: flex; align-items: center; gap: 8px; padding: 6px 10px; border-radius: 8px; background: #fff; border: 1px solid #e9ecef; min-width: 260px; }
    .search-box i { color: #9aa0a6; }
    .search-box input { border: none; outline: none; padding: 6px; font-size: 0.95rem; width: 100%; }
    .filter-controls { display: flex; gap: 8px; align-items: center; }
    .filter-controls .form-control { padding: 6px 8px; height: auto; min-width: 140px; }

    /* Card and table spacing tightened */
    .card { margin-bottom: 12px; border-radius: 10px; overflow: hidden; border: 1px solid #eef0f3; background: #fff; }
    .card-header { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: transparent; }
    .card-title { margin: 0; font-size: 1rem; }
    .card-body { padding: 8px 12px; }
    .table-responsive { margin: 0; }
    .table th, .table td { padding: 8px 10px; vertical-align: middle; }

    .customer-info { display: flex; align-items: center; gap: 8px; }
    .customer-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; }

    .btn-group { display: flex; gap: 6px; }

    .empty-state { padding: 1.8rem 0; }

    th { cursor: pointer; user-select: none; }
    th:hover { background-color: rgba(0,0,0,0.02); }

    .badge { padding: 6px 8px; border-radius: 999px; font-size: 0.78rem; }

    /* Responsive tweaks */
    @media (max-width: 900px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .filter-controls { width: 100%; justify-content: space-between; }
    }
    @media (max-width: 576px) {
        .stats-grid { grid-template-columns: 1fr; }
        .search-box { min-width: 100%; }
        .filter-controls { width: 100%; gap: 6px; }
    }
</style>
@endpush

@push('scripts')
<script>
    function filterCustomers() {
        const searchTerm = document.getElementById('customerSearch').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
        const table = document.getElementById('customersTable');
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            
            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = !statusFilter || text.includes(statusFilter);
            const matchesType = !typeFilter || text.includes(typeFilter);
            
            row.style.display = matchesSearch && matchesStatus && matchesType ? '' : 'none';
        }
    }
    
    function resetFilters() {
        document.getElementById('customerSearch').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('typeFilter').value = '';
        filterCustomers();
    }
    
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.customer-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
    }
    
    function deleteCustomer(id) {
        if (confirm('Are you sure you want to delete this customer?')) {
            // Submit delete form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/customers/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function exportCustomers() {
        window.location.href = '/customers/export';
    }
    
    function printCustomers() {
        window.print();
    }
    
    let sortDirection = {};
    function sortTable(columnIndex) {
        const table = document.getElementById('customersTable');
        const rows = Array.from(table.rows).slice(1);
        const direction = sortDirection[columnIndex] === 'asc' ? 'desc' : 'asc';
        sortDirection[columnIndex] = direction;
        
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue, undefined, {numeric: true});
            } else {
                return bValue.localeCompare(aValue, undefined, {numeric: true});
            }
        });
        
        rows.forEach(row => table.appendChild(row));
    }
</script>
@endpush
@endsection
