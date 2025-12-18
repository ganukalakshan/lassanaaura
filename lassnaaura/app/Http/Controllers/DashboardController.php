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
        $products = Product::with('stocks')->where('is_active', true)->get()->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image_url ?? '/images/default-product.png',
                'quantity' => $product->stocks->sum('quantity_on_hand') ?? 0
            ];
        });
        
        return view('aura.dashboard', compact('products'));
    }
    
    // Aura ERP Orders Page - Create new orders with customer-first workflow
    public function auraOrders()
    {
        $products = Product::where('is_active', true)->get();
        $customers = Customer::where('is_active', true)->get();
        
        return view('aura.orders-new', compact('products', 'customers'));
    }
    
    // Aura ERP Store Order - Handle new order with custom pricing
    public function auraStoreOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|in:cash,bank_transfer',
            'status' => 'required|in:confirmed,pending',
            'products' => 'required|json'
        ]);
        
        $products = json_decode($validated['products'], true);
        
        if (empty($products)) {
            return back()->with('error', 'Please add at least one product to the order');
        }
        
        DB::beginTransaction();
        try {
            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
            
            // Calculate totals
            $subtotal = 0;
            $totalDiscount = 0;
            
            foreach ($products as $product) {
                $subtotal += $product['selling_price'];
                $totalDiscount += $product['discount'] ?? 0;
            }
            
            // Create order
            $order = SalesOrder::create([
                'order_number' => $orderNumber,
                'customer_id' => $validated['customer_id'],
                'user_id' => auth()->id(),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'order_date' => now(),
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'total' => $subtotal
            ]);
            
            // Create order items and reduce inventory
            foreach ($products as $product) {
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product['product_id'],
                    'product_name' => $product['name'],
                    'quantity' => 1,
                    'unit_price' => $product['selling_price'],
                    'cost_price' => $product['cost_price'],
                    'discount_amount' => $product['discount'] ?? 0,
                    'subtotal' => $product['selling_price'],
                    'line_total' => $product['selling_price']
                ]);
                
                // Reduce product quantity from inventory
                $productModel = Product::find($product['product_id']);
                if ($productModel && $productModel->track_inventory) {
                    $stock = $productModel->stocks()->first();
                    if ($stock && $stock->quantity_on_hand >= 1) {
                        $stock->decrement('quantity_on_hand', 1);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('aura.orders.pending')->with('success', 'Order created successfully! Order #' . $orderNumber . ' is pending confirmation.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }
    
    // Aura ERP Complete Orders Page
    public function auraCompleteOrders()
    {
        $orders = SalesOrder::with(['customer', 'items.product', 'creator'])
            ->where('status', 'confirmed')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('aura.orders-complete', compact('orders'));
    }
    
    // Aura ERP Pending Orders Page
    public function auraPendingOrders()
    {
        $orders = SalesOrder::with(['customer', 'items.product', 'creator'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('aura.orders-pending', compact('orders'));
    }
    
    // Aura ERP Profit & Loss Analysis
    public function auraProfitAnalysis()
    {
        // Get all order items with related data for profit calculation
        $transactions = DB::table('sales_order_items as soi')
            ->join('sales_orders as so', 'soi.sales_order_id', '=', 'so.id')
            ->join('customers as c', 'so.customer_id', '=', 'c.id')
            ->join('products as p', 'soi.product_id', '=', 'p.id')
            ->select(
                'so.order_number',
                'so.order_date',
                'c.name as customer_name',
                'c.email as customer_email',
                'p.name as product_name',
                'p.sku as product_sku',
                'soi.cost_price',
                'soi.unit_price as selling_price',
                DB::raw('(soi.unit_price - soi.cost_price) as profit'),
                DB::raw('CASE WHEN soi.cost_price > 0 THEN ((soi.unit_price - soi.cost_price) / soi.cost_price * 100) ELSE 0 END as margin')
            )
            ->where('so.status', 'confirmed')
            ->orderBy('so.order_date', 'desc')
            ->get();
        
        // Calculate summary statistics
        $totalRevenue = $transactions->sum('selling_price');
        $totalCost = $transactions->sum('cost_price');
        $totalProfit = $totalRevenue - $totalCost;
        $totalTransactions = $transactions->count();
        $profitMargin = $totalRevenue > 0 ? (($totalProfit / $totalRevenue) * 100) : 0;
        
        return view('aura.profit-analysis', compact(
            'transactions',
            'totalRevenue',
            'totalCost',
            'totalProfit',
            'totalTransactions',
            'profitMargin'
        ));
    }
    
    // Mark Order as Complete
    public function markOrderComplete($id)
    {
        try {
            $order = SalesOrder::findOrFail($id);
            
            if ($order->status !== 'pending') {
                return back()->with('error', 'Only pending orders can be marked as complete.');
            }
            
            $order->update(['status' => 'confirmed']);
            
            return back()->with('success', 'Order #' . $order->order_number . ' marked as complete!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }
}
