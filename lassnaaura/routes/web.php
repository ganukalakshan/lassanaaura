<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InstallerController;

// Installer Routes
Route::get('/install', [InstallerController::class, 'index'])->name('installer.index');
Route::post('/install', [InstallerController::class, 'install'])->name('installer.install');

// Public Routes
Route::get('/', function () {
    // Check if installed
    if (!\Illuminate\Support\Facades\File::exists(storage_path('installed'))) {
        return redirect()->route('installer.index');
    }
    
    if (auth()->check()) {
        return redirect('/aura/dashboard');
    }
    return redirect('/login');
})->name('home');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {
    
    // Aura ERP Routes
    Route::get('/aura/dashboard', [DashboardController::class, 'auraDashboard'])->name('aura.dashboard');
    Route::get('/aura/products', [ProductController::class, 'auraProductDetails'])->name('aura.products');
    
    // Orders Routes
    Route::get('/aura/orders', [DashboardController::class, 'auraOrders'])->name('aura.orders');
    Route::post('/aura/orders', [DashboardController::class, 'auraStoreOrder'])->name('aura.orders.store');
    Route::get('/aura/orders/complete', [DashboardController::class, 'auraCompleteOrders'])->name('aura.orders.complete');
    Route::get('/aura/orders/pending', [DashboardController::class, 'auraPendingOrders'])->name('aura.orders.pending');
    Route::post('/aura/orders/{id}/complete', [DashboardController::class, 'markOrderComplete'])->name('aura.orders.mark.complete');
    
    // Profit Analysis Route
    Route::get('/aura/profit-analysis', [DashboardController::class, 'auraProfitAnalysis'])->name('aura.profit.analysis');
    
    Route::post('/aura/products/store', [ProductController::class, 'auraStore'])->name('aura.products.store');
    Route::put('/aura/products/{id}/update', [ProductController::class, 'auraUpdate'])->name('aura.products.update');
    Route::get('/aura/customers/add', [CustomerController::class, 'auraAddCustomer'])->name('aura.customers.add');
    Route::post('/aura/customers/store', [CustomerController::class, 'auraStoreCustomer'])->name('aura.customers.store');
    Route::get('/aura/orders', [DashboardController::class, 'auraOrders'])->name('aura.orders');
    Route::post('/aura/orders/store', [DashboardController::class, 'auraStoreOrder'])->name('aura.orders.store');
    Route::get('/aura/customers/search', [CustomerController::class, 'auraSearchCustomer'])->name('aura.customers.search');
    
});
