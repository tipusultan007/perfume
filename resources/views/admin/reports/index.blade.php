@extends('admin.layouts.app')

@section('title', 'Reports Overview')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-serif text-black">Reports Overview</h1>
            <p class="text-sm text-gray-500 mt-1">Key metrics and performance insights</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.reports.sales') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 flex items-center gap-2">
                <i class="ri-money-dollar-circle-line"></i> Sales Report
            </a>
            <a href="{{ route('admin.reports.products') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 flex items-center gap-2">
                <i class="ri-archive-line"></i> Products Report
            </a>
            <a href="{{ route('admin.reports.customers') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm hover:bg-gray-50 flex items-center gap-2">
                <i class="ri-user-star-line"></i> Customers Report
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today Sales -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Sales</p>
                    <h3 class="text-2xl font-semibold mt-1">${{ number_format($todaySales, 2) }}</h3>
                </div>
                <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                    <i class="ri-money-dollar-box-line text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">{{ $todayOrders }} orders today</p>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                    <h3 class="text-2xl font-semibold mt-1">{{ $pendingOrders }}</h3>
                </div>
                <div class="p-2 bg-orange-50 text-orange-600 rounded-lg">
                    <i class="ri-time-line text-xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-orange-600 mt-4 inline-block hover:underline">View pending orders</a>
        </div>

        <!-- Low Stock -->
        <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Low Stock Items</p>
                    <h3 class="text-2xl font-semibold mt-1">{{ $lowStockCount }}</h3>
                </div>
                <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                    <i class="ri-alert-line text-xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.reports.products') }}" class="text-xs text-red-600 mt-4 inline-block hover:underline">View alerts</a>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white p-6 rounded-2xl border border-black/5 shadow-sm">
        <h3 class="text-lg font-serif mb-6">Revenue Trend (Last 7 Days)</h3>
        <div class="relative h-80">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Revenue',
                data: @json($revenues),
                borderColor: '#000',
                backgroundColor: 'rgba(0, 0, 0, 0.05)',
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#FFF',
                pointBorderColor: '#000',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
@endsection
