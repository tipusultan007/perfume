@extends('admin.layouts.app')

@section('title', 'Edit Slider')
@section('page_title', 'Sliders')

@section('content')
<div x-data="sliderPreview()" class="grid grid-cols-1 lg:grid-cols-12 gap-10">
    <div class="lg:col-span-12 xl:col-span-7">
        <div class="flex items-center gap-4 mb-10">
            <a href="{{ route('admin.sliders.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                <i class="ri-arrow-left-line"></i>
            </a>
            <h3 class="font-bold text-2xl text-slate-900">Edit Slider Slide</h3>
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
            <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Slide Title</label>
                        <input type="text" name="title" x-model="title" value="{{ old('title', $slider->title) }}" placeholder="e.g. Luxury Scent Collection"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Subtitle / Small Text</label>
                        <input type="text" name="subtitle" x-model="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="e.g. New Arrivals 2026"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Main Description</label>
                    <textarea name="description" x-model="description" rows="4" placeholder="Enter the descriptive text that appears on the slide..."
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium resize-none">{{ old('description', $slider->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Call to Action Text</label>
                        <input type="text" name="button_text" x-model="button_text" value="{{ old('button_text', $slider->button_text) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold uppercase tracking-widest">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Destination URL</label>
                        <input type="text" name="button_link" value="{{ old('button_link', $slider->button_link) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Display Priority (Order)</label>
                        <input type="number" name="display_order" value="{{ old('display_order', $slider->display_order) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold">
                    </div>
                    <div class="flex items-center justify-between p-6 bg-slate-50 border border-slate-200 rounded-xl">
                        <div>
                            <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Visibility Status</h4>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-1">Show this slide in the main carousel</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                        </label>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100">
                    <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                        <i class="ri-brush-3-line text-lg"></i> Dynamic Styling & Content
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Background Accent</label>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <input type="color" name="bg_color" x-model="bg_color" class="w-12 h-12 rounded-lg cursor-pointer border-2 border-white shadow-sm">
                                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest flex-1" x-text="bg_color"></span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">UI Theme Mode</label>
                            <div class="relative">
                                <select name="ui_theme" x-model="ui_theme" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-[11px] text-slate-900 font-bold uppercase tracking-widest appearance-none cursor-pointer">
                                    <option value="dark">Dark (For Light BGs)</option>
                                    <option value="light">Light (For Dark BGs)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                    <i class="ri-arrow-down-s-line text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Interaction Color</label>
                            <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                <input type="color" name="accent_color" x-model="accent_color" class="w-12 h-12 rounded-lg cursor-pointer border-2 border-white shadow-sm">
                                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest flex-1" x-text="accent_color"></span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Icons Main</label>
                            <input type="color" name="social_color" x-model="social_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Icons Hover BG</label>
                            <input type="color" name="social_hover_color" x-model="social_hover_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Icons Color</label>
                            <input type="color" name="social_icon_color" x-model="social_icon_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Icons Hover Color</label>
                            <input type="color" name="social_icon_hover_color" x-model="social_icon_hover_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Nav Main</label>
                            <input type="color" name="nav_color" x-model="nav_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Nav Hover BG</label>
                            <input type="color" name="nav_hover_color" x-model="nav_hover_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Nav Icon Color</label>
                            <input type="color" name="nav_icon_color" x-model="nav_icon_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Nav Hover Icon</label>
                            <input type="color" name="nav_icon_hover_color" x-model="nav_icon_hover_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-6">
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Title Color</label>
                            <input type="color" name="title_color" x-model="title_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Description Color</label>
                            <input type="color" name="description_color" x-model="description_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Price Color</label>
                            <input type="color" name="price_color" x-model="price_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                            <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">Line/Accent Color</label>
                            <input type="color" name="line_color" x-model="line_color" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10 p-8 bg-slate-900 rounded-2xl shadow-xl shadow-slate-900/10">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-400 font-bold">Display Price</label>
                            <input type="text" name="price" x-model="price" value="{{ old('price', $slider->price) }}" placeholder="e.g. $145.00"
                                class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-xl focus:border-white focus:ring-4 focus:ring-white/5 outline-none transition-all text-sm text-white font-bold font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-400 font-bold">Fragrance Notes</label>
                            <input type="text" name="top_notes" x-model="top_notes" value="{{ old('top_notes', $slider->top_notes) }}" placeholder="e.g. Mint, Bergamot & Ozone"
                                class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-xl focus:border-white focus:ring-4 focus:ring-white/5 outline-none transition-all text-sm text-white font-medium">
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100">
                    <label class="block text-[10px] uppercase tracking-widest mb-6 text-slate-500 font-bold">Update Slide Image</label>
                    
                    <div class="w-48 h-28 rounded-xl border border-slate-200 overflow-hidden mb-6 bg-white shadow-sm" x-show="!imagePreview">
                        <img src="{{$slider->getFirstMediaUrl('slider') }}" alt="Current Slide" class="w-full h-full object-cover">
                    </div>

                    <div class="relative group">
                        <input type="file" name="image" @change="previewImage($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                        <div class="border-2 border-dashed border-slate-200 p-12 rounded-2xl flex flex-col items-center justify-center bg-slate-50 group-hover:bg-slate-100 group-hover:border-slate-900 transition-all duration-500">
                            <div class="w-20 h-20 bg-white border border-slate-100 rounded-2xl flex items-center justify-center mb-4 shadow-sm group-hover:scale-110 transition-transform">
                                <i class="ri-image-add-line text-4xl text-slate-300 group-hover:text-slate-900"></i>
                            </div>
                            <p class="text-[11px] uppercase tracking-widest font-bold text-slate-500 group-hover:text-slate-900">Drop new image here or click to browse</p>
                            <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">JPEG, PNG OR WEBP • MAX 2MB • RECOMMENDED 1920x800</p>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-slate-100 mt-10">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 active:scale-[0.98] duration-200">
                        Update Slide Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Preview -->
    <div class="lg:col-span-12 xl:col-span-5 hidden xl:block">
        <div class="sticky top-10">
            <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center justify-between">
                <span><i class="ri-eye-line text-lg mr-2"></i> Real-time Preview</span>
                <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-[9px]">Active</span>
            </h4>
            
            <div class="preview-canvas rounded-3xl overflow-hidden shadow-2xl border border-slate-200" 
                 :style="'background-color: ' + bg_color + '; color: ' + title_color">
                
                <div class="relative h-[600px] flex items-center justify-center p-12 overflow-hidden">
                    <!-- Background Text -->
                    <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[150px] font-serif font-bold leading-none select-none opacity-5 uppercase tracking-tighter whitespace-nowrap"
                        :class="ui_theme === 'dark' ? 'c-text-outline-dark' : 'c-text-outline'"
                        x-text="title.split(' ')[0]">
                    </h1>

                    <div class="relative z-10 w-full grid grid-cols-12 gap-6 items-center">
                        <div class="col-span-7 space-y-4">
                            <p class="tracking-[0.4em] text-[10px] font-bold uppercase" :style="'color: ' + accent_color">No. 01</p>
                            <h2 class="text-4xl font-serif leading-[1.1]" x-html="title.replace(' ', '<br>')"></h2>
                            <p class="text-xs font-light leading-relaxed max-w-xs opacity-80" :style="'color: ' + description_color" x-text="description"></p>
                            
                            <div class="flex items-center gap-6 pt-4">
                                <div class="w-10 h-10 rounded-full border flex items-center justify-center" :style="'border-color: ' + accent_color + '; color: ' + accent_color">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                                <span class="text-[10px] uppercase tracking-widest font-bold" x-text="button_text"></span>
                            </div>
                        </div>

                        <div class="col-span-1"></div>

                        <div class="col-span-4 space-y-8">
                            <div x-show="top_notes">
                                <h4 class="text-[9px] uppercase tracking-widest opacity-40 mb-2">Top Notes</h4>
                                <p class="font-serif text-sm border-l-2 pl-4" :style="'border-color: ' + accent_color" x-html="top_notes.replace('&', '&<br>')"></p>
                            </div>
                            
                            <div x-show="price">
                                <span class="text-2xl font-serif" :style="'color: ' + price_color" x-text="price"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottle Image -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <img :src="imagePreview" x-show="imagePreview" class="h-[60%] object-contain drop-shadow-2xl">
                    </div>

                    <!-- Social Icons Overlay -->
                    <div class="absolute left-10 bottom-10 flex gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" :style="'background-color: ' + social_color + '; color: ' + social_icon_color">
                            <i class="ri-facebook-fill text-sm"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full flex items-center justify-center" :style="'background-color: ' + social_color + '; color: ' + social_icon_color">
                            <i class="ri-instagram-line text-sm"></i>
                        </div>
                    </div>

                    <!-- Nav Arrows Overlay -->
                    <div class="absolute right-10 bottom-10 flex gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" :style="'background-color: ' + nav_color + '; color: ' + nav_icon_color">
                            <i class="ri-arrow-left-line"></i>
                        </div>
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" :style="'background-color: ' + nav_color + '; color: ' + nav_icon_color">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl">
                    <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 text-center">Interactive States</h5>
                    <div class="flex justify-center gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg" :style="'background-color: ' + social_hover_color + '; color: ' + social_icon_hover_color" title="Social Hover">
                            <i class="ri-share-line"></i>
                        </div>
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg" :style="'background-color: ' + nav_hover_color + '; color: ' + nav_icon_hover_color" title="Nav Hover">
                            <i class="ri-arrow-right-line"></i>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-white border border-slate-200 rounded-2xl flex flex-col items-center justify-center gap-2">
                    <div class="w-2 h-10 rounded-full" :style="'background-color: ' + line_color"></div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Active Accent</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-serif { font-family: 'Playfair Display', serif; }
    .c-text-outline { -webkit-text-stroke: 1px rgba(255,255,255,0.2); color: transparent; }
    .c-text-outline-dark { -webkit-text-stroke: 1px rgba(0,0,0,0.1); color: transparent; }
    .preview-canvas { transition: all 0.5s ease-in-out; }
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

