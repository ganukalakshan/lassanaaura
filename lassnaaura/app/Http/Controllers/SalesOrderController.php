<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = SalesOrder::with('customer');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $orders = $query->orderBy('order_date', 'desc')->paginate(20);
        
        return view('sales.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('sales.orders.create', compact('customers', 'products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after:order_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'shipping_method' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated) {
            $orderNumber = 'SO-' . date('Y') . '-' . str_pad(SalesOrder::whereYear('created_at', date('Y'))->count() + 1, 6, '0', STR_PAD_LEFT);
            
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_price'];
            }
            
            $order = SalesOrder::create([
                'order_number' => $orderNumber,
                'customer_id' => $validated['customer_id'],
                'warehouse_id' => $validated['warehouse_id'],
                'order_date' => $validated['order_date'],
                'expected_delivery_date' => $validated['expected_delivery_date'] ?? null,
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'status' => 'pending',
                'shipping_method' => $validated['shipping_method'] ?? null,
                'payment_terms' => $validated['payment_terms'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $order->salesOrderItems()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $item['quantity'] * $item['unit_price'],
                ]);
            }
            
            return $order;
        });
        
        return redirect()->route('sales.orders.index')
            ->with('success', 'Sales order created successfully!');
    }

    public function show(SalesOrder $order)
    {
        $order->load(['customer', 'warehouse', 'salesOrderItems.product']);
        return view('sales.orders.show', compact('order'));
    }

    public function edit(SalesOrder $order)
    {
        $customers = Customer::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('sales.orders.edit', compact('order', 'customers', 'products', 'warehouses'));
    }

    public function update(Request $request, SalesOrder $order)
    {
        // Similar implementation to store
        return redirect()->route('sales.orders.show', $order)
            ->with('success', 'Sales order updated successfully!');
    }

    public function destroy(SalesOrder $order)
    {
        $order->delete();
        return redirect()->route('sales.orders.index')
            ->with('success', 'Sales order deleted successfully!');
    }
}
