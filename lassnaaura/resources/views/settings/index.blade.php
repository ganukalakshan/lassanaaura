@extends('layouts.app')

@section('title', 'System Settings - Business Management System')
@section('page-title', 'Settings')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <h2 class="page-header-title">
                    <i class="fas fa-cog"></i>
                    System Settings
                </h2>
                <p class="page-header-subtitle">Configure your business management system</p>
            </div>
        </div>
    </div>

    <div class="settings-layout">
        <!-- Settings Sidebar -->
        <div class="settings-sidebar">
            <nav class="settings-nav">
                <a href="#general" class="settings-nav-item active" data-target="general">
                    <i class="fas fa-building"></i>
                    General Settings
                </a>
                <a href="#company" class="settings-nav-item" data-target="company">
                    <i class="fas fa-briefcase"></i>
                    Company Info
                </a>
                <a href="#tax" class="settings-nav-item" data-target="tax">
                    <i class="fas fa-percentage"></i>
                    Tax Settings
                </a>
                <a href="#payment" class="settings-nav-item" data-target="payment">
                    <i class="fas fa-credit-card"></i>
                    Payment Methods
                </a>
                <a href="#email" class="settings-nav-item" data-target="email">
                    <i class="fas fa-envelope"></i>
                    Email Settings
                </a>
                <a href="#invoice" class="settings-nav-item" data-target="invoice">
                    <i class="fas fa-file-invoice"></i>
                    Invoice Settings
                </a>
                <a href="#notifications" class="settings-nav-item" data-target="notifications">
                    <i class="fas fa-bell"></i>
                    Notifications
                </a>
                <a href="#security" class="settings-nav-item" data-target="security">
                    <i class="fas fa-lock"></i>
                    Security
                </a>
                <a href="#backup" class="settings-nav-item" data-target="backup">
                    <i class="fas fa-database"></i>
                    Backup & Restore
                </a>
            </nav>
        </div>

        <!-- Settings Content -->
        <div class="settings-content">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- General Settings -->
                <div class="settings-section active" id="general">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">General Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Application Name</label>
                                <input type="text" name="app_name" class="form-control" value="{{ $settings->app_name ?? 'Business MS' }}">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Currency</label>
                                    <select name="currency" class="form-control">
                                        <option value="USD">USD - US Dollar</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="GBP">GBP - British Pound</option>
                                        <option value="INR">INR - Indian Rupee</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Timezone</label>
                                    <select name="timezone" class="form-control">
                                        <option value="UTC">UTC</option>
                                        <option value="America/New_York">Eastern Time</option>
                                        <option value="America/Chicago">Central Time</option>
                                        <option value="America/Los_Angeles">Pacific Time</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Date Format</label>
                                    <select name="date_format" class="form-control">
                                        <option value="Y-m-d">YYYY-MM-DD</option>
                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Time Format</label>
                                    <select name="time_format" class="form-control">
                                        <option value="H:i">24 Hour</option>
                                        <option value="h:i A">12 Hour</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Info -->
                <div class="settings-section" id="company">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Company Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Company Logo</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Recommended size: 200x200px</small>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="{{ $settings->company_name ?? '' }}">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Registration Number</label>
                                    <input type="text" name="registration_number" class="form-control" value="{{ $settings->registration_number ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="company_address" class="form-control" rows="3">{{ $settings->company_address ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Phone</label>
                                    <input type="text" name="company_phone" class="form-control" value="{{ $settings->company_phone ?? '' }}">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email" name="company_email" class="form-control" value="{{ $settings->company_email ?? '' }}">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Website</label>
                                    <input type="url" name="company_website" class="form-control" value="{{ $settings->company_website ?? '' }}">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Tax/VAT Number</label>
                                    <input type="text" name="tax_number" class="form-control" value="{{ $settings->tax_number ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tax Settings -->
                <div class="settings-section" id="tax">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tax Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="tax_enabled" value="1" {{ ($settings->tax_enabled ?? false) ? 'checked' : '' }}>
                                    <span>Enable Tax Calculation</span>
                                </label>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Default Tax Rate (%)</label>
                                    <input type="number" name="default_tax_rate" class="form-control" value="{{ $settings->default_tax_rate ?? 0 }}" step="0.01">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Tax Label</label>
                                    <input type="text" name="tax_label" class="form-control" value="{{ $settings->tax_label ?? 'VAT' }}" placeholder="e.g., VAT, GST, Sales Tax">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="tax_inclusive" value="1" {{ ($settings->tax_inclusive ?? false) ? 'checked' : '' }}>
                                    <span>Prices are Tax Inclusive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Settings -->
                <div class="settings-section" id="invoice">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Invoice Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Invoice Prefix</label>
                                    <input type="text" name="invoice_prefix" class="form-control" value="{{ $settings->invoice_prefix ?? 'INV' }}">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Invoice Start Number</label>
                                    <input type="number" name="invoice_start_number" class="form-control" value="{{ $settings->invoice_start_number ?? 1000 }}">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Payment Terms (Days)</label>
                                    <input type="number" name="default_payment_terms" class="form-control" value="{{ $settings->default_payment_terms ?? 30 }}">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Late Payment Fee (%)</label>
                                    <input type="number" name="late_payment_fee" class="form-control" value="{{ $settings->late_payment_fee ?? 0 }}" step="0.01">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Invoice Footer Text</label>
                                <textarea name="invoice_footer" class="form-control" rows="3">{{ $settings->invoice_footer ?? '' }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Invoice Terms & Conditions</label>
                                <textarea name="invoice_terms" class="form-control" rows="4">{{ $settings->invoice_terms ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="settings-section" id="notifications">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notification Settings</h3>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3">Email Notifications</h5>
                            <div class="notification-options">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="notify_new_order" value="1" checked>
                                    <span>New Order Received</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="notify_low_stock" value="1" checked>
                                    <span>Low Stock Alert</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="notify_invoice_due" value="1" checked>
                                    <span>Invoice Due Reminder</span>
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="notify_payment_received" value="1" checked>
                                    <span>Payment Received</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Backup & Restore -->
                <div class="settings-section" id="backup">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Backup & Restore</h3>
                        </div>
                        <div class="card-body">
                            <div class="backup-section">
                                <h5>Database Backup</h5>
                                <p class="text-muted">Create a backup of your database</p>
                                <button type="button" class="btn btn-primary" onclick="createBackup()">
                                    <i class="fas fa-download"></i>
                                    Create Backup
                                </button>
                            </div>
                            
                            <hr>
                            
                            <div class="backup-section">
                                <h5>Automatic Backups</h5>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="auto_backup_enabled" value="1">
                                    <span>Enable Automatic Daily Backups</span>
                                </label>
                            </div>
                            
                            <hr>
                            
                            <div class="backup-section">
                                <h5>Recent Backups</h5>
                                <div class="backup-list">
                                    @forelse($backups ?? [] as $backup)
                                    <div class="backup-item">
                                        <div>
                                            <i class="fas fa-database"></i>
                                            {{ $backup->filename }}
                                        </div>
                                        <div>
                                            <span class="text-muted">{{ $backup->created_at->diffForHumans() }}</span>
                                            <button class="btn btn-sm btn-secondary ml-2">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-muted">No backups available</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="settings-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i>
                        Save Settings
                    </button>
                    <button type="reset" class="btn btn-secondary btn-lg">
                        <i class="fas fa-undo"></i>
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .settings-layout {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
    }
    
    .settings-sidebar {
        position: sticky;
        top: 2rem;
        height: fit-content;
    }
    
    .settings-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #495057;
        text-decoration: none;
        border-radius: 0.375rem;
        transition: all 0.2s;
    }
    
    .settings-nav-item:hover {
        background: #f8f9fa;
        color: #667eea;
    }
    
    .settings-nav-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .settings-nav-item i {
        width: 20px;
    }
    
    .settings-section {
        display: none;
    }
    
    .settings-section.active {
        display: block;
        animation: fadeIn 0.3s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .settings-actions {
        display: flex;
        gap: 1rem;
        padding: 2rem 0;
        border-top: 2px solid #e9ecef;
        margin-top: 2rem;
    }
    
    .notification-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
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
    }
    
    .backup-section {
        padding: 1rem 0;
    }
    
    .backup-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .backup-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.375rem;
    }
    
    @media (max-width: 768px) {
        .settings-layout {
            grid-template-columns: 1fr;
        }
        
        .settings-sidebar {
            position: static;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.settings-nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active nav item
            document.querySelectorAll('.settings-nav-item').forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            
            // Show corresponding section
            const target = this.getAttribute('data-target');
            document.querySelectorAll('.settings-section').forEach(section => section.classList.remove('active'));
            document.getElementById(target).classList.add('active');
        });
    });
    
    function createBackup() {
        if (confirm('Create a database backup? This may take a few moments.')) {
            fetch('/settings/backup', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `backup-${new Date().toISOString()}.sql`;
                a.click();
            });
        }
    }
</script>
@endpush
@endsection
