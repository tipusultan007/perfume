@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page_title', 'Discount Coupons')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Marketing</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
                    </ol>
                </div>
                <h4 class="page-title">Discount Coupons</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h4 class="header-title mb-0">Manage Coupons</h4>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary px-4">
                                <i class="ri-add-line me-1"></i> Create New Coupon
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-11 fw-bold tracking-wider">
                                    <th>Code</th>
                                    <th>Discount Value</th>
                                    <th>Expiry Date</th>
                                    <th class="text-center">Usage</th>
                                    <th>Status</th>
                                    <th class="text-end" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                <tr>
                                    <td>
                                        <span class="badge bg-soft-dark text-dark fw-bold px-2 py-1 fs-12 font-monospace border">
                                            {{ $coupon->code }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark fs-14">
                                            @if($coupon->type === 'percent')
                                                {{ $coupon->value }}% Off
                                            @else
                                                ${{ number_format($coupon->value, 2) }} Off
                                            @endif
                                        </div>
                                        @if($coupon->min_spend)
                                            <span class="text-muted fs-11 fw-semibold text-uppercase opacity-75">Min Spend: ${{ number_format($coupon->min_spend, 2) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-muted fs-12 fw-semibold">
                                        @if($coupon->expiry_date)
                                            <span class="{{ $coupon->expiry_date->isPast() ? 'text-danger' : '' }}">
                                                {{ $coupon->expiry_date->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted opacity-50 italic">No Expiry</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="fw-bold text-dark fs-14">{{ $coupon->used_count }}</span>
                                            @if($coupon->usage_limit)
                                                <span class="text-muted fs-10 fw-bold text-uppercase opacity-50">/ {{ $coupon->usage_limit }} Limit</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if(!$coupon->is_active)
                                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Inactive</span>
                                        @elseif($coupon->expiry_date && $coupon->expiry_date->isPast())
                                            <span class="badge bg-soft-danger text-danger rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Expired</span>
                                        @else
                                            <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Active</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-soft-primary btn-sm" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" 
                                                onsubmit="return confirm('Delete this coupon?');" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-ticket-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No coupons found</p>
                                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-link text-primary fw-bold text-uppercase fs-11 p-0">Create your first coupon</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($coupons->hasPages())
                    <div class="mt-4">
                        {{ $coupons->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-11 { font-size: 11px; }
    .fs-10 { font-size: 10px; }
    .fs-14 { font-size: 14px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
</style>
@endsection
