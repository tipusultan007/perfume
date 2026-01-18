@extends('admin.layouts.app')

@section('title', 'Manage Announcements')
@section('page_title', 'Announcements')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-sans font-semibold text-lg">Top Bar Announcements</h3>
    <a href="{{ route('admin.announcements.create') }}" class="px-6 py-3 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
        Add New Announcement
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
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Content</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Order</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Status</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($announcements as $announcement)
                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors">
                    <td class="py-6">
                        <div class="font-medium text-luxury-black max-w-xl">{{ $announcement->content }}</div>
                    </td>
                    <td><span class="font-mono text-xs">{{ $announcement->display_order }}</span></td>
                    <td>
                        @if($announcement->is_active)
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[10px] uppercase tracking-widest border border-emerald-100">Active</span>
                        @else
                            <span class="px-2 py-1 bg-gray-50 text-gray-400 text-[10px] uppercase tracking-widest border border-gray-100">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-luxury-accent hover:text-luxury-black transition-colors">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="4" class="py-10 text-center text-black/40 text-xs uppercase tracking-widest">No announcements found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
