@extends('emails.orders.layout')

@section('content')
<h2>Order Cancelled</h2>
<p>Dear {{ $order->user->name }},</p>
<p>Your order #{{ $order->order_number }} has been cancelled.</p>

<p>If you believe this is an error or have any questions, please contact our support team.</p>
@endsection
