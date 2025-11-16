<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'taxRate']);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->orderBy('name')->paginate(20);
        $categories = ProductCategory::where('is_active', true)->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::where('is_active', true)->get();
        $taxRates = TaxRate::where('is_active', true)->get();
        return view('products.create', compact('categories', 'taxRates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:products,sku|max:64',
            'barcode' => 'nullable|string|unique:products,barcode|max:64',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:product_categories,id',
            'tax_id' => 'nullable|exists:tax_rates,id',
            'unit' => 'required|string|max:20',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'minimum_price' => 'nullable|numeric|min:0',
            'track_inventory' => 'boolean',
            'reorder_level' => 'integer|min:0',
            'reorder_quantity' => 'integer|min:0',
        ]);
        
        $product = Product::create($validated);
        
        // Redirect to products index and highlight the newly created product card/button
        return redirect()->route('products.index', ['highlight' => $product->id])
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'taxRate', 'productStock.warehouse', 'stockMovements']);
        
        $totalStock = $product->productStock->sum('quantity_on_hand');
        $availableStock = $product->productStock->sum('available_quantity');
        
        return view('products.show', compact('product', 'totalStock', 'availableStock'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::where('is_active', true)->get();
        $taxRates = TaxRate::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories', 'taxRates'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:64|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:64|unique:products,barcode,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:product_categories,id',
            'tax_id' => 'nullable|exists:tax_rates,id',
            'unit' => 'required|string|max:20',
            'cost_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'minimum_price' => 'nullable|numeric|min:0',
            'track_inventory' => 'boolean',
            'reorder_level' => 'integer|min:0',
            'reorder_quantity' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        $product->update($validated);
        
        return redirect()->route('products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
