@extends('admin.layouts.app')

@section('title', 'Create Coupon')
@section('page_title', 'New Coupon')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.coupons.index') }}" class="text-xs uppercase tracking-widest text-black/50 hover:text-black transition-colors flex items-center gap-2">
            <i class="ri-arrow-left-line"></i> Back to Coupons
        </a>
    </div>

    <div class="bg-white border border-black/10 p-10">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <!-- Code & Active -->
            <div class="flex gap-6">
                <div class="flex-1">
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Coupon Code</label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. SUMMER25" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm uppercase" required>
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center pt-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="w-4 h-4 accent-luxury-black" checked>
                        <span class="text-xs uppercase tracking-widest text-black/80">Active</span>
                    </label>
                </div>
            </div>

            <!-- Type & Value -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Discount Type</label>
                    <select name="type" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                        <option value="percent">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Discount Value</label>
                    <input type="number" name="value" value="{{ old('value') }}" placeholder="0.00" step="0.01" min="0" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm" required>
                    @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Limits & Expiry -->
            <div class="grid grid-cols-3 gap-6">
                 <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Minimum Spend ($)</label>
                    <input type="number" name="min_spend" value="{{ old('min_spend') }}" placeholder="Optional" step="0.01" min="0" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Optional (Total Uses)" min="1" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                    @error('expiry_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all mt-4">Create Coupon</button>
        </form>
    </div>
</div>
@endsection
