@extends('admin.layouts.app')

@section('title', 'Manage Products')

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
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Products</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="header-title mb-0">Inventory Overview</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.import') }}" class="btn btn-soft-secondary fw-bold text-uppercase fs-11 tracking-wider">
                        <i class="ri-upload-cloud-2-line me-1"></i> Import Products
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-wider">
                        <i class="ri-add-line me-1"></i> Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert">
            <i class="ri-checkbox-circle-line me-1 align-middle fs-16"></i>
            <span class="fw-bold text-uppercase fs-11 tracking-wider">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label text-uppercase fs-10 fw-bold tracking-widest text-muted">Search</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="ri-search-line"></i></span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or SKU..." 
                                    class="form-control border-0 bg-light fw-semibold fs-13">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-uppercase fs-10 fw-bold tracking-widest text-muted">Category</label>
                            <select name="category_id" class="form-select border-0 bg-light fw-semibold fs-13">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-uppercase fs-10 fw-bold tracking-widest text-muted">Brand</label>
                            <select name="brand_id" class="form-select border-0 bg-light fw-semibold fs-13">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-uppercase fs-10 fw-bold tracking-widest text-muted">Type</label>
                            <select name="product_type" class="form-select border-0 bg-light fw-semibold fs-13">
                                <option value="">All Types</option>
                                <option value="simple" {{ request('product_type') == 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="variable" {{ request('product_type') == 'variable' ? 'selected' : '' }}>Variable</option>
                                <option value="bundle" {{ request('product_type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-dark w-100 fw-bold text-uppercase fs-11 tracking-wider py-2">
                                    Filter
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light w-100 fw-bold text-uppercase fs-11 tracking-wider py-2">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                    <th class="ps-4 py-3">Product Information</th>
                                    <th class="py-3">Category</th>
                                    <th class="py-3">Type</th>
                                    <th class="py-3">Price</th>
                                    <th class="py-3 text-center">Featured</th>
                                    <th class="pe-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @forelse($products as $product)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="my-0 fs-14 fw-bold text-dark">{{ $product->name }}</h5>
                                                <div class="d-flex align-items-center gap-2 mt-1">
                                                    <span class="text-muted fs-11 fw-semibold text-uppercase opacity-75">{{ $product->brand->name ?? 'No Brand' }}</span>
                                                    @if($product->size)
                                                        <span class="badge bg-soft-dark text-dark fs-10 fw-bold border">{{ $product->size }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted fw-semibold">{{ $product->category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $product->product_type == 'variable' ? 'bg-soft-info text-info' : 'bg-soft-primary text-primary' }} rounded-pill px-2 py-1 text-uppercase fs-10 tracking-wider fw-bold">
                                            {{ $product->product_type }}
                                            @if($product->product_type == 'variable')
                                                ({{ $product->variants_count ?? $product->variants->count() }})
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark font-monospace fs-14">${{ number_format($product->base_price, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                {{ $product->is_featured ? 'checked' : '' }} 
                                                onchange="toggleFeatured('{{ $product->slug }}', this)">
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-soft-primary btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-content-center" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-soft-warning btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-content-center" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form id="delete-form-{{ $product->slug }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="button" onclick="confirmDelete('{{ $product->slug }}', '{{ addslashes($product->name) }}')" class="btn btn-soft-danger btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-content-center" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-5 text-center">
                                        <div class="text-muted opacity-50">
                                            <i class="ri-archive-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest">No products found</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($products->hasPages())
                    <div class="px-4 py-3 border-top bg-light/30">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-muted fs-12 mb-0">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results</p>
                            <div class="pagination-newkirk">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
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
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
    
    .bg-soft-dark { background-color: rgba(15, 23, 42, 0.1); }
    .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1); }
    .bg-soft-info { background-color: rgba(6, 182, 212, 0.1); }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    
    .form-switch .form-check-input:checked {
        background-color: #0f172a;
        border-color: #0f172a;
    }

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

@section('scripts')
<script>
    function toggleFeatured(id, checkbox) {
        const isChecked = checkbox.checked;
        
        fetch(`/newkirk-management/products/${id}/toggle-featured`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ featured: isChecked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $.toast({
                    heading: 'Success',
                    text: data.message,
                    position: 'top-right',
                    loaderBg: '#0f172a',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 1
                });
            } else {
                checkbox.checked = !isChecked; // Revert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong.'
                });
            }
        })
        .catch(error => {
            checkbox.checked = !isChecked; // Revert
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Internal Server Error'
            });
        });
    }

    function confirmDelete(slug, name) {
        Swal.fire({
            title: 'Delete Product?',
            text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0F172A',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-4 overflow-hidden',
                confirmButton: 'btn btn-dark px-4 py-2 uppercase tracking-widest fs-11 fw-bold',
                cancelButton: 'btn btn-light px-4 py-2 uppercase tracking-widest fs-11 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + slug).submit();
            }
        });
    }
</script>
@endsection


