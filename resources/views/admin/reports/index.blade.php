@extends('admin.layouts.app')

@section('title', 'Reports Overview')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Analytics</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
                <h4 class="page-title">Performance Reports</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Header Summary -->
    <div class="row mb-4">
        <div class="col-12 d-flex flex-wrap gap-2 justify-content-end">
            <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-dark fw-bold text-uppercase fs-11 tracking-wider px-3">
                <i class="ri-money-dollar-circle-line me-1"></i> Sales
            </a>
            <a href="{{ route('admin.reports.products') }}" class="btn btn-outline-dark fw-bold text-uppercase fs-11 tracking-wider px-3">
                <i class="ri-archive-line me-1"></i> Products
            </a>
            <a href="{{ route('admin.reports.customers') }}" class="btn btn-outline-dark fw-bold text-uppercase fs-11 tracking-wider px-3">
                <i class="ri-user-star-line me-1"></i> Customers
            </a>
        </div>
    </div>

    <!-- KPI Metrics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Today's Revenue</h5>
                            <h3 class="my-0 fw-bold text-dark fs-24">${{ number_format($todaySales, 2) }}</h3>
                            <div class="mt-2">
                                <span class="badge bg-soft-success text-success fs-10 fw-bold px-2 py-1 rounded border border-success/10">{{ $todayOrders }} ORDERS</span>
                            </div>
                        </div>
                        <div class="avatar-lg bg-soft-success rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri-money-dollar-box-line fs-32 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Pending Orders</h5>
                            <h3 class="my-0 fw-bold text-dark fs-24">{{ $pendingOrders }}</h3>
                            <a href="{{ route('admin.orders.index') }}" class="mt-2 d-inline-block text-warning text-uppercase fs-10 fw-bold tracking-widest text-decoration-none">
                                Review Queue <i class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                        <div class="avatar-lg bg-soft-warning rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri-time-line fs-32 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Inventory Alerts</h5>
                            <h3 class="my-0 fw-bold text-dark fs-24">{{ $lowStockCount }}</h3>
                            <a href="{{ route('admin.reports.products') }}" class="mt-2 d-inline-block text-danger text-uppercase fs-10 fw-bold tracking-widest text-decoration-none">
                                Low Stock <i class="ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                        <div class="avatar-lg bg-soft-danger rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ri-error-warning-line fs-32 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-header bg-light/30 border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Revenue Trend</h5>
                    <span class="badge bg-dark rounded-pill px-2 py-1 fs-10 fw-bold tracking-widest text-uppercase">Last 7 Days</span>
                </div>
                <div class="card-body">
                    <div style="height: 400px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-10 { font-size: 10px !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-24 { font-size: 24px !important; }
    .fs-32 { font-size: 32px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    
    .avatar-lg { width: 56px; height: 56px; }

    canvas { width: 100% !important; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        
        // Create gradient
        const gradient = revenueCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(15, 23, 42, 0.08)');
        gradient.addColorStop(1, 'rgba(15, 23, 42, 0)');

        new Chart(revenueCtx, {
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
                    pointRadius: 4,
                    pointBackgroundColor: '#FFF',
                    pointBorderColor: '#0f172a',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#0f172a',
                    pointHoverBorderColor: '#FFF',
                    pointHoverBorderWidth: 2
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
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 12, family: 'Inter', weight: 'bold' },
                        bodyFont: { size: 12, family: 'Inter' },
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
                        grid: { color: '#f1f5f9', borderDash: [5, 5] },
                        ticks: {
                            font: { family: 'Inter', weight: 'bold', size: 10 },
                            color: '#94a3b8',
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Inter', weight: 'bold', size: 10 },
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    })();
</script>
@endsection
