@extends('admin.layouts.app')

@section('title', 'Edit Slider')
@section('page_title', 'Sliders')

@section('content')
<div x-data="sliderPreview()" class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">NewKirk</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Sliders</a></li>
                        <li class="breadcrumb-item active">Edit Slide</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Slider</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-7 col-lg-12">
            <div class="mb-4 d-flex align-items-center gap-2">
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="ri-arrow-left-line"></i> Back to List
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading fs-14 fw-bold text-uppercase tracking-wider">Validation Errors</h4>
                    <ul class="mb-0 fs-12">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Basic Information</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Slide Title</label>
                                <input type="text" name="title" x-model="title" value="{{ old('title', $slider->title) }}" placeholder="e.g. Luxury Scent Collection" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Subtitle / Small Text</label>
                                <input type="text" name="subtitle" x-model="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="e.g. New Arrivals 2026" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Main Description</label>
                                <textarea name="description" x-model="description" rows="3" placeholder="Enter the descriptive text that appears on the slide..." class="form-control">{{ old('description', $slider->description) }}</textarea>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Call to Action Text</label>
                                <input type="text" name="button_text" x-model="button_text" value="{{ old('button_text', $slider->button_text) }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Destination URL</label>
                                <input type="text" name="button_link" value="{{ old('button_link', $slider->button_link) }}" class="form-control">
                            </div>
                        </div>

                        <div class="row g-3 mt-1 align-items-center">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Display Priority (Order)</label>
                                <input type="number" name="display_order" value="{{ old('display_order', $slider->display_order) }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <div class="p-2 border rounded bg-light mt-4">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                                        <label class="form-check-label fw-bold text-uppercase fs-11 tracking-wider mb-0" for="is_active">Visibility Status</label>
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Dynamic Styling & Theme</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Background Accent</label>
                                <div class="input-group">
                                    <input type="color" name="bg_color" x-model="bg_color" class="form-control form-control-color p-1" style="width: 50px;">
                                    <input type="text" class="form-control bg-light fs-12 font-monospace" x-model="bg_color" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">UI Theme Mode</label>
                                <select name="ui_theme" x-model="ui_theme" class="form-select">
                                    <option value="dark">Dark (For Light BGs)</option>
                                    <option value="light">Light (For Dark BGs)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Interaction Color</label>
                                <div class="input-group">
                                    <input type="color" name="accent_color" x-model="accent_color" class="form-control form-control-color p-1" style="width: 50px;">
                                    <input type="text" class="form-control bg-light fs-12 font-monospace" x-model="accent_color" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Icons Main</label>
                                <input type="color" name="social_color" x-model="social_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Icons Hover BG</label>
                                <input type="color" name="social_hover_color" x-model="social_hover_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Icons Color</label>
                                <input type="color" name="social_icon_color" x-model="social_icon_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Icons Hover</label>
                                <input type="color" name="social_icon_hover_color" x-model="social_icon_hover_color" class="form-control form-control-color w-100 p-1">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Nav Main</label>
                                <input type="color" name="nav_color" x-model="nav_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Nav Hover BG</label>
                                <input type="color" name="nav_hover_color" x-model="nav_hover_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Nav Icon Color</label>
                                <input type="color" name="nav_icon_color" x-model="nav_icon_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Nav Hover Icon</label>
                                <input type="color" name="nav_icon_hover_color" x-model="nav_icon_hover_color" class="form-control form-control-color w-100 p-1">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Title Color</label>
                                <input type="color" name="title_color" x-model="title_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Desc Color</label>
                                <input type="color" name="description_color" x-model="description_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Price Color</label>
                                <input type="color" name="price_color" x-model="price_color" class="form-control form-control-color w-100 p-1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-10 text-muted text-uppercase fw-bold">Line Color</label>
                                <input type="color" name="line_color" x-model="line_color" class="form-control form-control-color w-100 p-1">
                            </div>
                        </div>

                        <div class="row g-3 mt-4 p-3 bg-dark rounded border border-secondary shadow-sm mx-0">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-light opacity-75">Display Price</label>
                                <input type="text" name="price" x-model="price" value="{{ old('price', $slider->price) }}" placeholder="e.g. $145.00" class="form-control bg-transparent text-white border-secondary fw-bold font-monospace">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-light opacity-75">Fragrance Notes</label>
                                <input type="text" name="top_notes" x-model="top_notes" value="{{ old('top_notes', $slider->top_notes) }}" placeholder="e.g. Mint, Bergamot & Ozone" class="form-control bg-transparent text-white border-secondary">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Slide Media</h4>
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted">Current Image</label>
                            <div class="mb-3">
                                <img src="{{ $slider->getFirstMediaUrl('slider') }}" alt="Current Slider Image" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted">Update Image</label>
                            <div class="p-4 border-2 border-dashed rounded text-center bg-light position-relative hover-bg-light transition-all">
                                <input type="file" name="image" @change="previewImage($event)" class="position-absolute w-100 h-100 top-0 start-0 opacity-0 cursor-pointer" style="z-index: 10;" accept="image/*">
                                <div class="py-3">
                                    <i class="ri-image-add-line fs-32 text-muted"></i>
                                    <p class="mt-2 fw-bold text-uppercase fs-11 tracking-wider text-dark">Drop new image here or click to browse</p>
                                    <p class="mb-0 fs-10 text-muted fw-semibold">JPEG, PNG OR WEBP • MAX 2MB • RECOMMENDED 1920x800</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold text-uppercase tracking-widest fs-14 shadow-lg">
                        <i class="ri-save-line me-1"></i> Update Slider Configuration
                    </button>
                </div>
            </form>
        </div>

        <!-- Live Preview -->
        <div class="col-xl-5 d-none d-xl-block">
            <div class="sticky-top" style="top: 100px;">
                <div class="card border-0 shadow-lg overflow-hidden">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fs-12 text-uppercase fw-bold text-muted tracking-widest">
                            <i class="ri-eye-line me-1 text-primary"></i> Real-time Preview
                        </h5>
                        <span class="badge bg-success-subtle text-success">Active Preview</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="preview-canvas overflow-hidden" 
                             :style="'background-color: ' + bg_color + '; color: ' + title_color">
                            
                            <div class="position-relative h-[600px] d-flex align-items-center justify-content-center p-4 overflow-hidden" style="height: 500px;">
                                <!-- Background Text -->
                                <h1 class="position-absolute start-50 top-50 translate-middle font-serif fw-bold select-none opacity-5 uppercase tracking-tighter text-nowrap"
                                    :class="ui_theme === 'dark' ? 'c-text-outline-dark' : 'c-text-outline'"
                                    style="font-size: 120px;"
                                    x-text="title.split(' ')[0] || 'LUXURY'">
                                </h1>

                                <div class="position-relative z-index-1 w-100 row align-items-center gx-4">
                                    <div class="col-7">
                                        <p class="tracking-widest fs-10 fw-bold text-uppercase mb-2" :style="'color: ' + accent_color">No. 01</p>
                                        <h2 class="font-serif fw-bold mb-3" style="font-size: 2.2rem; line-height: 1.1;" x-html="title.replace(' ', '<br>') || 'Luxury<br>Scent'"></h2>
                                        <p class="fs-12 font-light text-muted mb-4 opacity-75" :style="'color: ' + description_color" x-text="description || 'Slide description will appear here...'"></p>
                                        
                                        <div class="d-flex align-items-center gap-3 pt-2">
                                            <div class="rounded-circle border d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" :style="'border-color: ' + accent_color + '; color: ' + accent_color">
                                                <i class="ri-arrow-right-line"></i>
                                            </div>
                                            <span class="fs-10 text-uppercase fw-bold tracking-widest" x-text="button_text"></span>
                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <div class="mb-4" x-show="top_notes">
                                            <h4 class="fs-10 text-uppercase tracking-widest opacity-40 mb-2">Top Notes</h4>
                                            <p class="font-serif fs-13 border-start border-2 ps-3" :style="'border-color: ' + accent_color" x-html="top_notes.replace('&', '&<br>')"></p>
                                        </div>
                                        
                                        <div x-show="price">
                                            <span class="fs-24 font-serif" :style="'color: ' + price_color" x-text="price"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottle Image -->
                                <div class="position-absolute top-50 start-50 translate-middle w-100 h-100 d-flex align-items-center justify-content-center pointer-events-none" style="z-index: 0;">
                                    <img :src="imagePreview" x-show="imagePreview" class="h-75 object-fit-contain drop-shadow-2xl">
                                </div>

                                <!-- Overlay UI Elements -->
                                <div class="position-absolute bottom-0 start-0 p-4 d-flex gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;" :style="'background-color: ' + social_color + '; color: ' + social_icon_color">
                                        <i class="ri-facebook-fill fs-12"></i>
                                    </div>
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;" :style="'background-color: ' + social_color + '; color: ' + social_icon_color">
                                        <i class="ri-instagram-line fs-12"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div class="row align-items-center g-3">
                            <div class="col-6">
                                <div class="p-2 border rounded bg-light text-center">
                                    <h5 class="fs-10 fw-bold text-muted text-uppercase mb-2">Hover States</h5>
                                    <div class="d-flex justify-content-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 32px; height: 32px;" :style="'background-color: ' + social_hover_color + '; color: ' + social_icon_hover_color">
                                            <i class="ri-share-line"></i>
                                        </div>
                                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 32px; height: 32px;" :style="'background-color: ' + nav_hover_color + '; color: ' + nav_icon_hover_color">
                                            <i class="ri-arrow-right-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2 border rounded bg-white text-center d-flex flex-column align-items-center justify-content-center">
                                    <div class="rounded-pill mb-1" style="width: 4px; height: 24px;" :style="'background-color: ' + line_color"></div>
                                    <span class="fs-9 fw-bold text-muted text-uppercase tracking-tighter">Accent</span>
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
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap');
    .font-serif { font-family: 'Playfair Display', serif; }
    .fs-24 { font-size: 24px; }
    .fs-32 { font-size: 32px; }
    .fs-9 { font-size: 9px; }
    .tracking-widest { letter-spacing: 0.15em; }
    .c-text-outline { -webkit-text-stroke: 1px rgba(255,255,255,0.2); color: transparent; }
    .c-text-outline-dark { -webkit-text-stroke: 1px rgba(0,0,0,0.1); color: transparent; }
    .preview-canvas { transition: all 0.5s ease; border-radius: 20px; }
    .drop-shadow-2xl { filter: drop-shadow(0 25px 25px rgba(0, 0, 0, 0.15)); }
    .hover-bg-light:hover { background-color: #f8f9fa !important; border-color: #adb5bd !important; }
</style>

<script>
function sliderPreview() {
    return {
        title: '{{ old('title', $slider->title) }}',
        subtitle: '{{ old('subtitle', $slider->subtitle) }}',
        description: '{{ old('description', $slider->description) }}',
        button_text: '{{ old('button_text', $slider->button_text) }}',
        bg_color: '{{ old('bg_color', $slider->bg_color ?? '#FDFCF8') }}',
        accent_color: '{{ old('accent_color', $slider->accent_color ?? '#D4AF37') }}',
        ui_theme: '{{ old('ui_theme', $slider->ui_theme) }}',
        social_color: '{{ old('social_color', $slider->social_color ?? '#111827') }}',
        social_hover_color: '{{ old('social_hover_color', $slider->social_hover_color ?? '#D4AF37') }}',
        social_icon_color: '{{ old('social_icon_color', $slider->social_icon_color ?? '#FFFFFF') }}',
        social_icon_hover_color: '{{ old('social_icon_hover_color', $slider->social_icon_hover_color ?? '#111827') }}',
        nav_color: '{{ old('nav_color', $slider->nav_color ?? '#111827') }}',
        nav_hover_color: '{{ old('nav_hover_color', $slider->nav_hover_color ?? '#D4AF37') }}',
        nav_icon_color: '{{ old('nav_icon_color', $slider->nav_icon_color ?? '#FFFFFF') }}',
        nav_icon_hover_color: '{{ old('nav_icon_hover_color', $slider->nav_icon_hover_color ?? '#111827') }}',
        line_color: '{{ old('line_color', $slider->line_color ?? '#D4AF37') }}',
        title_color: '{{ old('title_color', $slider->title_color ?? '#111827') }}',
        description_color: '{{ old('description_color', $slider->description_color ?? '#6B7280') }}',
        price_color: '{{ old('price_color', $slider->price_color ?? '#111827') }}',
        price: '{{ old('price', $slider->price) }}',
        top_notes: '{{ old('top_notes', $slider->top_notes) }}',
        imagePreview: '{{ $slider->getFirstMediaUrl('slider') }}',
        
        previewImage(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (f) => {
                this.imagePreview = f.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
}
</script>
@endsection

