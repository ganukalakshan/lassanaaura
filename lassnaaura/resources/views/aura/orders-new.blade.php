@extends('layouts.aura')

@section('title', 'Create Order')
@section('page-title', 'Create New Order')

@push('styles')
<style>
    /* Modern Orders Module - Unique Design */
    .orders-workflow {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    /* Step Progress Indicator */
    .workflow-steps {
        display: flex;
        justify-content: center;
        margin-bottom: 40px;
        position: relative;
    }
    
    .workflow-steps::before {
        content: '';
        position: absolute;
        top: 30px;
        left: 20%;
        right: 20%;
        height: 3px;
        background: #e2e8f0;
        z-index: 0;
    }
    
    .step {
        flex: 1;
        max-width: 200px;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .step-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: white;
        border: 3px solid #e2e8f0;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: all 0.3s ease;
    }
    
    .step.active .step-circle {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    
    .step.completed .step-circle {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    .step-label {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }
    
    .step.active .step-label {
        color: #667eea;
    }
    
    /* Main Content Area */
    .order-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        animation: fadeIn 0.4s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Customer Selection Panel */
    .customer-panel {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .panel-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .search-box {
        position: relative;
        margin-bottom: 20px;
    }
    
    .search-box input {
        width: 100%;
        padding: 14px 45px 14px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
    }
    
    .search-box input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    
    .search-box i {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 18px;
    }
    
    .customer-list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .customer-card {
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .customer-card:hover {
        background: #f1f5f9;
        border-color: #667eea;
        transform: translateX(5px);
    }
    
    .customer-card.selected {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-color: #667eea;
    }
    
    .customer-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
    }
    
    .customer-info {
        font-size: 13px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        max-height: 600px;
        overflow-y: auto;
    }
    
    .product-item {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .product-item:hover {
        border-color: #667eea;
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
    }
    
    .product-item.selected {
        border-color: #10b981;
        background: #f0fdf4;
    }
    
    .product-image {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        margin: 0 auto 12px;
        overflow: hidden;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-image i {
        font-size: 36px;
        color: #94a3b8;
    }
    
    .product-name {
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
        margin-bottom: 8px;
    }
    
    .product-price {
        color: #667eea;
        font-weight: 700;
        font-size: 16px;
    }
    
    /* Order Summary Sidebar */
    .order-summary {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 20px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }
    
    .selected-customer {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
    .selected-customer h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .selected-customer p {
        font-size: 13px;
        opacity: 0.9;
    }
    
    .order-items {
        margin: 20px 0;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    
    .item-details {
        flex: 1;
    }
    
    .item-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }
    
    .item-price {
        font-size: 13px;
        color: #64748b;
    }
    
    .item-actions button {
        background: #ef4444;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
    }
    
    .payment-section {
        margin: 20px 0;
        padding: 20px 0;
        border-top: 2px solid #f1f5f9;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .payment-section h4 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
    }
    
    .payment-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .payment-option {
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-option:hover {
        border-color: #667eea;
    }
    
    .payment-option.selected {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }
    
    .payment-option i {
        font-size: 24px;
        margin-bottom: 6px;
        display: block;
    }
    
    .payment-option span {
        font-size: 13px;
        font-weight: 600;
    }
    
    .order-total {
        margin: 20px 0;
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 14px;
    }
    
    .total-row.grand-total {
        font-size: 20px;
        font-weight: 700;
        color: #667eea;
        border-top: 2px solid #e2e8f0;
        padding-top: 15px;
        margin-top: 10px;
    }
    
    .btn-complete {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-complete:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-complete:disabled {
        background: #94a3b8;
        cursor: not-allowed;
        transform: none;
    }
    
    .empty-message {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
    
    .empty-message i {
        font-size: 64px;
        margin-bottom: 20px;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="orders-workflow">
    <!-- Workflow Steps -->
    <div class="workflow-steps">
        <div class="step active" id="step1">
            <div class="step-circle"><i class="ri-user-3-line"></i></div>
            <div class="step-label">Select Customer</div>
        </div>
        <div class="step" id="step2">
            <div class="step-circle"><i class="ri-shopping-bag-3-line"></i></div>
            <div class="step-label">Add Products</div>
        </div>
        <div class="step" id="step3">
            <div class="step-circle"><i class="ri-money-dollar-circle-line"></i></div>
            <div class="step-label">Payment & Complete</div>
        </div>
    </div>
    
    <div class="order-content">
        <!-- Left Panel: Customer/Product Selection -->
        <div class="customer-panel">
            <!-- Customer Selection View -->
            <div id="customerView" style="display: block;">
                <div class="panel-header">
                    <h2>
                        <i class="ri-user-search-line" style="color: #667eea;"></i>
                        Select Customer
                    </h2>
                </div>
                
                <div class="search-box">
                    <input type="text" id="customerSearch" placeholder="Search customer by name, email, or phone..." autocomplete="off">
                    <i class="ri-search-line"></i>
                </div>
                
                <div class="customer-list" id="customerList">
                    @foreach($customers as $customer)
                    <div class="customer-card" onclick="selectCustomer({{ $customer->id }}, '{{ $customer->name }}', '{{ $customer->email }}', '{{ $customer->phone }}')">
                        <div class="customer-name">{{ $customer->name }}</div>
                        <div class="customer-info">
                            <i class="ri-mail-line"></i> {{ $customer->email }}
                        </div>
                        <div class="customer-info">
                            <i class="ri-phone-line"></i> {{ $customer->phone ?? 'N/A' }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Product Selection View -->
            <div id="productView" style="display: none;">
                <div class="panel-header">
                    <h2>
                        <i class="ri-shopping-bag-3-line" style="color: #667eea;"></i>
                        Select Products
                    </h2>
                    <button class="btn-back" onclick="backToCustomer()" style="background: #e2e8f0; color: #64748b; padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer;">
                        <i class="ri-arrow-left-line"></i> Back
                    </button>
                </div>
                
                <div class="product-grid">
                    @foreach($products as $product)
                    <div class="product-item" onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->cost_price }}, {{ $product->selling_price }}, '{{ $product->image_url }}')">
                        <div class="product-image">
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                            @else
                                <i class="ri-image-line"></i>
                            @endif
                        </div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">Rs {{ number_format($product->selling_price, 2) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Right Sidebar: Order Summary -->
        <div class="order-summary">
            <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
                <i class="ri-file-list-3-line" style="color: #667eea;"></i> Order Summary
            </h2>
            
            <div id="noCustomerMessage">
                <div class="empty-message">
                    <i class="ri-user-add-line"></i>
                    <p>Please select a customer<br>to start creating an order</p>
                </div>
            </div>
            
            <div id="orderSummaryContent" style="display: none;">
                <div class="selected-customer" id="customerInfo"></div>
                
                <h4 style="font-size: 14px; font-weight: 600; margin-bottom: 12px;">Order Items</h4>
                <div class="order-items" id="orderItems">
                    <div class="empty-message">
                        <i class="ri-shopping-bag-line"></i>
                        <p>No products added yet</p>
                    </div>
                </div>
                
                <div class="payment-section">
                    <h4>Payment Method</h4>
                    <div class="payment-options">
                        <div class="payment-option selected" onclick="selectPayment('cash')">
                            <i class="ri-money-dollar-circle-line"></i>
                            <span>Cash</span>
                        </div>
                        <div class="payment-option" onclick="selectPayment('bank_transfer')">
                            <i class="ri-bank-card-line"></i>
                            <span>Bank Transfer</span>
                        </div>
                    </div>
                </div>
                
                <div class="order-total">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">Rs 0.00</span>
                    </div>
                    <div class="total-row">
                        <span>Total Discount:</span>
                        <span id="totalDiscount" style="color: #10b981;">Rs 0.00</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Grand Total:</span>
                        <span id="grandTotal">Rs 0.00</span>
                    </div>
                </div>
                
                <button class="btn-complete" onclick="completeOrder()" id="completeBtn" disabled>
                    <i class="ri-check-double-line"></i> Complete Order
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Product Details Modal -->
<div id="productModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 35px; max-width: 550px; width: 90%;">
        <h3 style="font-size: 22px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <i class="ri-price-tag-3-line" style="color: #667eea;"></i>
            Product Details
        </h3>
        
        <!-- Product Image -->
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 120px; height: 120px; margin: 0 auto; border-radius: 12px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <img id="modalProductImage" src="" alt="Product" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                <i id="modalProductImagePlaceholder" class="ri-image-line" style="font-size: 48px; color: #94a3b8;"></i>
            </div>
        </div>
        
        <div style="background: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
            <div style="font-size: 13px; color: #64748b; margin-bottom: 6px;">Product Name</div>
            <div style="font-weight: 600; font-size: 16px;" id="modalProductName"></div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Cost Price (Fixed)</label>
                <input type="text" id="modalCostPrice" readonly style="width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 10px; background: #f1f5f9;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; color: #64748b; margin-bottom: 8px;">Selling Price</label>
                <input type="number" id="modalSellingPrice" step="0.01" style="width: 100%; padding: 12px; border: 2px solid #667eea; border-radius: 10px;" oninput="calculateDiscount()">
            </div>
        </div>
        
        <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%); padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 14px; font-weight: 600;">Customer Discount:</span>
                <span id="modalDiscount" style="font-size: 18px; font-weight: 700; color: #10b981;">Rs 0.00</span>
            </div>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button onclick="closeModal()" style="flex: 1; padding: 14px; background: #e2e8f0; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">Cancel</button>
            <button onclick="confirmProduct()" style="flex: 1; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">Add to Order</button>
        </div>
    </div>
</div>

<form id="orderForm" method="POST" action="{{ route('aura.orders.store') }}" style="display: none;">
    @csrf
    <input type="hidden" name="customer_id" id="formCustomerId">
    <input type="hidden" name="payment_method" id="formPaymentMethod" value="cash">
    <input type="hidden" name="status" id="formStatus" value="confirmed">
    <input type="hidden" name="products" id="formProducts">
</form>

@endsection

@push('scripts')
<script>
let selectedCustomerId = null;
let selectedCustomerName = '';
let selectedCustomerEmail = '';
let selectedCustomerPhone = '';
let selectedPaymentMethod = 'cash';
let orderItems = [];
let currentProduct = null;

// Customer Search
document.getElementById('customerSearch').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const customers = document.querySelectorAll('.customer-card');
    customers.forEach(customer => {
        const text = customer.textContent.toLowerCase();
        customer.style.display = text.includes(search) ? 'block' : 'none';
    });
});

function selectCustomer(id, name, email, phone) {
    selectedCustomerId = id;
    selectedCustomerName = name;
    selectedCustomerEmail = email;
    selectedCustomerPhone = phone;
    
    // Update UI
    document.getElementById('customerView').style.display = 'none';
    document.getElementById('productView').style.display = 'block';
    document.getElementById('noCustomerMessage').style.display = 'none';
    document.getElementById('orderSummaryContent').style.display = 'block';
    
    document.getElementById('customerInfo').innerHTML = `
        <h3>${name}</h3>
        <p><i class="ri-mail-line"></i> ${email}</p>
        <p><i class="ri-phone-line"></i> ${phone || 'N/A'}</p>
    `;
    
    // Update steps
    document.getElementById('step1').classList.add('completed');
    document.getElementById('step2').classList.add('active');
}

function backToCustomer() {
    document.getElementById('customerView').style.display = 'block';
    document.getElementById('productView').style.display = 'none';
    document.getElementById('step2').classList.remove('active');
}

function addProduct(id, name, costPrice, sellingPrice, imageUrl) {
    currentProduct = { id, name, costPrice, sellingPrice, imageUrl, originalSellingPrice: sellingPrice };
    
    document.getElementById('modalProductName').textContent = name;
    document.getElementById('modalCostPrice').value = 'Rs ' + parseFloat(costPrice).toFixed(2);
    document.getElementById('modalSellingPrice').value = sellingPrice;
    
    // Display product image
    const modalImage = document.getElementById('modalProductImage');
    const modalPlaceholder = document.getElementById('modalProductImagePlaceholder');
    
    if (imageUrl && imageUrl !== '') {
        modalImage.src = imageUrl;
        modalImage.style.display = 'block';
        modalPlaceholder.style.display = 'none';
    } else {
        modalImage.style.display = 'none';
        modalPlaceholder.style.display = 'block';
    }
    
    document.getElementById('productModal').style.display = 'flex';
    
    calculateDiscount();
}

function calculateDiscount() {
    if (!currentProduct) return;
    
    const newPrice = parseFloat(document.getElementById('modalSellingPrice').value) || 0;
    const discount = currentProduct.originalSellingPrice - newPrice;
    
    document.getElementById('modalDiscount').textContent = discount >= 0 ? 
        `Rs ${discount.toFixed(2)} OFF` : 
        `Rs ${Math.abs(discount).toFixed(2)} Extra`;
    
    document.getElementById('modalDiscount').style.color = discount >= 0 ? '#10b981' : '#ef4444';
}

function confirmProduct() {
    const newPrice = parseFloat(document.getElementById('modalSellingPrice').value) || 0;
    const discount = currentProduct.originalSellingPrice - newPrice;
    
    orderItems.push({
        product_id: currentProduct.id,
        name: currentProduct.name,
        cost_price: currentProduct.costPrice,
        selling_price: newPrice,
        original_price: currentProduct.originalSellingPrice,
        discount: discount,
        imageUrl: currentProduct.imageUrl
    });
    
    closeModal();
    updateOrderSummary();
    
    document.getElementById('step2').classList.add('completed');
    document.getElementById('step3').classList.add('active');
}

function closeModal() {
    document.getElementById('productModal').style.display = 'none';
    currentProduct = null;
}

function updateOrderSummary() {
    const itemsDiv = document.getElementById('orderItems');
    
    if (orderItems.length === 0) {
        itemsDiv.innerHTML = '<div class="empty-message"><i class="ri-shopping-bag-line"></i><p>No products added yet</p></div>';
        document.getElementById('completeBtn').disabled = true;
        return;
    }
    
    let html = '';
    let subtotal = 0;
    let totalDiscount = 0;
    
    orderItems.forEach((item, index) => {
        subtotal += item.selling_price;
        totalDiscount += item.discount;
        
        const imageHtml = item.imageUrl && item.imageUrl !== '' 
            ? `<img src="${item.imageUrl}" alt="${item.name}" style="width: 100%; height: 100%; object-fit: cover;">`
            : `<i class="ri-image-line" style="font-size: 20px; color: #94a3b8;"></i>`;
        
        html += `
            <div class="order-item">
                <div style="width: 45px; height: 45px; border-radius: 8px; overflow: hidden; background: #f1f5f9; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    ${imageHtml}
                </div>
                <div class="item-details" style="flex: 1;">
                    <div class="item-name">${item.name}</div>
                    <div class="item-price">Rs ${item.selling_price.toFixed(2)}</div>
                    ${item.discount > 0 ? `<div style="font-size: 12px; color: #10b981;">Discount: Rs ${item.discount.toFixed(2)}</div>` : ''}
                </div>
                <div class="item-actions">
                    <button onclick="removeItem(${index})"><i class="ri-delete-bin-line"></i></button>
                </div>
            </div>
        `;
    });
    
    itemsDiv.innerHTML = html;
    document.getElementById('subtotal').textContent = `Rs ${subtotal.toFixed(2)}`;
    document.getElementById('totalDiscount').textContent = `Rs ${totalDiscount.toFixed(2)}`;
    document.getElementById('grandTotal').textContent = `Rs ${subtotal.toFixed(2)}`;
    document.getElementById('completeBtn').disabled = false;
}

function removeItem(index) {
    orderItems.splice(index, 1);
    updateOrderSummary();
}

function selectPayment(method) {
    selectedPaymentMethod = method;
    document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
    event.target.closest('.payment-option').classList.add('selected');
}

function completeOrder() {
    if (!selectedCustomerId || orderItems.length === 0) {
        alert('Please select a customer and add products');
        return;
    }
    
    document.getElementById('formCustomerId').value = selectedCustomerId;
    document.getElementById('formPaymentMethod').value = selectedPaymentMethod;
    document.getElementById('formProducts').value = JSON.stringify(orderItems);
    document.getElementById('orderForm').submit();
}

// Close modal on outside click
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endpush
