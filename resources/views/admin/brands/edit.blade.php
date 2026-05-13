@extends('admin.layouts.app')

@section('title', 'Edit Brand')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Brands</a></li>
                        <li class="breadcrumb-item active">Edit Brand</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Brand: {{ $brand->name }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Update Details</h5>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Brand Name</label>
                            <input type="text" name="name" value="{{ old('name', $brand->name) }}" required
                                class="form-control form-control-lg fs-14">
                            @error('name')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Brand Logo</label>
                            <div class="row align-items-center g-3">
                                @if($brand->getFirstMediaUrl('logo'))
                                <div class="col-auto">
                                    <div class="avatar-xl bg-white border rounded p-2 shadow-sm d-flex align-items-center justify-content-center overflow-hidden" style="width: 100px; height: 100px;">
                                        <img src="{{ $brand->getFirstMediaUrl('logo') }}" alt="{{ $brand->name }}" class="img-fluid object-fit-contain w-100 h-100">
                                    </div>
                                </div>
                                @endif
                                <div class="col">
                                    <div class="border border-dashed rounded p-3 bg-light">
                                        <input type="file" name="logo" class="form-control fs-12">
                                        <p class="mt-2 text-muted fs-10 text-uppercase tracking-widest fw-bold mb-0">Upload to replace existing logo (PNG/SVG)</p>
                                    </div>
                                </div>
                            </div>
                            @error('logo')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Description (Optional)</label>
                            <textarea name="description" rows="4" 
                                class="form-control fs-14">{{ old('description', $brand->description) }}</textarea>
                            @error('description')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-dark w-100 py-3 text-uppercase tracking-widest fs-11 fw-bold shadow-lg">
                                <i class="ri-refresh-line me-1"></i> Update Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
