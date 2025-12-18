<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Aura ERP Dashboard - Show all products with quantity
    public function auraDashboard()
    {
        $products = Product::with('stock')->where('is_active', true)->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image_url ?? '/images/default-product.png',
                'quantity' => $product->stock->sum('quantity_on_hand') ?? 0
            ];
        });
        
        return view('aura.dashboard', compact('products'));
    }
    
    // Aura ERP Orders Page - POS style order creation
    public function auraOrders()
    {
        $products = Product::with('stock')->where('is_active', true)->get();
        $customers = Customer::where('is_active', true)->get();
        
        return view('aura.orders', compact('products', 'customers'));
    }
    
    // Aura ERP Store Order
    public function auraStoreOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1'
        ]);
        
        DB::beginTransaction();
        try {
            $order = SalesOrder::create([
                'customer_id' => $validated['customer_id'],
                'order_date' => now(),
                'status' => 'pending',
                'user_id' => auth()->id()
            ]);
            
            $total = 0;
            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['id']);
                $subtotal = $product->selling_price * $productData['quantity'];
                $total += $subtotal;
                
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->selling_price,
                    'subtotal' => $subtotal
                ]);
            }
            
            $order->update(['total' => $total]);
            
            DB::commit();
            return response()->json(['success' => true, 'order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
