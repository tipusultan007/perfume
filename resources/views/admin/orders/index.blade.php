@extends('admin.layouts.app')

@section('title', 'Manage Orders')
@section('page_title', 'Orders')

@section('content')
<div class="bg-white p-10 shadow-sm border border-black/[0.03]">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-black/5">
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Order #</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Customer</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Date</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Status</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Total</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($orders as $order)
                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors">
                    <td class="py-6 font-mono text-xs">{{ $order->order_number }}</td>
                    <td class="font-medium">
                        <div class="flex flex-col">
                            <span>{{ $order->shipping_address['name'] ?? 'Guest' }}</span>
                            <span class="text-[10px] opacity-40 uppercase tracking-tighter">{{ $order->user->email ?? $order->shipping_address['email'] ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="opacity-60 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-50 text-yellow-700',
                                'processing' => 'bg-blue-50 text-blue-700',
                                'shipped' => 'bg-purple-50 text-purple-700',
                                'completed' => 'bg-green-50 text-green-700',
                                'cancelled' => 'bg-red-50 text-red-700',
                                'refunded' => 'bg-gray-100 text-gray-700',
                            ];
                        @endphp
                        <span class="inline-block px-2 py-1 {{ $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-700' }} text-[10px] rounded uppercase tracking-wider">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="font-mono text-xs">${{ number_format($order->grand_total, 2) }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-luxury-accent hover:text-luxury-black transition-colors uppercase text-[10px] tracking-widest font-semibold">
                            View Details
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
    
    <div class="mt-10">
        {{ $orders->links() }}
    </div>
</div>
@endsection
