@extends('layouts.app')

@section('title', 'Dashboard - Business Management System')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stats-value">$45,850</div>
            <div class="stats-label">Revenue (MTD)</div>
        </div>
    </div>
    
    <div class="col-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value">342</div>
            <div class="stats-label">Total Customers</div>
        </div>
    </div>
    
    <div class="col-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stats-value">128</div>
            <div class="stats-label">Pending Invoices</div>
        </div>
    </div>
    
    <div class="col-3">
        <div class="stats-card">
            <div class="stats-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stats-value">$125,450</div>
            <div class="stats-label">Stock Value</div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: var(--spacing-xl);">
    <!-- Recent Invoices -->
    <div class="col-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Invoices</h3>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-2025-000001</td>
                                <td>ABC Corporation</td>
                                <td>Nov 15, 2025</td>
                                <td>$2,500.00</td>
                                <td><span class="badge badge-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>INV-2025-000002</td>
                                <td>XYZ Ltd</td>
                                <td>Nov 14, 2025</td>
                                <td>$1,850.00</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>INV-2025-000003</td>
                                <td>Tech Solutions</td>
                                <td>Nov 13, 2025</td>
                                <td>$3,200.00</td>
                                <td><span class="badge badge-primary">Sent</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('invoices.index') }}" class="btn btn-primary">View All Invoices</a>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Alert -->
    <div class="col-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Low Stock Alert</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: var(--spacing-md);">
                    <div style="padding: var(--spacing-md); background: var(--danger-light); border-radius: var(--radius-md); border-left: 4px solid var(--danger);">
                        <div style="font-weight: 600; color: var(--text-primary);">Product A</div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary);">Only 5 units left</div>
                    </div>
                    <div style="padding: var(--spacing-md); background: var(--warning-light); border-radius: var(--radius-md); border-left: 4px solid var(--warning);">
                        <div style="font-weight: 600; color: var(--text-primary);">Product B</div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary);">Only 8 units left</div>
                    </div>
                    <div style="padding: var(--spacing-md); background: var(--warning-light); border-radius: var(--radius-md); border-left: 4px solid var(--warning);">
                        <div style="font-weight: 600; color: var(--text-primary);">Product C</div>
                        <div style="font-size: 0.875rem; color: var(--text-secondary);">Only 12 units left</div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Manage Inventory</a>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: var(--spacing-xl);">
    <!-- Quick Actions -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-md);">
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-lg" style="text-decoration: none;">
                        <i class="fas fa-plus"></i>
                        New Invoice
                    </a>
                    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-lg" style="text-decoration: none;">
                        <i class="fas fa-user-plus"></i>
                        Add Customer
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg" style="text-decoration: none;">
                        <i class="fas fa-box"></i>
                        Add Product
                    </a>
                    <a href="{{ route('payments.create') }}" class="btn btn-primary btn-lg" style="text-decoration: none;">
                        <i class="fas fa-credit-card"></i>
                        Record Payment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
