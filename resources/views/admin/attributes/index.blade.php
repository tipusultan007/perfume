@extends('admin.layouts.app')

@section('title', 'Manage Attributes')
@section('page_title', 'Attributes')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-bold text-2xl text-slate-900">Attributes</h3>
    <a href="{{ route('admin.attributes.create') }}" class="px-6 py-3 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg shadow-xl hover:bg-slate-800 transition-all">
        Add New Attribute
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 text-emerald-700 p-6 mb-10 rounded-xl border border-emerald-100 shadow-sm flex items-center space-x-3">
        <i class="ri-checkbox-circle-line text-xl"></i>
        <span class="text-[11px] uppercase tracking-widest font-bold">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Attribute Name</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Configured Values</th>
                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($attributes as $attribute)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="text-sm font-bold text-slate-900 uppercase tracking-wide">{{ $attribute->name }}</span>
                    </td>
                    <td class="py-6">
                        <div class="flex flex-wrap gap-2">
                            @foreach($attribute->values as $value)
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-slate-200">{{ $value->value }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end items-center gap-3">
                            <a href="{{ route('admin.attributes.edit', $attribute) }}" 
                                class="w-9 h-9 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-slate-900 hover:border-slate-900 hover:shadow-lg transition-all shadow-sm">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.attributes.destroy', $attribute) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white hover:shadow-lg transition-all shadow-sm">
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
    
    <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
        {{ $attributes->links() }}
    </div>
</div>
@endsection
