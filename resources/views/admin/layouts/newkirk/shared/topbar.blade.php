<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="{{ route('admin.dashboard') }}" class="logo-light">
                    <span class="logo-lg">
                        <h3 class="text-white mt-3 font-serif tracking-widest">{{ \App\Models\Setting::get('site_name', 'NewKirk') }}</h3>
                    </span>
                    <span class="logo-sm">
                        <h3 class="text-white mt-3">N</h3>
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="{{ route('admin.dashboard') }}" class="logo-dark">
                    <span class="logo-lg">
                        <h3 class="text-dark mt-3 font-serif tracking-widest">{{ \App\Models\Setting::get('site_name', 'NewKirk') }}</h3>
                    </span>
                    <span class="logo-sm">
                        <h3 class="text-dark mt-3">N</h3>
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="ri-menu-2-fill"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-notification-3-fill fs-22"></i>
                    @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="noti-icon-badge">{{ $unreadNotificationsCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                    <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fs-16 fw-semibold"> Notification</h6>
                            </div>
                            <div class="col-auto">
                                @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                    <form action="{{ route('admin.notifications.read-all') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-dark text-decoration-underline border-0">
                                            <small>Clear All</small>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="max-height: 300px;" data-simplebar>
                        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
                            <h5 class="text-muted fs-12 fw-bold p-2 text-uppercase mb-0">Unread Notifications</h5>
                            @foreach($unreadNotifications as $notification)
                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST" id="notify-form-{{ $notification->id }}">
                                    @csrf
                                    <a href="javascript:void(0);" onclick="document.getElementById('notify-form-{{ $notification->id }}').submit();" class="dropdown-item p-0 notify-item unread-noti card m-0 shadow-none">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="ri-message-3-line fs-18"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 text-truncate ms-2">
                                                    <h5 class="noti-item-title fw-semibold fs-14">
                                                        {{ $notification->data['title'] ?? 'New Notification' }}
                                                        <small class="fw-normal text-muted float-end ms-1">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </h5>
                                                    <small class="noti-item-subtitle text-muted">{{ $notification->data['message'] ?? '' }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </form>
                            @endforeach
                        @else
                            <div class="p-4 text-center">
                                <i class="ri-notification-off-line fs-24 text-muted"></i>
                                <p class="text-muted mb-0 mt-2">No new notifications</p>
                            </div>
                        @endif
                    </div>

                    <!-- All-->
                    <a href="{{ route('admin.notifications.index') }}" class="dropdown-item text-center text-primary text-decoration-underline fw-bold notify-item border-top border-light py-2">
                        View All
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold bg-primary" style="width: 32px; height: 32px;">
                            {{ substr(auth('admin')->user()->name, 0, 1) }}
                        </div>
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">
                            {{ auth('admin')->user()->name }}
                        </h5>
                        <h6 class="my-0 fw-normal">Administrator</h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                        <i class="ri-account-circle-fill fs-18 align-middle me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                        <i class="ri-settings-4-fill fs-18 align-middle me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="ri-logout-box-fill fs-18 align-middle me-1"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->
