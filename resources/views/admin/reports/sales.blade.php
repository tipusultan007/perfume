@extends('admin.layouts.app')

@section('title', 'Sales Report')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
                        <li class="breadcrumb-item active">Sales</li>
                    </ol>
                </div>
                <h4 class="page-title">Sales Analytics</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.reports.sales') }}" method="GET" class="row align-items-end g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Start Date</label>
                            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control border-light-subtle shadow-none py-2">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">End Date</label>
                            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control border-light-subtle shadow-none py-2">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-dark w-100 fw-bold text-uppercase fs-11 tracking-wider py-2">
                                <i class="ri-filter-3-line me-1"></i> Apply Analysis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Metrics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <p class="text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Gross Revenue</p>
                    <h2 class="fw-bold text-dark my-0">${{ number_format($totalRevenue, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <p class="text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Total Orders</p>
                    <h2 class="fw-bold text-dark my-0">{{ number_format($totalOrders) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <p class="text-muted fw-bold text-uppercase fs-10 tracking-widest mb-2">Avg. Order Value</p>
                    <h2 class="fw-bold text-dark my-0">${{ number_format($avgOrderValue, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-light/30 border-bottom py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Performance Trend</h5>
                </div>
                <div class="card-body">
                    <div style="height: 350px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light/30 border-bottom py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Transaction History</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light/50">
                                <tr class="text-muted fw-bold text-uppercase fs-10 tracking-widest border-top-0">
                                    <th class="ps-4 py-3">Reference</th>
                                    <th class="py-3">Date</th>
                                    <th class="py-3">Customer</th>
                                    <th class="py-3">Payment</th>
                                    <th class="py-3">Status</th>
                                    <th class="text-end pe-4 py-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark uppercase tracking-wider">#{{ $order->order_number }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-12">{{ $order->created_at->format('M d, Y') }}</span>
                                            <span class="text-muted fs-11">{{ $order->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-13">{{ $order->shipping_address['first_name'] ?? 'Guest' }} {{ $order->shipping_address['last_name'] ?? '' }}</span>
                                            <span class="text-muted fs-10 text-uppercase fw-bold">Verified Buyer</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-10 fw-bold text-uppercase">{{ $order->payment_method }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'completed' => 'bg-soft-success text-success',
                                                'pending'   => 'bg-soft-warning text-warning',
                                                'cancelled' => 'bg-soft-danger text-danger',
                                                'processing'=> 'bg-soft-info text-info'
                                            ][$order->status] ?? 'bg-soft-secondary text-secondary';
                                        @endphp
                                        <span class="badge {{ $statusClass }} px-3 py-1.5 rounded-pill fs-10 fw-bold text-uppercase tracking-widest">{{ $order->status }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="fw-bold text-dark fs-15">${{ number_format($order->grand_total, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="ri-history-line fs-48 text-muted opacity-20 mb-3 d-block"></i>
                                            <p class="text-muted fw-bold text-uppercase fs-11 tracking-widest">No matching transactions found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
    .fs-15 { font-size: 15px !important; }
    .fs-24 { font-size: 24px !important; }
    .fs-48 { font-size: 48px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.1); }
    .bg-soft-info { background-color: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.1); }
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); border: 1px solid rgba(100, 116, 139, 0.1); }

    .form-control:focus {
        border-color: #0f172a !important;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.05) !important;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
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
                    borderRadius: 4,
                    maxBarThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
                        border: { display: false },
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            font: { family: 'Inter', weight: 'bold', size: 10 },
                            color: '#94a3b8',
                            callback: value => '$' + value.toLocaleString()
                        }
                    },
                    x: {
                        border: { display: false },
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

