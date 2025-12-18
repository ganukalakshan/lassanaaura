@extends('layouts.aura')

@section('title', 'Complete Orders')
@section('page-title', 'Complete Orders')

@push('styles')
<style>
    .orders-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    
    .btn-new-order {
        padding: 12px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-new-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 16px;
    }
    
    .order-card {
        background: white;
        border-radius: 10px;
        padding: 14px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
    }
    
    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .order-number {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .order-date {
        font-size: 11px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        background: #dcfce7;
        color: #166534;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    
    .order-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .order-field {
        padding: 8px;
        background: #f8fafc;
        border-radius: 6px;
    }
    
    .field-label {
        font-size: 10px;
        color: #64748b;
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .field-value {
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .order-items {
        margin: 12px 0;
    }
    
    .items-title {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 6px;
    }
    
    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 10px;
        background: #f8fafc;
        border-radius: 5px;
        margin-bottom: 4px;
        font-size: 11px;
    }
    
    .item-name {
        font-weight: 600;
        color: #1e293b;
    }
    
    .item-price {
        color: #667eea;
        font-weight: 600;
    }
    
    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 6px;
        margin-top: 10px;
    }
    
    .total-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
    }
    
    .total-amount {
        font-size: 16px;
        font-weight: 700;
        color: #667eea;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
    }
    
    .empty-state i {
        font-size: 80px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 20px;
        color: #64748b;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: #94a3b8;
        margin-bottom: 25px;
    }
    
    .payment-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        background: #dbeafe;
        color: #1e40af;
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <div class="header-actions">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 5px;">Complete Orders</h1>
            <p style="color: #64748b;">View all confirmed and completed orders</p>
        </div>
        <a href="{{ route('aura.orders') }}" class="btn-new-order">
            <i class="ri-add-line"></i> Create New Order
        </a>
    </div>
    
    @if(session('success'))
    <div style="background: #dcfce7; border-left: 4px solid #10b981; padding: 16px; border-radius: 8px; margin-bottom: 20px; color: #166534;">
        <i class="ri-check-line"></i> {{ session('success') }}
    </div>
    @endif
    
    <div class="orders-grid">
        @forelse($orders as $order)
        <div class="order-card">
            <div class="order-header">
                <div>
                    <div class="order-number">{{ $order->order_number }}</div>
                    <div class="order-date">
                        <i class="ri-calendar-line"></i>
                        {{ $order->order_date->format('d M Y, h:i A') }}
                    </div>
                </div>
                <div class="status-badge">
                    <i class="ri-check-double-line"></i> Confirmed
                </div>
            </div>
            
            <div class="order-body">
                <div class="order-field">
                    <div class="field-label">Customer</div>
                    <div class="field-value">{{ $order->customer->name }}</div>
                </div>
                <div class="order-field">
                    <div class="field-label">Email</div>
                    <div class="field-value" style="font-size: 13px;">{{ $order->customer->email }}</div>
                </div>
                <div class="order-field">
                    <div class="field-label">Payment Method</div>
                    <div class="field-value">
                        <span class="payment-badge">
                            <i class="ri-{{ $order->payment_method === 'cash' ? 'money-dollar-circle-line' : 'bank-card-line' }}"></i>
                            {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}
                        </span>
                    </div>
                </div>
                <div class="order-field">
                    <div class="field-label">Created By</div>
                    <div class="field-value">{{ $order->creator->name ?? 'System' }}</div>
                </div>
            </div>
            
            <div class="order-items">
                <div class="items-title">
                    <i class="ri-shopping-bag-line"></i> Order Items ({{ $order->items->count() }})
                </div>
                @foreach($order->items as $item)
                <div class="item-row">
                    <span class="item-name">{{ $item->product->name }}</span>
                    <span class="item-price">Rs {{ number_format($item->unit_price, 2) }}</span>
                </div>
                @endforeach
            </div>
            
            <div class="order-total">
                <span class="total-label">Total Amount:</span>
                <span class="total-amount">Rs {{ number_format($order->total, 2) }}</span>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="ri-file-list-line"></i>
            <h3>No Complete Orders Yet</h3>
            <p>Confirmed orders will appear here</p>
            <a href="{{ route('aura.orders') }}" class="btn-new-order">
                <i class="ri-add-line"></i> Create Your First Order
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
