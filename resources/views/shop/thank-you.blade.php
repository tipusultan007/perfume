@extends('layouts.store')

@section('title', "Order Confirmed | NewKirk NYC")

@section('styles')
<style>
    /* --- 2. Success Hero --- */
    .success-hero {
        padding: 140px 5% 60px;
        text-align: center;
        max-width: 700px;
        margin: 0 auto;
        animation: fadeIn 1s ease;
    }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .success-hero h1 { font-size: clamp(3rem, 8vw, 5rem); line-height: 1; margin-bottom: 25px; }
    .success-hero p { font-size: 15px; opacity: 0.7; max-width: 500px; margin: 0 auto; line-height: 1.8; }
    .order-id { display: inline-block; margin-top: 30px; font-weight: 600; font-size: 11px; letter-spacing: 2px; color: var(--accent); }

    /* --- 3. Order Status Timeline --- */
    .status-tracker {
        max-width: 800px;
        margin: 40px auto 80px;
        padding: 0 5%;
    }
    .timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
    }
    .timeline::before {
        content: ''; position: absolute; top: 10px; left: 0; width: 100%; height: 1px;
        background: var(--border); z-index: 1;
    }
    .t-step { position: relative; z-index: 2; background: white; text-align: center; padding: 0 10px; }
    .t-dot { width: 20px; height: 20px; border: 1px solid var(--border); border-radius: 50%; background: white; margin: 0 auto 15px; }
    .t-step.active .t-dot { background: var(--black); border-color: var(--black); }
    .t-label { font-size: 10px; text-transform: uppercase; font-weight: 600; letter-spacing: 1px; }

    /* --- 4. Details Grid --- */
    .details-container {
        background: var(--cream);
        padding: 80px 5%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1000px;
        margin: 0 auto 100px;
        gap: 60px;
    }
    .detail-box h3 { font-size: 1.8rem; margin-bottom: 20px; }
    .detail-box p { font-size: 14px; opacity: 0.7; line-height: 2; }
    .order-review {
        max-width: 1000px;
        margin: 0 auto 100px;
        padding: 0 5%;
    }
    .order-review h2 {
        font-size: clamp(2rem, 4vw, 3rem);
        margin-bottom: 30px;
        text-align: center;
    }
    .order-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }
    .order-table th,
    .order-table td {
        padding: 18px 0;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
        text-align: left;
        vertical-align: top;
    }
    .order-table th {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.55;
    }
    .order-table th:last-child,
    .order-table td:last-child {
        text-align: right;
    }
    .order-item-meta {
        display: block;
        margin-top: 4px;
        font-size: 12px;
        opacity: 0.55;
    }
    .order-totals {
        max-width: 360px;
        margin-left: auto;
        padding-top: 24px;
    }
    .order-total-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 12px;
        font-size: 14px;
    }
    .order-total-row.final {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid var(--border);
        font-size: 20px;
        font-weight: 600;
    }
    .empty-confirmation {
        max-width: 700px;
        margin: 0 auto 100px;
        padding: 50px 5%;
        text-align: center;
        background: var(--cream);
    }
    .empty-confirmation p {
        opacity: 0.7;
        line-height: 1.8;
        margin-bottom: 28px;
    }

    /* --- 5. Post-Purchase Engagement --- */
    .engagement {
        text-align: center;
        padding-bottom: 120px;
    }
    .engagement h2 { font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 30px; }
    .cta-group { display: flex; justify-content: center; gap: 20px; margin-top: 40px; }
    
    .btn-outline-dark { 
        padding: 18px 45px; 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 2px;
        border: 1px solid var(--black);
        transition: var(--transition);
    }
    .btn-outline-dark:hover {
        background: var(--black);
        color: white;
    }

    @media (max-width: 1024px) {
        .details-container { grid-template-columns: 1fr; text-align: center; margin: 0 20px 80px; }
    }
    @media (max-width: 768px) {
        .success-hero h1 { font-size: 3rem; }
        .timeline { flex-direction: column; gap: 40px; }
        .timeline::before { display: none; }
        .t-step { display: flex; align-items: center; gap: 20px; text-align: left; background: transparent; }
        .t-dot { margin: 0; }
        .cta-group { flex-direction: column; padding: 0 20px; }
        .order-table th:nth-child(2),
        .order-table td:nth-child(2) {
            display: none;
        }
        .order-totals {
            max-width: none;
        }
    }
