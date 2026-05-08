@extends('admin.layouts.app')

@section('title', 'Manage Categories')

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
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
                <h4 class="page-title">Product Categories</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-3">
        <div class="col-12 text-end">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-wider">
                <i class="ri-add-line me-1"></i> Add New Category
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
                                    <th class="ps-4 py-3">Category Name</th>
                                    <th class="py-3">URL Slug</th>
                                    <th class="py-3">Parent Hierarchy</th>
                                    <th class="py-3">Product Count</th>
                                    <th class="pe-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @forelse($categories as $category)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <h5 class="my-0 fs-14 fw-bold text-dark">{{ $category->name }}</h5>
                                    </td>
                                    <td>
                                        <code class="text-muted fw-bold fs-11 tracking-tight">{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">
                                                {{ $category->parent->name }}
                                            </span>
                                        @else
                                            <span class="text-muted opacity-50 italic fs-12">Top Level</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-dark fs-14">{{ $category->products_count ?? 0 }}</span>
                                            <span class="text-muted fs-10 text-uppercase tracking-widest fw-bold">Items</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                                class="btn btn-soft-warning btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
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
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-node-tree fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No categories defined</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($categories->hasPages())
                    <div class="px-4 py-3 border-top bg-light/30">
                        <div class="pagination-newkirk">
                            {{ $categories->links() }}
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
    
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); }
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


