@extends('layouts.app')

@section('title', 'Sales Quotes - Business Management System')
@section('page-title', 'Sales Quotes')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-file-alt"></i>
                    Sales Quotes
                </h2>
                <p class="page-header-subtitle">Create and manage sales quotations</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('sales.quotes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    New Quote
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $totalQuotes ?? 0 }}</h3>
                <p class="stat-card-label">Total Quotes</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $pendingQuotes ?? 0 }}</h3>
                <p class="stat-card-label">Pending Quotes</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">{{ $acceptedQuotes ?? 0 }}</h3>
                <p class="stat-card-label">Accepted</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-value">${{ number_format($totalValue ?? 0, 2) }}</h3>
                <p class="stat-card-label">Total Value</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-section">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search quotes...">
        </div>
        
        <div class="filter-controls">
            <select class="form-control">
                <option value="">All Status</option>
                <option value="draft">Draft</option>
                <option value="sent">Sent</option>
                <option value="accepted">Accepted</option>
                <option value="rejected">Rejected</option>
                <option value="expired">Expired</option>
            </select>
            
            <button class="btn btn-secondary" onclick="resetFilters()">
                <i class="fas fa-redo"></i>
                Reset
            </button>
        </div>
    </div>

    <!-- Quotes Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i>
                Quotes List
            </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Quote #</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Valid Until</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotes ?? [] as $quote)
                        <tr>
                            <td><strong class="text-primary">#{{ $quote->quote_number }}</strong></td>
                            <td>{{ $quote->customer->name }}</td>
                            <td>{{ $quote->quote_date->format('M d, Y') }}</td>
                            <td>{{ $quote->valid_until->format('M d, Y') }}</td>
                            <td><strong class="text-success">${{ number_format($quote->total, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $quote->status === 'accepted' ? 'success' : ($quote->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($quote->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('sales.quotes.show', $quote->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sales.quotes.edit', $quote->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                    <h4>No Quotes Found</h4>
                                    <a href="{{ route('sales.quotes.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        New Quote
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
@endsection
