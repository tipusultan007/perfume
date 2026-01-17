@extends('emails.orders.layout')

@section('content')
<h2>Your Order Has Shipped!</h2>
<p>Dear {{ $order->user->name }},</p>
<p>Great news! Your order #{{ $order->order_number }} has been shipped and is on its way to you.</p>

<div class="order-details">
    <p><strong>Shipping Address:</strong><br>
    {{ $order->shipping_address['address'] ?? '' }}<br>
    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['zip'] ?? '' }}
    </p>
</div>

<p>You can track your order status in your account.</p>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn">Track Order</a>
</p>
@endsection
