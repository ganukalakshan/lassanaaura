@extends('layouts.app')

@section('title', 'Reports - Business Management System')
@section('page-title', 'Reports')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-chart-bar"></i>
                    Business Reports & Analytics
                </h2>
                <p class="page-header-subtitle">Comprehensive business intelligence and reporting</p>
            </div>
        </div>
    </div>

    <!-- Report Categories Grid -->
    <div class="report-categories-grid">
        <!-- Sales Reports -->
        <div class="card report-category-card">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3 class="card-title text-white">
                    <i class="fas fa-chart-line"></i>
                    Sales Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="report-list">
                    <a href="{{ route('reports.sales') }}" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Sales Summary</h5>
                            <p>Overview of all sales activities</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.sales') }}?type=by-customer" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Sales by Customer</h5>
                            <p>Customer-wise sales breakdown</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.sales') }}?type=by-product" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Sales by Product</h5>
                            <p>Product performance analysis</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.sales') }}?type=by-period" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Sales Trends</h5>
                            <p>Period-wise sales analysis</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Purchase Reports -->
        <div class="card report-category-card">
            <div class="card-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <h3 class="card-title text-white">
                    <i class="fas fa-shopping-bag"></i>
                    Purchase Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="report-list">
                    <a href="{{ route('reports.purchases') }}" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Purchase Summary</h5>
                            <p>Overview of all purchases</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.purchases') }}?type=by-supplier" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Purchase by Supplier</h5>
                            <p>Supplier-wise purchase analysis</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.purchases') }}?type=by-product" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Purchase by Product</h5>
                            <p>Product-wise purchase breakdown</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Inventory Reports -->
        <div class="card report-category-card">
            <div class="card-header" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3 class="card-title text-white">
                    <i class="fas fa-warehouse"></i>
                    Inventory Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="report-list">
                    <a href="{{ route('reports.inventory') }}" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Stock Summary</h5>
                            <p>Current inventory levels</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.inventory') }}?type=valuation" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Inventory Valuation</h5>
                            <p>Stock value analysis</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.inventory') }}?type=movement" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Stock Movement</h5>
                            <p>Inventory transactions history</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.inventory') }}?type=low-stock" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Low Stock Report</h5>
                            <p>Items below reorder level</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Financial Reports -->
        <div class="card report-category-card">
            <div class="card-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3 class="card-title text-white">
                    <i class="fas fa-coins"></i>
                    Financial Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="report-list">
                    <a href="{{ route('reports.profit-loss') }}" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Profit & Loss</h5>
                            <p>Income statement analysis</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.cash-flow') }}" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Cash Flow</h5>
                            <p>Cash in and out analysis</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="#" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Accounts Receivable</h5>
                            <p>Outstanding customer payments</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="#" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Accounts Payable</h5>
                            <p>Outstanding supplier payments</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Customer Reports -->
        <div class="card report-category-card">
            <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3 class="card-title text-white">
                    <i class="fas fa-users-cog"></i>
                    Customer Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="report-list">
                    <a href="{{ route('reports.customers') }}" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-address-book"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Customer List</h5>
                            <p>Complete customer directory</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.customers') }}?type=top-customers" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Top Customers</h5>
                            <p>Best performing customers</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="{{ route('reports.customers') }}?type=aging" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Customer Aging</h5>
                            <p>Outstanding balance aging report</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tax Reports -->
        <div class="card report-category-card">
            <div class="card-header" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
                <h3 class="card-title text-white">
                    <i class="fas fa-percentage"></i>
                    Tax Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="report-list">
                    <a href="#" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Tax Summary</h5>
                            <p>Tax collected and paid</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="#" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>VAT/GST Report</h5>
                            <p>Value added tax summary</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    
                    <a href="#" class="report-item">
                        <div class="report-item-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="report-item-content">
                            <h5>Tax by Category</h5>
                            <p>Tax breakdown by category</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Reports -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-magic"></i>
                Custom Report Builder
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">Create custom reports with your own criteria and filters</p>
            <div class="custom-report-form">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Report Type</label>
                        <select class="form-control">
                            <option>Sales Report</option>
                            <option>Purchase Report</option>
                            <option>Inventory Report</option>
                            <option>Financial Report</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>Date Range</label>
                        <select class="form-control">
                            <option>Today</option>
                            <option>This Week</option>
                            <option>This Month</option>
                            <option>This Quarter</option>
                            <option>This Year</option>
                            <option>Custom Range</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label>Export Format</label>
                        <select class="form-control">
                            <option>PDF</option>
                            <option>Excel (XLSX)</option>
                            <option>CSV</option>
                        </select>
                    </div>
                </div>
                
                <button class="btn btn-primary">
                    <i class="fas fa-play"></i>
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Stats Dashboard -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tachometer-alt"></i>
                Quick Statistics
            </h3>
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-card-content">
                        <h3 class="stat-card-value">${{ number_format($totalSales ?? 0, 2) }}</h3>
                        <p class="stat-card-label">Total Sales (This Month)</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-card-content">
                        <h3 class="stat-card-value">${{ number_format($totalPurchases ?? 0, 2) }}</h3>
                        <p class="stat-card-label">Total Purchases (This Month)</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <div class="stat-card-content">
                        <h3 class="stat-card-value">${{ number_format($profit ?? 0, 2) }}</h3>
                        <p class="stat-card-label">Net Profit (This Month)</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div class="stat-card-content">
                        <h3 class="stat-card-value">{{ number_format($profitMargin ?? 0, 1) }}%</h3>
                        <p class="stat-card-label">Profit Margin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .report-categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .report-category-card {
        overflow: hidden;
    }
    
    .report-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .report-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.375rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s;
    }
    
    .report-item:hover {
        background: #e9ecef;
        transform: translateX(4px);
    }
    
    .report-item-icon {
        width: 40px;
        height: 40px;
        border-radius: 0.375rem;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .report-item-content {
        flex: 1;
    }
    
    .report-item-content h5 {
        margin: 0 0 0.25rem 0;
        font-size: 0.938rem;
        font-weight: 600;
    }
    
    .report-item-content p {
        margin: 0;
        font-size: 0.813rem;
        color: #6c757d;
    }
    
    .report-item > i.fa-chevron-right {
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .custom-report-form .form-row {
        margin-bottom: 1rem;
    }
</style>
@endpush
@endsection
