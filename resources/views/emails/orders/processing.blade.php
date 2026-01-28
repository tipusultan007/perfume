@extends('emails.orders.layout')

@section('content')
<h2 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Order #{{ $order->order_number }} Confirmed.</h2>

<p>Hello {{ $order->shipping_address['first_name'] ?? 'there' }},</p>
<p>Thank you for choosing {{ \App\Models\Setting::get('site_name', "L'ESSENCE NYC") }}. We have received your order and our atelier has begun the preparation process.</p>

<div class="order-details" style="background: #fdf9f4; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0; font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">Order Summary</p>
    <div style="margin-top: 15px;">
        <p style="margin: 5px 0;"><strong>Order Number:</strong> {{ $order->order_number }}</p>
        <p style="margin: 5px 0;"><strong>Total Amount:</strong> ${{ number_format($order->grand_total, 2) }}</p>
        <p style="margin: 5px 0;"><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
    </div>
</div>

<p>We will notify you with a shipping confirmation as soon as your signature objects are ready for transit.</p>

<p style="text-align: center; margin-top: 40px;">
    <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}&email={{ $order->shipping_address['email'] }}" class="btn">View Your Order</a>
</p>
@endsection
