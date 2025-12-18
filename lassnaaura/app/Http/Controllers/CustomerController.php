<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Aura ERP Add Customer Page - Centered form
    public function auraAddCustomer()
    {
        return view('aura.customers');
    }
    
    // Aura ERP Store Customer
    public function auraStoreCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);
        
        $customer = Customer::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'customer_code' => 'CUST-' . strtoupper(uniqid()),
            'address' => $validated['address'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'is_active' => true
        ]);
        
        return redirect()->route('aura.customers.add')->with('success', 'Customer added successfully!');
    }
    
    // Aura ERP Search Customer (for orders page)
    public function auraSearchCustomer(Request $request)
    {
        $search = $request->get('search');
        
        $customers = Customer::where('is_active', true)
            ->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();
            
        return response()->json($customers);
    }
}
