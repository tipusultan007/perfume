@extends('admin.layouts.app')

@section('title', 'Edit Brand')
@section('page_title', 'Update Brand')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.brands.index') }}" class="w-10 h-10 border border-black/5 flex items-center justify-center hover:bg-black hover:text-white transition-all">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-serif text-xl">Edit Brand: {{ $brand->name }}</h3>
    </div>

    <div class="bg-white border border-black/5 p-10">
        <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Brand Name</label>
                <input type="text" name="name" value="{{ old('name', $brand->name) }}" required
                    class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                @error('name')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Brand Logo</label>
                @if($brand->getFirstMediaUrl('logo'))
                    <div class="mb-4">
                        <img src="{{ $brand->getFirstMediaUrl('logo') }}" alt="{{ $brand->name }}" class="w-20 h-20 object-contain border border-black/5 p-2">
                    </div>
                @endif
                <input type="file" name="logo" class="w-full py-4 text-xs">
                @error('logo')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Description</label>
                <textarea name="description" rows="4" 
                    class="w-full py-4 border border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent px-4">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="px-10 py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
                    Update Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
