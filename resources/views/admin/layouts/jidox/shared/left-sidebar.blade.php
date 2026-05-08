<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
        <span class="logo-lg">
            <h3 class="text-white mt-3 font-serif tracking-widest text-uppercase" style="font-weight: 700; letter-spacing: 2px;">{{ \App\Models\Setting::get('site_name', 'NewKirk') }}</h3>
        </span>
        <span class="logo-sm">
            <h3 class="text-white mt-3 fw-bold">N</h3>
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
        <span class="logo-lg">
            <h3 class="text-dark mt-3 font-serif tracking-widest text-uppercase" style="font-weight: 700; letter-spacing: 2px;">{{ \App\Models\Setting::get('site_name', 'NewKirk') }}</h3>
        </span>
        <span class="logo-sm">
            <h3 class="text-dark mt-3 fw-bold">N</h3>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        
        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title mt-1">General</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                    <i class="ri-dashboard-2-fill"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.home-settings.index') }}" class="side-nav-link">
                    <i class="ri-home-7-line"></i>
                    <span> Home Settings </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.sliders.index') }}" class="side-nav-link">
                    <i class="ri-gallery-line"></i>
                    <span> Hero Sliders </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.popups.index') }}" class="side-nav-link">
                    <i class="ri-window-line"></i>
                    <span> Offers Popups </span>
                </a>
            </li>

            <li class="side-nav-title mt-2">Catalog</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarProducts" aria-expanded="false" aria-controls="sidebarProducts" class="side-nav-link">
                    <i class="ri-archive-line"></i>
                    <span> Products </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarProducts">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('admin.products.index') }}">All Products</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.products.import') }}">Import Products</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.categories.index') }}" class="side-nav-link">
                    <i class="ri-stack-line"></i>
                    <span> Categories </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.brands.index') }}" class="side-nav-link">
                    <i class="ri-medal-line"></i>
                    <span> Brands </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.attributes.index') }}" class="side-nav-link">
                    <i class="ri-list-settings-line"></i>
                    <span> Attributes </span>
                </a>
            </li>

            <li class="side-nav-title mt-2">Sales</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.orders.index') }}" class="side-nav-link">
                    <i class="ri-shopping-bag-3-line"></i>
                    <span> Orders </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.customers.index') }}" class="side-nav-link">
                    <i class="ri-user-heart-line"></i>
                    <span> Customers </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.coupons.index') }}" class="side-nav-link">
                    <i class="ri-ticket-line"></i>
                    <span> Coupons </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.reports.index') }}" class="side-nav-link">
                    <i class="ri-bar-chart-2-line"></i>
                    <span> Reports </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.newsletter.index') }}" class="side-nav-link">
                    <i class="ri-mail-send-line"></i>
                    <span> Newsletter </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.contact-submissions.index') }}" class="side-nav-link">
                    <i class="ri-question-answer-line"></i>
                    <span> Contact Inquiries </span>
                </a>
            </li>

            <li class="side-nav-title mt-2">Configuration</li>

            <li class="side-nav-item">
                <a href="{{ route('admin.taxes.index') }}" class="side-nav-link">
                    <i class="ri-percent-line"></i>
                    <span> Tax Rates </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.settings.index') }}" class="side-nav-link">
                    <i class="ri-settings-4-line"></i>
                    <span> Global Settings </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('admin.announcements.index') }}" class="side-nav-link">
                    <i class="ri-notification-badge-line"></i>
                    <span> Announcements </span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
