@extends('admin.layouts.app')

@section('title', 'Add Brand')
@section('page_title', 'Create Brand')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-4 mb-10">
        <a href="{{ route('admin.brands.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line"></i>
        </a>
        <h3 class="font-bold text-2xl text-slate-900">New Brand</h3>
    </div>

    <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Brand Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Chanel"
                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                @error('name')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Brand Logo</label>
                <div class="relative group">
                    <input type="file" name="logo" class="w-full px-5 py-6 bg-slate-50 border border-dashed border-slate-300 rounded-xl text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-slate-900 file:text-white hover:border-slate-900 transition-all cursor-pointer">
                    <div class="mt-2 text-[9px] text-slate-400 uppercase tracking-widest font-bold">Recommended: PNG or SVG with transparent background</div>
                </div>
                @error('logo')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Description</label>
                <textarea name="description" rows="4" placeholder="Brief history or style of the brand..."
                    class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-rose-500 text-[10px] mt-2 block font-bold tracking-widest">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-6 border-t border-slate-100 mt-10">
                <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                    Save Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
