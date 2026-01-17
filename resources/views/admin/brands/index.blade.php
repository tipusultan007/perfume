@extends('admin.layouts.app')

@section('title', 'Manage Brands')
@section('page_title', 'Brands')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-serif text-xl">All Brands</h3>
    <a href="{{ route('admin.brands.create') }}" class="px-6 py-3 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
        Add New Brand
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 text-emerald-700 p-4 mb-8 text-xs uppercase tracking-widest border border-emerald-100">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white border border-black/5 p-10">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-black/5">
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Logo</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Name</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Slug</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($brands as $brand)
                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors">
                    <td class="py-4">
                        @if($brand->getFirstMediaUrl('logo'))
                            <img src="{{ $brand->getFirstMediaUrl('logo') }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain border border-black/5 p-1">
                        @else
                            <div class="w-10 h-10 bg-gray-50 flex items-center justify-center text-[10px] opacity-40 border border-black/5">NO LOGO</div>
                        @endif
                    </td>
                    <td class="py-6 font-medium">{{ $brand->name }}</td>
                    <td class="opacity-60">{{ $brand->slug }}</td>
                    <td class="text-right">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="text-luxury-accent hover:text-luxury-black transition-colors">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="4" class="py-10 text-center text-black/40 text-xs uppercase tracking-widest">No brands found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-10">
        {{ $brands->links() }}
    </div>
</div>
@endsection
