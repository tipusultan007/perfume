@extends('admin.layouts.app')

@section('title', 'Add Category')
@section('page_title', 'Create Category')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-bold text-2xl text-slate-900">New Category</h3>
    </div>

    <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Floral Perfumes"
                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                @error('name')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Parent Category (Optional)</label>
                <div class="relative">
                    <select name="parent_id" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium appearance-none cursor-pointer">
                        <option value="">None (Top Level)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        <i class="ri-arrow-down-s-line text-lg"></i>
                    </div>
                </div>
                @error('parent_id')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-100 mt-10">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
