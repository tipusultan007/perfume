@extends('admin.layouts.app')

@section('title', 'Edit Popup')
@section('page_title', 'Popups')

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
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Popup</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-8 col-lg-12">
            <div class="mb-4 d-flex align-items-center gap-2">
                <a href="{{ route('admin.popups.index') }}" class="btn btn-sm btn-outline-dark">
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

            <form id="popup-form" action="{{ route('admin.popups.update', $popup) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Popup Media</h4>
                        <div class="mb-4">
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted">Current Image</label>
                            <div class="mb-3">
                                @if($popup->hasMedia('popup'))
                                    <img src="{{ $popup->getFirstMediaUrl('popup') }}" alt="Current Popup" class="img-thumbnail" style="max-height: 150px;" id="current-popup-image">
                                @else
                                    <div class="p-3 bg-light border rounded text-muted">No image assigned</div>
                                @endif
                            </div>
                            
                            <label class="form-label text-uppercase fs-11 fw-bold text-muted">Update Image</label>
                            <div class="p-4 border-2 border-dashed rounded text-center bg-light position-relative hover-bg-light transition-all">
                                <input type="file" name="image" class="position-absolute w-100 h-100 top-0 start-0 opacity-0 cursor-pointer" style="z-index: 10;" accept="image/*">
                                <div class="py-3" id="upload-placeholder">
                                    <i class="ri-image-add-line fs-32 text-muted"></i>
                                    <p class="mt-2 fw-bold text-uppercase fs-11 tracking-wider text-dark">Drop new image here or click to browse</p>
                                    <p class="mb-0 fs-10 text-muted fw-semibold">JPG, PNG OR WEBP • MAX 2MB</p>
                                </div>
                                <div id="image-preview-container" class="d-none py-2">
                                    <img id="image-preview-element" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                                    <p class="mt-2 mb-0 fs-10 text-primary fw-bold text-uppercase">Click or drag to change image</p>
                                </div>
                            </div>
                            <div id="image-error" class="d-none mt-2 text-danger fs-11 fw-bold text-uppercase"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">General Content</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Title</label>
                                <input type="text" name="title" value="{{ old('title', $popup->title) }}" placeholder="e.g. Summer Sale" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Subtitle</label>
                                <input type="text" name="subtitle" value="{{ old('subtitle', $popup->subtitle) }}" placeholder="e.g. 50% Off Everything" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Description</label>
                                <textarea name="description" rows="3" placeholder="Enter popup description..." class="form-control">{{ old('description', $popup->description) }}</textarea>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Link (Optional)</label>
                                <input type="text" name="link" value="{{ old('link', $popup->link) }}" placeholder="https://..." class="form-control font-monospace fs-12">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">CTA Text</label>
                                <input type="text" name="cta_text" value="{{ old('cta_text', $popup->cta_text) }}" placeholder="e.g. Shop Now" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Design & Typography</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Design Template</label>
                                <select name="template_id" class="form-select">
                                    <option value="luxury-minimalist" {{ $popup->template_id == 'luxury-minimalist' ? 'selected' : '' }}>Luxury Minimalist</option>
                                    <option value="elegant-sidebar" {{ $popup->template_id == 'elegant-sidebar' ? 'selected' : '' }}>Elegant Sidebar</option>
                                    <option value="modern-glass" {{ $popup->template_id == 'modern-glass' ? 'selected' : '' }}>Modern Glass</option>
                                    <option value="dark-gold" {{ $popup->template_id == 'dark-gold' ? 'selected' : '' }}>Dark Gold</option>
                                    <option value="vintage-classic" {{ $popup->template_id == 'vintage-classic' ? 'selected' : '' }}>Vintage Classic</option>
                                    <option value="floating-minimalist" {{ $popup->template_id == 'floating-minimalist' ? 'selected' : '' }}>Floating Minimalist</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Luxury Font Family</label>
                                <select name="font_family" class="form-select">
                                    <option value="Cormorant Garamond" {{ $popup->font_family == 'Cormorant Garamond' ? 'selected' : '' }}>Cormorant Garamond</option>
                                    <option value="Playfair Display" {{ $popup->font_family == 'Playfair Display' ? 'selected' : '' }}>Playfair Display</option>
                                    <option value="Cinzel" {{ $popup->font_family == 'Cinzel' ? 'selected' : '' }}>Cinzel (Classic)</option>
                                    <option value="Montserrat" {{ $popup->font_family == 'Montserrat' ? 'selected' : '' }}>Montserrat (Minimal)</option>
                                    <option value="Outfit" {{ $popup->font_family == 'Outfit' ? 'selected' : '' }}>Outfit (Modern Luxury)</option>
                                    <option value="Prata" {{ $popup->font_family == 'Prata' ? 'selected' : '' }}>Prata (High Contrast)</option>
                                    <option value="La Belle Aurore" {{ $popup->font_family == 'La Belle Aurore' ? 'selected' : '' }}>La Belle Aurore (Script)</option>
                                    <option value="Bodoni Moda" {{ $popup->font_family == 'Bodoni Moda' ? 'selected' : '' }}>Bodoni Moda (Fashion)</option>
                                    <option value="Josefin Sans" {{ $popup->font_family == 'Josefin Sans' ? 'selected' : '' }}>Josefin Sans (Vintage)</option>
                                    <option value="Syncopate" {{ $popup->font_family == 'Syncopate' ? 'selected' : '' }}>Syncopate (Minimalist)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Scheduling & Status</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">Start Date & Time</label>
                                <input type="datetime-local" name="start_date" value="{{ old('start_date', $popup->start_date ? $popup->start_date->format('Y-m-d\TH:i') : '') }}" class="form-control font-monospace fs-12">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-uppercase fs-11 fw-bold text-muted">End Date & Time</label>
                                <input type="datetime-local" name="end_date" value="{{ old('end_date', $popup->end_date ? $popup->end_date->format('Y-m-d\TH:i') : '') }}" class="form-control font-monospace fs-12">
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                                        <div>
                                            <label class="form-check-label fw-bold text-uppercase fs-11 tracking-wider mb-0" for="show_newsletter">Show Newsletter</label>
                                            <p class="text-muted fs-10 mb-0 uppercase tracking-tighter">Include subscription form</p>
                                        </div>
                                        <input class="form-check-input ms-0" type="checkbox" name="show_newsletter" id="show_newsletter" value="1" {{ $popup->show_newsletter ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded bg-light">
                                    <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                                        <div>
                                            <label class="form-check-label fw-bold text-uppercase fs-11 tracking-wider mb-0" for="is_active">Active Status</label>
                                            <p class="text-muted fs-10 mb-0 uppercase tracking-tighter">Enable this popup immediately</p>
                                        </div>
                                        <input class="form-check-input ms-0" type="checkbox" name="is_active" id="is_active" value="1" {{ $popup->is_active ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5 d-flex gap-2">
                    <button type="button" onclick="previewPopup()" class="btn btn-outline-primary btn-lg flex-grow-1 py-3 fw-bold text-uppercase tracking-widest fs-12">
                        <i class="ri-eye-line me-1"></i> Live Preview
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1 py-3 fw-bold text-uppercase tracking-widest fs-12 shadow-lg">
                        <i class="ri-refresh-line me-1"></i> Update Popup Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-popup :isPreview="true" />

<style>
    .avatar-lg { height: 4.5rem; width: 4.5rem; }
    .fs-11 { font-size: 11px; }
    .fs-10 { font-size: 10px; }
    .tracking-widest { letter-spacing: 0.1em; }
    .hover-bg-light:hover { background-color: #f8f9fa !important; border-color: #adb5bd !important; }
</style>

<script>
    // Image Preview Logic
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const placeholder = document.getElementById('upload-placeholder');
        const container = document.getElementById('image-preview-container');
        const img = document.getElementById('image-preview-element');
        const errorContainer = document.getElementById('image-error');

        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                errorContainer.innerText = 'Image size too large. Max 2MB allowed.';
                errorContainer.classList.remove('d-none');
                this.value = ''; 
                return;
            }
            errorContainer.classList.add('d-none');

            const reader = new FileReader();
            reader.onload = function(event) {
                img.src = event.target.result;
                placeholder.classList.add('d-none');
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    function previewPopup() {
        const form = document.getElementById('popup-form');
        const formData = new FormData(form);
        const newsletterInput = form.querySelector('input[name=show_newsletter]');
        
        const data = {
            title: formData.get('title'),
            subtitle: formData.get('subtitle'),
            description: formData.get('description'),
            link: formData.get('link'),
            cta_text: formData.get('cta_text'),
            template_id: formData.get('template_id'),
            font_family: formData.get('font_family'),
            show_newsletter: newsletterInput ? newsletterInput.checked : false,
            image_preview: null
        };

        const imageInput = form.querySelector('input[name=image]');
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                data.image_preview = e.target.result;
                window.dispatchEvent(new CustomEvent('open-popup-preview', { detail: data }));
            }
            reader.readAsDataURL(imageInput.files[0]);
        } else {
            const existingImg = document.getElementById('current-popup-image');
            if(existingImg) data.image_preview = existingImg.src;
            window.dispatchEvent(new CustomEvent('open-popup-preview', { detail: data }));
        }
    }

    // AJAX Submission
    document.getElementById('popup-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Updating...';

        const formData = new FormData(form);
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                $.toast({
                    heading: 'Success!',
                    text: result.message,
                    position: 'top-right',
                    loaderBg: '#5ba035',
                    icon: 'success',
                    hideAfter: 2000,
                    stack: 1,
                    afterHidden: function () {
                        window.location.href = result.redirect;
                    }
                });
            } else {
                let errorMessage = result.message || 'Something went wrong.';
                if (result.errors) {
                    errorMessage = Object.values(result.errors).flat().join('<br>');
                }
                
                $.toast({
                    heading: 'Validation Error',
                    text: errorMessage,
                    position: 'top-right',
                    loaderBg: '#bf441d',
                    icon: 'error',
                    hideAfter: 5000,
                    stack: 1
                });
            }
        } catch (error) {
            console.error('Submission error:', error);
            $.toast({
                heading: 'Error',
                text: "An error occurred during submission.",
                position: 'top-right',
                loaderBg: '#bf441d',
                icon: 'error',
                hideAfter: 5000,
                stack: 1
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    });
</script>
@endsection
