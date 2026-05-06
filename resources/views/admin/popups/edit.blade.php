@extends('admin.layouts.app')

@section('title', 'Edit Popup')
@section('page_title', 'Popups')

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.popups.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-bold text-2xl text-slate-900">Edit Popup</h3>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 text-rose-700 p-6 mb-10 rounded-xl border border-rose-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <i class="ri-error-warning-line text-xl"></i>
                <span class="text-[11px] uppercase tracking-widest font-bold">Validation Errors</span>
            </div>
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-[10px] uppercase tracking-widest font-bold opacity-80">• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-slate-200 p-8 md:p-12 rounded-2xl shadow-sm overflow-hidden">
        <form id="popup-form" action="{{ route('admin.popups.update', $popup) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')
            
            <!-- Image Upload -->
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Popup Image</label>
                <div class="flex items-center gap-6">
                    <div class="shrink-0">
                         <div class="w-32 h-32 bg-slate-50 rounded-xl border-2 border-dashed border-slate-200 flex items-center justify-center text-slate-300 overflow-hidden relative group">
                            @if($popup->hasMedia('popup'))
                                <img src="{{ $popup->getFirstMediaUrl('popup') }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-[9px] font-bold uppercase tracking-widest">Change</span>
                                </div>
                            @else
                                <i class="ri-image-add-line text-3xl"></i>
                            @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <input type="file" name="image" class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-3 file:px-6
                            file:rounded-full file:border-0
                            file:text-[10px] file:font-bold file:uppercase file:tracking-widest
                            file:bg-slate-900 file:text-white
                            hover:file:bg-slate-800 file:transition-all cursor-pointer"
                        />
                         <p class="mt-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest">Supports JPG, PNG, GIF. Max 2MB. Leave empty to keep current image.</p>
                         <p id="image-error" class="hidden mt-2 text-[10px] text-rose-500 font-bold uppercase tracking-widest"></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Title</label>
                    <input type="text" name="title" value="{{ old('title', $popup->title) }}" placeholder="e.g. Summer Sale"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Subtitle</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $popup->subtitle) }}" placeholder="e.g. 50% Off Everything"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Description</label>
                <textarea name="description" rows="3" placeholder="Enter popup description..."
                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('description', $popup->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Link (Optional)</label>
                    <input type="text" name="link" value="{{ old('link', $popup->link) }}" placeholder="https://..."
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-mono">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">CTA Text</label>
                    <input type="text" name="cta_text" value="{{ old('cta_text', $popup->cta_text) }}" placeholder="e.g. Shop Now"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Design Template</label>
                    <select name="template_id" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium appearance-none">
                        <option value="luxury-minimalist" {{ $popup->template_id == 'luxury-minimalist' ? 'selected' : '' }}>Luxury Minimalist</option>
                        <option value="elegant-sidebar" {{ $popup->template_id == 'elegant-sidebar' ? 'selected' : '' }}>Elegant Sidebar</option>
                        <option value="modern-glass" {{ $popup->template_id == 'modern-glass' ? 'selected' : '' }}>Modern Glass</option>
                        <option value="dark-gold" {{ $popup->template_id == 'dark-gold' ? 'selected' : '' }}>Dark Gold</option>
                        <option value="vintage-classic" {{ $popup->template_id == 'vintage-classic' ? 'selected' : '' }}>Vintage Classic</option>
                        <option value="floating-minimalist" {{ $popup->template_id == 'floating-minimalist' ? 'selected' : '' }}>Floating Minimalist</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Luxury Font Family</label>
                    <select name="font_family" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium appearance-none">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Start Date & Time</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date', $popup->start_date ? $popup->start_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-mono">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">End Date & Time</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date', $popup->end_date ? $popup->end_date->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="flex items-center justify-between p-6 bg-slate-50 border border-slate-200 rounded-xl">
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Show Newsletter</h4>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-1">Include subscription form</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="show_newsletter" value="1" {{ $popup->show_newsletter ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900 shadow-inner"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between p-6 bg-slate-50 border border-slate-200 rounded-xl">
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Active Status</h4>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-1">Enable this popup</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $popup->is_active ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end items-center gap-4 pt-8 border-t border-slate-100">
                <button type="button" onclick="previewPopup()" class="bg-white text-slate-900 border border-slate-200 px-8 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                    <i class="ri-eye-line mr-2"></i> Live Preview
                </button>
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Update Popup
                </button>
            </div>
        </form>
    </div>
</div>

<x-popup :isPreview="true" />

<script>
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

        // Handle image preview
        const imageInput = form.querySelector('input[name=image]');
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                data.image_preview = e.target.result;
                window.dispatchEvent(new CustomEvent('open-popup-preview', { detail: data }));
            }
            reader.readAsDataURL(imageInput.files[0]);
        } else {
            // If no new image, try to get existing one from the img tag
            const existingImg = document.querySelector('.w-32.h-32 img');
            if(existingImg) data.image_preview = existingImg.src;
            window.dispatchEvent(new CustomEvent('open-popup-preview', { detail: data }));
        }
    }

    // Image size validation
    document.querySelector('input[name="image"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const errorContainer = document.getElementById('image-error');
        if (file && file.size > 2 * 1024 * 1024) { // 2MB
            errorContainer.innerText = 'Image size too large. Max 2MB allowed.';
            errorContainer.classList.remove('hidden');
            this.value = ''; // Reset input
        } else {
            errorContainer.classList.add('hidden');
        }
    });

    // AJAX Submission
    document.getElementById('popup-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerText;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin mr-2"></i> Updating...';

        const formData = new FormData(form);
        formData.append('_method', 'PUT'); // Ensure PUT request for update
        
        try {
            const response = await fetch(form.action, {
                method: 'POST', // Browser fetch doesn't support PUT with FormData natively in some contexts, Laravel uses _method
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: result.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = result.redirect;
                });
            } else {
                // Handle validation errors
                let errorMessage = result.message || 'Something went wrong.';
                if (result.errors) {
                    errorMessage = Object.values(result.errors).flat().join('<br>');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessage,
                    confirmButtonColor: '#0f172a'
                });
            }
        } catch (error) {
            console.error('Submission error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "An error occurred during submission. Please check your connection or file size.",
                confirmButtonColor: '#0f172a'
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerText = originalBtnText;
        }
    });
</script>
@endsection
