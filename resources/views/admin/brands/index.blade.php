@extends('admin.layouts.app')

@section('title', 'Manage Brands')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Catalog</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Brands</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-3">
        <div class="col-12 text-end">
            <a href="{{ route('admin.brands.create') }}" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-wider">
                <i class="ri-add-line me-1"></i> Add New Brand
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert">
            <i class="ri-checkbox-circle-line me-1 align-middle fs-16"></i>
            <span class="fw-bold text-uppercase fs-11 tracking-wider">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                    <th class="ps-4 py-3" style="width: 100px;">Identity</th>
                                    <th class="py-3">Brand Name</th>
                                    <th class="py-3">Slug</th>
                                    <th class="pe-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @forelse($brands as $brand)
                                <tr>
                                    <td class="ps-4 py-3">
                                        @if($brand->getFirstMediaUrl('logo'))
                                            <div class="avatar-md bg-white border border-light rounded p-1 shadow-sm d-flex align-items-center justify-center overflow-hidden" style="width: 48px; height: 48px;">
                                                <img src="{{ $brand->getFirstMediaUrl('logo') }}" alt="{{ $brand->name }}" class="img-fluid object-fit-contain w-100 h-100">
                                            </div>
                                        @else
                                            <div class="avatar-md bg-light border border-dashed rounded d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                                <span class="fs-10 fw-bold opacity-50">NO LOGO</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="my-0 fs-14 fw-bold text-dark text-uppercase tracking-wide">{{ $brand->name }}</h5>
                                    </td>
                                    <td>
                                        <code class="text-muted fw-bold fs-11 tracking-tight text-uppercase">{{ $brand->slug }}</code>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.brands.edit', $brand) }}" 
                                                class="btn btn-soft-warning btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="btn btn-soft-danger btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-5 text-center">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-medal-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No brands found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($brands->hasPages())
                    <div class="px-4 py-3 border-top bg-light/30">
                        <div class="pagination-newkirk">
                            {{ $brands->links() }}
                        </div>
                    </div>
                    @endif
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
    .fs-14 { font-size: 14px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
    
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }

    /* Fix Laravel Pagination for NewKirk */
    .pagination-newkirk .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .pagination-newkirk .page-link {
        border-radius: 8px !important;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .pagination-newkirk .page-item.active .page-link {
        background-color: #0f172a;
        border-color: #0f172a;
        color: white;
    }
</style>
@endsection


