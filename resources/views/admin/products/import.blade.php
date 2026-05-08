@extends('admin.layouts.app')

@section('title', 'Import Products')

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
                <h4 class="page-title">Bulk Product Import</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 md:p-5">
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                        <div>
                            <h4 class="header-title mb-1">Import from Excel/CSV</h4>
                            <p class="text-muted fs-12 mb-0">Upload your product inventory file below.</p>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-soft-secondary btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert">
                            <ul class="list-unstyled mb-0 fs-12 fw-bold text-uppercase tracking-wider">
                                @foreach ($errors->all() as $error)
                                    <li><i class="ri-error-warning-line me-1"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-2">Select Inventory File</label>
                            <div class="bg-light p-4 rounded-3 border-2 border-dashed border-slate-200 text-center position-relative group-hover">
                                <input type="file" name="file" id="file" required
                                    class="form-control fw-bold border-0 bg-white py-3 shadow-sm">
                                <div class="mt-2">
                                    <p class="text-muted fs-11 mb-0 italic">Supported: .xlsx, .xls, .csv (Max 10MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-soft-dark border-0 mb-4">
                            <div class="card-body">
                                <h5 class="fs-11 text-uppercase fw-bold tracking-widest text-dark mb-3 border-bottom border-dark/10 pb-2">
                                    <i class="ri-information-line me-1"></i> File Header Requirements
                                </h5>
                                <p class="text-muted fs-12 mb-3">Ensure your file contains these exact headers in the first row:</p>
                                <div class="d-flex flex-wrap gap-1">
                                    @php
                                        $headers = ['Brand', 'Name', 'Size', 'Gender', 'Notes', 'Description', 'Concentration', 'Season', 'Top Notes', 'Heart Notes', 'Base Notes', 'Intensity'];
                                    @endphp
                                    @foreach($headers as $header)
                                        <span class="badge bg-white text-dark border fs-10 fw-bold px-2 py-1 text-uppercase">{{ $header }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold text-uppercase fs-11 tracking-widest shadow-lg">
                            <i class="ri-rocket-2-line me-1"></i> Start Import Process
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-10 { font-size: 10px !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    .bg-soft-dark { background-color: rgba(15, 23, 42, 0.05); }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
</style>
@endsection
