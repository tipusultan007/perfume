@extends('admin.layouts.app')

@section('title', 'Manage Orders')
@section('page_title', 'Orders')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-bold text-2xl text-slate-900">Orders</h3>
</div>

<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Order #</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Customer</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Date</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Status</th>
                    <th class="py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold">Total</th>
                    <th class="px-8 py-5 text-[10px] uppercase tracking-widest text-slate-500 font-bold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($orders as $order)
                <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="text-xs font-mono font-bold text-slate-900 bg-slate-100 px-2 py-1 rounded">{{ $order->order_number }}</span>
                    </td>
                    <td class="py-6">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-900">{{ $order->shipping_address['name'] ?? 'Guest' }}</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $order->user->email ?? $order->shipping_address['email'] ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="py-6">
                        <span class="text-xs font-bold text-slate-500">{{ $order->created_at->format('M d, Y') }}</span>
                    </td>
                    <td>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'processing' => 'bg-sky-50 text-sky-600 border-sky-100',
                                'shipped' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                                'refunded' => 'bg-slate-50 text-slate-600 border-slate-200',
                            ];
                        @endphp
                        <span class="inline-block px-3 py-1 {{ $statusClasses[$order->status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }} border text-[9px] font-bold rounded-full uppercase tracking-widest">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="py-6">
                        <span class="text-sm font-bold text-slate-900">${{ number_format($order->grand_total, 2) }}</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" 
                            class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 text-[10px] font-bold uppercase tracking-widest text-slate-600 hover:text-slate-900 hover:border-slate-900 hover:shadow-lg transition-all rounded-lg shadow-sm">
                            Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-10 text-center text-black/40 text-xs uppercase tracking-widest">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
        {{ $orders->links() }}
    </div>
</div>
@endsection
