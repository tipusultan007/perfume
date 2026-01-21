@extends('admin.layouts.app')

@section('title', 'Customers Report')

@section('content')
<div class="space-y-10">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Customers Report</h1>
            <p class="text-slate-500 font-medium mt-1">High-value customers and lifetime engagement insights</p>
        </div>
        <a href="{{ route('admin.reports.index') }}" 
            class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line text-lg"></i>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
            <h3 class="text-lg font-bold text-slate-900">Top 20 Customers by Spend</h3>
            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] uppercase font-bold tracking-widest rounded-lg border border-slate-200">Lifetime Value</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold">
                        <th class="px-8 py-5">Rank</th>
                        <th class="px-8 py-5">Customer</th>
                        <th class="px-8 py-5">Email</th>
                        <th class="px-8 py-5">Location</th>
                        <th class="px-8 py-5 text-right">Total Orders</th>
                        <th class="px-8 py-5 text-right">Total Spent</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($topCustomers as $index => $customer)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <span class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-400 font-mono text-xs font-bold rounded-lg border border-slate-100 group-hover:bg-slate-900 group-hover:text-white group-hover:border-slate-900 transition-all">
                                #{{ $index + 1 }}
                            </span>
                        </td>
                        <td class="px-8 py-6 font-bold text-slate-900">
                            {{ $customer->shipping_address['first_name'] ?? 'Guest' }} {{ $customer->shipping_address['last_name'] ?? '' }}
                        </td>
                        <td class="px-8 py-6 text-slate-500 font-medium">{{ $customer->shipping_address['email'] ?? '-' }}</td>
                        <td class="px-8 py-6 text-slate-400 text-xs font-semibold">
                            {{ $customer->shipping_address['city'] ?? '' }}, {{ $customer->shipping_address['country'] ?? '' }}
                        </td>
                        <td class="px-8 py-6 text-right font-bold text-slate-700">
                            <span class="px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">{{ $customer->order_count }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-lg font-bold text-slate-900">${{ number_format($customer->total_spent, 2) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                    <i class="ri-user-search-line text-3xl text-slate-200"></i>
                                </div>
                                <p class="text-sm font-bold uppercase tracking-widest">No customer data available yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
