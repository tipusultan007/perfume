@extends('admin.layouts.app')

@section('title', 'Customer Details')
@section('page_title', 'Customer Profile')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Customers</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <h4 class="page-title">Customer Profile</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <div class="avatar-lg mx-auto mb-3">
                        <span class="avatar-title bg-soft-primary text-primary rounded-circle fw-bold fs-24 uppercase">
                            {{ substr($customer->name, 0, 1) }}
                        </span>
                    </div>
                    <h4 class="mb-1 text-dark fw-bold">{{ $customer->name }}</h4>
                    <p class="text-muted font-14 fw-medium">{{ $customer->email }}</p>

                    <div class="row mt-4 pt-2 border-top">
                        <div class="col-6 border-end">
                            <h5 class="text-muted fs-11 text-uppercase tracking-wider fw-bold">Total Orders</h5>
                            <h4 class="mb-0 text-dark fw-bold">{{ $customer->orders->count() }}</h4>
                        </div>
                        <div class="col-6">
                            <h5 class="text-muted fs-11 text-uppercase tracking-wider fw-bold">Member Since</h5>
                            <h4 class="mb-0 text-dark fw-bold">{{ $customer->created_at->format('M Y') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">
                        <i class="ri-map-pin-line me-1 text-primary"></i> Contact Information
                    </h4>
                    
                    <div class="mb-4 pb-3 border-bottom">
                        <h5 class="text-muted fs-11 text-uppercase tracking-wider fw-bold mb-2">Shipping Address</h5>
                        @if($customer->shipping_address)
                            <p class="text-dark fs-13 fw-medium mb-0 lh-base">
                                {{ $customer->shipping_address['address'] ?? '' }}<br>
                                {{ $customer->shipping_address['city'] ?? '' }}, {{ $customer->shipping_address['state'] ?? '' }} {{ $customer->shipping_address['zip'] ?? '' }}<br>
                                {{ $customer->shipping_address['country'] ?? '' }}
                            </p>
                        @else
                            <p class="text-muted fs-13 italic mb-0">No shipping address saved.</p>
                        @endif
                    </div>

                    <div>
                        <h5 class="text-muted fs-11 text-uppercase tracking-wider fw-bold mb-2">Billing Address</h5>
                        @if($customer->billing_address)
                            <p class="text-dark fs-13 fw-medium mb-0 lh-base">
                                {{ $customer->billing_address['address'] ?? '' }}<br>
                                {{ $customer->billing_address['city'] ?? '' }}, {{ $customer->billing_address['state'] ?? '' }} {{ $customer->billing_address['zip'] ?? '' }}<br>
                                {{ $customer->billing_address['country'] ?? '' }}
                            </p>
                        @else
                            <p class="text-muted fs-13 italic mb-0">No billing address saved.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-4">Order History</h4>
                    
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-11 fw-bold tracking-wider">
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end" style="width: 80px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-dark fw-bold">#{{ $order->id }}</a>
                                    </td>
                                    <td class="text-muted fs-12 fw-semibold">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($order->status) {
                                                'completed' => 'bg-soft-success text-success',
                                                'pending' => 'bg-soft-warning text-warning',
                                                'cancelled' => 'bg-soft-danger text-danger',
                                                default => 'bg-soft-secondary text-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="text-end text-dark fw-bold font-monospace">${{ number_format($order->total ?? 0, 2) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-soft-primary btn-sm">
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-shopping-bag-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No orders found</p>
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
    .avatar-lg { height: 80px; width: 80px; }
    .avatar-title { font-size: 24px; }
    .fs-11 { font-size: 11px; }
    .fs-10 { font-size: 10px; }
    .fs-13 { font-size: 13px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
</style>
@endsection

