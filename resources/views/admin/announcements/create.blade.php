@extends('admin.layouts.app')

@section('title', 'Add Announcement')
@section('page_title', 'Announcements')

@section('content')
<div class="mb-10">
    <a href="{{ route('admin.announcements.index') }}" class="text-luxury-black/50 hover:text-luxury-black transition-colors text-xs uppercase tracking-widest flex items-center gap-2">
        <i class="ri-arrow-left-line"></i> Back to List
    </a>
</div>

<div class="bg-white p-10 shadow-sm border border-black/[0.03] max-w-2xl">
    <h3 class="font-sans font-semibold text-lg mb-8">Create New Announcement</h3>

    <form action="{{ route('admin.announcements.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-[11px] uppercase tracking-widest text-black/40 font-medium mb-2">Content</label>
                <textarea name="content" rows="3" class="w-full bg-gray-50 border border-black/5 p-4 text-sm focus:outline-none focus:border-luxury-accent transition-colors" placeholder="Enter announcement text..." required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-[10px] mt-1 uppercase tracking-tighter">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-black/40 font-medium mb-2">Display Order</label>
                    <input type="number" name="display_order" value="{{ old('display_order', 0) }}" class="w-full bg-gray-50 border border-black/5 p-4 text-sm focus:outline-none focus:border-luxury-accent transition-colors">
                    @error('display_order')
                        <p class="text-red-500 text-[10px] mt-1 uppercase tracking-tighter">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[11px] uppercase tracking-widest text-black/40 font-medium mb-2">Status</label>
                    <select name="is_active" class="w-full bg-gray-50 border border-black/5 p-4 text-sm focus:outline-none focus:border-luxury-accent transition-colors outline-none h-[54px]">
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-10 py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Save Announcement
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
