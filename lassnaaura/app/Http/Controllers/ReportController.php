<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\SalesOrder;
use App\Models\PurchaseOrder;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function salesReport(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        
        $salesData = Invoice::whereBetween('invoice_date', [$dateFrom, $dateTo])
            ->select(
                DB::raw('DATE(invoice_date) as date'),
                DB::raw('SUM(total) as total_sales'),
                DB::raw('SUM(paid_amount) as total_collected'),
                DB::raw('COUNT(*) as invoice_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $topProducts = DB::table('invoice_items')
            ->join('invoices', 'invoice_items.invoice_id', '=', 'invoices.id')
            ->whereBetween('invoices.invoice_date', [$dateFrom, $dateTo])
            ->select(
                'invoice_items.product_name',
                DB::raw('SUM(invoice_items.quantity) as total_quantity'),
                DB::raw('SUM(invoice_items.line_total) as total_revenue')
            )
            ->groupBy('invoice_items.product_id', 'invoice_items.product_name')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
        
        return view('reports.sales', compact('salesData', 'topProducts', 'dateFrom', 'dateTo'));
    }

    public function purchaseReport(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        
        $purchaseData = PurchaseOrder::whereBetween('order_date', [$dateFrom, $dateTo])
            ->select(
                DB::raw('DATE(order_date) as date'),
                DB::raw('SUM(total) as total_purchases'),
                DB::raw('COUNT(*) as po_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $topSuppliers = PurchaseOrder::whereBetween('order_date', [$dateFrom, $dateTo])
            ->with('supplier')
            ->select(
                'supplier_id',
                DB::raw('SUM(total) as total_amount'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('supplier_id')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();
        
        return view('reports.purchases', compact('purchaseData', 'topSuppliers', 'dateFrom', 'dateTo'));
    }

    public function profitLossReport(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        
        $revenue = Invoice::whereBetween('invoice_date', [$dateFrom, $dateTo])
            ->where('status', 'paid')
            ->sum('total');
        
        $purchases = PurchaseOrder::whereBetween('order_date', [$dateFrom, $dateTo])
            ->where('status', 'completed')
            ->sum('total');
        
        $expenses = Expense::whereBetween('expense_date', [$dateFrom, $dateTo])
            ->sum('amount');
        
        $expensesByCategory = Expense::whereBetween('expense_date', [$dateFrom, $dateTo])
            ->with('category')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();
        
        $netProfit = $revenue - $purchases - $expenses;
        $profitMargin = $revenue > 0 ? ($netProfit / $revenue) * 100 : 0;
        
        return view('reports.profit-loss', compact(
            'revenue', 'purchases', 'expenses', 'netProfit', 'profitMargin',
            'expensesByCategory', 'dateFrom', 'dateTo'
        ));
    }

    public function inventoryReport(Request $request)
    {
        $lowStockProducts = Product::with('productStock')
            ->whereHas('productStock', function($q) {
                $q->whereRaw('quantity_on_hand <= reorder_level');
            })
            ->get();
        
        $stockValue = DB::table('product_stock')
            ->join('products', 'product_stock.product_id', '=', 'products.id')
            ->select(
                DB::raw('SUM(product_stock.quantity_on_hand * products.cost_price) as total_value')
            )
            ->first();
        
        $warehouseStock = DB::table('product_stock')
            ->join('warehouses', 'product_stock.warehouse_id', '=', 'warehouses.id')
            ->select(
                'warehouses.name as warehouse_name',
                DB::raw('COUNT(DISTINCT product_stock.product_id) as product_count'),
                DB::raw('SUM(product_stock.quantity_on_hand) as total_quantity')
            )
            ->groupBy('product_stock.warehouse_id', 'warehouses.name')
            ->get();
        
        return view('reports.inventory', compact('lowStockProducts', 'stockValue', 'warehouseStock'));
    }

    public function customerReport(Request $request)
    {
        $topCustomers = Customer::withSum('invoices', 'total')
            ->withCount('invoices')
            ->orderBy('invoices_sum_total', 'desc')
            ->limit(20)
            ->get();
        
        $customerStats = [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('is_active', true)->count(),
            'customers_with_outstanding' => Customer::whereHas('invoices', function($q) {
                $q->whereIn('status', ['sent', 'partially_paid']);
            })->count(),
        ];
        
        return view('reports.customers', compact('topCustomers', 'customerStats'));
    }

    public function cashFlowReport(Request $request)
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->toDateString());
        
        $paymentsReceived = Payment::whereBetween('payment_date', [$dateFrom, $dateTo])
            ->sum('amount');
        
        $expensesPaid = Expense::whereBetween('expense_date', [$dateFrom, $dateTo])
            ->sum('amount');
        
        $purchasesPaid = PurchaseOrder::whereBetween('order_date', [$dateFrom, $dateTo])
            ->where('status', 'completed')
            ->sum('total');
        
        $netCashFlow = $paymentsReceived - $expensesPaid - $purchasesPaid;
        
        return view('reports.cash-flow', compact(
            'paymentsReceived', 'expensesPaid', 'purchasesPaid',
            'netCashFlow', 'dateFrom', 'dateTo'
        ));
    }
}
