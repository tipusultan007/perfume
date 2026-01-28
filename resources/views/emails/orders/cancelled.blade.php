@extends('emails.orders.layout')

@section('content')
<h2 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Order Update.</h2>

<p>Hello {{ $order->shipping_address['first_name'] ?? 'there' }},</p>
<p>This message is to confirm that your order #{{ $order->order_number }} has been officially {{ $order->status }}.</p>

<div class="order-details" style="background: #fafafa; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0;"><strong>Status:</strong> <span style="text-transform: uppercase; color: #999;">{{ ucfirst($order->status) }}</span></p>
</div>

<p>If you have any questions or would like to discuss this further, our concierge team is always available at <a href="mailto:info@lessence.nyc">info@lessence.nyc</a>.</p>
@endsection
