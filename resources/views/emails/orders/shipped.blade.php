@extends('emails.orders.layout')

@section('content')
<h2 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Your Order has Shipped.</h2>

<p>Hello {{ $order->shipping_address['first_name'] ?? 'there' }},</p>
<p>Wonderful news! Your order #{{ $order->order_number }} has been carefully prepared and is now en route to your destination.</p>

<div class="order-details" style="background: #fdf9f4; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0; font-size: 13px; color: #666; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">Destination</p>
    <div style="margin-top: 15px;">
        <p style="margin: 5px 0;"><strong>Address:</strong><br>
        {{ $order->shipping_address['address'] ?? '' }}<br>
        {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['zip'] ?? '' }}
        </p>
    </div>
</div>

<p>You can track the progress of your delivery by visiting your order status page below.</p>

<p style="text-align: center; margin-top: 40px;">
    <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}&email={{ $order->shipping_address['email'] }}" class="btn">Track Your Delivery</a>
</p>
@endsection
