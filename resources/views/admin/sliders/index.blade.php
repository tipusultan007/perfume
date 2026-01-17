@extends('admin.layouts.app')

@section('title', 'Manage Sliders')
@section('page_title', 'Sliders')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-sans font-semibold text-lg">All Sliders</h3>
    <a href="{{ route('admin.sliders.create') }}" class="px-6 py-3 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
        Add New Slider
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 text-emerald-700 p-4 mb-8 text-xs uppercase tracking-widest border border-emerald-100">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-10 shadow-sm border border-black/[0.03]">

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-black/5">
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Image</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Title/Subtitle</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Order</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Status</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($sliders as $slider)
                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors">
                    <td class="py-6">
                        <img src="{{ $slider->image_path }}" alt="Slider Image" class="w-20 h-12 object-cover border border-black/5">
                    </td>
                    <td class="py-6">
                        <div class="font-medium text-luxury-black">{{ $slider->title }}</div>
                        <div class="text-[10px] uppercase tracking-tighter opacity-50">{{ $slider->subtitle }}</div>
                    </td>
                    <td><span class="font-mono text-xs">{{ $slider->display_order }}</span></td>
                    <td>
                        @if($slider->is_active)
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[10px] uppercase tracking-widest border border-emerald-100">Active</span>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest border border-gray-100">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-luxury-accent hover:text-luxury-black transition-colors">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-black/40 text-xs uppercase tracking-widest">No sliders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
