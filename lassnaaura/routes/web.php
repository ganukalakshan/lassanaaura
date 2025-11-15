<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SalesQuoteController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/kpis', [DashboardController::class, 'getKPIs'])->name('dashboard.kpis');
    Route::get('/dashboard/recent-invoices', [DashboardController::class, 'getRecentInvoices'])->name('dashboard.recent-invoices');
    Route::get('/dashboard/low-stock', [DashboardController::class, 'getLowStockProducts'])->name('dashboard.low-stock');
    Route::get('/dashboard/sales-chart', [DashboardController::class, 'getSalesChartData'])->name('dashboard.sales-chart');
    
    // Customer Management
    Route::resource('customers', CustomerController::class);
    
    // Product Management
    Route::resource('products', ProductController::class);
    
    // Invoice Management
    Route::resource('invoices', InvoiceController::class);
    
    // Sales Quotes
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::resource('quotes', SalesQuoteController::class);
        Route::resource('orders', SalesOrderController::class);
    });
    
    // Supplier Management
    Route::resource('suppliers', SupplierController::class);
    
    // Purchase Order Management
    Route::prefix('purchases')->name('purchases.')->group(function () {
        Route::resource('orders', PurchaseOrderController::class);
    });
    
    // Expense Management
    Route::resource('expenses', ExpenseController::class);
    
    // Payment Management
    Route::resource('payments', PaymentController::class);
    
    // Inventory Management
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/adjust', [InventoryController::class, 'adjustStock'])->name('adjust');
        Route::post('/adjust', [InventoryController::class, 'storeAdjustment'])->name('adjust.store');
        Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
        Route::get('/transfer', [InventoryController::class, 'transferStock'])->name('transfer');
        Route::post('/transfer', [InventoryController::class, 'storeTransfer'])->name('transfer.store');
    });
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('sales');
        Route::get('/purchases', [ReportController::class, 'purchaseReport'])->name('purchases');
        Route::get('/profit-loss', [ReportController::class, 'profitLossReport'])->name('profit-loss');
        Route::get('/inventory', [ReportController::class, 'inventoryReport'])->name('inventory');
        Route::get('/customers', [ReportController::class, 'customerReport'])->name('customers');
        Route::get('/cash-flow', [ReportController::class, 'cashFlowReport'])->name('cash-flow');
    });
});
