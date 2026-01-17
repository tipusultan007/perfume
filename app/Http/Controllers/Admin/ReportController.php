<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Quick Stats
        $todaySales = Order::whereDate('created_at', Carbon::today())->sum('grand_total');
        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $lowStockCount = Product::where('stock_quantity', '<=', 5)->count(); // Threshold 5

        // Recent 7 Days Revenue Trend for simplified dashboard chart
        $dates = collect();
        $revenues = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates->push($date->format('M d'));
            $revenues->push(Order::whereDate('created_at', $date)->sum('grand_total'));
        }

        return view('admin.reports.index', compact(
            'todaySales', 'todayOrders', 'pendingOrders', 'lowStockCount',
            'dates', 'revenues'
        ));
    }

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $orders = Order::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay()
        ])->orderBy('created_at', 'desc')->get();

        $totalRevenue = $orders->sum('grand_total');
        $totalOrders = $orders->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Daily Chart Data
        $chartData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(grand_total) as revenue'),
            DB::raw('COUNT(*) as count')
        )
        ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

        return view('admin.reports.sales', compact(
            'startDate', 'endDate', 'orders', 
            'totalRevenue', 'totalOrders', 'avgOrderValue', 'chartData'
        ));
    }

    public function products()
    {
        // Top 10 Best Sellers
        $bestSellers = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(total) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // Low Stock
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->limit(20)
            ->get();

        return view('admin.reports.products', compact('bestSellers', 'lowStockProducts'));
    }

    public function customers()
    {
        // Top Spenders
        // Assuming 'users' table or linking orders to users. 
        // If guest checkout is common, we might group by email. 
        // Here assuming user_id is present for registered users.
        
        $topCustomers = Order::select('user_id', 'shipping_address', DB::raw('SUM(grand_total) as total_spent'), DB::raw('COUNT(*) as order_count'))
            ->whereNotNull('user_id')
            ->groupBy('user_id', 'shipping_address') // grouping by address for email availability if needed, but user_id is safer
            ->with('user')
            ->orderByDesc('total_spent')
            ->limit(20)
            ->get();
            
        return view('admin.reports.customers', compact('topCustomers'));
    }
}
