@extends('admin.layouts.app')

@section('title', 'Products Report')

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
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <h4 class="page-title">Inventory & Performance</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- Best Sellers -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light/30 border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Top 10 Best Sellers</h5>
                    <span class="badge bg-soft-success text-success fs-10 fw-bold px-2 py-1 rounded text-uppercase tracking-widest">By Quantity</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light/50">
                                <tr class="text-muted fw-bold text-uppercase fs-10 tracking-widest border-top-0">
                                    <th class="ps-4 py-3">Product</th>
                                    <th class="text-end py-3">Sold</th>
                                    <th class="text-end pe-4 py-3">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellers as $index => $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="avatar-sm bg-light text-dark fw-mono fs-10 fw-bold rounded d-flex align-items-center justify-content-center border">
                                                #{{ $index + 1 }}
                                            </span>
                                            <span class="fw-bold text-dark fs-13">{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-11 fw-bold">{{ number_format($item->total_qty) }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="fw-bold text-dark fs-14">${{ number_format($item->total_revenue, 2) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted opacity-50">
                                        <i class="ri-shopping-basket-line fs-32 mb-2 d-block"></i>
                                        <p class="fs-11 fw-bold text-uppercase tracking-widest mb-0">No sales data recorded yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-soft-danger-header border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-danger">Low Stock Alerts</h5>
                    <span class="badge bg-danger text-white fs-10 fw-bold px-2 py-1 rounded text-uppercase tracking-widest">Qty <= 10</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light/50">
                                <tr class="text-muted fw-bold text-uppercase fs-10 tracking-widest border-top-0">
                                    <th class="ps-4 py-3">Product</th>
                                    <th class="text-end py-3">Stock</th>
                                    <th class="text-end pe-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <span class="fw-bold text-dark fs-13">{{ $product->name }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold {{ $product->stock_quantity == 0 ? 'text-danger' : 'text-warning' }} fs-14">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($product->stock_quantity == 0)
                                            <span class="badge bg-soft-danger text-danger px-2 py-1 rounded-pill fs-9 fw-bold text-uppercase tracking-widest">Out of Stock</span>
                                        @else
                                            <span class="badge bg-soft-warning text-warning px-2 py-1 rounded-pill fs-9 fw-bold text-uppercase tracking-widest">Priority Restock</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="ri-checkbox-circle-line fs-32 text-success opacity-50 mb-2 d-block"></i>
                                        <p class="fs-11 fw-bold text-uppercase tracking-widest mb-0 text-success">Inventory is healthy</p>
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
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .fs-32 { font-size: 32px !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger-header { background-color: rgba(239, 68, 68, 0.05); }
    
    .avatar-sm { width: 32px; height: 32px; }
</style>
@endsection

