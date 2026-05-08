@extends('admin.layouts.app')

@section('title', 'Manage Sliders')
@section('page_title', 'Sliders')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Sliders</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Sliders</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-line me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <h4 class="header-title">Slider Records</h4>
                        </div>
                        <div class="col-sm-8 text-sm-end">
                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary"><i class="ri-add-line me-1"></i> Add New Slider</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Title / Subtitle</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sliders as $slider)
                                <tr>
                                    <td>
                                        <img src="{{ $slider->getFirstMediaUrl('slider') }}" alt="Slider Image" class="rounded" height="48">
                                    </td>
                                    <td>
                                        <h5 class="mt-0 mb-1 fs-14 text-dark">{{ $slider->title }}</h5>
                                        <p class="mb-0 text-muted fs-12">{{ $slider->subtitle }}</p>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ str_pad($slider->display_order, 2, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        @if($slider->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                        @else
                                            <span class="badge bg-light text-muted border">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary btn-icon">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-icon">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="ri-image-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-11 tracking-wider">No sliders found</p>
                                            <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-link">Create your first slide</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($sliders->hasPages())
                    <div class="mt-4">
                        {{ $sliders->links() }}
                    </div>
                    @endif
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
@endsection
