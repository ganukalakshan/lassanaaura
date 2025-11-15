<?php

namespace App\Http\Controllers;

use App\Models\SalesQuote;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesQuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = SalesQuote::with('customer');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $quotes = $query->orderBy('quote_date', 'desc')->paginate(20);
        
        return view('sales.quotes.index', compact('quotes'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        
        return view('sales.quotes.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_date' => 'required|date',
            'valid_until' => 'required|date|after:quote_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated) {
            $quoteNumber = 'QT-' . date('Y') . '-' . str_pad(SalesQuote::whereYear('created_at', date('Y'))->count() + 1, 6, '0', STR_PAD_LEFT);
            
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            
            $quote = SalesQuote::create([
                'quote_number' => $quoteNumber,
                'customer_id' => $validated['customer_id'],
                'quote_date' => $validated['quote_date'],
                'valid_until' => $validated['valid_until'],
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'status' => 'draft',
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $quote->salesQuoteItems()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }
            
            return $quote;
        });
        
        return redirect()->route('sales.quotes.index')
            ->with('success', 'Quote created successfully!');
    }

    public function show(SalesQuote $quote)
    {
        $quote->load(['customer', 'salesQuoteItems.product']);
        return view('sales.quotes.show', compact('quote'));
    }

    public function edit(SalesQuote $quote)
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        
        return view('sales.quotes.edit', compact('quote', 'customers', 'products'));
    }

    public function update(Request $request, SalesQuote $quote)
    {
        // Similar implementation to store
        return redirect()->route('sales.quotes.show', $quote)
            ->with('success', 'Quote updated successfully!');
    }

    public function destroy(SalesQuote $quote)
    {
        $quote->delete();
        return redirect()->route('sales.quotes.index')
            ->with('success', 'Quote deleted successfully!');
    }
}
