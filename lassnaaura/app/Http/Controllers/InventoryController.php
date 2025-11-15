<?php

namespace App\Http\Controllers;

use App\Models\ProductStock;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductStock::with(['product', 'warehouse']);
        
        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }
        
        if ($request->filled('low_stock')) {
            $query->whereRaw('quantity_on_hand <= reorder_level');
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        
        $inventory = $query->paginate(20);
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('inventory.index', compact('inventory', 'warehouses'));
    }

    public function adjustStock()
    {
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('inventory.adjust', compact('products', 'warehouses'));
    }

    public function storeAdjustment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'movement_type' => 'required|in:adjustment,sale,purchase,transfer,return',
            'quantity' => 'required|integer',
            'reference_number' => 'nullable|string|max:64',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated) {
            // Get or create product stock
            $productStock = ProductStock::firstOrCreate(
                [
                    'product_id' => $validated['product_id'],
                    'warehouse_id' => $validated['warehouse_id'],
                ],
                [
                    'quantity_on_hand' => 0,
                    'available_quantity' => 0,
                    'reserved_quantity' => 0,
                    'reorder_level' => 10,
                ]
            );
            
            // Update stock levels
            $oldQuantity = $productStock->quantity_on_hand;
            $productStock->quantity_on_hand += $validated['quantity'];
            $productStock->available_quantity += $validated['quantity'];
            $productStock->save();
            
            // Create stock movement record
            StockMovement::create([
                'product_id' => $validated['product_id'],
                'warehouse_id' => $validated['warehouse_id'],
                'movement_type' => $validated['movement_type'],
                'quantity' => $validated['quantity'],
                'old_quantity' => $oldQuantity,
                'new_quantity' => $productStock->quantity_on_hand,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
        });
        
        return redirect()->route('inventory.index')
            ->with('success', 'Stock adjusted successfully!');
    }

    public function movements(Request $request)
    {
        $query = StockMovement::with(['product', 'warehouse', 'creator']);
        
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        
        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }
        
        if ($request->filled('movement_type')) {
            $query->where('movement_type', $request->movement_type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        
        $movements = $query->orderBy('created_at', 'desc')->paginate(20);
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('inventory.movements', compact('movements', 'products', 'warehouses'));
    }

    public function transferStock()
    {
        $products = Product::where('is_active', true)->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        
        return view('inventory.transfer', compact('products', 'warehouses'));
    }

    public function storeTransfer(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:64',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated) {
            // Reduce from source warehouse
            $fromStock = ProductStock::where('product_id', $validated['product_id'])
                ->where('warehouse_id', $validated['from_warehouse_id'])
                ->firstOrFail();
            
            if ($fromStock->available_quantity < $validated['quantity']) {
                throw new \Exception('Insufficient stock in source warehouse.');
            }
            
            $fromStock->quantity_on_hand -= $validated['quantity'];
            $fromStock->available_quantity -= $validated['quantity'];
            $fromStock->save();
            
            // Add to destination warehouse
            $toStock = ProductStock::firstOrCreate(
                [
                    'product_id' => $validated['product_id'],
                    'warehouse_id' => $validated['to_warehouse_id'],
                ],
                ['quantity_on_hand' => 0, 'available_quantity' => 0]
            );
            
            $toStock->quantity_on_hand += $validated['quantity'];
            $toStock->available_quantity += $validated['quantity'];
            $toStock->save();
            
            // Record movements
            StockMovement::create([
                'product_id' => $validated['product_id'],
                'warehouse_id' => $validated['from_warehouse_id'],
                'movement_type' => 'transfer',
                'quantity' => -$validated['quantity'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
            
            StockMovement::create([
                'product_id' => $validated['product_id'],
                'warehouse_id' => $validated['to_warehouse_id'],
                'movement_type' => 'transfer',
                'quantity' => $validated['quantity'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
        });
        
        return redirect()->route('inventory.index')
            ->with('success', 'Stock transferred successfully!');
    }
}
