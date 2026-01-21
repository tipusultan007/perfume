@extends('admin.layouts.app')

@section('title', 'Products Report')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Products Report</h1>
            <p class="text-slate-500 font-medium mt-1">Inventory health and top-performing product analysis</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" 
            class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line text-lg"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        <!-- Best Sellers -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                <h3 class="text-lg font-bold text-slate-900">Top 10 Best Sellers</h3>
                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] uppercase font-bold tracking-widest rounded-lg border border-emerald-100">By Quantity</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                            <th class="px-8 py-5">Product</th>
                            <th class="px-8 py-5 text-right">Sold</th>
                            <th class="px-8 py-5 text-right">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($bestSellers as $index => $item)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                            <td class="px-8 py-6 flex items-center gap-4">
                                <span class="w-7 h-7 flex items-center justify-center bg-slate-50 text-slate-400 font-mono text-[10px] font-bold rounded border border-slate-100 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all">
                                    #{{ $index + 1 }}
                                </span>
                                <span class="font-bold text-slate-900">{{ $item->product_name }}</span>
                            </td>
                            <td class="px-8 py-6 text-right font-bold text-slate-700">
                                <span class="px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">{{ number_format($item->total_qty) }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-bold text-slate-900">${{ number_format($item->total_revenue, 2) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                        <i class="ri-shopping-basket-line text-3xl text-slate-200"></i>
                                    </div>
                                    <p class="text-sm font-bold uppercase tracking-widest">No sales data recorded yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-rose-50/30">
                <h3 class="text-lg font-bold text-rose-900">Low Stock Alerts</h3>
                <span class="px-3 py-1 bg-rose-100 text-rose-600 text-[10px] uppercase font-bold tracking-widest rounded-lg border border-rose-200">Qty <= 10</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                            <th class="px-8 py-5">Product</th>
                            <th class="px-8 py-5 text-right">Stock</th>
                            <th class="px-8 py-5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse($lowStockProducts as $product)
                        <tr class="border-b border-slate-50 hover:bg-rose-50/20 transition-all group">
                            <td class="px-8 py-6 font-bold text-slate-900">{{ $product->name }}</td>
                            <td class="px-8 py-6 text-right">
                                <span class="font-bold {{ $product->stock_quantity == 0 ? 'text-rose-600' : 'text-amber-600' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if($product->stock_quantity == 0)
                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-[10px] font-bold uppercase tracking-widest border border-rose-200 shadow-sm">Out of Stock</span>
                                @else
                                    <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-widest border border-amber-200 shadow-sm">Priority Restock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center">
                                        <i class="ri-checkbox-circle-line text-3xl text-emerald-400"></i>
                                    </div>
                                    <p class="text-sm font-bold uppercase tracking-widest">Inventory is healthy</p>
                                    <p class="text-xs -mt-2">No low stock items found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
