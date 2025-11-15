<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $customers = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('is_active', true)->get();
        return view('customers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'tax_id' => 'nullable|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'required|integer|min:0',
            'assigned_user_id' => 'nullable|exists:users,id',
            'lead_source' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);
        
        // Generate customer code
        $validated['customer_code'] = 'CUS-' . str_pad(Customer::max('id') + 1, 6, '0', STR_PAD_LEFT);
        
        $customer = Customer::create($validated);
        
        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load(['invoices', 'salesOrders', 'customerContacts', 'loyaltyPoints']);
        
        // Calculate customer statistics
        $stats = [
            'total_invoices' => $customer->invoices()->count(),
            'total_spent' => $customer->invoices()->where('status', 'paid')->sum('total'),
            'outstanding' => $customer->outstanding_balance,
            'total_orders' => $customer->salesOrders()->count(),
            'loyalty_points' => $customer->loyaltyPoints()->where('type', 'earned')->sum('points') 
                              - $customer->loyaltyPoints()->where('type', 'redeemed')->sum('points'),
        ];
        
        return view('customers.show', compact('customer', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $users = User::where('is_active', true)->get();
        return view('customers.edit', compact('customer', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'tax_id' => 'nullable|string|max:100',
            'credit_limit' => 'nullable|numeric|min:0',
            'payment_terms_days' => 'required|integer|min:0',
            'assigned_user_id' => 'nullable|exists:users,id',
            'lead_source' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $customer->update($validated);
        
        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        
        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
