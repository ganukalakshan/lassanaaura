@extends('layouts.app')

@section('title', 'Expenses - Business Management System')
@section('page-title', 'Expenses')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-money-bill-wave"></i>
                    Expense Management
                </h2>
                <p class="page-header-subtitle">Track and manage business expenses</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Expense
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
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalExpenses ?? 0, 2) }}</h3>
                <p class="stat-card-label">Total Expenses</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($thisMonthExpenses ?? 0, 2) }}</h3>
                <p class="stat-card-label">This Month</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $expenseCount ?? 0 }}</h3>
                <p class="stat-card-label">Total Records</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($avgExpense ?? 0, 2) }}</h3>
                <p class="stat-card-label">Average Expense</p>
            </div>
        </div>
    </div>

    <!-- Expense Categories Chart -->
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-pie"></i>
                Expenses by Category
            </h3>
        </div>
        <div class="card-body">
            <canvas id="expenseCategoryChart" height="80"></canvas>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="expenseSearch" placeholder="Search expenses...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="categoryFilter">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            
            <input type="date" class="form-control" id="dateFrom">
            <input type="date" class="form-control" id="dateTo">
            
            <select class="form-control" id="statusFilter">
                <option value="">All Status</option>
                <option value="approved">Approved</option>
                <option value="pending">Pending</option>
                <option value="rejected">Rejected</option>
            </select>
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Expense List
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Expense #</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses ?? [] as $expense)
                        <tr>
                            <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                            <td><strong class="text-primary">#{{ $expense->expense_number }}</strong></td>
                            <td><span class="badge badge-info">{{ $expense->category->name ?? 'Uncategorized' }}</span></td>
                            <td>{{ Str::limit($expense->description, 40) }}</td>
                            <td>{{ $expense->vendor_name ?? '-' }}</td>
                            <td><strong class="text-danger">${{ number_format($expense->amount, 2) }}</strong></td>
                            <td>{{ ucfirst($expense->payment_method) }}</td>
                            <td>
                                <span class="badge badge-{{ $expense->status === 'approved' ? 'success' : ($expense->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($expense->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($expense->receipt_path)
                                    <button class="btn btn-sm btn-secondary" onclick="viewReceipt('{{ $expense->receipt_path }}')">
                                        <i class="fas fa-file"></i>
                                    </button>
                                    @endif
                                    <button onclick="deleteExpense({{ $expense->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                    <h4>No Expenses Found</h4>
                                    <a href="{{ route('expenses.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        Add Expense
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    function viewReceipt(path) {
        window.open(`/storage/${path}`, '_blank');
    }
    
    function deleteExpense(id) {
        if (confirm('Are you sure you want to delete this expense?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/expenses/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function resetFilters() {
        document.getElementById('expenseSearch').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
        document.getElementById('statusFilter').value = '';
    }
    
    // Expense Category Chart
    const ctx = document.getElementById('expenseCategoryChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($categoryLabels ?? ['Office Supplies', 'Utilities', 'Rent', 'Marketing', 'Other']),
                datasets: [{
                    data: @json($categoryData ?? [3000, 1500, 5000, 2000, 1000]),
                    backgroundColor: [
                        '#667eea',
                        '#fa709a',
                        '#43e97b',
                        '#4facfe',
                        '#f093fb'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection
