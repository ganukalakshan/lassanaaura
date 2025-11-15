@extends('layouts.app')

@section('title', 'Add New Customer - Business Management System')
@section('page-title', 'Add New Customer')

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
                    <i class="fas fa-user-plus"></i>
                    Add New Customer
                </h2>
                <p class="page-header-subtitle">Fill in the customer information below</p>
            </div>
        </div>
    </div>

    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-grid">
            <!-- Basic Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="customer_type" class="form-label required">Customer Type</label>
                            <select name="type" id="customer_type" class="form-control @error('type') is-invalid @enderror" required onchange="toggleBusinessFields()">
                                <option value="">Select Type</option>
                                <option value="individual" {{ old('type') === 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="business" {{ old('type') === 'business' ? 'selected' : '' }}>Business</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="status" class="form-label required">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name" class="form-label required">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="John Doe" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6" id="company_name_group" style="display: none;">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                                   value="{{ old('company_name') }}" placeholder="ABC Corporation">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email" class="form-label required">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" placeholder="john@example.com" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="phone" class="form-label required">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-icon">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" placeholder="+1 234 567 8900" required>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row" id="business_fields" style="display: none;">
                        <div class="form-group col-md-6">
                            <label for="tax_number" class="form-label">Tax Number / VAT</label>
                            <input type="text" name="tax_number" id="tax_number" class="form-control @error('tax_number') is-invalid @enderror" 
                                   value="{{ old('tax_number') }}" placeholder="VAT123456789">
                            @error('tax_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" name="website" id="website" class="form-control @error('website') is-invalid @enderror" 
                                   value="{{ old('website') }}" placeholder="https://example.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Address Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="address_line1" class="form-label required">Address Line 1</label>
                        <input type="text" name="address_line1" id="address_line1" class="form-control @error('address_line1') is-invalid @enderror" 
                               value="{{ old('address_line1') }}" placeholder="123 Main Street" required>
                        @error('address_line1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address_line2" class="form-label">Address Line 2</label>
                        <input type="text" name="address_line2" id="address_line2" class="form-control @error('address_line2') is-invalid @enderror" 
                               value="{{ old('address_line2') }}" placeholder="Apartment, suite, etc. (optional)">
                        @error('address_line2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city" class="form-label required">City</label>
                            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" 
                                   value="{{ old('city') }}" placeholder="New York" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="state" class="form-label">State / Province</label>
                            <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror" 
                                   value="{{ old('state') }}" placeholder="NY">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="postal_code" class="form-label required">Postal / ZIP Code</label>
                            <input type="text" name="postal_code" id="postal_code" class="form-control @error('postal_code') is-invalid @enderror" 
                                   value="{{ old('postal_code') }}" placeholder="10001" required>
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="country" class="form-label required">Country</label>
                            <select name="country" id="country" class="form-control @error('country') is-invalid @enderror" required>
                                <option value="">Select Country</option>
                                <option value="US" {{ old('country') === 'US' ? 'selected' : '' }}>United States</option>
                                <option value="UK" {{ old('country') === 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="CA" {{ old('country') === 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="AU" {{ old('country') === 'AU' ? 'selected' : '' }}>Australia</option>
                                <option value="IN" {{ old('country') === 'IN' ? 'selected' : '' }}>India</option>
                            </select>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment & Billing Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-credit-card"></i>
                        Payment & Billing Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="payment_terms" class="form-label">Payment Terms (Days)</label>
                            <select name="payment_terms" id="payment_terms" class="form-control @error('payment_terms') is-invalid @enderror">
                                <option value="0" {{ old('payment_terms', '0') === '0' ? 'selected' : '' }}>Due on Receipt</option>
                                <option value="15" {{ old('payment_terms') === '15' ? 'selected' : '' }}>Net 15</option>
                                <option value="30" {{ old('payment_terms') === '30' ? 'selected' : '' }}>Net 30</option>
                                <option value="45" {{ old('payment_terms') === '45' ? 'selected' : '' }}>Net 45</option>
                                <option value="60" {{ old('payment_terms') === '60' ? 'selected' : '' }}>Net 60</option>
                            </select>
                            @error('payment_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="credit_limit" class="form-label">Credit Limit</label>
                            <div class="input-group">
                                <span class="input-group-icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <input type="number" name="credit_limit" id="credit_limit" class="form-control @error('credit_limit') is-invalid @enderror" 
                                       value="{{ old('credit_limit', '0') }}" placeholder="0.00" step="0.01" min="0">
                            </div>
                            @error('credit_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="discount_percentage" class="form-label">Default Discount (%)</label>
                            <div class="input-group">
                                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control @error('discount_percentage') is-invalid @enderror" 
                                       value="{{ old('discount_percentage', '0') }}" placeholder="0" step="0.01" min="0" max="100">
                                <span class="input-group-icon">
                                    <i class="fas fa-percent"></i>
                                </span>
                            </div>
                            @error('discount_percentage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="currency" class="form-label">Preferred Currency</label>
                            <select name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror">
                                <option value="USD" {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard"></i>
                        Additional Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                  rows="4" placeholder="Add any additional notes about this customer...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Communication Preferences</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="email_notifications" value="1" {{ old('email_notifications') ? 'checked' : '' }}>
                                <span>Email Notifications</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="sms_notifications" value="1" {{ old('sms_notifications') ? 'checked' : '' }}>
                                <span>SMS Notifications</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="marketing_emails" value="1" {{ old('marketing_emails') ? 'checked' : '' }}>
                                <span>Marketing Emails</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i>
                Save Customer
            </button>
            <button type="reset" class="btn btn-secondary btn-lg">
                <i class="fas fa-undo"></i>
                Reset Form
            </button>
            <a href="{{ route('customers.index') }}" class="btn btn-light btn-lg">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

@push('styles')
<style>
    .form-grid {
        display: grid;
        gap: 1.5rem;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .input-group {
        display: flex;
        align-items: center;
    }
    
    .input-group-icon {
        padding: 0.5rem 0.75rem;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-right: none;
        border-radius: 0.375rem 0 0 0.375rem;
        color: #6c757d;
    }
    
    .input-group input {
        border-left: none;
        border-radius: 0 0.375rem 0.375rem 0;
    }
    
    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-start;
        padding: 1.5rem 0;
        border-top: 2px solid #e9ecef;
        margin-top: 2rem;
    }
    
    .form-label.required::after {
        content: ' *';
        color: #dc3545;
    }
    
    .btn-back {
        margin-bottom: 1rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleBusinessFields() {
        const type = document.getElementById('customer_type').value;
        const companyNameGroup = document.getElementById('company_name_group');
        const businessFields = document.getElementById('business_fields');
        
        if (type === 'business') {
            companyNameGroup.style.display = 'block';
            businessFields.style.display = 'flex';
        } else {
            companyNameGroup.style.display = 'none';
            businessFields.style.display = 'none';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleBusinessFields();
    });
</script>
@endpush
@endsection
