@extends('layouts.aura')

@section('title', 'Add Customer')
@section('page-title', 'Customer Management')

@push('styles')
<style>
    /* Add Customer Unique Layout - Minimal Centered Form */
    .customer-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 200px);
        animation: zoomIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes zoomIn {
        from { 
            opacity: 0; 
            transform: scale(0.95);
        }
        to { 
            opacity: 1; 
            transform: scale(1);
        }
    }
    
    .customer-card {
        background: white;
        border-radius: 24px;
        padding: 50px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 550px;
        position: relative;
        overflow: hidden;
    }
    
    .customer-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    
    .customer-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .customer-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 40px;
        color: white;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }
    
    .customer-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    
    .customer-header p {
        color: #64748b;
        font-size: 15px;
    }
    
    .customer-form-group {
        margin-bottom: 24px;
    }
    
    .customer-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 10px;
    }
    
    .customer-label i {
        color: #667eea;
        font-size: 18px;
    }
    
    .customer-input {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 15px;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        background: #fafbfc;
    }
    
    .customer-input:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }
    
    .customer-textarea {
        min-height: 100px;
        resize: vertical;
        font-family: 'Inter', sans-serif;
    }
    
    .customer-btn {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 14px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }
    
    .customer-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(102, 126, 234, 0.4);
    }
    
    .customer-btn:active {
        transform: translateY(-1px);
    }
    
    .customer-btn i {
        font-size: 20px;
    }
    
    .input-hint {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .input-hint i {
        font-size: 14px;
    }
    
    .required-mark {
        color: #ef4444;
        margin-left: 4px;
    }
    
    .success-animation {
        animation: successPulse 0.6s ease;
    }
    
    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>
@endpush

@section('content')
<div class="customer-wrapper">
    <div class="customer-card">
        <div class="customer-header">
            <div class="customer-icon">
                <i class="ri-user-heart-line"></i>
            </div>
            <h1>Add New Customer</h1>
            <p>Build lasting relationships</p>
        </div>
        
        <form action="{{ route('aura.customers.store') }}" method="POST">
            @csrf
            
            <div class="customer-form-group">
                <label class="customer-label">
                    <i class="ri-user-line"></i>
                    <span>Customer Name<span class="required-mark">*</span></span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    class="customer-input" 
                    placeholder="Enter full name"
                    required
                    autocomplete="name"
                >
                <div class="input-hint">
                    <i class="ri-information-line"></i>
                    <span>Full legal or business name</span>
                </div>
            </div>
            
            <div class="customer-form-group">
                <label class="customer-label">
                    <i class="ri-phone-line"></i>
                    <span>Phone Number<span class="required-mark">*</span></span>
                </label>
                <input 
                    type="tel" 
                    name="phone" 
                    class="customer-input" 
                    placeholder="+1 (555) 000-0000"
                    required
                    autocomplete="tel"
                >
                <div class="input-hint">
                    <i class="ri-information-line"></i>
                    <span>Primary contact number</span>
                </div>
            </div>
            
            <div class="customer-form-group">
                <label class="customer-label">
                    <i class="ri-map-pin-line"></i>
                    <span>Address</span>
                </label>
                <input 
                    type="text" 
                    name="address" 
                    class="customer-input" 
                    placeholder="Street address, city, state"
                    autocomplete="street-address"
                >
                <div class="input-hint">
                    <i class="ri-information-line"></i>
                    <span>Optional - for delivery or billing</span>
                </div>
            </div>
            
            <div class="customer-form-group">
                <label class="customer-label">
                    <i class="ri-file-text-line"></i>
                    <span>Notes</span>
                </label>
                <textarea 
                    name="notes" 
                    class="customer-input customer-textarea" 
                    placeholder="Any additional information..."
                ></textarea>
                <div class="input-hint">
                    <i class="ri-information-line"></i>
                    <span>Optional - preferences, special instructions</span>
                </div>
            </div>
            
            <button type="submit" class="customer-btn">
                <i class="ri-user-add-line"></i>
                <span>Add Customer</span>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const btn = document.querySelector('.customer-btn');
    
    form.addEventListener('submit', function() {
        btn.innerHTML = '<i class="ri-loader-4-line" style="animation: spin 1s linear infinite;"></i><span>Adding Customer...</span>';
        btn.disabled = true;
    });
});

const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>
@endpush
