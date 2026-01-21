@extends('admin.layouts.app')

@section('title', 'Reports Overview')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Reports Overview</h1>
            <p class="text-slate-500 font-medium mt-1">Real-time performance metrics and business insights</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.reports.sales') }}" class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm flex items-center gap-2">
                <i class="ri-money-dollar-circle-line text-lg"></i> Sales
            </a>
            <a href="{{ route('admin.reports.products') }}" class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm flex items-center gap-2">
                <i class="ri-archive-line text-lg"></i> Products
            </a>
            <a href="{{ route('admin.reports.customers') }}" class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm flex items-center gap-2">
                <i class="ri-user-star-line text-lg"></i> Customers
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Today Sales -->
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-2">Today's Revenue</span>
                    <h3 class="text-3xl font-bold text-slate-900 tracking-tight">${{ number_format($todaySales, 2) }}</h3>
                </div>
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm">
                    <i class="ri-money-dollar-box-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-8 flex items-center gap-2">
                <span class="text-xs font-bold text-slate-900 px-2 py-1 bg-slate-50 border border-slate-100 rounded-lg">{{ $todayOrders }}</span>
                <span class="text-xs text-slate-500 font-medium tracking-wide">successful orders today</span>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-2">Pending Orders</span>
                    <h3 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $pendingOrders }}</h3>
                </div>
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm">
                    <i class="ri-time-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-amber-600 hover:text-amber-700 flex items-center gap-2 group/link">
                    Review Pending Queue <i class="ri-arrow-right-line group-hover/link:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <span class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400 mb-2">Inventory Alerts</span>
                    <h3 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $lowStockCount }}</h3>
                </div>
                <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all transform group-hover:rotate-6 shadow-sm">
                    <i class="ri-error-warning-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-8">
                <a href="{{ route('admin.reports.products') }}" class="text-[10px] font-bold uppercase tracking-widest text-rose-600 hover:text-rose-700 flex items-center gap-2 group/link">
                    View Low Stock Items <i class="ri-arrow-right-line group-hover/link:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-10 group">
        <div class="flex justify-between items-center mb-10">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-3">
                <i class="ri-line-chart-line text-slate-300"></i> Revenue Trend
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest ml-4 px-3 py-1 bg-slate-50 border border-slate-100 rounded-full">Last 7 Days</span>
            </h3>
        </div>
        <div class="relative h-[400px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(15, 23, 42, 0.1)');
    gradient.addColorStop(1, 'rgba(15, 23, 42, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Revenue',
                data: @json($revenues),
                borderColor: '#0f172a',
                backgroundColor: gradient,
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                pointBackgroundColor: '#FFF',
                pointBorderColor: '#0f172a',
                pointBorderWidth: 3,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#0f172a',
                pointHoverBorderColor: '#FFF',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
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
                    grid: {
                        color: '#f1f5f9'
                    },
                    ticks: {
                        font: { family: 'Inter', weight: 'bold', size: 11 },
                        color: '#94a3b8',
                        padding: 10,
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    border: { display: false },
                    grid: {
                        display: false
                    },
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
