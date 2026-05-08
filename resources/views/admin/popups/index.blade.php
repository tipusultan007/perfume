@extends('admin.layouts.app')

@section('title', 'Manage Popups')
@section('page_title', 'Popups')

@section('content')
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Popups</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Offers Popups</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom">
                    <h4 class="header-title mb-0">Active Popups</h4>
                    <a href="{{ route('admin.popups.create') }}" class="btn btn-primary shadow-sm">
                        <i class="ri-add-line me-1"></i> Add New Popup
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="ri-check-line me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-uppercase fs-11 tracking-wider text-muted font-bold" style="width: 150px;">Image</th>
                                    <th class="text-uppercase fs-11 tracking-wider text-muted font-bold">Title / Link</th>
                                    <th class="text-uppercase fs-11 tracking-wider text-muted font-bold">Schedule</th>
                                    <th class="text-uppercase fs-11 tracking-wider text-muted font-bold">Status</th>
                                    <th class="text-uppercase fs-11 tracking-wider text-muted font-bold text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($popups as $popup)
                                <tr>
                                    <td>
                                        <div class="avatar-lg bg-light rounded p-1 border">
                                            @if($popup->hasMedia('popup'))
                                                <img src="{{ $popup->getFirstMediaUrl('popup') }}" alt="Popup Image" class="img-fluid rounded">
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="ri-image-line fs-24"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="m-0 font-14">{{ $popup->title }}</h5>
                                        <p class="mb-0 text-muted fs-12 font-monospace">{{ Str::limit($popup->link, 40) }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <span class="badge bg-info-subtle text-info fs-10 text-uppercase fw-bold">
                                                Start: {{ $popup->start_date ? $popup->start_date->format('M d, Y H:i') : 'Immediate' }}
                                            </span>
                                            <span class="badge bg-warning-subtle text-warning fs-10 text-uppercase fw-bold">
                                                End: {{ $popup->end_date ? $popup->end_date->format('M d, Y H:i') : 'Never' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" 
                                                class="form-check-input status-toggle" 
                                                data-id="{{ $popup->id }}"
                                                data-url="{{ route('admin.popups.toggle-status', $popup) }}"
                                                {{ $popup->is_active ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.popups.edit', $popup) }}" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form action="{{ route('admin.popups.destroy', $popup) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Delete">
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
                                            <i class="ri-notification-badge-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-11 tracking-wider">No popups discovered</p>
                                            <a href="{{ route('admin.popups.create') }}" class="btn btn-sm btn-outline-primary mt-2">Create your first popup</a>
                                        </div>
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
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const url = this.getAttribute('data-url');
            
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    $.toast({
                        heading: 'Success!',
                        text: result.message,
                        position: 'top-right',
                        loaderBg: '#5ba035',
                        icon: 'success',
                        hideAfter: 3000,
                        stack: 1
                    });
                } else {
                    this.checked = !this.checked; // Revert
                    $.toast({
                        heading: 'Error',
                        text: 'Failed to update status.',
                        position: 'top-right',
                        loaderBg: '#bf441d',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 1
                    });
                }
            } catch (error) {
                this.checked = !this.checked; // Revert
                console.error('Toggle error:', error);
            }
        });
    });
</script>
@endsection
