@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page_title', 'Discount Coupons')

@section('content')
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
        <h3 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Manage Coupons</h3>
        <a href="{{ route('admin.coupons.create') }}" class="flex items-center gap-2 bg-slate-900 text-white px-8 py-3.5 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
            <i class="ri-add-line text-lg"></i> Create New
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                    <th class="px-8 py-6">Code</th>
                    <th class="px-8 py-6">Discount</th>
                    <th class="px-8 py-6">Expiry</th>
                    <th class="px-8 py-6 text-center">Usage</th>
                    <th class="px-8 py-6">Status</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($coupons as $coupon)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="font-bold font-mono text-slate-900 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 uppercase">{{ $coupon->code }}</span>
                    </td>
                    <td class="px-8 py-6 font-medium text-slate-700">
                        @if($coupon->type === 'percent')
                            <span class="text-slate-900 font-bold">{{ $coupon->value }}%</span> Off
                        @else
                            <span class="text-slate-900 font-bold">${{ number_format($coupon->value, 2) }}</span> Off
                        @endif
                        @if($coupon->min_spend)
                            <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1.5">Min Spend: ${{ number_format($coupon->min_spend, 2) }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-slate-500 text-xs font-semibold">
                        @if($coupon->expiry_date)
                            <span class="{{ $coupon->expiry_date->isPast() ? 'text-rose-500' : '' }}">
                                {{ $coupon->expiry_date->format('M d, Y') }}
                            </span>
                        @else
                            <span class="text-slate-300 font-medium italic">No Expiry</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-center">
                        <div class="inline-flex flex-col items-center">
                            <span class="text-slate-900 font-bold">{{ $coupon->used_count }}</span>
                            @if($coupon->usage_limit)
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">/ {{ $coupon->usage_limit }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        @if(!$coupon->is_active)
                            <span class="inline-flex items-center justify-center bg-slate-100 text-slate-500 px-4 py-1.5 border border-slate-200 rounded-full text-[10px] uppercase tracking-widest font-bold">Inactive</span>
                        @elseif($coupon->expiry_date && $coupon->expiry_date->isPast())
                            <span class="inline-flex items-center justify-center bg-rose-50 text-rose-500 px-4 py-1.5 border border-rose-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Expired</span>
                        @else
                            <span class="inline-flex items-center justify-center bg-emerald-50 text-emerald-600 px-4 py-1.5 border border-emerald-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Active</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white rounded-lg transition-all shadow-sm" 
                                title="Edit">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" 
                                onsubmit="return confirm('Delete this coupon?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all shadow-sm" 
                                    title="Delete">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center text-slate-400">
                        <div class="flex flex-col items-center gap-4">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center">
                                <i class="ri-ticket-line text-4xl text-slate-200"></i>
                            </div>
                            <p class="text-sm font-bold uppercase tracking-widest">No coupons found</p>
                            <a href="{{ route('admin.coupons.create') }}" class="text-slate-900 border-b-2 border-slate-900 pb-0.5 text-xs font-bold uppercase tracking-widest hover:text-slate-600 hover:border-slate-600 transition-all">Create your first coupon</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($coupons->hasPages())
    <div class="p-8 border-t border-slate-100 bg-slate-50/30">
        {{ $coupons->links() }}
    </div>
    @endif
</div>
@endsection
