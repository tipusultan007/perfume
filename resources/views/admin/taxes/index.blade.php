@extends('admin.layouts.app')

@section('title', 'Tax Settings')
@section('page_title', 'Tax Configurations')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Tax Rates</li>
                    </ol>
                </div>
                <h4 class="page-title">Tax Configurations</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- List of Tax Rates -->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Active Tax Rates</h4>
                    
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-11 fw-bold tracking-wider">
                                    <th>Name / Scope</th>
                                    <th>Rate (%)</th>
                                    <th>Priority</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($taxRates as $rate)
                                <tr>
                                    <td>
                                        <h5 class="my-0 fs-14 fw-bold text-dark">{{ $rate->name }}</h5>
                                        <span class="text-muted fs-11 fw-semibold text-uppercase opacity-75">
                                            Region: {{ $rate->state_code ?? 'Global' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-dark text-dark fw-bold px-2 py-1 fs-12 font-monospace border">
                                            {{ number_format($rate->rate, 3) }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-bold">L{{ $rate->priority }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($rate->is_active)
                                            <span class="badge bg-soft-success text-success rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Active</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.taxes.destroy', $rate) }}" method="POST" 
                                            onsubmit="return confirm('Delete this tax rate?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-percent-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No tax rates defined</p>
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

        <!-- Add New Tax Rate -->
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Add Tax Rate</h4>
                    
                    <form action="{{ route('admin.taxes.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Display Name</label>
                            <input type="text" name="name" required placeholder="e.g. Standard Sales Tax" 
                                class="form-control fw-semibold">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Rate (%)</label>
                                <input type="number" step="0.0001" name="rate" required placeholder="8.875" 
                                    class="form-control fw-bold">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">State (2 Char)</label>
                                <input type="text" name="state_code" maxlength="2" placeholder="AL" 
                                    class="form-control fw-bold text-uppercase">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-wider text-muted">Priority</label>
                            <input type="number" name="priority" value="1" 
                                class="form-control fw-semibold">
                        </div>

                        <div class="bg-light p-3 rounded mb-4">
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked value="1">
                                <label class="form-check-label fs-12 fw-bold text-muted ms-1" for="isActive">ACTIVE STATUS</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_shipping_taxable" id="isShippingTaxable" checked value="1">
                                <label class="form-check-label fs-12 fw-bold text-muted ms-1" for="isShippingTaxable">TAXABLE SHIPPING</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold text-uppercase fs-11 py-2">
                            <i class="ri-save-line me-1"></i> Save Tax Rate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-11 { font-size: 11px; }
    .fs-10 { font-size: 10px; }
    .fs-12 { font-size: 12px; }
    .fs-14 { font-size: 14px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
</style>
@endsection

