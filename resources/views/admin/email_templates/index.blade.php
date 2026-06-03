@extends('admin.layouts.app')

@section('title', 'Email Templates')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Email Templates</li>
                    </ol>
                </div>
                <h4 class="page-title">Email Templates</h4>
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

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                    <th class="ps-4 py-3">Template Name</th>
                                    <th class="py-3">Subject</th>
                                    <th class="py-3">Last Updated</th>
                                    <th class="pe-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @foreach($templates as $template)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <h5 class="my-0 fs-14 fw-bold text-dark">{{ ucwords(str_replace('_', ' ', $template->name)) }}</h5>
                                        <span class="text-muted fs-11 font-monospace">{{ $template->name }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $template->subject }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-12">{{ $template->updated_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.email-templates.edit', $template) }}" 
                                                class="btn btn-soft-warning btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
    
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
</style>
@endsection
