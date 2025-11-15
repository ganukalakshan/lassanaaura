@extends('layouts.app')

@section('title', 'Invoices - Business Management System')
@section('page-title', 'Invoices')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-file-invoice"></i>
                    Invoice Management
                </h2>
                <p class="page-header-subtitle">Create and manage customer invoices</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Create Invoice
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
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalInvoices ?? 0 }}</h3>
                <p class="stat-card-label">Total Invoices</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($paidAmount ?? 0, 2) }}</h3>
                <p class="stat-card-label">Paid Amount</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($pendingAmount ?? 0, 2) }}</h3>
                <p class="stat-card-label">Pending Payment</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($overdueAmount ?? 0, 2) }}</h3>
                <p class="stat-card-label">Overdue</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="invoiceSearch" placeholder="Search by invoice number or customer name...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control" id="statusFilter">
                <option value="">All Status</option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="paid">Paid</option>
                <option value="overdue">Overdue</option>
                <option value="cancelled">Cancelled</option>
            </select>
            
            <input type="date" class="form-control" id="dateFrom" placeholder="From Date">
            <input type="date" class="form-control" id="dateTo" placeholder="To Date">
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Invoice List
            </h3>
            <div class="card-actions">
                <span class="badge badge-primary">{{ $invoices->total() ?? 0 }} invoices</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices ?? [] as $invoice)
                        <tr>
                            <td><strong class="text-primary">#{{ $invoice->invoice_number }}</strong></td>
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                            <td>{{ $invoice->due_date->format('M d, Y') }}</td>
                            <td><strong>${{ number_format($invoice->total, 2) }}</strong></td>
                            <td><span class="text-success">${{ number_format($invoice->paid_amount, 2) }}</span></td>
                            <td><strong class="text-danger">${{ number_format($invoice->balance, 2) }}</strong></td>
                            <td>
                                @php
                                    $statusColors = [
                                        'draft' => 'secondary',
                                        'sent' => 'info',
                                        'paid' => 'success',
                                        'overdue' => 'danger',
                                        'cancelled' => 'dark'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $statusColors[$invoice->status] ?? 'secondary' }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="downloadInvoice({{ $invoice->id }})" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button onclick="deleteInvoice({{ $invoice->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                                    <h4>No Invoices Found</h4>
                                    <p class="text-muted">Create your first invoice</p>
                                    <a href="{{ route('invoices.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        Create Invoice
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if(isset($invoices) && $invoices->hasPages())
        <div class="card-footer">
            {{ $invoices->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function downloadInvoice(id) {
        window.open(`/invoices/${id}/download`, '_blank');
    }
    
    function deleteInvoice(id) {
        if (confirm('Are you sure you want to delete this invoice?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/invoices/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    function resetFilters() {
        document.getElementById('invoiceSearch').value = '';
        document.getElementById('statusFilter').value = '';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
    }
</script>
@endpush
@endsection
