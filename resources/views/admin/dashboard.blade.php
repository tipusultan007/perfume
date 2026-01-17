@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')
@section('page_title', 'Overview')

@section('content')
<div class="space-y-8">
    <!-- Stats Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Revenue</p>
                    <h3 class="text-2xl font-serif font-medium mt-1">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="p-3 bg-luxury-cream text-luxury-accent rounded-xl">
                    <i class="ri-money-dollar-circle-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="text-green-600 font-medium flex items-center">
                    <i class="ri-arrow-up-line mr-1"></i> +12.5%
                </span>
                <span class="text-gray-400 ml-2">from last month</span>
            </div>
        </div>

        <!-- Orders -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">New Orders</p>
                    <h3 class="text-2xl font-serif font-medium mt-1">{{ $newOrdersCount }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                    <i class="ri-shopping-bag-3-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="text-gray-400">Today's orders</span>
            </div>
        </div>

        <!-- Customers -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Customers</p>
                    <h3 class="text-2xl font-serif font-medium mt-1">{{ number_format($totalCustomers) }}</h3>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                    <i class="ri-user-heart-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="text-green-600 font-medium flex items-center">
                    <i class="ri-arrow-up-line mr-1"></i> +5.2%
                </span>
                <span class="text-gray-400 ml-2">new growth</span>
            </div>
        </div>
        
        <!-- Products -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Top Products</p>
                    <h3 class="text-2xl font-serif font-medium mt-1">{{ $topProducts->count() }}</h3>
                </div>
                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                    <i class="ri-star-smile-line text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs">
                <span class="text-gray-400">Best sellers</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-serif text-lg">Revenue Overview</h3>
                <select class="text-xs border-none bg-gray-50 rounded-lg px-3 py-1 text-gray-500 focus:ring-0 cursor-pointer hover:bg-gray-100 transition-colors">
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
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <h3 class="font-serif text-lg mb-6">Top Selling Products</h3>
            <div class="space-y-4">
                @foreach($topProducts as $index => $product)
                <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <div class="w-8 h-8 rounded-full bg-luxury-cream text-luxury-accent flex items-center justify-center font-serif font-medium text-sm flex-shrink-0">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $product->product_name }}</h4>
                        <p class="text-xs text-gray-500">{{ $product->total_qty }} sold</p>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-medium block">${{ number_format($product->revenue, 0) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.reports.products') }}" class="block mt-6 text-center text-xs text-luxury-accent hover:underline uppercase tracking-wider font-medium">View All Products</a>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white p-8 rounded-2xl border border-black/5 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-serif text-lg">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-gray-500 hover:text-black transition-colors">View All Orders</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-black/5">
                        <th class="py-4 text-[11px] uppercase tracking-widest text-gray-400 font-medium pl-4">Order ID</th>
                        <th class="py-4 text-[11px] uppercase tracking-widest text-gray-400 font-medium">Customer</th>
                        <th class="py-4 text-[11px] uppercase tracking-widest text-gray-400 font-medium">Date</th>
                        <th class="py-4 text-[11px] uppercase tracking-widest text-gray-400 font-medium">Amount</th>
                        <th class="py-4 text-[11px] uppercase tracking-widest text-gray-400 font-medium">Status</th>
                        <th class="py-4 text-[11px] uppercase tracking-widest text-gray-400 font-medium pr-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($recentOrders as $order)
                    <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors group">
                        <td class="py-4 pl-4 font-medium text-black group-hover:text-luxury-accent transition-colors">{{ $order->order_number }}</td>
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs text-gray-500">
                                    {{ substr($order->shipping_address['first_name'] ?? 'G', 0, 1) }}
                                </div>
                                <span>{{ $order->shipping_address['first_name'] ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="py-4 font-medium">${{ number_format($order->grand_total, 2) }}</td>
                        <td class="py-4">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-orange-50 text-orange-600',
                                    'processing' => 'bg-blue-50 text-blue-600',
                                    'completed' => 'bg-green-50 text-green-600',
                                    'cancelled' => 'bg-red-50 text-red-600',
                                ];
                                $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="inline-block px-2.5 py-0.5 text-[10px] uppercase tracking-wider font-semibold rounded-full {{ $class }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-4 pr-4 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-luxury-accent hover:text-black transition-colors text-xs font-medium border-b border-transparent hover:border-black">View Details</a>
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
