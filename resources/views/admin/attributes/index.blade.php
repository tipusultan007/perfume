@extends('admin.layouts.app')

@section('title', 'Manage Attributes')
@section('page_title', 'Attributes')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-serif text-xl">All Attributes</h3>
    <a href="{{ route('admin.attributes.create') }}" class="px-6 py-3 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
        Add New Attribute
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
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Attribute Name</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Values</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($attributes as $attribute)
                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors">
                    <td class="py-6 font-medium">{{ $attribute->name }}</td>
                    <td class="opacity-60">
                        @foreach($attribute->values as $value)
                            <span class="inline-block px-2 py-1 bg-gray-100 text-[10px] rounded mr-1 lowercase tracking-wider">{{ $value->value }}</span>
                        @endforeach
                    </td>
                    <td class="text-right">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.attributes.edit', $attribute) }}" class="text-luxury-accent hover:text-luxury-black transition-colors">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.attributes.destroy', $attribute) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="3" class="py-10 text-center text-black/40 text-xs uppercase tracking-widest">No attributes found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-10">
        {{ $attributes->links() }}
    </div>
</div>
@endsection
