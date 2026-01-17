@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)
@section('page_title', 'Order Details')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Left: Order Items & Status -->
    <div class="lg:col-span-2 space-y-10">
        
        <!-- Order Items -->
        <div class="bg-white border border-black/5 p-10">
            <div class="flex justify-between items-center mb-8 border-b border-black/5 pb-4">
                <h3 class="font-serif text-xl">Items</h3>
                <span class="font-mono text-sm opacity-60">{{ $order->order_number }}</span>
            </div>
            
            <table class="w-full text-left mb-8">
                <thead>
                    <tr class="border-b border-black/5">
                        <th class="py-4 text-[10px] uppercase tracking-widest text-black/40">Product</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-black/40">Cost</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-black/40">Qty</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-black/40 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($order->items as $item)
                    <tr class="border-b border-black/5">
                        <td class="py-6">
                            <div class="flex items-center gap-4">
                                @if($item->product && $item->product->hasMedia('featured_image'))
                                    <img src="{{ $item->product->getFirstMediaUrl('featured_image', 'thumb') }}" class="w-12 h-12 object-cover border border-black/5">
                                @else
                                    <div class="w-12 h-12 bg-gray-50 border border-black/5"></div>
                                @endif
                                <div>
                                    <div class="font-medium">{{ $item->product_name }}</div>
                                    @if($item->variant_name)
                                        <div class="text-[10px] uppercase tracking-widest opacity-60">{{ $item->variant_name }}</div>
                                    @endif
                                    <div class="text-[10px] font-mono opacity-40">{{ $item->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="font-mono text-xs opacity-60">${{ number_format($item->price, 2) }}</td>
                        <td class="font-mono text-xs opacity-60">x{{ $item->quantity }}</td>
                        <td class="text-right font-mono text-xs font-semibold">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-full md:w-1/2 space-y-3">
                    <div class="flex justify-between text-sm opacity-60">
                        <span>Subtotal</span>
                        <span class="font-mono">${{ number_format($order->items->sum('total'), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm opacity-60">
                        <span>Shipping</span>
                        <span class="font-mono">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm opacity-60">
                        <span>Tax</span>
                        <span class="font-mono">${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-serif border-t border-black/5 pt-4 mt-4">
                        <span>Total</span>
                        <span class="font-mono">${{ number_format($order->grand_total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Customer & Actions -->
    <div class="space-y-10">
        
        <!-- Status Management -->
        <div class="bg-white border border-black/5 p-8">
            <h3 class="font-serif text-lg mb-6">Order Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Order Status</label>
                    <select name="status" class="w-full py-2 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'] as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Payment Status</label>
                    <select name="payment_status" class="w-full py-2 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        @foreach(['pending', 'paid', 'failed'] as $status)
                            <option value="{{ $status }}" {{ $order->payment_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="w-full py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-lg">
                    Update Order
                </button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white border border-black/5 p-8">
            <h3 class="font-serif text-lg mb-6">Customer Details</h3>
            
            <div class="mb-6">
                <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Name</span>
                <span class="text-sm font-medium">{{ $order->shipping_address['name'] ?? 'N/A' }}</span>
            </div>
            
            <div class="mb-6">
                <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Contact</span>
                <a href="mailto:{{ $order->shipping_address['email'] ?? '' }}" class="block text-sm hover:text-luxury-accent transition-colors">{{ $order->shipping_address['email'] ?? 'N/A' }}</a>
                <span class="block text-sm opacity-60 mt-1">{{ $order->shipping_address['phone'] ?? 'N/A' }}</span>
            </div>

            <div class="mb-6">
                <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Shipping Address</span>
                <p class="text-sm opacity-60 leading-relaxed">
                    {{ $order->shipping_address['address'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}
                </p>
            </div>

            <div class="pt-6 border-t border-black/5">
                 <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Billing Address</span>
                 @if(json_encode($order->shipping_address) === json_encode($order->billing_address))
                    <span class="text-xs italic opacity-60">Same as shipping</span>
                 @else
                    <p class="text-sm opacity-60 leading-relaxed">
                        {{ $order->billing_address['address'] ?? '' }}<br>
                        {{ $order->billing_address['city'] ?? '' }} {{ $order->billing_address['zip'] ?? '' }}
                    </p>
                 @endif
            </div>
        </div>
    </div>
</div>
@endsection
