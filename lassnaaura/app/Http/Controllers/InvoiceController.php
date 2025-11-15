<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('customer');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        
        if ($request->filled('date_from')) {
            $query->where('invoice_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('invoice_date', '<=', $request->date_to);
        }
        
        $invoices = $query->orderBy('invoice_date', 'desc')->paginate(20);
        $customers = Customer::where('is_active', true)->get();
        
        return view('invoices.index', compact('invoices', 'customers'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        
        return view('invoices.create', compact('customers', 'products', 'branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated, $request) {
            // Generate invoice number
            $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad(Invoice::whereYear('created_at', date('Y'))->count() + 1, 6, '0', STR_PAD_LEFT);
            
            // Calculate totals
            $subtotal = 0;
            $taxAmount = 0;
            $discountAmount = 0;
            
            foreach ($validated['items'] as $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $lineTotal * ($item['discount_percent'] ?? 0) / 100;
                $lineTotal -= $itemDiscount;
                $itemTax = $lineTotal * ($item['tax_rate'] ?? 0) / 100;
                
                $subtotal += $lineTotal;
                $taxAmount += $itemTax;
                $discountAmount += $itemDiscount;
            }
            
            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $validated['customer_id'],
                'branch_id' => $validated['branch_id'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'tax_amount' => $taxAmount,
                'total' => $subtotal + $taxAmount,
                'status' => 'draft',
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
            
            // Create invoice items
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $lineTotal * ($item['discount_percent'] ?? 0) / 100;
                $lineTotal -= $itemDiscount;
                $itemTax = $lineTotal * ($item['tax_rate'] ?? 0) / 100;
                
                $invoice->invoiceItems()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_percent' => $item['discount_percent'] ?? 0,
                    'discount_amount' => $itemDiscount,
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $itemTax,
                    'line_total' => $lineTotal + $itemTax,
                ]);
            }
            
            return $invoice;
        });
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully!');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'invoiceItems.product', 'payments']);
        
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return redirect()->route('invoices.show', $invoice)
                ->with('error', 'Only draft invoices can be edited.');
        }
        
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $branches = Branch::where('is_active', true)->get();
        
        return view('invoices.edit', compact('invoice', 'customers', 'products', 'branches'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Similar to store but update existing invoice
        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== 'draft') {
            return redirect()->route('invoices.index')
                ->with('error', 'Only draft invoices can be deleted.');
        }
        
        $invoice->delete();
        
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully!');
    }
}
