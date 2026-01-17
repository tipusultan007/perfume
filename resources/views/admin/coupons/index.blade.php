@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page_title', 'Discount Coupons')

@section('content')
<div class="bg-white border border-black/10">
    <div class="p-6 border-b border-black/10 flex justify-between items-center bg-gray-50/30">
        <h3 class="text-sm font-semibold uppercase tracking-widest text-black/60">Manage Coupons</h3>
        <a href="{{ route('admin.coupons.create') }}" class="flex items-center gap-2 bg-luxury-black text-white px-6 py-3 text-[10px] uppercase tracking-widest hover:bg-black/80 transition-all">
            <i class="ri-add-line text-lg"></i> Create New
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-black/10 text-[10px] uppercase tracking-widest text-black/60 bg-gray-50/50">
                    <th class="p-6 font-medium">Code</th>
                    <th class="p-6 font-medium">Discount</th>
                    <th class="p-6 font-medium">Expiry</th>
                    <th class="p-6 font-medium text-center">Usage</th>
                    <th class="p-6 font-medium">Status</th>
                    <th class="p-6 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($coupons as $coupon)
                <tr class="border-b border-black/5 hover:bg-gray-50/30 transition-colors group">
                    <td class="p-6 font-semibold font-mono text-black/80">{{ $coupon->code }}</td>
                    <td class="p-6">
                        @if($coupon->type === 'percent')
                            {{ $coupon->value }}% Off
                        @else
                            ${{ number_format($coupon->value, 2) }} Off
                        @endif
                        @if($coupon->min_spend)
                            <span class="block text-[10px] text-black/40 mt-1">Min Spend: ${{ $coupon->min_spend }}</span>
                        @endif
                    </td>
                    <td class="p-6 text-black/60 text-xs">
                        @if($coupon->expiry_date)
                            <span class="{{ $coupon->expiry_date->isPast() ? 'text-red-500' : '' }}">
                                {{ $coupon->expiry_date->format('M d, Y') }}
                            </span>
                        @else
                            <span class="text-black/30">No Expiry</span>
                        @endif
                    </td>
                    <td class="p-6 text-center text-xs">
                        {{ $coupon->used_count }} 
                        @if($coupon->usage_limit)
                            <span class="text-black/40">/ {{ $coupon->usage_limit }}</span>
                        @endif
                    </td>
                    <td class="p-6">
                        @if(!$coupon->is_active)
                            <span class="inline-flex items-center justify-center bg-gray-100 text-gray-500 px-2 py-1 rounded text-[10px] uppercase tracking-widest font-medium">Inactive</span>
                        @elseif($coupon->expiry_date && $coupon->expiry_date->isPast())
                            <span class="inline-flex items-center justify-center bg-red-50 text-red-500 px-2 py-1 rounded text-[10px] uppercase tracking-widest font-medium">Expired</span>
                        @else
                            <span class="inline-flex items-center justify-center bg-green-50 text-green-700 px-2 py-1 rounded text-[10px] uppercase tracking-widest font-medium">Active</span>
                        @endif
                    </td>
                    <td class="p-6 text-right">
                        <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="text-black hover:text-luxury-black" title="Edit">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('Delete this coupon?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600" title="Delete">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12 text-center text-black/40">
                        <div class="flex flex-col items-center gap-2">
                            <i class="ri-ticket-line text-3xl mb-2"></i>
                            <p class="text-sm">No coupons found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($coupons->hasPages())
    <div class="p-6 border-t border-black/10">
        {{ $coupons->links() }}
    </div>
    @endif
</div>
@endsection
