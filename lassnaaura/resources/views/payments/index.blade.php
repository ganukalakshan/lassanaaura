@extends('layouts.app')

@section('title', 'Payments - Business Management System')
@section('page-title', 'Payments')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-credit-card"></i>
                    Payment Management
                </h2>
                <p class="page-header-subtitle">Track and manage payments</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('payments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Record Payment
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalReceived ?? 0, 2) }}</h3>
                <p class="stat-card-label">Payments Received</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalPaid ?? 0, 2) }}</h3>
                <p class="stat-card-label">Payments Made</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-receipt"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $paymentCount ?? 0 }}</h3>
                <p class="stat-card-label">Total Transactions</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($todayPayments ?? 0, 2) }}</h3>
                <p class="stat-card-label">Today's Payments</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search payments...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control">
                <option value="">All Types</option>
                <option value="received">Received</option>
                <option value="paid">Paid</option>
            </select>
            
            <select class="form-control">
                <option value="">All Methods</option>
                <option value="cash">Cash</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="credit_card">Credit Card</option>
                <option value="check">Check</option>
            </select>
            
            <input type="date" class="form-control" id="dateFrom">
            <input type="date" class="form-control" id="dateTo">
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Payment Transactions
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Payment #</th>
                            <th>Type</th>
                            <th>Customer/Supplier</th>
                            <th>Invoice/PO #</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Reference</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments ?? [] as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td><strong class="text-primary">#{{ $payment->payment_number }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $payment->type === 'received' ? 'success' : 'danger' }}">
                                    <i class="fas fa-arrow-{{ $payment->type === 'received' ? 'down' : 'up' }}"></i>
                                    {{ ucfirst($payment->type) }}
                                </span>
                            </td>
                            <td>{{ $payment->payer_name }}</td>
                            <td>#{{ $payment->reference_number }}</td>
                            <td>
                                <strong class="text-{{ $payment->type === 'received' ? 'success' : 'danger' }}">
                                    ${{ number_format($payment->amount, 2) }}
                                </strong>
                            </td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ $payment->transaction_reference ?? '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-sm btn-secondary" onclick="printReceipt({{ $payment->id }})">
                                        <i class="fas fa-print"></i>
                                    </button>
                                    <button onclick="deletePayment({{ $payment->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                    <h4>No Payments Found</h4>
                                    <a href="{{ route('payments.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        Record Payment
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
    function printReceipt(id) {
        window.open(`/payments/${id}/receipt`, '_blank');
    }
    
    function deletePayment(id) {
        if (confirm('Are you sure you want to delete this payment?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/payments/${id}`;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush
@endsection
