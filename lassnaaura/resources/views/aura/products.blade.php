@extends('layouts.aura')

@section('title', 'Product Details')
@section('page-title', 'Product Management')

@push('styles')
<style>
    /* Product Details Unique Layout - Form-Driven with Table */
    .product-container {
        display: grid;
        grid-template-columns: 400px 1fr;
        gap: 30px;
        animation: slideIn 0.4s ease;
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    /* Left Panel - Form Section */
    .product-form-panel {
        background: white;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    
    .form-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .form-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-header p {
        color: #64748b;
        font-size: 14px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    
    .btn-primary {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    
    /* Right Panel - Product List */
    .product-list-panel {
        background: white;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .list-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .product-count {
        background: #667eea;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .product-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    
    .product-table thead th {
        background: #f8fafc;
        padding: 15px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }
    
    .product-table thead th:first-child {
        border-radius: 10px 0 0 10px;
    }
    
    .product-table thead th:last-child {
        border-radius: 0 10px 10px 0;
    }
    
    .product-table tbody tr {
        background: #fafbfc;
        transition: all 0.2s ease;
    }
    
    .product-table tbody tr:hover {
        background: #f1f5f9;
        transform: scale(1.01);
    }
    
    .product-table tbody td {
        padding: 18px 15px;
        border: none;
        font-size: 14px;
    }
    
    .product-table tbody td:first-child {
        border-radius: 10px 0 0 10px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .product-table tbody td:last-child {
        border-radius: 0 10px 10px 0;
    }
    
    .price-cell {
        color: #059669;
        font-weight: 600;
    }
    
    .discount-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .quantity-cell {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .quantity-bar {
        flex: 1;
        height: 6px;
        background: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
    }
    
    .quantity-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transition: width 0.3s ease;
    }
    
    .edit-btn {
        padding: 8px 16px;
        background: #f1f5f9;
        color: #667eea;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .edit-btn:hover {
        background: #667eea;
        color: white;
    }
    
    .empty-products {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
    
    .empty-products i {
        font-size: 64px;
        margin-bottom: 15px;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="product-container">
    <!-- Left Panel: Add/Edit Form -->
    <div class="product-form-panel">
        <div class="form-header">
            <h2>
                <i class="ri-add-circle-line" style="color: #667eea;"></i>
                Add New Product
            </h2>
            <p>Fill in the details below</p>
        </div>
        
        <form action="{{ route('aura.products.store') }}" method="POST" id="productForm">
            @csrf
            <input type="hidden" name="_method" value="POST" id="formMethod">
            <input type="hidden" name="product_id" id="productId">
            
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-input" placeholder="Enter product name" required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Cost Price</label>
                    <input type="number" name="cost_price" class="form-input" placeholder="0.00" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Selling Price</label>
                    <input type="number" name="selling_price" class="form-input" placeholder="0.00" step="0.01" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Discount (%)</label>
                    <input type="number" name="discount" class="form-input" placeholder="0" min="0" max="100">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-input" placeholder="0" min="0" required>
                </div>
            </div>
            
            <button type="submit" class="btn-primary">
                <i class="ri-save-line"></i>
                <span id="btnText">Save Product</span>
            </button>
        </form>
    </div>
    
    <!-- Right Panel: Product List -->
    <div class="product-list-panel">
        <div class="list-header">
            <h2>
                <i class="ri-list-check" style="color: #667eea;"></i>
                All Products
            </h2>
            <span class="product-count">{{ $products->count() }} Products</span>
        </div>
        
        @if($products->count() > 0)
        <table class="product-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Cost</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>${{ number_format($product->cost_price, 2) }}</td>
                    <td class="price-cell">${{ number_format($product->selling_price, 2) }}</td>
                    <td>
                        @if($product->discount > 0)
                            <span class="discount-badge">{{ $product->discount }}% OFF</span>
                        @else
                            <span style="color: #94a3b8;">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="quantity-cell">
                            <span style="font-weight: 600; min-width: 30px;">{{ $product->stock->sum('quantity_on_hand') ?? 0 }}</span>
                            <div class="quantity-bar">
                                <div class="quantity-fill" style="width: {{ min(($product->stock->sum('quantity_on_hand') ?? 0) * 2, 100) }}%;"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button class="edit-btn" onclick="editProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->cost_price }}, {{ $product->selling_price }}, {{ $product->discount }}, {{ $product->stock->sum('quantity_on_hand') ?? 0 }})">
                            <i class="ri-edit-line"></i> Edit
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-products">
            <i class="ri-inbox-line"></i>
            <p>No products yet. Add your first product using the form.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function editProduct(id, name, cost, price, discount, quantity) {
    document.querySelector('[name="name"]').value = name;
    document.querySelector('[name="cost_price"]').value = cost;
    document.querySelector('[name="selling_price"]').value = price;
    document.querySelector('[name="discount"]').value = discount;
    document.querySelector('[name="quantity"]').value = quantity;
    
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('productId').value = id;
    document.getElementById('productForm').action = `/aura/products/${id}/update`;
    document.getElementById('btnText').textContent = 'Update Product';
    document.querySelector('.form-header h2 i').className = 'ri-edit-line';
    document.querySelector('.form-header h2').innerHTML = '<i class="ri-edit-line" style="color: #667eea;"></i> Edit Product';
    
    // Scroll to form
    document.querySelector('.product-form-panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
@endpush
