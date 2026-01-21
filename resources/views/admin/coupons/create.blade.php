@extends('admin.layouts.app')

@section('title', 'Create Coupon')
@section('page_title', 'New Coupon')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.coupons.index') }}" 
            class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line text-lg"></i>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden p-10">
        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Code -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Coupon Code</label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. SUMMER25" 
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold uppercase" required>
                    @error('code') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Active Toggle -->
                <div class="flex items-end pb-4">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900"></div>
                        <span class="ms-3 text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500 group-hover:text-slate-900 transition-colors">Active Coupon</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Type -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Discount Type</label>
                    <div class="relative">
                        <select name="type" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-semibold appearance-none">
                            <option value="percent">Percentage (%)</option>
                            <option value="fixed">Fixed Amount ($)</option>
                        </select>
                        <i class="ri-arrow-down-s-line absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-lg"></i>
                    </div>
                </div>

                <!-- Value -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Discount Value</label>
                    <input type="number" name="value" value="{{ old('value') }}" placeholder="0.00" step="0.01" min="0" 
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold" required>
                    @error('value') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Min Spend -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Min Spend ($)</label>
                    <input type="number" name="min_spend" value="{{ old('min_spend') }}" placeholder="Optional" step="0.01" min="0" 
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold">
                </div>

                <!-- Usage Limit -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Optional" min="1" 
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold">
                </div>

                <!-- Expiry Date -->
                <div class="space-y-4">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" 
                        class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold">
                    @error('expiry_date') <p class="text-rose-500 text-[10px] font-bold uppercase tracking-widest mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-slate-900 text-white text-[11px] font-bold uppercase tracking-[0.2em] rounded-lg hover:bg-slate-800 transition-all shadow-xl hover:shadow-slate-900/20 active:scale-[0.98]">
                    Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
