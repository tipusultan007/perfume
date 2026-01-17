@extends('emails.orders.layout')

@section('content')
<h2>New Order Received</h2>
<p>Hello Admin,</p>
<p>A new order #{{ $order->order_number }} has been placed by {{ $order->user ? $order->user->name : 'Guest' }}.</p>

<div class="order-details">
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Total:</strong> ${{ number_format($order->grand_total, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
</div>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn">Manage Order</a>
</p>
@endsection
