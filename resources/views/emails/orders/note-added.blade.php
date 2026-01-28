@extends('emails.orders.layout')

@section('content')
    <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 20px; font-weight: 300; margin-bottom: 20px;">An update regarding your Order #{{ $order->order_number }}.</h2>
    
    <p>Hello {{ $order->shipping_address['first_name'] ?? 'there' }},</p>
    
    <p>Our atelier has added a new update to your order:</p>
    
    <div class="order-details" style="font-style: italic; color: #555; border-left: 2px solid #D4AF37; background: #fafafa; padding: 20px; margin: 30px 0;">
        "{{ $note->note }}"
    </div>
    
    <p>You can view the full details of your order and its history by visiting your account dashboard.</p>
    
    <div style="margin-top: 40px; text-align: center;">
        <a href="{{ route('order.track') }}?order_number={{ $order->order_number }}&email={{ $order->shipping_address['email'] }}" class="btn">View Order Details</a>
    </div>
    
    <p style="margin-top: 40px;">Sincerely,<br>The {{ \App\Models\Setting::get('site_name', "L'ESSENCE NYC") }} Team</p>
@endsection
