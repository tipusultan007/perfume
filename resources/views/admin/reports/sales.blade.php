@extends('admin.layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-serif text-black">Sales Report</h1>
            <p class="text-sm text-gray-500 mt-1">Detailed sales performance analysis</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:text-black transition-colors">
            <i class="ri-arrow-left-line"></i> Back to Reports
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:w-auto">
                <label class="block text-xs font-medium text-gray-500 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-black">
            </div>
            <div class="w-full md:w-auto">
                <label class="block text-xs font-medium text-gray-500 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-black">
            </div>
            <button type="submit" class="px-6 py-2 bg-black text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors">
                Apply Filter
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <p class="text-sm text-gray-500">Total Revenue</p>
            <h3 class="text-2xl font-semibold mt-1">${{ number_format($totalRevenue, 2) }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <p class="text-sm text-gray-500">Total Orders</p>
            <h3 class="text-2xl font-semibold mt-1">{{ $totalOrders }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <p class="text-sm text-gray-500">Avg. Order Value</p>
            <h3 class="text-2xl font-semibold mt-1">${{ number_format($avgOrderValue, 2) }}</h3>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
        <h3 class="text-lg font-serif mb-6">Sales Trend (Selected Period)</h3>
        <div class="relative h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-black/5">
            <h3 class="text-lg font-serif">Transactions</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-black/5 text-xs text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Order ID</th>
                        <th class="px-6 py-3 font-medium">Date</th>
                        <th class="px-6 py-3 font-medium">Customer</th>
                        <th class="px-6 py-3 font-medium">Payment</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-black/5">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-black">{{ $order->order_number }}</td>
                        <td class="px-6 py-3 text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-3 text-gray-900">
                            {{ $order->shipping_address['first_name'] ?? 'Guest' }} {{ $order->shipping_address['last_name'] ?? '' }}
                        </td>
                        <td class="px-6 py-3 capitalize text-gray-700">{{ $order->payment_method }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $order->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                   ($order->status === 'pending' ? 'bg-orange-50 text-orange-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-right font-medium text-black">${{ number_format($order->grand_total, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No orders found for this period.</td>
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
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData->pluck('date')),
            datasets: [{
                label: 'Revenue',
                data: @json($chartData->pluck('revenue')),
                backgroundColor: '#000',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: value => '$' + value }
                }
            }
        }
    });
</script>
@endsection
