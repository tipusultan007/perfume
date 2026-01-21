@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)
@section('page_title', 'Order Details')

@section('content')
<div class="mb-10 flex items-center gap-4">
    <a href="{{ route('admin.orders.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center hover:bg-slate-900 hover:text-white transition-all shadow-sm">
        <i class="ri-arrow-left-line"></i>
    </a>
    <h3 class="font-bold text-2xl text-slate-900">Order <span class="text-slate-400 font-medium">#{{ $order->order_number }}</span></h3>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Left: Order Items & Status -->
    <div class="lg:col-span-2 space-y-10">
        
        <!-- Order Items -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="bg-slate-50/50 px-8 py-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="font-bold text-slate-900 uppercase tracking-widest text-xs">Items Ordered</h3>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Quantity: {{ $order->items->count() }} line items</span>
            </div>
            
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/20 border-b border-slate-50">
                        <th class="px-8 py-4 text-[10px] uppercase tracking-widest text-slate-400 font-bold">Product Information</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-slate-400 font-bold">Unit Price</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-slate-400 font-bold">Qty</th>
                        <th class="px-8 py-4 text-[10px] uppercase tracking-widest text-slate-400 font-bold text-right">Sum Total</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($order->items as $item)
                    <tr class="border-b border-slate-50 hover:bg-slate-50/30 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                @if($item->product && $item->product->hasMedia('featured_image'))
                                    <div class="w-16 h-16 rounded-lg border border-slate-100 p-1 bg-white shadow-sm flex items-center justify-center">
                                        <img src="{{ $item->product->getFirstMediaUrl('featured_image', 'thumb') }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                @else
                                    <div class="w-16 h-16 bg-slate-50 rounded-lg border border-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-400 uppercase">No Img</div>
                                @endif
                                <div>
                                    <div class="text-sm font-bold text-slate-900">{{ $item->product_name }}</div>
                                    @if($item->variant_name)
                                        <div class="text-[9px] uppercase tracking-widest font-bold text-slate-500 mt-1">{{ $item->variant_name }}</div>
                                    @endif
                                    <div class="text-[9px] font-mono font-bold text-slate-400 mt-1 uppercase tracking-tighter">{{ $item->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-6 font-mono text-xs font-bold text-slate-500">${{ number_format($item->price, 2) }}</td>
                        <td class="py-6 font-mono text-xs font-bold text-slate-500">x{{ $item->quantity }}</td>
                        <td class="px-8 py-6 text-right font-mono text-sm font-bold text-slate-900">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-8 py-10 bg-slate-50/50 flex justify-end border-t border-slate-100">
                <div class="w-full md:w-1/2 space-y-4">
                    <div class="flex justify-between text-[11px] uppercase tracking-widest font-bold text-slate-500">
                        <span>Subtotal</span>
                        <span class="text-slate-900 font-mono">${{ number_format($order->items->sum('total'), 2) }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] uppercase tracking-widest font-bold text-slate-500">
                        <span>Shipping</span>
                        <span class="text-slate-900 font-mono">${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] uppercase tracking-widest font-bold text-slate-500">
                        <span>Tax</span>
                        <span class="text-slate-900 font-mono">${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-lg font-bold border-t border-slate-200 pt-6 mt-6">
                        <span class="text-slate-900 uppercase tracking-widest text-sm">Grand Total</span>
                        <span class="text-slate-900 font-mono">${{ number_format($order->grand_total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Customer & Actions -->
    <div class="space-y-10">
        
        <!-- Status Management -->
        <div class="bg-white border border-slate-200 p-8 rounded-xl shadow-sm">
            <h3 class="font-bold text-slate-900 uppercase tracking-widest text-xs mb-8 border-b border-slate-100 pb-4">Order Governance</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Logistics Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold appearance-none cursor-pointer">
                            @foreach(['pending', 'processing', 'shipped', 'completed', 'cancelled', 'refunded'] as $status)
                                <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i class="ri-arrow-down-s-line text-lg"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Financing Status</label>
                    <div class="relative">
                        <select name="payment_status" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-bold appearance-none cursor-pointer">
                            @foreach(['pending', 'paid', 'failed'] as $status)
                                <option value="{{ $status }}" {{ $order->payment_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                            <i class="ri-arrow-down-s-line text-lg"></i>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-6 border-t border-slate-100">
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[10px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                        Commit Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white border border-slate-200 p-8 rounded-xl shadow-sm">
            <h3 class="font-bold text-slate-900 uppercase tracking-widest text-xs mb-8 border-b border-slate-100 pb-4">Client Dossier</h3>
            
            <div class="mb-8">
                <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Legal Name</span>
                <span class="text-sm font-bold text-slate-900">{{ $order->shipping_address['name'] ?? 'Guest Customer' }}</span>
            </div>
            
            <div class="mb-8">
                <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Electronic Mail</span>
                <a href="mailto:{{ $order->shipping_address['email'] ?? '' }}" class="block text-sm font-bold text-slate-900 hover:text-slate-600 transition-colors">{{ $order->shipping_address['email'] ?? 'N/A' }}</a>
                <span class="block text-xs font-bold text-slate-400 mt-2">{{ $order->shipping_address['phone'] ?? 'N/A' }}</span>
            </div>

            <div class="mb-8 p-4 bg-slate-50 rounded-lg border border-slate-100">
                <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-3">Courier Destination</span>
                <p class="text-xs font-bold text-slate-700 leading-relaxed uppercase tracking-wide">
                    {{ $order->shipping_address['address'] ?? '' }}<br>
                    <span class="text-slate-400">{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}</span>
                </p>
            </div>

            <div class="pt-6 border-t border-slate-100">
                 <span class="block text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-3">Billing Records</span>
                 @if(json_encode($order->shipping_address) === json_encode($order->billing_address))
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Synchronized with shipping</span>
                 @else
                    <p class="text-xs font-bold text-slate-700 leading-relaxed uppercase tracking-wide">
                        {{ $order->billing_address['address'] ?? '' }}<br>
                        <span class="text-slate-400">{{ $order->billing_address['city'] ?? '' }} {{ $order->billing_address['zip'] ?? '' }}</span>
                    </p>
                 @endif
            </div>
        </div>
    </div>
</div>
@endsection
