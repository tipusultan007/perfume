@extends('admin.layouts.app')

@section('title', 'Customer Details')
@section('page_title', 'Customer Profile')

@section('content')
<div class="max-w-6xl">
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('admin.customers.index') }}" 
            class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
            <i class="ri-arrow-left-line text-lg"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Profile & Addresses -->
        <div class="space-y-8">
            <!-- Profile Card -->
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm text-center">
                <div class="w-24 h-24 bg-slate-50 border border-slate-100 rounded-full mx-auto mb-6 flex items-center justify-center text-3xl font-bold text-slate-400">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h2 class="font-bold text-2xl text-slate-900 mb-1">{{ $customer->name }}</h2>
                <p class="text-sm text-slate-500 font-medium mb-8">{{ $customer->email }}</p>
                
                <div class="border-t border-slate-50 pt-8 grid grid-cols-2 gap-4 text-center">
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Total Orders</span>
                        <span class="text-xl font-bold text-slate-900">{{ $customer->orders->count() }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Member Since</span>
                        <span class="text-xs font-bold text-slate-900">{{ $customer->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="bg-white border border-slate-200 p-8 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-6 flex items-center gap-3">
                    <i class="ri-map-pin-line text-slate-300"></i> Saved Addresses
                </h3>
                
                <div class="space-y-8">
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-3">Shipping Address</span>
                        @if($customer->shipping_address)
                            <p class="text-sm leading-relaxed text-slate-600 font-medium">
                                {{ $customer->shipping_address['address'] ?? '' }}<br>
                                {{ $customer->shipping_address['city'] ?? '' }}, {{ $customer->shipping_address['state'] ?? '' }} {{ $customer->shipping_address['zip'] ?? '' }}<br>
                                {{ $customer->shipping_address['country'] ?? '' }}
                            </p>
                        @else
                            <p class="text-sm text-slate-300 italic font-medium">No shipping address saved.</p>
                        @endif
                    </div>
                    
                    <div class="border-t border-slate-50 pt-6">
                        <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-3">Billing Address</span>
                        @if($customer->billing_address)
                            <p class="text-sm leading-relaxed text-slate-600 font-medium">
                                {{ $customer->billing_address['address'] ?? '' }}<br>
                                {{ $customer->billing_address['city'] ?? '' }}, {{ $customer->billing_address['state'] ?? '' }} {{ $customer->billing_address['zip'] ?? '' }}<br>
                                {{ $customer->billing_address['country'] ?? '' }}
                            </p>
                        @else
                            <p class="text-sm text-slate-300 italic font-medium">No billing address saved.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Order History -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                    <h3 class="font-bold text-lg text-slate-900">Order History</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-[10px] uppercase tracking-[0.15em] text-slate-500 font-bold border-b border-slate-100">
                                <th class="px-8 py-5">Order ID</th>
                                <th class="px-8 py-5">Date</th>
                                <th class="px-8 py-5">Status</th>
                                <th class="px-8 py-5 text-right">Total</th>
                                <th class="px-8 py-5"></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($customer->orders as $order)
                            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-all group">
                                <td class="px-8 py-6 font-mono text-xs text-slate-400 font-bold group-hover:text-slate-900 transition-colors">#{{ $order->id }}</td>
                                <td class="px-8 py-6 text-slate-500 text-xs font-semibold">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center px-4 py-1.5 border text-[10px] font-bold rounded-full uppercase tracking-widest
                                        {{ $order->status === 'completed' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 
                                          ($order->status === 'pending' ? 'bg-amber-50 border-amber-100 text-amber-600' : 
                                          ($order->status === 'cancelled' ? 'bg-rose-50 border-rose-100 text-rose-600' : 'bg-slate-100 border-slate-200 text-slate-500')) }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-slate-900">${{ number_format($order->total ?? 0, 2) }}</td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                        class="w-10 h-10 inline-flex items-center justify-center bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white rounded-lg transition-all shadow-sm">
                                        <i class="ri-arrow-right-line text-lg"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-slate-400">
                                    <div class="flex flex-col items-center gap-4">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                            <i class="ri-shopping-bag-line text-3xl text-slate-200"></i>
                                        </div>
                                        <p class="text-sm font-bold uppercase tracking-widest">No orders found</p>
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
</div>
@endsection

