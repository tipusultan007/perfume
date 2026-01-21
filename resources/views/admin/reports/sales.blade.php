@extends('admin.layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Sales Report</h1>
            <p class="text-slate-500 font-medium mt-1">Granular analysis of revenue streams and order volume</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" 
            class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line text-lg"></i>
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm transition-all group">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-col md:flex-row items-end gap-6">
            <div class="w-full md:w-auto flex-1">
                <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-3">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate }}" 
                    class="w-full bg-white border border-slate-200 rounded-lg px-5 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
            </div>
            <div class="w-full md:w-auto flex-1">
                <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-3">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate }}" 
                    class="w-full bg-white border border-slate-200 rounded-lg px-5 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all">
            </div>
            <button type="submit" class="w-full md:w-auto px-10 py-4 bg-slate-900 text-white text-[11px] font-bold uppercase tracking-[0.2em] rounded-lg hover:bg-slate-800 transition-all shadow-xl hover:shadow-slate-900/20 active:scale-[0.98]">
                Apply Filter
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group text-center">
            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-2">Total Gross Revenue</span>
            <h3 class="text-3xl font-bold text-slate-900 tracking-tight">${{ number_format($totalRevenue, 2) }}</h3>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group text-center">
            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-2">Processed Orders</span>
            <h3 class="text-3xl font-bold text-slate-900 tracking-tight">{{ number_format($totalOrders) }}</h3>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group text-center">
            <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-2">Avg. Order Value</span>
            <h3 class="text-3xl font-bold text-slate-900 tracking-tight">${{ number_format($avgOrderValue, 2) }}</h3>
        </div>
    </div>

    <!-- Chart -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-10 group">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-3">
                <i class="ri-bar-chart-fold-line text-slate-300"></i> Sales Performance Trend
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-4 px-3 py-1 bg-slate-50 border border-slate-100 rounded-full">Custom Range</span>
            </h3>
        </div>
        <div class="relative h-[400px]">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col transition-all">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
            <h3 class="text-lg font-bold text-slate-900">Transaction History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                        <th class="px-8 py-5">Order Reference</th>
                        <th class="px-8 py-5">Date & Time</th>
                        <th class="px-8 py-5">Customer Billing</th>
                        <th class="px-8 py-5">Payment</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($orders as $order)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6 font-bold text-slate-900 uppercase tracking-wider">{{ $order->order_number }}</td>
                        <td class="px-8 py-6 text-slate-500 font-medium text-xs">{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900">{{ $order->shipping_address['first_name'] ?? 'Guest' }} {{ $order->shipping_address['last_name'] ?? '' }}</span>
                                <span class="text-[10px] text-slate-400 uppercase font-bold tracking-tight">Verified Buyer</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-slate-50 border border-slate-100 rounded-lg text-[10px] font-bold uppercase tracking-widest text-slate-600">{{ $order->payment_method }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 border text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm
                                {{ $order->status === 'completed' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 
                                   ($order->status === 'pending' ? 'bg-amber-50 border-amber-100 text-amber-600' : 
                                   ($order->status === 'cancelled' ? 'bg-rose-50 border-rose-100 text-rose-600' : 'bg-slate-100 border-slate-200 text-slate-500')) }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-lg font-bold text-slate-900">${{ number_format($order->grand_total, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                    <i class="ri-history-line text-3xl text-slate-200"></i>
                                </div>
                                <p class="text-sm font-bold uppercase tracking-widest">No matching transactions found</p>
                            </div>
                        </td>
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
                label: 'Gross Revenue',
                data: @json($chartData->pluck('revenue')),
                backgroundColor: '#0f172a',
                hoverBackgroundColor: '#334155',
                borderRadius: 8,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { size: 13, family: 'Inter', weight: 'bold' },
                    bodyFont: { size: 13, family: 'Inter' },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
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
                    border: { display: false },
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { family: 'Inter', weight: 'bold', size: 11 },
                        color: '#94a3b8',
                        padding: 10,
                        callback: value => '$' + value.toLocaleString()
                    }
                },
                x: {
                    border: { display: false },
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Inter', weight: 'bold', size: 11 },
                        color: '#94a3b8',
                        padding: 10
                    }
                }
            }
        }
    });
</script>
@endsection
