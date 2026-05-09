@extends('admin.layouts.app')

@section('title', 'Customers Report')

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
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div>
                <h4 class="page-title">Customer Insights</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-light/30 border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Top 20 Customers by Spend</h5>
                    <span class="badge bg-dark text-white fs-10 fw-bold px-2 py-1 rounded text-uppercase tracking-widest">Lifetime Value</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light/50">
                                <tr class="text-muted fw-bold text-uppercase fs-10 tracking-widest border-top-0">
                                    <th class="ps-4 py-3">Rank</th>
                                    <th class="py-3">Customer</th>
                                    <th class="py-3">Engagement</th>
                                    <th class="py-3">Location</th>
                                    <th class="text-end py-3">Orders</th>
                                    <th class="text-end pe-4 py-3">Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topCustomers as $index => $customer)
                                <tr>
                                    <td class="ps-4">
                                        <span class="avatar-xs bg-light text-muted fw-mono fs-11 fw-bold rounded d-flex align-items-center justify-content-center border">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-13">{{ $customer->shipping_address['first_name'] ?? 'Guest' }} {{ $customer->shipping_address['last_name'] ?? '' }}</span>
                                            <span class="text-muted fs-11">{{ $customer->shipping_address['email'] ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($customer->user_id)
                                            <span class="badge bg-soft-info text-info fs-9 fw-bold text-uppercase tracking-widest px-2 py-1 rounded-pill">Registered Member</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary fs-9 fw-bold text-uppercase tracking-widest px-2 py-1 rounded-pill">Guest Buyer</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted fs-12 font-medium">
                                            {{ $customer->shipping_address['city'] ?? 'Unknown' }}, {{ $customer->shipping_address['country'] ?? '' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-11 fw-bold">{{ $customer->order_count }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="fw-bold text-dark fs-15">${{ number_format($customer->total_spent, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="ri-user-search-line fs-32 opacity-20 mb-2 d-block"></i>
                                        <p class="fs-11 fw-bold text-uppercase tracking-widest mb-0">No customer data available yet</p>
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
    .fs-9 { font-size: 9px !important; }
    .fs-10 { font-size: 10px !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-15 { font-size: 15px !important; }
    .fs-32 { font-size: 32px !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    
    .bg-soft-info { background-color: rgba(6, 182, 212, 0.1); }
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); }
    
    .avatar-xs { width: 28px; height: 28px; }
</style>
@endsection

