@extends('admin.layouts.app')

@section('title', 'Customer Details')
@section('page_title', 'Customer Profile')

@section('content')
<div class="max-w-6xl">
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-xs uppercase tracking-widest text-black/50 hover:text-black transition-colors flex items-center gap-2">
            <i class="ri-arrow-left-line"></i> Back to Customers
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar: Profile & Addresses -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="bg-white border border-black/10 p-8 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center text-3xl font-serif text-black/30">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h2 class="font-serif text-2xl mb-1">{{ $customer->name }}</h2>
                <p class="text-sm text-black/50 mb-6">{{ $customer->email }}</p>
                
                <div class="border-t border-black/5 pt-6 grid grid-cols-2 gap-4 text-center">
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-black/40 mb-1">Total Orders</span>
                        <span class="text-xl font-medium">{{ $customer->orders->count() }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-black/40 mb-1">Member Since</span>
                        <span class="text-xs font-medium">{{ $customer->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="bg-white border border-black/10 p-6">
                <h3 class="font-serif text-lg mb-4 flex items-center gap-2">
                    <i class="ri-map-pin-line text-black/40"></i> Addresses
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest text-black/40 mb-2">Shipping Address</span>
                        @if($customer->shipping_address)
                            <p class="text-sm leading-relaxed text-black/70">
                                {{ $customer->shipping_address['address'] ?? '' }}<br>
                                {{ $customer->shipping_address['city'] ?? '' }}, {{ $customer->shipping_address['state'] ?? '' }} {{ $customer->shipping_address['zip'] ?? '' }}<br>
                                {{ $customer->shipping_address['country'] ?? '' }}
                            </p>
                        @else
                            <p class="text-sm text-black/30 italic">No shipping address saved.</p>
                        @endif
                    </div>
                    
                    <div class="border-t border-black/5 pt-4">
                        <span class="block text-[10px] uppercase tracking-widest text-black/40 mb-2">Billing Address</span>
                        @if($customer->billing_address)
                            <p class="text-sm leading-relaxed text-black/70">
                                {{ $customer->billing_address['address'] ?? '' }}<br>
                                {{ $customer->billing_address['city'] ?? '' }}, {{ $customer->billing_address['state'] ?? '' }} {{ $customer->billing_address['zip'] ?? '' }}<br>
                                {{ $customer->billing_address['country'] ?? '' }}
                            </p>
                        @else
                            <p class="text-sm text-black/30 italic">No billing address saved.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content: Order History -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-black/10">
                <div class="p-6 border-b border-black/10 bg-gray-50/30">
                    <h3 class="font-serif text-lg">Order History</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase tracking-widest text-black/50 border-b border-black/5">
                                <th class="p-5 font-medium">Order ID</th>
                                <th class="p-5 font-medium">Date</th>
                                <th class="p-5 font-medium">Status</th>
                                <th class="p-5 font-medium text-right">Total</th>
                                <th class="p-5 font-medium"></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($customer->orders as $order)
                            <tr class="border-b border-black/5 hover:bg-gray-50/30 transition-colors">
                                <td class="p-5 mono">#{{ $order->id }}</td>
                                <td class="p-5 text-black/60 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="p-5">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-[10px] uppercase tracking-widest font-medium 
                                        {{ $order->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                          ($order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="p-5 text-right font-medium">${{ number_format($order->total ?? 0, 2) }}</td>
                                <td class="p-5 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-black/40 hover:text-black transition-colors">
                                        <i class="ri-arrow-right-line"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-black/40">
                                    <p class="text-sm">No orders found for this customer.</p>
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
