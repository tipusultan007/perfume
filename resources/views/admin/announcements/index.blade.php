@extends('admin.layouts.app')

@section('title', 'Manage Announcements')

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
                        <li class="breadcrumb-item active">Announcements</li>
                    </ol>
                </div>
                <h4 class="page-title">Top Bar Announcements</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4" role="alert">
            <i class="ri-check-line me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light/30 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="header-title mb-0">Active Announcements</h5>
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-dark btn-sm fw-bold text-uppercase fs-11 tracking-widest px-3">
                        <i class="ri-add-line me-1"></i> Add Announcement
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0">
                            <thead class="bg-light/50">
                                <tr>
                                    <th class="ps-4 text-uppercase fs-11 fw-bold tracking-widest text-muted border-0">Content</th>
                                    <th class="text-uppercase fs-11 fw-bold tracking-widest text-muted border-0">Order</th>
                                    <th class="text-uppercase fs-11 fw-bold tracking-widest text-muted border-0">Status</th>
                                    <th class="pe-4 text-uppercase fs-11 fw-bold tracking-widest text-muted border-0 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $announcement)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-medium text-dark text-truncate" style="max-width: 400px;">{{ $announcement->content }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-dark border fw-bold">{{ $announcement->display_order }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if($announcement->is_active)
                                            <span class="badge bg-soft-success text-success px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Active</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-soft-primary btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-content-center" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-content-center" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-5 text-center text-muted fs-12 fw-bold text-uppercase tracking-widest">
                                        No announcements found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fs-10 { font-size: 10px !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); }
</style>
@endsection
