@extends('admin.layouts.app')

@section('title', 'Add New Slider')
@section('page_title', 'Sliders')

@section('content')
<div class="max-w-4xl">
    <div class="flex justify-between items-center mb-10">
        <h3 class="font-serif text-xl">Create New Slide</h3>
        <a href="{{ route('admin.sliders.index') }}" class="text-[11px] uppercase tracking-widest text-black/40 hover:text-black transition-all">
            &larr; Back to list
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 text-red-600 p-6 mb-8 text-xs uppercase tracking-widest border border-red-100">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-black/5 p-10 space-y-8">
        @csrf
        
        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="w-full border-b border-black/10 py-3 focus:outline-none focus:border-luxury-accent transition-colors text-sm" placeholder="e.g. New Arrivals">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border-b border-black/10 py-3 focus:outline-none focus:border-luxury-accent transition-colors text-sm" placeholder="e.g. Luxury Scent">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full border border-black/10 p-4 focus:outline-none focus:border-luxury-accent transition-colors text-sm resize-none" placeholder="Enter description text...">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Button Text</label>
                <input type="text" name="button_text" value="{{ old('button_text', 'Shop Now') }}" class="w-full border-b border-black/10 py-3 focus:outline-none focus:border-luxury-accent transition-colors text-sm">
            </div>
            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Button Link</label>
                <input type="text" name="button_link" value="{{ old('button_link', '#') }}" class="w-full border-b border-black/10 py-3 focus:outline-none focus:border-luxury-accent transition-colors text-sm">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8">
            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Display Order</label>
                <input type="number" name="display_order" value="{{ old('display_order', 0) }}" class="w-full border-b border-black/10 py-3 focus:outline-none focus:border-luxury-accent transition-colors text-sm">
            </div>
            <div class="space-y-2 flex items-center gap-4 h-full pt-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 accent-luxury-black">
                    <span class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Active</span>
                </label>
            </div>
        </div>

        <div class="space-y-4">
            <label class="text-[11px] uppercase tracking-widest text-black/40 font-medium">Slider Image</label>
            <div class="border-2 border-dashed border-black/5 p-10 text-center relative hover:border-luxury-accent/50 transition-colors">
                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                <div class="text-black/30">
                    <i class="ri-image-add-line text-4xl mb-2"></i>
                    <p class="text-xs uppercase tracking-widest">Click to upload or drag & drop</p>
                    <p class="text-[10px] opacity-60 mt-2">Recommended size: 1920x800px (Max 2MB)</p>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-black/5">
            <button type="submit" class="px-10 py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-xl shadow-black/10">
                Save & Create Slide
            </button>
        </div>
    </form>
</div>
@endsection
