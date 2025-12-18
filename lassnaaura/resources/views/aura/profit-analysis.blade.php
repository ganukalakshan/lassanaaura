@extends('layouts.aura')

@section('title', 'Profit & Loss Analysis')
@section('page-title', 'Profit & Loss Analysis')

@push('styles')
<style>
    .profit-container {
        max-width: 1600px;
        margin: 0 auto;
    }
    
    /* Summary Cards */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }
    
    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
    }
    
    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }
    
    .summary-card.profit::before {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    }
    
    .summary-card.loss::before {
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
    }
    
    .summary-card.revenue::before {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .summary-card.cost::before {
        background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
    }
    
    .summary-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 24px;
    }
    
    .summary-card.profit .summary-icon {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .summary-card.loss .summary-icon {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .summary-card.revenue .summary-icon {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }
    
    .summary-card.cost .summary-icon {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }
    
    .summary-label {
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .summary-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .summary-change {
        font-size: 12px;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .summary-change.positive {
        color: #10b981;
    }
    
    .summary-change.negative {
        color: #ef4444;
    }
    
    /* Transactions Table */
    .transactions-section {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .section-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-buttons {
        display: flex;
        gap: 10px;
    }
    
    .filter-btn {
        padding: 8px 16px;
        border: 2px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-btn:hover {
        border-color: #667eea;
        color: #667eea;
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
    }
    
    .transactions-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .transactions-table thead {
        background: #f8fafc;
    }
    
    .transactions-table th {
        padding: 15px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .transactions-table td {
        padding: 18px 15px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #1e293b;
    }
    
    .transactions-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .transactions-table tbody tr:hover {
        background: #f8fafc;
    }
    
    .order-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        background: #f1f5f9;
        color: #64748b;
    }
    
    .profit-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
    }
    
    .profit-badge.positive {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    
    .profit-badge.negative {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }
    
    .profit-margin {
        font-size: 12px;
        color: #64748b;
        margin-top: 4px;
    }
    
    .product-details {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .product-sku {
        font-size: 12px;
        color: #94a3b8;
    }
    
    .price-breakdown {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    
    .price-item {
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .price-label {
        color: #94a3b8;
    }
    
    .price-value {
        font-weight: 600;
        color: #1e293b;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
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
    }
    
    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: #64748b;
    }
</style>
@endpush

@section('content')
<div class="profit-container">
    <!-- Summary Cards -->
    <div class="summary-grid">
        <div class="summary-card profit">
            <div class="summary-icon">
                <i class="ri-arrow-up-circle-fill"></i>
            </div>
            <div class="summary-label">Total Profit</div>
            <div class="summary-value">Rs {{ number_format($totalProfit, 2) }}</div>
            <div class="summary-change positive">
                <i class="ri-arrow-up-line"></i>
                From {{ $totalTransactions }} transactions
            </div>
        </div>
        
        <div class="summary-card revenue">
            <div class="summary-icon">
                <i class="ri-money-dollar-circle-fill"></i>
            </div>
            <div class="summary-label">Total Revenue</div>
            <div class="summary-value">Rs {{ number_format($totalRevenue, 2) }}</div>
            <div class="summary-change">
                <i class="ri-shopping-bag-3-line"></i>
                Total sales amount
            </div>
        </div>
        
        <div class="summary-card cost">
            <div class="summary-icon">
                <i class="ri-price-tag-3-fill"></i>
            </div>
            <div class="summary-label">Total Cost</div>
            <div class="summary-value">Rs {{ number_format($totalCost, 2) }}</div>
            <div class="summary-change">
                <i class="ri-box-3-line"></i>
                Product costs
            </div>
        </div>
        
        <div class="summary-card {{ $profitMargin >= 30 ? 'profit' : ($profitMargin >= 15 ? 'revenue' : 'loss') }}">
            <div class="summary-icon">
                <i class="ri-percent-line"></i>
            </div>
            <div class="summary-label">Profit Margin</div>
            <div class="summary-value">{{ number_format($profitMargin, 1) }}%</div>
            <div class="summary-change {{ $profitMargin >= 20 ? 'positive' : 'negative' }}">
                <i class="ri-{{ $profitMargin >= 20 ? 'arrow-up' : 'arrow-down' }}-line"></i>
                {{ $profitMargin >= 20 ? 'Good' : 'Needs Improvement' }} margin
            </div>
        </div>
    </div>
    
    <!-- Transactions Table -->
    <div class="transactions-section">
        <div class="section-header">
            <h2>
                <i class="ri-file-list-3-line" style="color: #667eea;"></i>
                Transaction Details
            </h2>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterTransactions('all')">All</button>
                <button class="filter-btn" onclick="filterTransactions('profit')">Profitable</button>
                <button class="filter-btn" onclick="filterTransactions('loss')">Loss</button>
            </div>
        </div>
        
        @if($transactions->count() > 0)
        <table class="transactions-table">
            <thead>
                <tr>
                    <th>Order Details</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Cost vs Selling</th>
                    <th>Profit/Loss</th>
                    <th>Margin</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="transactionsBody">
                @foreach($transactions as $transaction)
                <tr class="transaction-row" data-type="{{ $transaction->profit >= 0 ? 'profit' : 'loss' }}">
                    <td>
                        <span class="order-badge">{{ $transaction->order_number }}</span>
                    </td>
                    <td>
                        <div class="product-details">{{ $transaction->customer_name }}</div>
                        <div class="product-sku">{{ $transaction->customer_email }}</div>
                    </td>
                    <td>
                        <div class="product-details">{{ $transaction->product_name }}</div>
                        <div class="product-sku">SKU: {{ $transaction->product_sku ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <div class="price-breakdown">
                            <div class="price-item">
                                <span class="price-label">Cost:</span>
                                <span class="price-value">Rs {{ number_format($transaction->cost_price, 2) }}</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">Selling:</span>
                                <span class="price-value">Rs {{ number_format($transaction->selling_price, 2) }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="profit-badge {{ $transaction->profit >= 0 ? 'positive' : 'negative' }}">
                            <i class="ri-{{ $transaction->profit >= 0 ? 'arrow-up' : 'arrow-down' }}-line"></i>
                            Rs {{ number_format(abs($transaction->profit), 2) }}
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: {{ $transaction->margin >= 20 ? '#10b981' : ($transaction->margin >= 10 ? '#f59e0b' : '#ef4444') }};">
                            {{ number_format($transaction->margin, 1) }}%
                        </div>
                    </td>
                    <td>
                        <div class="date-badge">
                            <i class="ri-calendar-line"></i>
                            {{ \Carbon\Carbon::parse($transaction->order_date)->format('d M Y') }}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="ri-line-chart-line"></i>
            <h3>No Transaction Data</h3>
            <p>Create some orders to see profit and loss analysis</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterTransactions(type) {
    const rows = document.querySelectorAll('.transaction-row');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter rows
    rows.forEach(row => {
        if (type === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.type === type ? '' : 'none';
        }
    });
}
</script>
@endpush
