@extends('admin.layouts.app')

@section('title', 'Notifications Archive')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">NewKirk</a></li>
                        <li class="breadcrumb-item active">Notifications</li>
                    </ol>
                </div>
                <h4 class="page-title">Communication Center</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-4">
        <div class="col-sm-6">
            <p class="text-muted fs-13 mb-0">Manage your atelier's real-time alerts and communication history.</p>
        </div>
        <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
            @if(auth('admin')->user()->unreadNotifications->count() > 0)
                <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm">
                        <i class="ri-check-double-line me-1"></i> Mark All as Read
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="notification-list-archive">
                @forelse($notifications as $notif)
                    <div class="card mb-3 border-0 shadow-sm {{ $notif->read_at ? 'opacity-75' : 'border-start border-4 border-primary' }}">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="avatar-md bg-soft-{{ $notif->data['type'] == 'order_success' ? 'success' : 'primary' }} text-{{ $notif->data['type'] == 'order_success' ? 'success' : 'primary' }} rounded-circle d-flex align-items-center justify-content-center border">
                                        <i class="ri-{{ $notif->data['type'] == 'order_success' ? 'shopping-cart-2-fill' : 'notification-3-fill' }} fs-20"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-soft-{{ $notif->data['type'] == 'order_success' ? 'success' : 'primary' }} text-{{ $notif->data['type'] == 'order_success' ? 'success' : 'primary' }} fs-10 fw-bold text-uppercase tracking-widest px-2 py-1">
                                            {{ $notif->data['type'] == 'order_success' ? 'Order Successful' : 'System Alert' }}
                                        </span>
                                        <small class="text-muted font-mono fs-11">
                                            {{ $notif->created_at->format('M d, H:i') }} ({{ $notif->created_at->diffForHumans() }})
                                        </small>
                                    </div>
                                    <h5 class="fs-15 fw-bold text-dark mb-1">{{ $notif->data['title'] ?? 'New Notification' }}</h5>
                                    <p class="text-muted mb-3 fs-13 lh-base">{{ $notif->data['message'] }}</p>
                                    
                                    <div class="d-flex align-items-center gap-3">
                                        @if(isset($notif->data['order_id']))
                                            <a href="{{ route('admin.orders.show', $notif->data['order_id']) }}" class="btn btn-sm btn-outline-dark fs-10 fw-bold text-uppercase tracking-widest px-3">
                                                <i class="ri-external-link-line me-1"></i> View Order
                                            </a>
                                        @endif
                                        
                                        @if(!$notif->read_at)
                                            <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-link text-primary fs-11 fw-bold p-0 text-decoration-none">
                                                    <i class="ri-check-line me-1"></i> Mark as Read
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5 text-center">
                            <div class="avatar-lg bg-light text-muted rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4">
                                <i class="ri-notification-off-line fs-32"></i>
                            </div>
                            <h4 class="fw-bold text-dark text-uppercase tracking-widest fs-14 mb-2">No notifications found</h4>
                            <p class="text-muted mb-0 fs-13">Your communication channel is currently quiet. Everything is running smoothly.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
    .fs-10 { font-size: 10px !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-15 { font-size: 15px !important; }
    .fs-20 { font-size: 20px !important; }
    .fs-32 { font-size: 32px !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    
    .bg-soft-primary { background-color: rgba(59, 130, 246, 0.1); }
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    
    .avatar-md { width: 48px; height: 48px; }
    .avatar-lg { width: 64px; height: 64px; }
    
    .opacity-75 { opacity: 0.75; }
</style>
@endsection

