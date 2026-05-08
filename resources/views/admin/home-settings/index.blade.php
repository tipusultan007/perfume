@extends('admin.layouts.app')

@section('title', 'Home Page Settings')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                        <li class="breadcrumb-item active">Home Settings</li>
                    </ol>
                </div>
                <h4 class="page-title">Home Page Customization</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 mb-4 shadow-sm" role="alert">
            <i class="ri-check-line me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Section Visibility Control -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                        <div>
                            <h4 class="header-title mb-1">Home Page Sections</h4>
                            <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-0">Toggle which modules are visible on the storefront</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.home-settings.visibility') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            @php
                                $sections = [
                                    'hero' => 'Hero Slider',
                                    'categories' => 'Category Collection',
                                    'promo_banners' => 'Promo Banners (Top)',
                                    'banner_signature' => 'Banner: Signature Scents',
                                    'recent_arrivals' => 'Recent Arrivals',
                                    'cta' => 'CTA Section (Confidence)',
                                    'featured' => 'Featured Products',
                                    'banner_seasonal' => 'Banner: Seasonal Picks',
                                    'special_offers' => 'Special Offers',
                                    'banner_engraving' => 'Banner: Exclusive Engraving',
                                    'clearance' => 'Limited/Clearance',
                                    'banner_final' => 'Banner: Final Call',
                                    'testimonials' => 'Testimonials',
                                    'banner_elite' => 'Banner: Elite Collection',
                                    'services' => 'Services (Footer)',
                                    'newsletter' => 'Newsletter Form'
                                ];
                            @endphp

                            @foreach($sections as $key => $label)
                                <div class="col-md-6 col-lg-3">
                                    <div class="p-3 border rounded-3 bg-light/30 transition-all hover-shadow">
                                        <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0 mb-0">
                                            <label class="form-check-label fw-bold text-uppercase fs-10 tracking-widest text-muted mb-0" for="show_{{ $key }}">{{ $label }}</label>
                                            <input class="form-check-input ms-0 mt-0 h-4 w-8" type="checkbox" name="show_{{ $key }}" id="show_{{ $key }}" value="1" {{ \App\Models\Setting::get('home_show_'.$key, 1) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-top text-end">
                            <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">
                                <i class="ri-save-line me-1"></i> Save Visibility
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Configuration Columns -->
        <div class="col-lg-8">
            <!-- Hero Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="header-title mb-1">Hero Section</h4>
                    <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-4">Main attraction of the homepage</p>
                    
                    <form action="{{ route('admin.home-settings.hero') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4 pb-3 border-bottom">
                             <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest mb-3">Slider Design Concept</label>
                             <div class="d-flex gap-4">
                                 <div class="form-check custom-radio">
                                     <input type="radio" id="style_default" name="hero_style" value="default" {{ ($heroStyle ?? 'default') == 'default' ? 'checked' : '' }} class="form-check-input">
                                     <label class="form-check-label fs-13" for="style_default">Standard Presentation</label>
                                 </div>
                                 <div class="form-check custom-radio">
                                     <input type="radio" id="style_modern" name="hero_style" value="modern" {{ ($heroStyle ?? 'default') == 'modern' ? 'checked' : '' }} class="form-check-input">
                                     <label class="form-check-label fs-13 fw-bold text-primary" for="style_modern">Modern 3D Experience</label>
                                 </div>
                             </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Main Title</label>
                                <input type="text" name="title" value="{{ $hero->title ?? '' }}" class="form-control  shadow-none fs-13" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Subtitle</label>
                                <input type="text" name="subtitle" value="{{ $hero->subtitle ?? '' }}" class="form-control  shadow-none fs-13">
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Button Text</label>
                                <input type="text" name="button_text" value="{{ $hero->button_text ?? '' }}" class="form-control  shadow-none fs-13">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Button Link</label>
                                <input type="text" name="button_link" value="{{ $hero->button_link ?? '' }}" class="form-control  shadow-none font-mono fs-12">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Background Image URL</label>
                            <input type="text" name="image_path" value="{{ $hero->image_path ?? '' }}" class="form-control  shadow-none fs-13 font-mono" placeholder="https://images.unsplash.com/...">
                        </div>
                        <div class="text-end border-top pt-4">
                            <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Hero Section</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Heritage Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h4 class="header-title mb-1">Heritage Section</h4>
                    <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-4">Brand Story & Legacy Branding</p>
                    
                    <form action="{{ route('admin.home-settings.heritage') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Section Title</label>
                                <input type="text" name="title" value="{{ $heritage->title ?? '' }}" class="form-control  shadow-none fs-13" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Badge/Subtitle</label>
                                <input type="text" name="subtitle" value="{{ $heritage->subtitle ?? '' }}" class="form-control  shadow-none fs-13">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Content Text</label>
                            <textarea name="content" rows="4" class="form-control  shadow-none fs-13">{{ $heritage->content ?? '' }}</textarea>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">CTA Button Text</label>
                                <input type="text" name="button_text" value="{{ $heritage->button_text ?? '' }}" class="form-control  shadow-none fs-13">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">CTA Button Link</label>
                                <input type="text" name="button_link" value="{{ $heritage->button_link ?? '' }}" class="form-control  shadow-none font-mono fs-12">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest">Section Image URL</label>
                            <input type="text" name="image_path" value="{{ $heritage->image_path ?? '' }}" class="form-control  shadow-none font-mono fs-13" placeholder="https://images.unsplash.com/...">
                        </div>
                        <div class="text-end border-top pt-4">
                            <button type="submit" class="btn btn-dark fw-bold text-uppercase fs-11 tracking-widest px-4">Save Heritage Section</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Curation -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 100px; z-index: 10;">
                <div class="card-body p-4">
                    <h4 class="header-title mb-1">Curation</h4>
                    <p class="text-muted fs-12 text-uppercase tracking-widest fw-bold mb-4">Pin items to your landing page</p>
                    
                    <form action="{{ route('admin.home-settings.curation') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest mb-3 border-bottom w-100 pb-2">Main Categories (Max 4)</label>
                            <div class="overflow-auto border rounded-3 p-2 bg-light/30 vstack gap-1" style="max-height: 250px;">
                                @foreach($categories as $category)
                                <div class="form-check p-2 rounded transition-all hover-bg-light">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ $category->show_on_home ? 'checked' : '' }}>
                                    <label class="form-check-label fs-13 cursor-pointer fw-medium" for="cat_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted tracking-widest mb-3 border-bottom w-100 pb-2">Featured Collection</label>
                            <div class="overflow-auto border rounded-3 p-2 bg-light/30 vstack gap-1" style="max-height: 250px;">
                                @foreach($products as $product)
                                <div class="form-check p-2 rounded transition-all hover-bg-light">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="products[]" value="{{ $product->id }}" id="prod_{{ $product->id }}" {{ $product->is_featured ? 'checked' : '' }}>
                                    <label class="form-check-label fs-13 text-truncate d-inline-block cursor-pointer fw-medium" style="max-width: 80%;" for="prod_{{ $product->id }}">
                                        {{ $product->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold text-uppercase fs-12 tracking-widest shadow-lg">
                            <i class="ri-checkbox-circle-line me-1"></i> Apply Changes
                        </button>
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
    .tracking-widest { letter-spacing: 0.1em; }
    .hover-shadow:hover { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
    .hover-bg-light:hover { background-color: #f1f3fa !important; }
    .cursor-pointer { cursor: pointer; }
</style>
@endsection
