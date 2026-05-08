@extends('admin.layouts.app')

@section('title', 'Edit Campaign')

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.newsletter.index') }}">Newsletter</a></li>
                        <li class="breadcrumb-item active">Edit Campaign</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Campaign</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                        <div>
                            <h4 class="header-title mb-1">Update Campaign Details</h4>
                            <p class="text-muted fs-12 mb-0">Refine your message and update recipient targeting.</p>
                        </div>
                        <a href="{{ route('admin.newsletter.index') }}" class="btn btn-soft-secondary btn-sm rounded-circle p-0 w-8 h-8 d-flex align-items-center justify-center">
                            <i class="ri-arrow-left-line"></i>
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 mb-4" role="alert">
                            <h5 class="alert-heading fs-12 fw-bold text-uppercase tracking-widest"><i class="ri-error-warning-fill me-1"></i> Action Required</h5>
                            <ul class="list-unstyled mb-0 fs-12 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.newsletter.update', $campaign->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-2">Email Subject Line</label>
                                <input type="text" name="subject" value="{{ old('subject', $campaign->subject) }}"
                                    class="form-control form-control-lg fw-bold  shadow-none fs-14"
                                    placeholder="Enter email subject" required>
                                @error('subject') <div class="text-danger fs-11 fw-bold text-uppercase mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-2">Campaign Content</label>
                                <textarea name="content" rows="12"
                                    class="form-control  shadow-none fs-13"
                                    placeholder="Write your email content here (HTML supported)..." required>{{ old('content', $campaign->content) }}</textarea>
                                <div class="d-flex align-items-center gap-2 mt-2 text-muted">
                                    <i class="ri-information-line"></i>
                                    <p class="fs-11 fw-bold text-uppercase tracking-wider mb-0">Basic HTML tags are allowed. An unsubscribe link will be automatically appended.</p>
                                </div>
                                @error('content') <div class="text-danger fs-11 fw-bold text-uppercase mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted mb-3">Target Audience</label>
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <div class="audience-option border rounded-3 p-3 position-relative">
                                            <div class="form-check custom-radio">
                                                <input class="form-check-input" type="radio" name="recipient_type" id="type_all" value="all" 
                                                    {{ old('recipient_type', $campaign->recipient_type) == 'all' ? 'checked' : '' }} onchange="toggleSubscribersList(false)">
                                                <label class="form-check-label ms-2" for="type_all">
                                                    <span class="d-block fw-bold text-dark fs-14">Broadcast to All</span>
                                                    <span class="text-muted fs-11">All {{ $subscribers->count() }} active subscribers</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="audience-option border rounded-3 p-3 position-relative">
                                            <div class="form-check custom-radio">
                                                <input class="form-check-input" type="radio" name="recipient_type" id="type_select" value="select" 
                                                    {{ old('recipient_type', $campaign->recipient_type) == 'select' ? 'checked' : '' }} onchange="toggleSubscribersList(true)">
                                                <label class="form-check-label ms-2" for="type_select">
                                                    <span class="d-block fw-bold text-dark fs-14">Targeted Selection</span>
                                                    <span class="text-muted fs-11">Select specific subscribers manually</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $targetRecipients = $campaign->target_recipients ?? [];
                                    $oldRecipients = old('recipients', $targetRecipients);
                                @endphp

                                <div id="subscribersList" class="collapse {{ old('recipient_type', $campaign->recipient_type) == 'select' ? 'show' : '' }}">
                                    <div class="bg-light rounded-3 p-3 border">
                                        <div class="max-h-80 overflow-y-auto pr-2 custom-scrollbar" style="max-height: 350px;">
                                            <div class="row g-2">
                                                @foreach($subscribers as $subscriber)
                                                <div class="col-md-6">
                                                    <div class="card mb-0 border shadow-none">
                                                        <div class="card-body p-2 px-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input subscriber-checkbox" type="checkbox" 
                                                                    name="recipients[]" value="{{ $subscriber->id }}" id="sub_{{ $subscriber->id }}"
                                                                    {{ (is_array($oldRecipients) && in_array($subscriber->id, $oldRecipients)) ? 'checked' : '' }}
                                                                    {{ old('recipient_type', $campaign->recipient_type) == 'select' ? '' : 'disabled' }}>
                                                                <label class="form-check-label ms-1" for="sub_{{ $subscriber->id }}">
                                                                    <span class="d-block fw-bold text-dark fs-12">{{ $subscriber->email }}</span>
                                                                    <span class="text-muted fs-10 text-uppercase tracking-tighter">Joined {{ $subscriber->created_at->format('M d, Y') }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('recipients') <div class="text-danger fs-11 fw-bold text-uppercase mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-top d-flex flex-wrap gap-2 justify-content-end">
                            <a href="{{ route('admin.newsletter.index') }}" class="btn btn-light px-4 fw-bold text-uppercase fs-11 tracking-widest">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-dark px-4 fw-bold text-uppercase fs-11 tracking-widest shadow-lg">
                                <i class="ri-refresh-line me-1"></i> Update Campaign Details
                            </button>
                        </div>
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
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-8 { width: 32px !important; }
    .h-8 { height: 32px !important; }
    
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    
    .audience-option {
        transition: all 0.2s ease;
        background-color: #fff;
    }
    .audience-option:has(input:checked) {
        border-color: #0f172a !important;
        background-color: rgba(15, 23, 42, 0.02);
    }
    
    .custom-radio .form-check-input:checked {
        background-color: #0f172a;
        border-color: #0f172a;
    }
</style>
@endsection

@section('scripts')
<script>
    function toggleSubscribersList(show) {
        const list = document.getElementById('subscribersList');
        const checkboxes = document.querySelectorAll('.subscriber-checkbox');

        if (show) {
            $(list).collapse('show');
            checkboxes.forEach(cb => cb.disabled = false);
        } else {
            $(list).collapse('hide');
            checkboxes.forEach(cb => cb.disabled = true);
        }
    }
</script>
@endsection
