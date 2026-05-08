@extends('admin.layouts.app')

@section('title', 'Edit Announcement')

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.announcements.index') }}">Announcements</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Announcement</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                        <h5 class="header-title mb-0">Update Details</h5>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-soft-secondary btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-content-center">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                    </div>

                    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-2">Announcement Content</label>
                                <textarea name="content" rows="4" 
                                    class="form-control border-light shadow-none fs-13" 
                                    placeholder="Enter the message for the top bar announcement..." required>{{ old('content', $announcement->content) }}</textarea>
                                @error('content')
                                    <div class="text-danger fs-11 fw-bold text-uppercase mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-2">Display Order</label>
                                <input type="number" name="display_order" value="{{ old('display_order', $announcement->display_order) }}" 
                                    class="form-control border-light shadow-none fs-13" placeholder="0">
                                @error('display_order')
                                    <div class="text-danger fs-11 fw-bold text-uppercase mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-2">Current Status</label>
                                <select name="is_active" class="form-select border-light shadow-none fs-13">
                                    <option value="1" {{ old('is_active', $announcement->is_active) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !old('is_active', $announcement->is_active) ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark px-4 fw-bold text-uppercase fs-11 tracking-widest shadow-lg">
                                <i class="ri-refresh-line me-1"></i> Update Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <h5 class="header-title text-white mb-3">Announcement Tip</h5>
                    <p class="fs-13 opacity-75 mb-0">
                        Updating an announcement will reflect immediately on the storefront. Use display order to prioritize which message appears first if multiple announcements are active.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-11 { font-size: 11px !important; }
    .fs-13 { font-size: 13px !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
</style>
@endsection
