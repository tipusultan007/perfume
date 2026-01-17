@extends('emails.orders.layout')

@section('content')
<h2>Order Delivered</h2>
<p>Dear {{ $order->user->name }},</p>
<p>Your order #{{ $order->order_number }} has been marked as completed. We hope you enjoy your purchase!</p>

<p>If you have any questions or feedback, please let us know.</p>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn">View Order</a>
</p>
@endsection
