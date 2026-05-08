@extends('admin.layouts.app')

@section('title', 'Newsletter Dashboard')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Communications</a></li>
                        <li class="breadcrumb-item active">Newsletter</li>
                    </ol>
                </div>
                <h4 class="page-title">Newsletter Management</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="header-title mb-1">Campaigns & Subscribers</h4>
                <p class="text-muted fs-12 mb-0">Manage your audience and marketing outreach.</p>
            </div>
            <a href="{{ route('admin.newsletter.create') }}" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-wider">
                <i class="ri-mail-send-line me-1"></i> Create Campaign
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Active Subscribers -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm overflow-hidden h-100">
                <div class="card-header bg-light/30 border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Active Subscribers</h5>
                    <span class="badge bg-dark rounded-pill px-2 py-1 fs-10">{{ $subscribers->total() }} TOTAL</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="bg-light/50">
                                <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                    <th class="ps-4 py-2">Email Address</th>
                                    <th class="py-2">Status</th>
                                    <th class="pe-4 py-2">Joined</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @forelse($subscribers as $subscriber)
                                <tr>
                                    <td class="ps-4 py-3 fw-bold text-dark">{{ $subscriber->email }}</td>
                                    <td>
                                        @if($subscriber->is_subscribed)
                                            <span class="badge bg-soft-success text-success px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Active</span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Unsubscribed</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-muted fs-11 fw-semibold">{{ $subscriber->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-5 text-center">
                                        <div class="text-muted opacity-50 py-4">
                                            <i class="ri-user-add-line fs-36"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-10 tracking-widest mb-0">No subscribers</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($subscribers->hasPages())
                <div class="card-footer bg-light/30 border-top py-3">
                    <div class="pagination-jidox">
                        {{ $subscribers->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Marketing Campaigns -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm overflow-hidden h-100 mt-4 mt-xl-0">
                <div class="card-header bg-light/30 border-bottom py-3">
                    <h5 class="card-title mb-0 fs-13 text-uppercase fw-bold tracking-widest text-dark">Marketing Campaigns</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="bg-light/50">
                                <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                    <th class="ps-4 py-2">Campaign Subject</th>
                                    <th class="py-2">Status</th>
                                    <th class="pe-4 py-2 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @forelse($campaigns as $campaign)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-14 mb-1">{{ $campaign->subject }}</span>
                                            <div class="d-flex align-items-center gap-2 text-muted fs-10 text-uppercase fw-bold tracking-widest">
                                                <span><i class="ri-user-follow-line me-1"></i> {{ $campaign->recipient_count }}</span>
                                                <span class="opacity-25">|</span>
                                                <span>{{ $campaign->sent_at ? $campaign->sent_at->format('M d, Y') : 'Draft' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($campaign->status === 'sent')
                                            <span class="badge bg-soft-success text-success px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Sent</span>
                                        @elseif($campaign->status === 'sending')
                                            <span class="badge bg-soft-info text-info px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold animate-pulse">Sending</span>
                                        @elseif($campaign->status === 'error')
                                            <span class="badge bg-soft-danger text-danger px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Failure</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">Draft</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            @if($campaign->status === 'draft' || $campaign->status === 'error')
                                            <form action="{{ route('admin.newsletter.send', $campaign->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-soft-success btn-sm rounded-circle p-0 w-8 h-8 " title="Send Now" onclick="return confirm('Launch this campaign?')">
                                                    <i class="ri-send-plane-fill"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.newsletter.edit', $campaign->id) }}" class="btn btn-soft-primary btn-sm rounded-circle p-0 w-8 h-8 d-flex justify-content-center align-items-center" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            @endif
                                            
                                            <button onclick="confirmDelete('{{ $campaign->id }}')" class="btn btn-soft-danger btn-sm rounded-circle p-0 w-8 h-8 " title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                            <form id="delete-form-{{ $campaign->id }}" action="{{ route('admin.newsletter.destroy', $campaign->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="py-5 text-center">
                                        <div class="text-muted opacity-50 py-4">
                                            <i class="ri-mail-line fs-36"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-10 tracking-widest mb-0">No campaigns</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($campaigns->hasPages())
                <div class="card-footer bg-light/30 border-top py-3">
                    <div class="pagination-jidox">
                        {{ $campaigns->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
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
    
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    .bg-soft-info { background-color: rgba(6, 182, 212, 0.1); }
    .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1); }
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); }

    /* Fix Laravel Pagination for Jidox */
    .pagination-jidox .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .pagination-jidox .page-link {
        border-radius: 8px !important;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .pagination-jidox .page-item.active .page-link {
        background-color: #0f172a;
        border-color: #0f172a;
        color: white;
    }
</style>
@endsection

@section('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Campaign?',
            text: "This action cannot be undone. Are you sure you want to proceed?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#f43f5e',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-4 overflow-hidden',
                confirmButton: 'btn btn-dark px-4 py-2 uppercase tracking-widest fs-11 fw-bold',
                cancelButton: 'btn btn-light px-4 py-2 uppercase tracking-widest fs-11 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
