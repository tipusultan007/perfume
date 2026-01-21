@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')
@section('page_title', 'Overview')

@section('content')
<div class="space-y-8">
    <!-- Stats Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Total Revenue</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="p-3 bg-slate-50 text-slate-900 rounded-xl group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <i class="ri-money-dollar-circle-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-600 font-bold">
                    +12.5%
                </span>
                <span class="text-slate-400 ml-2 font-medium">from last month</span>
            </div>
        </div>

        <!-- Orders -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">New Orders</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2">{{ $newOrdersCount }}</h3>
                </div>
                <div class="p-3 bg-slate-50 text-slate-900 rounded-xl group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <i class="ri-shopping-bag-3-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="text-slate-400 font-medium">Today's active orders</span>
            </div>
        </div>

        <!-- Customers -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Total Customers</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalCustomers) }}</h3>
                </div>
                <div class="p-3 bg-slate-50 text-slate-900 rounded-xl group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <i class="ri-user-heart-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-600 font-bold">
                    +5.2%
                </span>
                <span class="text-slate-400 ml-2 font-medium">new growth</span>
            </div>
        </div>
        
        <!-- Products -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-all hover:shadow-md group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Top Products</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-2">{{ $topProducts->count() }}</h3>
                </div>
                <div class="p-3 bg-slate-50 text-slate-900 rounded-xl group-hover:bg-slate-900 group-hover:text-white transition-all">
                    <i class="ri-star-smile-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="text-slate-400 font-medium">Best sellers available</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-bold text-slate-900">Revenue Overview</h3>
                <select class="text-xs border border-slate-200 bg-slate-50 rounded-lg px-4 py-2 text-slate-600 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none cursor-pointer hover:bg-slate-100 transition-colors">
                    <option>Last 12 Months</option>
                    <option>Last 30 Days</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="relative h-80 w-full">
                <canvas id="dashboardRevenueChart"></canvas>
            </div>
        </div>

        <!-- Top Products List -->
        <div class="bg-white p-8 rounded-xl border border-slate-200 shadow-sm">
            <h3 class="font-bold text-slate-900 mb-8">Top Selling Products</h3>
            <div class="space-y-4">
                @foreach($topProducts as $index => $product)
                <div class="flex items-center gap-4 p-4 hover:bg-slate-50 rounded-xl transition-all border border-transparent hover:border-slate-100">
                    <div class="w-10 h-10 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-slate-900 truncate">{{ $product->product_name }}</h4>
                        <p class="text-[11px] text-slate-500 font-medium">{{ $product->total_qty }} units sold</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold text-slate-900 block">${{ number_format($product->revenue, 0) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.reports.products') }}" class="block mt-8 text-center text-[11px] text-slate-500 hover:text-slate-900 uppercase tracking-[0.2em] font-bold border border-slate-200 py-3 rounded-lg hover:bg-slate-50 transition-all">View All Products</a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white p-0 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
            <h3 class="font-bold text-slate-900">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-[11px] text-slate-600 font-bold uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">View All Orders</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-5 text-[11px] uppercase tracking-widest text-slate-500 font-bold">Order ID</th>
                        <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-bold">Customer</th>
                        <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-bold">Date</th>
                        <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-bold">Amount</th>
                        <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-bold">Status</th>
                        <th class="px-8 py-5 text-[11px] uppercase tracking-widest text-slate-500 font-bold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-5 font-bold text-slate-900">{{ $order->order_number }}</td>
                        <td class="py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 border border-slate-200">
                                    {{ substr($order->shipping_address['first_name'] ?? 'G', 0, 1) }}
                                </div>
                                <span class="font-medium text-slate-700">{{ $order->shipping_address['first_name'] ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td class="py-5 text-slate-500 font-medium">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="py-5 font-bold text-slate-900">${{ number_format($order->grand_total, 2) }}</td>
                        <td class="py-5">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                                $class = $statusClasses[$order->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                            @endphp
                            <span class="inline-flex px-2.5 py-1 text-[10px] uppercase tracking-widest font-bold rounded-md border {{ $class }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-50 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-900 hover:text-white transition-all shadow-sm border border-slate-200">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('dashboardRevenueChart').getContext('2d');
    
    // Gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 0, 0, 0.1)');
    gradient.addColorStop(1, 'rgba(0, 0, 0, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Revenue',
                data: @json($revenues),
                borderColor: '#1a1a1a', // luxury black
                backgroundColor: gradient,
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#1a1a1a',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1a1a1a',
                    padding: 12,
                    titleFont: { family: 'Inter', size: 13 },
                    bodyFont: { family: 'Inter', size: 13 },
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.03)',
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9ca3af',
                        callback: function(value) {
                            if(value >= 1000) return '$' + (value/1000) + 'k';
                            return '$' + value;
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9ca3af'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
        }
    });
</script>
@endsection
