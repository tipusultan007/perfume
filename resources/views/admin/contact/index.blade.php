@extends('admin.layouts.app')

@section('title', 'Contact Submissions')

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
                        <li class="breadcrumb-item active">Inquiries</li>
                    </ol>
                </div>
                <h4 class="page-title">Contact Inquiries</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="header-title mb-1">Customer Inbox</h4>
                    <p class="text-muted fs-12 mb-0">Manage and respond to customer support requests.</p>
                </div>
                <span class="badge bg-dark rounded-pill px-3 py-2 fs-10 fw-bold tracking-widest text-uppercase">
                    {{ $submissions->total() }} Total Inquiries
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 table-hover">
                            <thead class="table-light">
                                <tr class="text-uppercase fs-10 fw-bold tracking-widest text-muted">
                                    <th class="ps-4 py-3" style="width: 100px;">Status</th>
                                    <th class="py-3">Sender Information</th>
                                    <th class="py-3">Inquiry Subject</th>
                                    <th class="py-3">Received Date</th>
                                    <th class="pe-4 py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fs-13">
                                @forelse($submissions as $submission)
                                <tr>
                                    <td class="ps-4 py-3">
                                        @if($submission->status === 'unread')
                                            <span class="badge bg-soft-success text-success px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold border border-success/10">NEW</span>
                                        @else
                                            <span class="badge bg-soft-secondary text-secondary px-2 py-1 rounded-pill text-uppercase fs-10 tracking-wider fw-bold">READ</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-14 mb-1">{{ $submission->name }}</span>
                                            <span class="text-muted fs-11 fw-semibold">{{ $submission->email }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $submission->subject ?? 'General Inquiry' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-11 fw-semibold">{{ $submission->created_at->format('M d, Y H:i') }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <a href="{{ route('admin.contact-submissions.show', $submission->id) }}" 
                                                class="btn btn-soft-primary btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center" title="View Message">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <button onclick="confirmDelete('{{ $submission->id }}')" 
                                                class="btn btn-soft-danger btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center" title="Delete Submission">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                            <form id="delete-form-{{ $submission->id }}" action="{{ route('admin.contact-submissions.destroy', $submission->id) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center">
                                        <div class="text-muted opacity-50 py-5">
                                            <i class="ri-inbox-archive-line fs-48"></i>
                                            <p class="mt-2 fw-bold text-uppercase fs-12 tracking-widest mb-0">Inbox is empty</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($submissions->hasPages())
                    <div class="px-4 py-3 border-top bg-light/30">
                        <div class="pagination-newkirk">
                            {{ $submissions->links() }}
                        </div>
                    </div>
                    @endif
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
    
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    .bg-soft-secondary { background-color: rgba(100, 116, 139, 0.1); }
    .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1); }

    /* Fix Laravel Pagination for NewKirk */
    .pagination-newkirk .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .pagination-newkirk .page-link {
        border-radius: 8px !important;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        border: 1px solid #e2e8f0;
    }
    .pagination-newkirk .page-item.active .page-link {
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
            title: 'Delete Submission?',
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


