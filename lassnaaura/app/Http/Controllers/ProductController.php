<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Aura ERP Product Details Page - Form + Table split view
    public function auraProductDetails()
    {
        $products = Product::with('stocks', 'category')->where('is_active', true)->get();
        $categories = ProductCategory::where('is_active', true)->get();
        
        return view('aura.products', compact('products', 'categories'));
    }
    
    // Aura ERP Store Product
    public function auraStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $imageUrl = '/images/products/' . $imageName;
        }
        
        $product = Product::create([
            'name' => $validated['name'],
            'sku' => 'SKU-' . strtoupper(uniqid()),
            'cost_price' => $validated['cost_price'],
            'selling_price' => $validated['selling_price'],
            'discount' => $validated['discount'] ?? 0,
            'category_id' => $validated['category_id'] ?? null,
            'image_url' => $imageUrl,
            'is_active' => true
        ]);
        
        // Create initial stock if quantity > 0
        if ($validated['quantity'] > 0) {
            // Get or create default warehouse
            $warehouse = \App\Models\Warehouse::firstOrCreate(
                ['name' => 'Main Warehouse'],
                [
                    'code' => 'WH-001',
                    'address' => 'Default Location',
                    'is_active' => true
                ]
            );
            
            ProductStock::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'quantity_on_hand' => $validated['quantity'],
                'quantity_allocated' => 0
            ]);
        }
        
        return redirect()->route('aura.products')->with('success', 'Product added successfully!');
    }
    
    // Aura ERP Update Product
    public function auraUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'quantity' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $updateData = [
            'name' => $validated['name'],
            'cost_price' => $validated['cost_price'],
            'selling_price' => $validated['selling_price'],
            'discount' => $validated['discount'] ?? 0,
            'category_id' => $validated['category_id'] ?? null
        ];
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $updateData['image_url'] = '/images/products/' . $imageName;
        }
        
        $product->update($updateData);
        
        // Update or create stock
        $warehouse = \App\Models\Warehouse::firstOrCreate(
            ['name' => 'Main Warehouse'],
            [
                'code' => 'WH-001',
                'address' => 'Default Location',
                'is_active' => true
            ]
        );
        
        $stock = ProductStock::where('product_id', $product->id)->first();
        if ($stock) {
            $stock->update(['quantity_on_hand' => $validated['quantity']]);
        } else {
            ProductStock::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'quantity_on_hand' => $validated['quantity'],
                'reserved_quantity' => 0
            ]);
        }
        
        return redirect()->route('aura.products')->with('success', 'Product updated successfully!');
    }
}
