@extends('emails.orders.layout')

@section('content')
<h2 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Refund Processed.</h2>

<p>Hello {{ $order->shipping_address['first_name'] ?? 'there' }},</p>
<p>We are writing to inform you that a refund has been issued for your order #{{ $order->order_number }}.</p>

<div class="order-details" style="background: #fafafa; border: 1px solid #eee; padding: 20px; margin: 30px 0;">
    <p style="margin: 0;"><strong>Status:</strong> <span style="text-transform: uppercase; color: #D4AF37;">Refunded</span></p>
</div>

<p>The funds should appear in your original payment method shortly, depending on your financial institution's processing times.</p>
@endsection
