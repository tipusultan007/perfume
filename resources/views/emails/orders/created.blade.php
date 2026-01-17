@extends('emails.orders.layout')

@section('content')
<h2>Ty for Order!</h2>
<p>Dear {{ $order->user ? $order->user->name : 'Customer' }},</p>
<p>Thank you for shopping with us. Your order #{{ $order->order_number }} has been placed successfully.</p>

<div class="order-details">
    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
    <p><strong>Total:</strong> ${{ number_format($order->grand_total, 2) }}</p>
    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
</div>

<h3>Items</h3>
<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    @foreach($order->items as $item)
    <tr style="border-bottom: 1px solid #eee;">
        <td style="padding: 10px 0;">{{ $item->product_name }} @if($item->variant_name) ({{ $item->variant_name }}) @endif x {{ $item->quantity }}</td>
        <td style="padding: 10px 0; text-align: right;">${{ number_format($item->price * $item->quantity, 2) }}</td>
    </tr>
    @endforeach
</table>

<p style="text-align: center; margin-top: 30px;">
    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn">View Order</a>
</p>
@endsection
