@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="ri-calendar-todo-fill fs-13"></i>
                            </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="ri-refresh-line"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-money-dollar-circle-line widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Total Revenue">Total Revenue</h5>
                    <h3 class="mt-3 mb-3">${{ number_format($totalRevenue, 2) }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 12.5%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-shopping-bag-3-line widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="New Orders">New Orders</h5>
                    <h3 class="mt-3 mb-3">{{ $newOrdersCount }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-danger me-2"><i class="ri-arrow-down-line"></i> 1.08%</span>
                        <span class="text-nowrap">Since yesterday</span>
                    </p>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-user-heart-line widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Total Customers">Total Customers</h5>
                    <h3 class="mt-3 mb-3">{{ number_format($totalCustomers) }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 5.2%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-star-smile-line widget-icon"></i>
                    </div>
                    <h5 class="text-muted fw-normal mt-0" title="Top Products">Top Products</h5>
                    <h3 class="mt-3 mb-3">{{ $topProducts->count() }}</h3>
                    <p class="mb-0 text-muted">
                        <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 4.87%</span>
                        <span class="text-nowrap">Since last month</span>
                    </p>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Revenue Overview</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-more-2-fill"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    @php
                        $currentRevenue = $revenues->last() ?? 0;
                        $prevRevenue = $revenues->count() > 1 ? $revenues->slice(-2, 1)->first() : 0;
                    @endphp
                    <div class="chart-content-bg">
                        <div class="row text-center">
                            <div class="col-sm-6">
                                <p class="text-muted mb-0 mt-2">Current Month</p>
                                <h3 class="fw-normal mb-3">
                                    <span>${{ number_format($currentRevenue, 2) }}</span>
                                </h3>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-0 mt-2">Previous Month</p>
                                <h3 class="fw-normal mb-3">
                                    <span>${{ number_format($prevRevenue, 2) }}</span>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div style="height: 335px;">
                         <canvas id="dashboardRevenueChart"></canvas>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Top Selling Products</h4>
                    <a href="{{ route('admin.reports.products') }}" class="btn btn-sm btn-light">View All</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <tbody>
                                @foreach($topProducts as $index => $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title bg-primary-600 rounded-circle">
                                                        {{ $index + 1 }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="mt-0 mb-1 fs-14">{{ $product->product_name }}</h5>
                                                <span class="text-muted fs-12">{{ $product->total_qty }} units sold</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <h5 class="mt-0 mb-1 fs-14">${{ number_format($product->revenue, 0) }}</h5>
                                        <span class="text-muted fs-12">Revenue</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title">Recent Orders</h4>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light">Export</a>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td><span class="fw-bold">{{ $order->order_number }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2">
                                                <span class="avatar-title bg-primary-600 rounded-circle">
                                                    {{ substr($order->shipping_address['first_name'] ?? 'G', 0, 1) }}
                                                </span>
                                            </div>
                                            {{ $order->shipping_address['first_name'] ?? 'Guest' }}
                                        </div>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td><span class="fw-bold">${{ number_format($order->grand_total, 2) }}</span></td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-warning-lighten text-warning',
                                                'processing' => 'bg-info-lighten text-info',
                                                'completed' => 'bg-success-lighten text-success',
                                                'cancelled' => 'bg-danger-lighten text-danger',
                                            ];
                                            $class = $statusClasses[$order->status] ?? 'bg-secondary-lighten text-secondary';
                                        @endphp
                                        <span class="badge {{ $class }} px-2 py-1">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-light">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dashboardRevenueChart').getContext('2d');
        
        // Gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(66, 84, 186, 0.1)');
        gradient.addColorStop(1, 'rgba(66, 84, 186, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenues),
                    borderColor: '#4254ba', // NewKirk primary
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#4254ba',
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
    });
</script>
@endsection

