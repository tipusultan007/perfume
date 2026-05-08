@extends('admin.layouts.app')

@section('title', 'Edit Coupon')
@section('page_title', 'Edit Coupon')

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Coupons</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Coupon: <span class="text-primary">{{ $coupon->code }}</span></h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Coupon Code</label>
                                <input type="text" name="code" value="{{ old('code', $coupon->code) }}" placeholder="e.g. SUMMER25" 
                                    class="form-control fw-bold text-uppercase @error('code') is-invalid @enderror" required>
                                @error('code') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1" {{ $coupon->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label fs-12 fw-bold text-muted ms-1" for="isActive">ACTIVE STATUS</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Discount Type</label>
                                <select name="type" class="form-select fw-semibold">
                                    <option value="percent" {{ $coupon->type === 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Discount Value</label>
                                <div class="input-group">
                                    <input type="number" name="value" value="{{ old('value', $coupon->value) }}" placeholder="0.00" step="0.01" min="0" 
                                        class="form-control fw-bold @error('value') is-invalid @enderror" required>
                                    @error('value') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4 pb-2 border-bottom"></div>

                        <div class="row mb-4 mt-2">
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Min Spend ($)</label>
                                <input type="number" name="min_spend" value="{{ old('min_spend', $coupon->min_spend) }}" placeholder="Optional" step="0.01" min="0" 
                                    class="form-control fw-semibold">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Usage Limit</label>
                                <input type="number" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="Unlimited if empty" min="1" 
                                    class="form-control fw-semibold">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Expiry Date</label>
                                <input type="date" name="expiry_date" value="{{ old('expiry_date', $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d') : '') }}" 
                                    class="form-control fw-semibold @error('expiry_date') is-invalid @enderror">
                                @error('expiry_date') <div class="invalid-feedback fw-bold">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light px-4 fw-bold text-uppercase fs-11">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold text-uppercase fs-11">
                                <i class="ri-check-line me-1"></i> Update Coupon
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-11 { font-size: 11px; }
    .fs-12 { font-size: 12px; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
