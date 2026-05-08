@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">View Product</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $product->name }}</h4>
            </div>
        </div>
    </div>

    <!-- Header Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card mb-0 shadow-none bg-transparent">
                <div class="card-body p-0 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                        <div>
                            <h5 class="m-0 fw-semibold">{{ $product->name }}</h5>
                            <p class="text-muted mb-0 fs-11 text-uppercase tracking-wider">
                                {{ ucfirst($product->product_type) }} Product • {{ $product->sku ?? 'No SKU' }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary px-4">
                            <i class="ri-edit-line me-1"></i> Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Media & Gallery -->
        <div class="col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-2">
                    <div class="bg-light rounded overflow-hidden">
                        @if($product->getFirstMediaUrl('featured'))
                            <img src="{{ $product->getFirstMediaUrl('featured') }}" class="img-fluid w-100 object-fit-cover aspect-ratio-1x1 rounded">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light-subtle text-muted fs-11 text-uppercase tracking-widest rounded" style="aspect-ratio: 1/1;">No Image</div>
                        @endif
                    </div>
                </div>
            </div>

            @if($product->getMedia('gallery')->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase tracking-wider">Gallery</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        @foreach($product->getMedia('gallery') as $media)
                        <div class="col-4">
                            <div class="border rounded p-1">
                                <img src="{{ $media->getUrl() }}" class="img-fluid rounded object-fit-cover aspect-ratio-1x1">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- SEO Data -->
            <div class="card border-0 shadow-sm mt-4 bg-light-subtle">
                <div class="card-body">
                    <h5 class="card-title mb-3 fs-12 text-uppercase tracking-wider border-bottom pb-2">SEO Preview</h5>
                    <div class="mb-3">
                        <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Meta Title</label>
                        <p class="fw-semibold mb-0 fs-13 text-primary">{{ $product->meta_title ?? $product->name }}</p>
                    </div>
                    <div>
                        <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Meta Description</label>
                        <p class="text-muted mb-0 fs-12 lh-base">{{ $product->meta_description ?? Str::limit(strip_tags($product->description), 150) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Details -->
        <div class="col-lg-8 col-xl-9">
            <!-- Basic Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fs-14 text-uppercase tracking-wider">Product Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 col-6 mb-3 mb-md-0">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Category</label>
                            <span class="fw-semibold fs-14">{{ $product->category->name }}</span>
                        </div>
                        <div class="col-md-3 col-6 mb-3 mb-md-0">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Brand</label>
                            <span class="fw-semibold fs-14">{{ $product->brand->name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Base Price</label>
                            <span class="fw-bold fs-15 text-primary">${{ number_format($product->base_price, 2) }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Total Stock</label>
                            <span class="badge {{ ($product->product_type == 'variable' ? $product->variants->sum('stock_quantity') : $product->stock_quantity) < 10 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-2 py-1 fs-12">
                                {{ $product->product_type == 'variable' ? $product->variants->sum('stock_quantity') : $product->stock_quantity }} units
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Short Description</label>
                        <p class="text-muted fs-13 leading-relaxed mb-0">{{ $product->short_description ?? 'No short description provided.' }}</p>
                    </div>

                    <div>
                        <label class="text-muted fs-10 text-uppercase tracking-widest mb-2 d-block border-bottom pb-1">Full Description</label>
                        <div class="fs-14 text-muted lh-lg">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scent Profile -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 fs-14 text-uppercase tracking-wider">Scent Profile & Attributes</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4 mb-4">
                        <div class="col-md-3 col-6">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Gender</label>
                            <span class="fw-semibold fs-13">{{ $product->gender ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Concentration</label>
                            <span class="fw-semibold fs-13">{{ $product->concentration ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Size</label>
                            <span class="fw-semibold fs-13">{{ $product->size ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Season</label>
                            <span class="fw-semibold fs-13">{{ $product->season ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Top Notes</label>
                            <p class="fs-13 text-muted mb-0">{{ $product->top_notes ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Heart Notes</label>
                            <p class="fs-13 text-muted mb-0">{{ $product->heart_notes ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted fs-10 text-uppercase tracking-widest mb-1 d-block">Base Notes</label>
                            <p class="fs-13 text-muted mb-0">{{ $product->base_notes ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants -->
            @if($product->product_type === 'variable')
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-14 text-uppercase tracking-wider">Product Variants</h5>
                    <span class="badge bg-primary-subtle text-primary">{{ $product->variants->count() }} Variants</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light-subtle">
                                <tr>
                                    <th class="ps-3 fs-11 text-uppercase tracking-widest text-muted border-0">Combination</th>
                                    <th class="fs-11 text-uppercase tracking-widest text-muted border-0">SKU</th>
                                    <th class="fs-11 text-uppercase tracking-widest text-muted border-0">Price</th>
                                    <th class="fs-11 text-uppercase tracking-widest text-muted border-0">Stock</th>
                                    <th class="pe-3 text-center fs-11 text-uppercase tracking-widest text-muted border-0">Image</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @foreach($product->variants as $variant)
                                <tr>
                                    <td class="ps-3 py-3">
                                        <span class="fw-medium">{{ $variant->attributeValues->pluck('value')->join(' / ') }}</span>
                                    </td>
                                    <td class="text-muted font-monospace">{{ $variant->sku }}</td>
                                    <td>
                                        @if($variant->sale_price)
                                            <span class="text-danger fw-semibold">${{ number_format($variant->sale_price, 2) }}</span>
                                            <del class="text-muted fs-11 ms-1">${{ number_format($variant->price, 2) }}</del>
                                        @else
                                            <span class="fw-semibold">${{ number_format($variant->price, 2) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $variant->stock_quantity < 10 ? 'bg-danger-subtle text-danger' : 'bg-success-subtle text-success' }} px-2">
                                            {{ $variant->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="pe-3 text-center">
                                        @if($variant->getFirstMediaUrl('variant_image'))
                                            <img src="{{ $variant->getFirstMediaUrl('variant_image') }}" class="rounded shadow-sm border" style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded border d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="ri-image-line text-muted fs-14"></i>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
