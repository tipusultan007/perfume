@extends('admin.layouts.app')

@section('title', 'Add Category')
@section('page_title', 'Create Category')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 border border-black/5 flex items-center justify-center hover:bg-black hover:text-white transition-all">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-serif text-xl">New Category</h3>
    </div>

    <div class="bg-white border border-black/5 p-10">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                @error('name')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Parent Category (Optional)</label>
                <select name="parent_id" class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent appearance-none">
                    <option value="">None (Top Level)</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @endforeach
                </select>
                @error('parent_id')
                    <span class="text-red-500 text-[10px] mt-2 block tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-6">
                <button type="submit" class="px-10 py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
