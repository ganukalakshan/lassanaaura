@extends('layouts.aura')

@section('title', 'Dashboard')
@section('page-title', 'Product Overview')

@push('styles')
<style>
    /* Dashboard Unique Layout - Card Grid System */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 28px rgba(102, 126, 234, 0.25);
    }
    
    .product-image-wrapper {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-placeholder {
        font-size: 64px;
        color: rgba(102, 126, 234, 0.3);
    }
    
    .product-info {
        padding: 20px;
    }
    
    .product-name {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-quantity {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        background: #f1f5f9;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
    }
    
    .quantity-icon {
        color: #667eea;
        font-size: 18px;
    }
    
    .quantity-badge {
        color: #667eea;
        font-weight: 600;
    }
    
    .quantity-label {
        color: #64748b;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        grid-column: 1 / -1;
    }
    
    .empty-state i {
        font-size: 80px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }
    
    .empty-state h3 {
        font-size: 24px;
        color: #475569;
        margin-bottom: 10px;
    }
    
    .empty-state p {
        color: #94a3b8;
        font-size: 16px;
    }
    
    .dashboard-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px;
        border-radius: 20px;
        margin-bottom: 35px;
        color: white;
    }
    
    .dashboard-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .dashboard-header p {
        font-size: 16px;
        opacity: 0.9;
    }
    
    .stock-status {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }
    
    .stock-available {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }
    
    .stock-low {
        background: rgba(251, 146, 60, 0.9);
        color: white;
    }
    
    .stock-out {
        background: rgba(239, 68, 68, 0.9);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="dashboard-header">
    <h1>📦 Available Products</h1>
    <p>Quick overview of your product inventory</p>
</div>

@if($products->count() > 0)
<div class="dashboard-grid">
    @foreach($products as $product)
    <div class="product-card">
        <div class="product-image-wrapper">
            @if(!empty($product['image']) && $product['image'] !== '/images/default-product.png')
                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="product-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <i class="ri-box-3-line product-placeholder" style="display:none;"></i>
            @else
                <i class="ri-box-3-line product-placeholder"></i>
            @endif
            
            @if($product['quantity'] > 20)
                <div class="stock-status stock-available">In Stock</div>
            @elseif($product['quantity'] > 0)
                <div class="stock-status stock-low">Low Stock</div>
            @else
                <div class="stock-status stock-out">Out of Stock</div>
            @endif
        </div>
        
        <div class="product-info">
            <h3 class="product-name">{{ $product['name'] }}</h3>
            
            <div class="product-quantity">
                <i class="ri-stack-line quantity-icon"></i>
                <span class="quantity-badge">{{ $product['quantity'] }}</span>
                <span class="quantity-label">units available</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <i class="ri-inbox-line"></i>
    <h3>No Products Available</h3>
    <p>Start by adding products in the Product Details section</p>
</div>
@endif
@endsection
