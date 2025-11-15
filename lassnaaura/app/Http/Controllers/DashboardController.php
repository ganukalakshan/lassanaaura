<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\Expense;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get KPI data
        $kpis = $this->getKPIs();
        $recentInvoices = $this->getRecentInvoices();
        $lowStockProducts = $this->getLowStockProducts();
        $salesChartData = $this->getSalesChartData();
        
        return view('dashboard', compact('kpis', 'recentInvoices', 'lowStockProducts', 'salesChartData'));
    }
    
    private function getKPIs()
    {
        $currentMonth = now()->startOfMonth();
        $currentYear = now()->startOfYear();
        
        return [
            'revenue_mtd' => Invoice::where('invoice_date', '>=', $currentMonth)
                ->where('status', '!=', 'cancelled')
                ->sum('total'),
            'revenue_ytd' => Invoice::where('invoice_date', '>=', $currentYear)
                ->where('status', '!=', 'cancelled')
                ->sum('total'),
            'receivables' => Invoice::whereIn('status', ['sent', 'partially_paid', 'overdue'])
                ->sum('balance_due'),
            'payables' => 0, // Will calculate from purchase orders
            'stock_value' => DB::table('product_stock')
                ->join('products', 'product_stock.product_id', '=', 'products.id')
                ->selectRaw('SUM(product_stock.quantity_on_hand * products.cost_price) as total')
                ->value('total') ?? 0,
            'total_customers' => Customer::where('is_active', true)->count(),
            'orders_today' => SalesOrder::whereDate('order_date', today())->count(),
            'low_stock_count' => DB::table('products')
                ->whereRaw('(SELECT COALESCE(SUM(quantity_on_hand), 0) FROM product_stock WHERE product_id = products.id) <= products.reorder_level')
                ->count(),
        ];
    }
    
    private function getRecentInvoices()
    {
        return Invoice::with('customer')
            ->orderBy('invoice_date', 'desc')
            ->limit(10)
            ->get();
    }
    
    private function getLowStockProducts()
    {
        return Product::select('products.*')
            ->selectRaw('(SELECT SUM(quantity_on_hand) FROM product_stock WHERE product_id = products.id) as total_stock')
            ->whereRaw('(SELECT SUM(quantity_on_hand) FROM product_stock WHERE product_id = products.id) <= products.reorder_level')
            ->where('track_inventory', true)
            ->limit(10)
            ->get();
    }
    
    private function getSalesChartData()
    {
        $last30Days = Invoice::where('invoice_date', '>=', now()->subDays(30))
            ->where('status', '!=', 'cancelled')
            ->selectRaw('DATE(invoice_date) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return [
            'labels' => $last30Days->pluck('date'),
            'data' => $last30Days->pluck('total'),
        ];
    }
}
