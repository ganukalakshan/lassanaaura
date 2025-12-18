@extends('layouts.aura')

@section('title', 'Orders')
@section('page-title', 'Create Order')

@push('styles')
<style>
    /* Orders Unique Layout - POS Transaction Style */
    .orders-layout {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 25px;
        height: calc(100vh - 180px);
        animation: fadeInUp 0.4s ease;
    }
    
    @keyframes fadeInUp {
        from { 
            opacity: 0; 
            transform: translateY(30px);
        }
        to { 
            opacity: 1; 
            transform: translateY(0);
        }
    }
    
    /* Left Panel - Customer Selection */
    .customer-panel {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .customer-search-section {
        margin-bottom: 25px;
    }
    
    .search-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .search-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 16px 50px 16px 50px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 20px;
    }
    
    .selected-customer-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px;
        border-radius: 16px;
        color: white;
        margin-bottom: 25px;
    }
    
    .selected-customer-card h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .selected-customer-card p {
        opacity: 0.9;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }
    
    .product-selection-section {
        flex: 1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    
    .section-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 15px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .product-card-mini {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: center;
    }
    
    .product-card-mini:hover {
        border-color: #667eea;
        background: white;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
    }
    
    .product-card-mini.selected {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
    }
    
    .product-mini-icon {
        font-size: 36px;
        margin-bottom: 8px;
        opacity: 0.7;
    }
    
    .product-card-mini.selected .product-mini-icon {
        opacity: 1;
    }
    
    .product-mini-name {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        line-height: 1.3;
    }
    
    .product-mini-price {
        font-size: 15px;
        font-weight: 700;
        color: #059669;
    }
    
    .product-card-mini.selected .product-mini-price {
        color: white;
    }
    
    .product-mini-stock {
        font-size: 11px;
        margin-top: 4px;
        opacity: 0.7;
    }
    
    /* Right Panel - Order Cart */
    .order-cart-panel {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }
    
    .order-cart-panel::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .cart-header {
        margin-bottom: 20px;
    }
    
    .cart-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .cart-items {
        flex: 1;
        overflow-y: auto;
        margin-bottom: 20px;
        max-height: 300px;
    }
    
    .cart-item {
        background: #f8fafc;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .cart-item-info {
        flex: 1;
    }
    
    .cart-item-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .cart-item-price {
        font-size: 13px;
        color: #059669;
        font-weight: 600;
    }
    
    .cart-item-qty {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        padding: 6px 10px;
        border-radius: 8px;
    }
    
    .qty-btn {
        background: #667eea;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .qty-value {
        font-weight: 600;
        min-width: 24px;
        text-align: center;
    }
    
    .cart-summary {
        border-top: 2px solid #f1f5f9;
        padding-top: 20px;
        margin-bottom: 20px;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 15px;
    }
    
    .summary-row.total {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #e2e8f0;
    }
    
    .total-value {
        color: #667eea;
    }
    
    .checkout-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(16, 185, 129, 0.4);
    }
    
    .checkout-btn:disabled {
        background: #cbd5e1;
        cursor: not-allowed;
        transform: none;
    }
    
    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
    
    .empty-cart i {
        font-size: 64px;
        margin-bottom: 15px;
    }
    
    .empty-cart p {
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="orders-layout">
    <!-- Left Panel: Customer & Products -->
    <div class="customer-panel">
        <!-- Customer Search -->
        <div class="customer-search-section">
            <div class="search-header">
                <i class="ri-user-search-line" style="color: #667eea; font-size: 24px;"></i>
                <h3>Select Customer</h3>
            </div>
            <div class="search-box">
                <i class="ri-search-line search-icon"></i>
                <input 
                    type="text" 
                    class="search-input" 
                    id="customerSearch"
                    placeholder="Search by name, phone, or ID..."
                    autocomplete="off"
                >
            </div>
        </div>
        
        <!-- Selected Customer Display -->
        <div id="selectedCustomerCard" style="display: none;">
            <div class="selected-customer-card">
                <h4 id="customerName">—</h4>
                <p><i class="ri-phone-line"></i> <span id="customerPhone">—</span></p>
                <p><i class="ri-fingerprint-line"></i> ID: <span id="customerId">—</span></p>
            </div>
        </div>
        
        <!-- Product Selection -->
        <div class="product-selection-section">
            <div class="section-header">
                <h3>
                    <i class="ri-shopping-bag-3-line" style="color: #667eea;"></i>
                    Select Products
                </h3>
            </div>
            
            <div class="product-grid" id="productGrid">
                @foreach($products as $product)
                <div class="product-card-mini" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->selling_price }}" onclick="toggleProduct(this)">
                    <div class="product-mini-icon">📦</div>
                    <div class="product-mini-name">{{ $product->name }}</div>
                    <div class="product-mini-price">Rs {{ number_format($product->selling_price, 2) }}</div>
                    <div class="product-mini-stock">{{ $product->stocks->sum('quantity_on_hand') ?? 0 }} in stock</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <!-- Right Panel: Order Cart -->
    <div class="order-cart-panel">
        <div class="cart-header">
            <h3>
                <i class="ri-shopping-cart-line" style="color: #667eea;"></i>
                Order Cart
            </h3>
        </div>
        
        <div class="cart-items" id="cartItems">
            <div class="empty-cart">
                <i class="ri-shopping-basket-line"></i>
                <p>Cart is empty<br>Select products to add</p>
            </div>
        </div>
        
        <div class="cart-summary">
            <div class="summary-row">
                <span>Items:</span>
                <span id="itemCount">0</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span class="total-value" id="totalAmount">Rs 0.00</span>
            </div>
        </div>
        
        <button class="checkout-btn" id="checkoutBtn" disabled onclick="processOrder()">
            <i class="ri-check-double-line"></i>
            <span>Complete Order</span>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedCustomer = null;