</style>
@endsection

@section('content')
<main>
    <section class="success-hero">
        <p class="mono" style="margin-bottom: 15px; opacity: 0.5;">Purchase Confirmed</p>
        <h1>Thank You.</h1>
        @if($order)
            <p>Your order is being prepared with care. We have sent a confirmation email to <strong>{{ $order->shipping_address['email'] ?? auth()->user()->email ?? 'your email' }}</strong>.</p>
            <div class="order-id">Order {{ $order->order_number }}</div>
        @else
            <p>Your order confirmation will appear here after checkout is complete.</p>
        @endif
    </section>

    @if($order)
    <section class="status-tracker">
        <div class="timeline">
            <div class="t-step active">
                <div class="t-dot"></div>
                <span class="t-label">Confirmed</span>
            </div>
            <div class="t-step">
                <div class="t-dot"></div>
                <span class="t-label">Preparing</span>
            </div>
            <div class="t-step">
                <div class="t-dot"></div>
                <span class="t-label">Shipped</span>
            </div>
            <div class="t-step">
                <div class="t-dot"></div>
                <span class="t-label">Delivered</span>
            </div>
        </div>
    </section>

    <section class="details-container">
        <div class="detail-box">
            <h3>Delivery Details</h3>
            <p>
                {{ trim(($order->shipping_address['first_name'] ?? '') . ' ' . ($order->shipping_address['last_name'] ?? '')) }}<br>
                {{ $order->shipping_address['address'] ?? '' }}<br>
                {{ $order->shipping_address['city'] ?? '' }}{{ !empty($order->shipping_address['state']) ? ', ' . $order->shipping_address['state'] : '' }} {{ $order->shipping_address['zip'] ?? '' }}<br>
                {{ $order->shipping_address['country'] ?? '' }}<br>
                {{ $order->shipping_address['phone'] ?? '' }}
            </p>
        </div>
        <div class="detail-box">
            <h3>Order Status</h3>
            <p>Estimated Arrival: {{ now()->addDays(5)->format('M d') }} – {{ now()->addDays(7)->format('M d') }}<br>
            Payment: {{ ucfirst($order->payment_status) }} via {{ str_replace('_', ' ', ucfirst($order->payment_method)) }}<br>
            A tracking link will be sent once your items leave our studio.</p>
        </div>
    </section>

    <section class="order-review">
        <h2>Order Details</h2>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product_name }}
                        @if($item->variant_name)
                            <span class="order-item-meta">{{ $item->variant_name }}</span>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-totals">
            <div class="order-total-row">
                <span>Subtotal</span>
                <span>${{ number_format($order->items->sum('total'), 2) }}</span>
            </div>
            <div class="order-total-row">
                <span>Shipping</span>
                <span>{{ $order->shipping_cost > 0 ? '$' . number_format($order->shipping_cost, 2) : 'Free' }}</span>
            </div>
            <div class="order-total-row">
                <span>Tax</span>
                <span>${{ number_format($order->tax_amount, 2) }}</span>
            </div>
            <div class="order-total-row final">
                <span>Total</span>
                <span>${{ number_format($order->grand_total, 2) }}</span>
            </div>
        </div>
    </section>
    @else
    <section class="empty-confirmation">
        <p>No recent order was found for this browser session. You can continue shopping or check your email for an existing order confirmation.</p>
        <a href="{{ route('shop') }}" class="btn-outline-dark">Back to Shop</a>
    </section>
    @endif

    <section class="engagement">
        <h2>While You Wait</h2>
        <p class="serif" style="font-size: 1.2rem; font-style: italic; opacity: 0.7;">Explore the olfactory landscape of New York.</p>
        <div class="cta-group">
            <a href="#" class="btn-luxe bg-black text-white">Read the Journal</a>
            <a href="{{ route('shop') }}" class="btn-outline-dark">Back to Shop</a>
        </div>
    </section>
</main>
@endsection
