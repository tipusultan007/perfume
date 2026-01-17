@extends('emails.orders.layout')

@section('content')
<h2>Order #{{ $order->order_number }} Confirmed</h2>
<p>Dear {{ $order->user->name }},</p>
<p>Thank you for your order! We have received it and are currently processing it.</p>

<div class="order-details">
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Total Amount:</strong> ${{ number_format($order->grand_total, 2) }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
</div>

<p>We will notify you once your order has been shipped.</p>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn">View Order</a>
</p>
@endsection
