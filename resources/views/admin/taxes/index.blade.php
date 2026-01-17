@extends('admin.layouts.app')

@section('title', 'Tax Settings')
@section('page_title', 'Tax Configurations')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- List of Tax Rates -->
    <div class="lg:col-span-2">
        <div class="bg-white border border-black/5 p-8">
            <h3 class="font-serif text-xl mb-6">Tax Rates</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-black/5">
                            <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Name</th>
                            <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Rate (%)</th>
                            <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">State</th>
                            <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Priority</th>
                            <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Status</th>
                            <th class="py-4 text-[9px] uppercase tracking-widest text-black/40 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        @foreach($taxRates as $rate)
                        <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-all">
                            <td class="py-4 font-semibold">{{ $rate->name }}</td>
                            <td class="py-4">{{ number_format($rate->rate, 3) }}%</td>
                            <td class="py-4">{{ $rate->state_code ?? 'All' }}</td>
                            <td class="py-4">{{ $rate->priority }}</td>
                            <td class="py-4">
                                <span class="px-2 py-1 {{ $rate->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $rate->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <form action="{{ route('admin.taxes.destroy', $rate) }}" method="POST" onsubmit="return confirm('Delete this rate?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        
                        @if($taxRates->isEmpty())
                        <tr>
                            <td colspan="6" class="py-8 text-center opacity-40">No tax rates defined.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create New Tax Rate -->
    <div>
        <div class="bg-white border border-black/5 p-8 sticky top-24">
            <h3 class="font-serif text-xl mb-6">Add Tax Rate</h3>
            <form action="{{ route('admin.taxes.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Display Name</label>
                    <input type="text" name="name" required placeholder="e.g. NY Sales Tax" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Rate (%)</label>
                        <input type="number" step="0.0001" name="rate" required placeholder="8.875" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                    </div>
                    <div>
                         <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">State (2 Char)</label>
                         <input type="text" name="state_code" maxlength="2" placeholder="NY" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm uppercase">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                     <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-2 opacity-60">Priority</label>
                        <input type="number" name="priority" value="1" class="w-full py-3 border-b border-black/10 focus:border-luxury-black outline-none bg-transparent text-sm">
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_active" checked class="form-checkbox h-4 w-4 text-luxury-black border-gray-300 focus:ring-0">
                        <span class="text-[10px] uppercase tracking-widest opacity-80">Active</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_shipping_taxable" checked class="form-checkbox h-4 w-4 text-luxury-black border-gray-300 focus:ring-0">
                        <span class="text-[10px] uppercase tracking-widest opacity-80">Apply to Shipping</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
                    Save Rate
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
