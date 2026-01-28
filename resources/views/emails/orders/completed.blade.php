@extends('emails.orders.layout')

@section('content')
<h2 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">Delivered & Complete.</h2>

<p>Hello {{ $order->shipping_address['first_name'] ?? 'there' }},</p>
<p>Your order #{{ $order->order_number }} has been successfully delivered. We hope your new signature objects bring a touch of luxury to your daily rituals.</p>

<div class="order-details" style="background: #fdf9f4; border: 1px solid #eee; padding: 20px; margin: 30px 0; text-align: center;">
    <p style="margin: 0; font-style: italic;">"Fragrance is the most intense form of memory."</p>
</div>

<p>We would be honored to hear about your experience. Feel free to share your thoughts or revisit the collection for your next inspiration.</p>

<p style="text-align: center; margin-top: 40px;">
    <a href="{{ url('/shop') }}" class="btn">Return to the Collection</a>
</p>
@endsection
