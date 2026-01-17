@extends('emails.orders.layout')

@section('content')
<h2>Order Refunded</h2>
<p>Dear {{ $order->user->name }},</p>
<p>A refund has been processed for your order #{{ $order->order_number }}.</p>

<p>Please check your account or payment provider for details. It may take a few business days to appear.</p>
@endsection