let cartItems = [];

// Customer search
const customerSearch = document.getElementById('customerSearch');
customerSearch.addEventListener('input', debounce(searchCustomers, 300));

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

async function searchCustomers() {
    const search = customerSearch.value;
    if (search.length < 2) return;
    
    const response = await fetch(`/aura/customers/search?search=${encodeURIComponent(search)}`);
    const customers = await response.json();
    
    if (customers.length > 0) {
        selectCustomer(customers[0]);
    }
}

function selectCustomer(customer) {
    selectedCustomer = customer;
    document.getElementById('customerName').textContent = customer.name;
    document.getElementById('customerPhone').textContent = customer.phone || 'N/A';
    document.getElementById('customerId').textContent = customer.customer_code;
    document.getElementById('selectedCustomerCard').style.display = 'block';
    updateCheckoutButton();
}

function toggleProduct(element) {
    const id = element.dataset.id;
    const name = element.dataset.name;
    const price = parseFloat(element.dataset.price);
    
    const existingIndex = cartItems.findIndex(item => item.id == id);
    
    if (existingIndex >= 0) {
        cartItems.splice(existingIndex, 1);
        element.classList.remove('selected');
    } else {
        cartItems.push({ id, name, price, quantity: 1 });
        element.classList.add('selected');
    }
    
    updateCart();
}

function updateCart() {
    const cartContainer = document.getElementById('cartItems');
    
    if (cartItems.length === 0) {
        cartContainer.innerHTML = '<div class="empty-cart"><i class="ri-shopping-basket-line"></i><p>Cart is empty<br>Select products to add</p></div>';
    } else {
        cartContainer.innerHTML = cartItems.map((item, index) => `
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">Rs ${item.price.toFixed(2)} each</div>
                </div>
                <div class="cart-item-qty">
                    <button class="qty-btn" onclick="updateQuantity(${index}, -1)">−</button>
                    <span class="qty-value">${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
                </div>
            </div>
        `).join('');
    }
    
    const total = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    document.getElementById('itemCount').textContent = cartItems.length;
    document.getElementById('totalAmount').textContent = 'Rs ' + total.toFixed(2);
    
    updateCheckoutButton();
}

function updateQuantity(index, change) {
    cartItems[index].quantity += change;
    if (cartItems[index].quantity <= 0) {
        const productCard = document.querySelector(`[data-id="${cartItems[index].id}"]`);
        if (productCard) productCard.classList.remove('selected');
        cartItems.splice(index, 1);
    }
    updateCart();
}

function updateCheckoutButton() {
    const btn = document.getElementById('checkoutBtn');
    btn.disabled = !selectedCustomer || cartItems.length === 0;
}

async function processOrder() {
    const btn = document.getElementById('checkoutBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="ri-loader-4-line" style="animation: spin 1s linear infinite;"></i><span>Processing...</span>';
    
    try {
        const response = await fetch('/aura/orders/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                customer_id: selectedCustomer.id,
                products: cartItems.map(item => ({
                    id: item.id,
                    quantity: item.quantity
                }))
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Order created successfully!');
            location.reload();
        } else {
            alert('Error: ' + result.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="ri-check-double-line"></i><span>Complete Order</span>';
        }
    } catch (error) {
        alert('Error processing order');
        btn.disabled = false;
        btn.innerHTML = '<i class="ri-check-double-line"></i><span>Complete Order</span>';
    }
}
</script>
@endpush
