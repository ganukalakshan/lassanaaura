<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Bank;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'bank']);
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('date_from')) {
            $query->where('expense_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('expense_date', '<=', $request->date_to);
        }
        
        $expenses = $query->orderBy('expense_date', 'desc')->paginate(20);
        $categories = ExpenseCategory::where('is_active', true)->get();
        
        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('is_active', true)->get();
        $banks = Bank::where('is_active', true)->get();
        
        return view('expenses.create', compact('categories', 'banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,debit_card',
            'bank_id' => 'required_if:payment_method,bank_transfer,check|nullable|exists:banks,id',
            'reference_number' => 'nullable|string|max:64',
            'vendor_name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $validated['created_by'] = auth()->id();
        
        $expense = Expense::create($validated);
        
        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense recorded successfully!');
    }

    public function show(Expense $expense)
    {
        $expense->load(['category', 'bank', 'creator']);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::where('is_active', true)->get();
        $banks = Bank::where('is_active', true)->get();
        
        return view('expenses.edit', compact('expense', 'categories', 'banks'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,debit_card',
            'bank_id' => 'required_if:payment_method,bank_transfer,check|nullable|exists:banks,id',
            'reference_number' => 'nullable|string|max:64',
            'vendor_name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $expense->update($validated);
        
        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense updated successfully!');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        
        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully!');
    }
}
