@extends('admin.layouts.app')

@section('title', 'Edit Slider')
@section('page_title', 'Sliders')

@section('content')
<div class="max-w-4xl">
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
                    <input type="text" name="title" value="{{ old('title', $slider->title) }}" placeholder="e.g. Luxury Scent Collection"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Subtitle / Small Text</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}" placeholder="e.g. New Arrivals 2026"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium font-mono">
                </div>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Main Description</label>
                <textarea name="description" rows="4" placeholder="Enter the descriptive text that appears on the slide..."
                    class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium resize-none">{{ old('description', $slider->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Call to Action Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $slider->button_text) }}"
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
                            <input type="color" name="bg_color" value="{{ old('bg_color', $slider->bg_color ?? '#FDFCF8') }}" class="w-12 h-12 rounded-lg cursor-pointer border-2 border-white shadow-sm">
                            <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest flex-1">Pick Color</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">UI Theme Mode</label>
                        <div class="relative">
                            <select name="ui_theme" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-[11px] text-slate-900 font-bold uppercase tracking-widest appearance-none cursor-pointer">
                                <option value="dark" {{ old('ui_theme', $slider->ui_theme) == 'dark' ? 'selected' : '' }}>Dark (For Light BGs)</option>
                                <option value="light" {{ old('ui_theme', $slider->ui_theme) == 'light' ? 'selected' : '' }}>Light (For Dark BGs)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                <i class="ri-arrow-down-s-line text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Interaction Color</label>
                        <div class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <input type="color" name="accent_color" value="{{ old('accent_color', $slider->accent_color ?? '#D4AF37') }}" class="w-12 h-12 rounded-lg cursor-pointer border-2 border-white shadow-sm">
                            <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-widest flex-1">Pick Accent</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                    @foreach(['social_color' => 'Socials', 'nav_color' => 'Arrows', 'line_color' => 'Accents', 'title_color' => 'Content'] as $field => $label)
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                        <label class="block text-[9px] uppercase tracking-widest text-slate-400 font-bold mb-3">{{ $label }}</label>
                        <input type="color" name="{{ $field }}" value="{{ old($field, $slider->$field ?? '#111827') }}" class="w-full h-8 rounded border-none cursor-pointer shadow-sm">
                    </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mt-10 p-8 bg-slate-900 rounded-2xl shadow-xl shadow-slate-900/10">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-400 font-bold">Display Price</label>
                        <input type="text" name="price" value="{{ old('price', $slider->price) }}" placeholder="e.g. $145.00"
                            class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-xl focus:border-white focus:ring-4 focus:ring-white/5 outline-none transition-all text-sm text-white font-bold font-mono">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-400 font-bold">Fragrance Notes</label>
                        <input type="text" name="top_notes" value="{{ old('top_notes', $slider->top_notes) }}" placeholder="e.g. Mint, Bergamot & Ozone"
                            class="w-full px-5 py-4 bg-white/10 border border-white/10 rounded-xl focus:border-white focus:ring-4 focus:ring-white/5 outline-none transition-all text-sm text-white font-medium">
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100">
                <label class="block text-[10px] uppercase tracking-widest mb-6 text-slate-500 font-bold">Update Slide Image</label>
                
                <div class="w-48 h-28 rounded-xl border border-slate-200 overflow-hidden mb-6 bg-white shadow-sm">
                    <img src="{{$slider->getFirstMediaUrl('slider') }}" alt="Current Slide" class="w-full h-full object-cover">
                </div>

                <div class="relative group">
                    <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
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
@endsection

