<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User; // Assuming User is customer
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats
        $totalRevenue = Order::sum('grand_total');
        $newOrdersCount = Order::whereDate('created_at', Carbon::today())->count();
        // User model is used for Customers
        $totalCustomers = User::count(); 
        if($totalCustomers == 0) $totalCustomers = \App\Models\Subscriber::count(); // Fallback to subscribers if users empty

        // 2. Chart Data (Monthly Revenue - Last 12 Months)
        $months = collect();
        $revenues = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push($date->format('M Y'));
            
            $revenue = Order::whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->sum('grand_total');
            $revenues->push($revenue);
        }

        // 3. Recent Orders
        $recentOrders = Order::latest()->take(5)->get();

        // 4. Top Selling Products
        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(total) as revenue'))
            ->groupBy('product_name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'newOrdersCount', 'totalCustomers', 
            'months', 'revenues', 
            'recentOrders', 'topProducts'
        ));
    }
}
