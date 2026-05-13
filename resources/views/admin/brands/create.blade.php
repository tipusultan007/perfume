@extends('admin.layouts.app')

@section('title', 'Add Brand')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Brands</a></li>
                        <li class="breadcrumb-item active">Add Brand</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Brand</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Brand Details</h5>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-light btn-sm">
                        <i class="ri-arrow-left-line me-1"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Brand Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Chanel"
                                class="form-control form-control-lg fs-14">
                            @error('name')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Brand Logo</label>
                            <div class="border border-dashed rounded p-3 bg-light">
                                <input type="file" name="logo" class="form-control fs-12">
                                <p class="mt-2 text-muted fs-10 text-uppercase tracking-widest fw-bold mb-0">Recommended: PNG or SVG with transparent background</p>
                            </div>
                            @error('logo')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Description (Optional)</label>
                            <textarea name="description" rows="4" placeholder="Brief history or style of the brand..."
                                class="form-control fs-14">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger fs-11 mt-1 fw-bold text-uppercase tracking-wider">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-dark w-100 py-3 text-uppercase tracking-widest fs-11 fw-bold shadow-lg">
                                <i class="ri-save-line me-1"></i> Save Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
