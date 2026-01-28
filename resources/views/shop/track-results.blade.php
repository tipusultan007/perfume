@extends('layouts.store')

@section('content')
<div class="checkout-wrapper">
    <div class="checkout-header-section text-center">
        <h1 class="font-serif text-5xl mb-2">Order Tracking</h1>
        <p class="mono opacity-50 text-xs text-uppercase">Order #{{ $order->order_number }}</p>
        <div class="w-20 h-[1px] bg-accent mx-auto mt-6"></div>
    </div>

    <div class="checkout-content-container" style="display: block; max-width: 900px; margin: 0 auto; padding: 0 5% 100px;">
        <div class="bg-white p-10 border border-black/5 shadow-sm">
            <div class="flex justify-between items-center mb-10 pb-6 border-b border-black/5">
                <div>
                    <h3 class="font-serif text-2xl mb-1">Status: {{ ucfirst($order->status) }}</h3>
                    <p class="text-xs opacity-50">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div class="text-right">
                    <span class="status-badge status-{{ strtolower($order->status) }}" style="padding: 8px 20px; border-radius: 30px; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; background: #fafafa; border: 1px solid rgba(0,0,0,0.1);">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            @include('partials.order-timeline', ['order' => $order])

            <div class="mt-12 pt-8 border-t border-black/5 text-center">
                <p class="text-xs opacity-50 mb-6">Need more details? Sign in to your account for full order history.</p>
                <a href="{{ route('order.track') }}" class="text-xs uppercase tracking-widest font-semibold border-b border-black pb-1 hover:border-accent hover:text-accent transition-all">Track another order</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .checkout-header-section {
        background: var(--cream);
        padding: 180px 5% 60px; /* 130px for navbar + 50px spacing */
        margin-bottom: 50px;
        border-bottom: 1px solid var(--border);
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* Status Badge Colors */
    .status-pending { color: #d4af37; border-color: rgba(212, 175, 55, 0.2) !important; background: rgba(212, 175, 55, 0.05) !important; }
    .status-processing { color: #3b82f6; border-color: rgba(59, 130, 246, 0.2) !important; background: rgba(59, 130, 246, 0.05) !important; }
    .status-shipped { color: #8b5cf6; border-color: rgba(139, 92, 246, 0.2) !important; background: rgba(139, 92, 246, 0.05) !important; }
    .status-delivered, .status-completed { color: #10b981; border-color: rgba(16, 185, 129, 0.2) !important; background: rgba(16, 185, 129, 0.05) !important; }
</style>
@endpush
