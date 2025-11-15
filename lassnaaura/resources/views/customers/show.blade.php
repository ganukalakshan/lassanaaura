@extends('layouts.app')

@section('title', 'Customer Details - Business Management System')
@section('page-title', 'Customer Details')

@section('content')
<div class="page-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Customers
                </a>
                <h2 class="page-header-title">
                    <i class="fas fa-user"></i>
                    {{ $customer->name }}
                </h2>
                <p class="page-header-subtitle">Customer #{{ $customer->customer_number }}</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <button onclick="printCustomer()" class="btn btn-secondary">
                    <i class="fas fa-print"></i>
                    Print
                </button>
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="status-banner">
        <span class="badge badge-{{ $customer->status === 'active' ? 'success' : 'danger' }} badge-lg">
            <i class="fas fa-circle"></i>
            {{ ucfirst($customer->status) }} Customer
        </span>
        <span class="badge badge-{{ $customer->type === 'business' ? 'info' : 'secondary' }} badge-lg">
            <i class="fas fa-{{ $customer->type === 'business' ? 'building' : 'user' }}"></i>
            {{ ucfirst($customer->type) }}
        </span>
    </div>

    <div class="details-grid">
        <!-- Customer Overview -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle"></i>
                    Customer Overview
                </h3>
            </div>
            <div class="card-body">
                <div class="customer-profile">
                    <div class="customer-avatar-large">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </div>
                    <div class="customer-details">
                        <h2>{{ $customer->name }}</h2>
                        @if($customer->company_name)
                        <p class="company-name">
                            <i class="fas fa-building"></i>
                            {{ $customer->company_name }}
                        </p>
                        @endif
                        <div class="contact-info">
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                            </div>
                            @if($customer->website)
                            <div class="contact-item">
                                <i class="fas fa-globe"></i>
                                <a href="{{ $customer->website }}" target="_blank">{{ $customer->website }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="detail-section mt-4">
                    <h4><i class="fas fa-map-marker-alt"></i> Address</h4>
                    <div class="address-box">
                        <p>{{ $customer->address_line1 }}</p>
                        @if($customer->address_line2)
                        <p>{{ $customer->address_line2 }}</p>
                        @endif
                        <p>{{ $customer->city }}, {{ $customer->state }} {{ $customer->postal_code }}</p>
                        <p>{{ $customer->country }}</p>
                    </div>
                </div>

                @if($customer->tax_number || $customer->notes)
                <div class="detail-section mt-4">
                    <h4><i class="fas fa-info-circle"></i> Additional Information</h4>
                    @if($customer->tax_number)
                    <p><strong>Tax Number:</strong> {{ $customer->tax_number }}</p>
                    @endif
                    @if($customer->notes)
                    <div class="notes-box">
                        <p><strong>Notes:</strong></p>
                        <p>{{ $customer->notes }}</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-column">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-value">{{ $customer->orders_count ?? 0 }}</h3>
                    <p class="stat-card-label">Total Orders</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-value">${{ number_format($customer->total_spent ?? 0, 2) }}</h3>
                    <p class="stat-card-label">Total Spent</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-value">{{ $customer->invoices_count ?? 0 }}</h3>
                    <p class="stat-card-label">Total Invoices</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-value">${{ number_format($customer->outstanding_balance ?? 0, 2) }}</h3>
                    <p class="stat-card-label">Outstanding</p>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-credit-card"></i>
                    Payment & Billing
                </h3>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Payment Terms</span>
                        <span class="info-value">Net {{ $customer->payment_terms ?? 0 }} days</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Credit Limit</span>
                        <span class="info-value">${{ number_format($customer->credit_limit ?? 0, 2) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Default Discount</span>
                        <span class="info-value">{{ $customer->discount_percentage ?? 0 }}%</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Currency</span>
                        <span class="info-value">{{ $customer->currency ?? 'USD' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart"></i>
                    Recent Orders
                </h3>
                <a href="#" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td><strong>#{{ $order->order_number }}</strong></td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td><strong class="text-success">${{ number_format($order->total, 2) }}</strong></td>
                                <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No orders yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-file-invoice"></i>
                    Recent Invoices
                </h3>
                <a href="#" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInvoices ?? [] as $invoice)
                            <tr>
                                <td><strong>#{{ $invoice->invoice_number }}</strong></td>
                                <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                <td><strong class="text-success">${{ number_format($invoice->total, 2) }}</strong></td>
                                <td><span class="badge badge-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No invoices yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Activity Timeline
                </h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($activities ?? [] as $activity)
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <h5>{{ $activity->description }}</h5>
                            <p class="text-muted">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted">No activity yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .status-banner {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .badge-lg {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .details-grid {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: 1fr 1fr;
    }
    
    .card-primary {
        grid-column: 1 / 2;
        grid-row: 1 / 3;
    }
    
    .stats-column {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        grid-column: 2 / 3;
        grid-row: 1 / 2;
    }
    
    .customer-profile {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }
    
    .customer-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 2rem;
        flex-shrink: 0;
    }
    
    .customer-details h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.75rem;
    }
    
    .company-name {
        color: #6c757d;
        margin: 0 0 1rem 0;
    }
    
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .contact-item i {
        width: 20px;
        color: #6c757d;
    }
    
    .detail-section h4 {
        margin-bottom: 1rem;
        color: #495057;
    }
    
    .address-box, .notes-box {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 0.375rem;
        border-left: 3px solid #667eea;
    }
    
    .address-box p, .notes-box p {
        margin: 0.25rem 0;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
    }
    
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-marker {
        position: absolute;
        left: -2rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px #667eea;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 12px;
        bottom: -12px;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item:last-child::before {
        display: none;
    }
    
    .timeline-content h5 {
        margin: 0 0 0.25rem 0;
        font-size: 0.938rem;
    }
    
    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .card-primary, .stats-column {
            grid-column: 1;
            grid-row: auto;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function printCustomer() {
        window.print();
    }
</script>
@endpush
@endsection
