@extends('admin.layouts.app')

@section('title', 'Global Settings')

@section('content')
<div class="container-fluid" x-data="{ tab: 'general' }">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Global Settings</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-xl-3 col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px; z-index: 10;">
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills settings-nav" role="tablist">
                        <button @click="tab = 'general'" :class="tab === 'general' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-settings-4-line fs-18 me-2"></i> General
                        </button>
                        <button @click="tab = 'contact'" :class="tab === 'contact' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-mail-line fs-18 me-2"></i> Contact
                        </button>
                        <button @click="tab = 'social'" :class="tab === 'social' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-links-line fs-18 me-2"></i> Social
                        </button>
                        <button @click="tab = 'navigation'" :class="tab === 'navigation' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-menu-line fs-18 me-2"></i> Navigation
                        </button>
                        <button @click="tab = 'footer'" :class="tab === 'footer' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-layout-bottom-line fs-18 me-2"></i> Footer
                        </button>
                        <button @click="tab = 'tax'" :class="tab === 'tax' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-percent-line fs-18 me-2"></i> Tax
                        </button>
                        <button @click="tab = 'announcement'" :class="tab === 'announcement' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-notification-badge-line fs-18 me-2"></i> Announcement
                        </button>
                        <button @click="tab = 'integrations'" :class="tab === 'integrations' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-puzzle-line fs-18 me-2"></i> Integrations
                        </button>
                        <button @click="tab = 'status'" :class="tab === 'status' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-shield-flash-line fs-18 me-2"></i> Site Status
                        </button>
                        <button @click="tab = 'mail'" :class="tab === 'mail' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-mail-send-line fs-18 me-2"></i> Email Settings
                        </button>
                        <button @click="tab = 'seo'" :class="tab === 'seo' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-search-eye-line fs-18 me-2"></i> SEO Settings
                        </button>
                        <button @click="tab = 'tools'" :class="tab === 'tools' ? 'active fw-bold' : ''" class="nav-link text-start py-3 px-4 rounded-0 border-bottom d-flex align-items-center">
                            <i class="ri-tools-line fs-18 me-2"></i> System Tools
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="col-xl-9 col-lg-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert">
                    <i class="ri-check-line me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert">
                    <i class="ri-error-warning-line me-1"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- General Tab -->
                    <div x-show="tab === 'general'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">General Configuration</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Standard Branding & Identity</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="update_general" value="1">
                            <div class="mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Site Name</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'NewKirk' }}" class="form-control  shadow-none fs-13">
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Site Description</label>
                                <textarea name="site_description" rows="4" class="form-control  shadow-none fs-13">{{ $settings['site_description'] ?? '' }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Site Logo</label>
                                @if(isset($settings['site_logo']) && !empty($settings['site_logo']))
                                    <div class="mb-3 p-3 bg-light rounded border w-fit">
                                        <img src="{{ str_starts_with($settings['site_logo'], 'http') ? $settings['site_logo'] : asset($settings['site_logo']) }}" alt="Current Logo" class="h-10 object-contain">
                                    </div>
                                @endif
                                <input type="file" name="site_logo" accept="image/*" class="form-control  shadow-none fs-13">
                                <p class="text-muted fs-11 mt-2">Recommended height: 40-60px. Format: PNG, JPG, SVG.</p>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Site Favicon</label>
                                @if(isset($settings['site_favicon']) && !empty($settings['site_favicon']))
                                    <div class="mb-3 p-3 bg-light rounded border w-fit">
                                        <img src="{{ str_starts_with($settings['site_favicon'], 'http') ? $settings['site_favicon'] : asset($settings['site_favicon']) }}" alt="Current Favicon" class="h-8 w-8 object-contain">
                                    </div>
                                @endif
                                <input type="file" name="site_favicon" accept="image/x-icon,image/png,image/svg+xml" class="form-control  shadow-none fs-13">
                                <p class="text-muted fs-11 mt-2">Recommended size: 32x32px. Format: ICO, PNG, SVG.</p>
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save General Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- Contact Tab -->
                    <div x-show="tab === 'contact'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Contact Information</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">How customers can reach you</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_contact" value="1">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Email Address</label>
                                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Phone Number</label>
                                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Office Address</label>
                                <textarea name="contact_address" rows="3" class="form-control  shadow-none fs-13">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Contact Info</button>
                            </div>
                        </form>
                    </div>

                    <!-- Social Tab -->
                    <div x-show="tab === 'social'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Social Media Links</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Connect your platform profiles</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_social" value="1">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Facebook URL</label>
                                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Instagram URL</label>
                                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Twitter / X URL</label>
                                    <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Pinterest URL</label>
                                    <input type="url" name="social_pinterest" value="{{ $settings['social_pinterest'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Social Links</button>
                            </div>
                        </form>
                    </div>

                    <!-- Navigation Tab -->
                    <div x-show="tab === 'navigation'" x-cloak x-data="navigationSettings({{ json_encode($settings['nav_menu_json'] ?? []) }})" class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Custom Navigation Links</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Manage your website's header menu</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_nav" value="1">
                            <input type="hidden" name="nav_menu_json" :value="JSON.stringify(menuItems)">
                            
                            <div class="vstack gap-4">
                                <template x-for="(item, index) in menuItems" :key="index">
                                    <div class="bg-light/30 border rounded-3 p-3 position-relative shadow-sm">
                                        <div class="d-flex gap-3 align-items-start">
                                            <div class="d-flex flex-column gap-1">
                                                <button type="button" @click="moveUp(index)" class="btn btn-sm btn-white border shadow-none p-1">
                                                    <i class="ri-arrow-up-s-line fs-14"></i>
                                                </button>
                                                <button type="button" @click="moveDown(index)" class="btn btn-sm btn-white border shadow-none p-1">
                                                    <i class="ri-arrow-down-s-line fs-14"></i>
                                                </button>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="row g-2 mb-3">
                                                    <div class="col-md-6">
                                                        <input type="text" x-model="item.label" placeholder="Menu Label" class="form-control form-control-sm  shadow-none fw-bold fs-13">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" x-model="item.url" placeholder="URL (e.g. /shop)" class="form-control form-control-sm  shadow-none font-mono fs-12">
                                                    </div>
                                                </div>
                                                
                                                <!-- Children -->
                                                <div class="ms-4 border-start ps-3 vstack gap-2" x-show="item.children && item.children.length > 0">
                                                    <template x-for="(child, cIndex) in item.children" :key="cIndex">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <div class="text-muted"><i class="ri-corner-down-right-line"></i></div>
                                                            <input type="text" x-model="child.label" placeholder="Sub Label" class="form-control form-control-sm  shadow-none fs-12">
                                                            <input type="text" x-model="child.url" placeholder="Sub URL" class="form-control form-control-sm  shadow-none fs-12">
                                                            <button type="button" @click="removeChild(index, cIndex)" class="btn btn-sm text-danger shadow-none p-1">
                                                                <i class="ri-close-circle-line fs-16"></i>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" @click="addChild(index)" class="btn btn-soft-primary btn-sm fs-11 fw-bold text-uppercase px-2">
                                                    <i class="ri-add-line me-1"></i> Child
                                                </button>
                                                <button type="button" @click="removeParent(index)" class="btn btn-soft-danger btn-sm p-1 rounded-circle w-7 h-7 d-flex align-items-center justify-content-center">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4">
                                <button type="button" @click="addParent()" class="btn btn-soft-secondary w-100 border-dashed py-3 fs-11 fw-bold text-uppercase tracking-widest">
                                    <i class="ri-add-circle-line me-1"></i> Add Main Menu Link
                                </button>
                            </div>

                            <div class="text-end border-top mt-4 pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Navigation</button>
                            </div>
                        </form>
                    </div>

                    <!-- Footer Tab -->
                    <div x-show="tab === 'footer'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Footer Configuration</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Website legal & copyright info</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_footer" value="1">
                            <div class="mb-4">
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Copyright Text</label>
                                <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? '© 2026 NewKirk NYC. All rights reserved.' }}" class="form-control  shadow-none fs-13">
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Footer Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tax Tab -->
                    <div x-show="tab === 'tax'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Tax System Switch</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Global toggle for tax calculations</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_tax_settings" value="1">
                            @php $taxEnabled = \App\Models\Setting::get('tax_enabled', false); @endphp
                            
                            <div class="p-4 bg-light rounded border mb-4 d-flex align-items-center justify-content-between">
                                <div class="me-4">
                                    <h5 class="mb-1 fs-14 fw-bold">Enable Tax Calculation</h5>
                                    <p class="text-muted fs-12 mb-0">When active, the system applies defined tax rates during checkout.</p>
                                </div>
                                <div class="form-check form-switch fs-18">
                                    <input class="form-check-input" type="checkbox" name="tax_enabled" value="1" {{ $taxEnabled ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Tax Settings</button>
                            </div>
                        </form>
                    </div>

                    <!-- Announcement Tab -->
                    <div x-show="tab === 'announcement'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Announcement Bar</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Top-level promotion controls</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_announcement_bar" value="1">
                            
                            <div class="p-4 bg-light rounded border mb-4 d-flex align-items-center justify-content-between">
                                <div class="me-4">
                                    <h5 class="mb-1 fs-14 fw-bold">Show Global Announcement Bar</h5>
                                    <p class="text-muted fs-12 mb-0">Toggle visibility of the sticky promotion bar at the top.</p>
                                </div>
                                <div class="form-check form-switch fs-18">
                                    <input class="form-check-input" type="checkbox" name="topbar_visible" value="1" {{ \App\Models\Setting::get('topbar_visible', false) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Background Accent Color</label>
                                    <input type="color" name="topbar_bg" value="{{ $settings['topbar_bg'] ?? '#0F172A' }}" class="form-control form-control-color w-100  shadow-none">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Typography Color</label>
                                    <input type="color" name="topbar_text_color" value="{{ $settings['topbar_text_color'] ?? '#FFFFFF' }}" class="form-control form-control-color w-100  shadow-none">
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between border-top mt-5 pt-4">
                                <a href="{{ route('admin.announcements.index') }}" class="btn btn-soft-secondary btn-sm fs-11 fw-bold text-uppercase px-3">
                                    <i class="ri-edit-circle-line me-1"></i> Manage Content
                                </a>
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Update Styling</button>
                            </div>
                        </form>
                    </div>

                    <!-- Integrations Tab -->
                    <div x-show="tab === 'integrations'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Third-Party Integrations</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Connect External Services</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST" class="vstack gap-4">
                            @csrf
                            <input type="hidden" name="update_integrations" value="1">
                            
                            <div class="p-4 bg-light/50 border rounded-3 shadow-sm">
                                <h5 class="fs-13 fw-bold text-uppercase tracking-widest mb-3">Google Analytics 4</h5>
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Measurement ID (G-XXXXXXXXXX)</label>
                                <input type="text" name="google_analytics_id" value="{{ \App\Models\Setting::get('google_analytics_id') ?? '' }}" placeholder="G-XXXXXXXXXX" class="form-control  shadow-none font-mono fs-13">
                            </div>

                            <div class="p-4 bg-light/50 border rounded-3 shadow-sm">
                                <h5 class="fs-13 fw-bold text-uppercase tracking-widest mb-3">Google reCAPTCHA v2</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Site Key</label>
                                        <input type="text" name="recaptcha_site_key" value="{{ \App\Models\Setting::get('recaptcha_site_key') ?? '' }}" class="form-control  shadow-none font-mono fs-13">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Secret Key</label>
                                        <input type="password" name="recaptcha_secret_key" value="{{ \App\Models\Setting::get('recaptcha_secret_key') ?? '' }}" class="form-control  shadow-none font-mono fs-13">
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-light/50 border rounded-3 shadow-sm">
                                <h5 class="fs-13 fw-bold text-uppercase tracking-widest mb-3">Google Ads</h5>
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Conversion ID (AW-XXXXXXXXX)</label>
                                <input type="text" name="google_ads_id" value="{{ \App\Models\Setting::get('google_ads_id') ?? '' }}" placeholder="AW-XXXXXXXXX" class="form-control  shadow-none font-mono fs-13">
                            </div>

                            <div class="p-4 bg-light/50 border rounded-3 shadow-sm">
                                <h5 class="fs-13 fw-bold text-uppercase tracking-widest mb-3">Meta (Facebook) Pixel</h5>
                                <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Pixel ID</label>
                                <input type="text" name="facebook_pixel_id" value="{{ \App\Models\Setting::get('facebook_pixel_id') ?? '' }}" class="form-control  shadow-none font-mono fs-13">
                            </div>

                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Integration Keys</button>
                            </div>
                        </form>
                    </div>

                    <!-- Site Status Tab -->
                    <div x-show="tab === 'status'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Site Visibility & Status</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Control public access to your boutique</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_site_status" value="1">
                            @php $currentStatus = \App\Models\Setting::get('site_status', 'live'); @endphp

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="status-card h-100">
                                        <input type="radio" name="site_status" value="live" class="d-none" {{ $currentStatus === 'live' ? 'checked' : '' }}>
                                        <div class="card h-100 border text-center p-3 cursor-pointer hover-shadow transition-all border-2 rounded-3 status-check-container">
                                            <i class="ri-global-line fs-32 mb-2 text-success"></i>
                                            <h6 class="text-uppercase tracking-widest fs-12 fw-bold mb-1">Live Mode</h6>
                                            <p class="fs-11 text-muted mb-0">Boutique open for business.</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="status-card h-100">
                                        <input type="radio" name="site_status" value="maintenance" class="d-none" {{ $currentStatus === 'maintenance' ? 'checked' : '' }}>
                                        <div class="card h-100 border text-center p-3 cursor-pointer hover-shadow transition-all border-2 rounded-3 status-check-container">
                                            <i class="ri-hammer-line fs-32 mb-2 text-warning"></i>
                                            <h6 class="text-uppercase tracking-widest fs-12 fw-bold mb-1">Maintenance</h6>
                                            <p class="fs-11 text-muted mb-0">Admins only access.</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="status-card h-100">
                                        <input type="radio" name="site_status" value="coming_soon" class="d-none" {{ $currentStatus === 'coming_soon' ? 'checked' : '' }}>
                                        <div class="card h-100 border text-center p-3 cursor-pointer hover-shadow transition-all border-2 rounded-3 status-check-container">
                                            <i class="ri-timer-flash-line fs-32 mb-2 text-info"></i>
                                            <h6 class="text-uppercase tracking-widest fs-12 fw-bold mb-1">Coming Soon</h6>
                                            <p class="fs-11 text-muted mb-0">Pre-launch splash page.</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Update Visibility</button>
                            </div>
                        </form>
                    </div>

                    <!-- Mail Tab -->
                    <div x-show="tab === 'mail'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Mail Configuration</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">SMTP & Sending Settings</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="update_mail" value="1">
                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail Mailer</label>
                                    <input type="text" name="mail_mailer" value="{{ $settings['mail_mailer'] ?? 'smtp' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail Host</label>
                                    <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail Port</label>
                                    <input type="text" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail Encryption</label>
                                    <input type="text" name="mail_encryption" value="{{ $settings['mail_encryption'] ?? 'tls' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail Username</label>
                                    <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail Password</label>
                                    <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail From Address</label>
                                    <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Mail From Name</label>
                                    <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}" class="form-control  shadow-none fs-13">
                                </div>
                            </div>
                            <div class="text-end border-top pt-4 mb-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Mail Settings</button>
                            </div>
                        </form>

                        <div class="p-4 bg-light/30 border rounded-3 mt-4">
                            <h5 class="fs-13 fw-bold text-uppercase tracking-widest mb-3">Test Connection</h5>
                            <form action="{{ route('admin.settings.test-smtp') }}" method="POST" class="row g-2">
                                @csrf
                                <div class="col flex-grow-1">
                                    <input type="email" name="test_email" placeholder="recipient@example.com" required class="form-control  shadow-none fs-13">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-soft-dark fw-bold text-uppercase fs-11 tracking-widest">Send Test</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- SEO Tab -->
                    <div x-show="tab === 'seo'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Search Engine Optimization</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Meta tags & social sharing</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="update_seo" value="1">
                            <div class="row g-4 mb-4">
                                <div class="col-md-6 border-end">
                                    <h5 class="fs-12 fw-bold text-uppercase tracking-widest text-muted mb-3 border-bottom pb-2">Standard Meta</h5>
                                    <div class="mb-3">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Meta Title</label>
                                        <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}" class="form-control  shadow-none fs-13">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Meta Keywords</label>
                                        <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" class="form-control  shadow-none fs-13">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Meta Description</label>
                                        <textarea name="meta_description" rows="4" class="form-control  shadow-none fs-13">{{ $settings['meta_description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fs-12 fw-bold text-uppercase tracking-widest text-muted mb-3 border-bottom pb-2">Social Graph (OG)</h5>
                                    <div class="mb-3">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Social Title</label>
                                        <input type="text" name="og_title" value="{{ $settings['og_title'] ?? '' }}" class="form-control  shadow-none fs-13">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Social Description</label>
                                        <textarea name="og_description" rows="3" class="form-control  shadow-none fs-13">{{ $settings['og_description'] ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-uppercase fs-11 fw-bold tracking-widest text-muted">Sharing Image</label>
                                        @if(isset($settings['og_image']) && !empty($settings['og_image']))
                                            <div class="mb-3 p-2 bg-light border rounded">
                                                <img src="{{ str_starts_with($settings['og_image'], 'http') ? $settings['og_image'] : asset($settings['og_image']) }}" class="h-16 w-32 object-cover rounded shadow-sm">
                                            </div>
                                        @endif
                                        <input type="file" name="og_image" accept="image/*" class="form-control  shadow-none fs-13">
                                    </div>
                                </div>
                            </div>
                            <div class="text-end border-top pt-4">
                                <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save SEO Settings</button>
                            </div>
                        </form>

                        <div class="mt-5 pt-4 border-top">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="fs-13 fw-bold text-uppercase tracking-widest mb-0">Sitemap Management</h5>
                                <form action="{{ route('admin.settings.generate-sitemap') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-soft-success btn-sm fw-bold text-uppercase fs-11">
                                        <i class="ri-refresh-line me-1"></i> Force Regenerate
                                    </button>
                                </form>
                            </div>
                            
                            @if(!empty($sitemapLinks))
                                <div class="bg-light/30 border rounded-3 p-3 overflow-auto" style="max-height: 300px;">
                                    <div class="vstack gap-2">
                                        @foreach($sitemapLinks as $link)
                                            <div class="d-flex align-items-center justify-content-between p-2 bg-white rounded  shadow-sm">
                                                <code class="fs-11 text-muted">{{ $link }}</code>
                                                <a href="{{ $link }}" target="_blank" class="btn btn-sm btn-light p-1">
                                                    <i class="ri-external-link-line fs-14"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5 bg-light/50 border border-dashed rounded-3">
                                    <i class="ri-file-search-line fs-32 text-muted mb-2 block"></i>
                                    <p class="text-muted fs-11 fw-bold text-uppercase tracking-widest mb-0">No sitemap data available</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- System Tools Tab -->
                    <div x-show="tab === 'tools'" x-cloak class="tab-pane-content">
                        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                            <div>
                                <h4 class="header-title mb-1">Maintenance Tools</h4>
                                <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Manage application performance</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card h-100 border shadow-none bg-light/30">
                                    <div class="card-body text-center p-4">
                                        <div class="w-12 h-12 bg-white rounded-circle shadow-sm border mx-auto d-flex align-items-center justify-content-center mb-3">
                                            <i class="ri-refresh-line fs-24 text-dark"></i>
                                        </div>
                                        <h5 class="fs-14 fw-bold mb-2">Clear Application Cache</h5>
                                        <p class="fs-12 text-muted mb-4">Flush application, config, route, and view caches.</p>
                                        <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Clear all application caches?')" class="btn btn-dark btn-sm w-100 fw-bold text-uppercase fs-11 py-2">Execute Clear</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card h-100 border shadow-none bg-light/30">
                                    <div class="card-body text-center p-4">
                                        <div class="w-12 h-12 bg-white rounded-circle shadow-sm border mx-auto d-flex align-items-center justify-content-center mb-3">
                                            <i class="ri-link-m fs-24 text-dark"></i>
                                        </div>
                                        <h5 class="fs-14 fw-bold mb-2">Fix Storage Link</h5>
                                        <p class="fs-12 text-muted mb-4">Re-generate the public storage symbolic link.</p>
                                        <form action="{{ route('admin.settings.storage-link') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-soft-dark btn-sm w-100 fw-bold text-uppercase fs-11 py-2 border">Create Link</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .fs-11 { font-size: 11px !important; }
    .fs-12 { font-size: 12px !important; }
    .fs-13 { font-size: 13px !important; }
    .fs-14 { font-size: 14px !important; }
    .fs-18 { font-size: 18px !important; }
    .fs-24 { font-size: 24px !important; }
    .fs-32 { font-size: 32px !important; }
    .tracking-widest { letter-spacing: 0.1em; }
    .w-7 { width: 28px !important; }
    .h-7 { height: 28px !important; }
    .w-12 { width: 48px !important; }
    .h-12 { height: 48px !important; }
    .settings-nav .nav-link { color: #6c757d; transition: all 0.2s; }
    .settings-nav .nav-link.active { background-color: #f8f9fa !important; color: #313a46 !important; border-right: 3px solid #313a46 !important; }
    .settings-nav .nav-link:hover:not(.active) { background-color: #f8f9fa; }
    .status-check-container { border-color: transparent; }
    input[type="radio"]:checked + .status-check-container { border-color: #313a46 !important; background-color: #f8f9fa; }
    .hover-shadow:hover { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
</style>
@endsection

@section('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('navigationSettings', (initialData) => ({
            menuItems: initialData || [],
            addParent() {
                this.menuItems.push({ label: '', url: '', children: [] });
            },
            addChild(parentIndex) {
                if (!this.menuItems[parentIndex]) return;
                if (!this.menuItems[parentIndex].children) {
                    this.menuItems[parentIndex].children = [];
                }
                this.menuItems[parentIndex].children.push({ label: '', url: '' });
            },
            removeParent(index) {
                if(confirm('Are you sure you want to remove this menu item and all its children?')) {
                    this.menuItems.splice(index, 1);
                }
            },
            removeChild(pIdx, cIdx) {
                this.menuItems[pIdx].children.splice(cIdx, 1);
            },
            moveUp(index) {
                if(index > 0) {
                    const item = this.menuItems[index];
                    this.menuItems.splice(index, 1);
                    this.menuItems.splice(index - 1, 0, item);
                }
            },
            moveDown(index) {
                if(index < this.menuItems.length - 1) {
                    const item = this.menuItems[index];
                    this.menuItems.splice(index, 1);
                    this.menuItems.splice(index + 1, 0, item);
                }
            }
        }));
    });
</script>
@endsection
