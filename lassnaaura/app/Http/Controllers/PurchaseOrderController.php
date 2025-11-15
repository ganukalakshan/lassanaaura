<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PurchaseOrder::with('supplier');
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        
        $purchaseOrders = $query->orderBy('order_date', 'desc')->paginate(20);
        $suppliers = Supplier::where('is_active', true)->get();
        
        return view('purchases.orders.index', compact('purchaseOrders', 'suppliers'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('purchases.orders.create', compact('suppliers', 'products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date|after_or_equal:order_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated) {
            $poNumber = 'PO-' . date('Y') . '-' . str_pad(PurchaseOrder::whereYear('created_at', date('Y'))->count() + 1, 6, '0', STR_PAD_LEFT);
            
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $subtotal += $item['quantity'] * $item['unit_cost'];
            }
            
            $purchaseOrder = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $validated['supplier_id'],
                'warehouse_id' => $validated['warehouse_id'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'subtotal' => $subtotal,
                'shipping_cost' => $validated['shipping_cost'] ?? 0,
                'tax_amount' => $validated['tax_amount'] ?? 0,
                'total' => $subtotal + ($validated['shipping_cost'] ?? 0) + ($validated['tax_amount'] ?? 0),
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $purchaseOrder->purchaseOrderItems()->create([
                    'product_id' => $item['product_id'],
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'line_total' => $item['quantity'] * $item['unit_cost'],
                ]);
            }
            
            return $purchaseOrder;
        });
        
        return redirect()->route('purchases.orders.index')
            ->with('success', 'Purchase order created successfully!');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'warehouse', 'purchaseOrderItems.product', 'goodsReceivedNotes']);
        return view('purchases.orders.show', compact('purchaseOrder'));
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('purchases.orders.edit', compact('purchaseOrder', 'suppliers', 'products', 'warehouses'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Similar implementation to store
        return redirect()->route('purchases.orders.show', $purchaseOrder)
            ->with('success', 'Purchase order updated successfully!');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchases.orders.index')
                ->with('error', 'Only pending orders can be deleted.');
        }
        
        $purchaseOrder->delete();
        return redirect()->route('purchases.orders.index')
            ->with('success', 'Purchase order deleted successfully!');
    }
}
