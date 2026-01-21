@extends('admin.layouts.app')

@section('title', 'Tax Settings')
@section('page_title', 'Tax Configurations')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- List of Tax Rates -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                <h3 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Active Tax Rates</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                            <th class="px-8 py-6">Name / Scope</th>
                            <th class="px-8 py-6">Rate (%)</th>
                            <th class="px-8 py-6">Priority</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($taxRates as $rate)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-slate-900">{{ $rate->name }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">
                                    Region: {{ $rate->state_code ?? 'Global' }}
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="bg-slate-900 text-white px-3 py-1 rounded-lg font-mono text-xs">{{ number_format($rate->rate, 3) }}%</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="text-slate-500 font-medium">L{{ $rate->priority }}</span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                @if($rate->is_active)
                                    <span class="inline-flex items-center justify-center bg-emerald-50 text-emerald-600 px-4 py-1.5 border border-emerald-100 rounded-full text-[10px] uppercase tracking-widest font-bold">Active</span>
                                @else
                                    <span class="inline-flex items-center justify-center bg-slate-100 text-slate-500 px-4 py-1.5 border border-slate-200 rounded-full text-[10px] uppercase tracking-widest font-bold">Inactive</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form action="{{ route('admin.taxes.destroy', $rate) }}" method="POST" 
                                        onsubmit="return confirm('Delete this tax rate?');" class="inline">
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
                            <td colspan="5" class="px-8 py-20 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center">
                                        <i class="ri-percent-line text-4xl text-slate-200"></i>
                                    </div>
                                    <p class="text-sm font-bold uppercase tracking-widest">No tax rates defined</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create New Tax Rate -->
    <div>
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden sticky top-24">
            <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                <h3 class="text-sm font-bold uppercase tracking-[0.15em] text-slate-500">Add Tax Rate</h3>
            </div>
            
            <form action="{{ route('admin.taxes.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-2">Display Name</label>
                    <input type="text" name="name" required placeholder="e.g. Standard Sales Tax" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-2">Rate (%)</label>
                        <input type="number" step="0.0001" name="rate" required placeholder="8.875" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    </div>
                    <div>
                         <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-2">State (2 Char)</label>
                         <input type="text" name="state_code" maxlength="2" placeholder="AL" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all uppercase">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-bold text-slate-400 mb-2">Priority</label>
                    <input type="number" name="priority" value="1" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_active" checked value="1" class="peer h-5 w-5 opacity-0 absolute cursor-pointer">
                            <div class="h-5 w-5 border-2 border-slate-200 rounded peer-checked:bg-slate-900 peer-checked:border-slate-900 transition-all"></div>
                            <i class="ri-check-line absolute text-white text-sm left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-slate-600 group-hover:text-slate-900 transition-colors">Active Status</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_shipping_taxable" checked value="1" class="peer h-5 w-5 opacity-0 absolute cursor-pointer">
                            <div class="h-5 w-5 border-2 border-slate-200 rounded peer-checked:bg-slate-900 peer-checked:border-slate-900 transition-all"></div>
                            <i class="ri-check-line absolute text-white text-sm left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-widest text-slate-600 group-hover:text-slate-900 transition-colors">Taxable Shipping</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all shadow-lg hover:shadow-slate-900/20">
                    Save Tax Rate
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

