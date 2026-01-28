@extends('emails.orders.layout')

@section('content')
<div style="text-align: center;">
    <p style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #9ca3af; margin-bottom: 20px;">Order Confirmation</p>
    <h1 style="font-size: 28px; margin-bottom: 30px;">Thank You for Your Order</h1>
    
    <p style="margin-bottom: 30px;">
        Dear {{ $order->user ? $order->user->name : 'Customer' }}, your order has been successfully placed at our atelier and is currently being prepared for curation.
    </p>

    <div class="order-details" style="background: #fdfcf8; border: 1px solid #f3f4f6; padding: 30px; margin: 40px 0; text-align: left;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 5px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Order Number</td>
                <td style="padding: 5px 0; text-align: right; font-weight: 600;">#{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Date</td>
                <td style="padding: 5px 0; text-align: right;">{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 5px 0; font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px;">Total amount</td>
                <td style="padding: 5px 0; text-align: right; font-weight: 600; color: #d4af37;">${{ number_format($order->grand_total, 2) }}</td>
            </tr>
        </table>
    </div>

    <h3 style="text-align: left; font-size: 13px; text-transform: uppercase; letter-spacing: 2px; border-bottom: 1px solid #f3f4f6; padding-bottom: 10px; margin-bottom: 20px;">Curated Items</h3>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 40px;">
        @foreach($order->items as $item)
        <tr style="border-bottom: 1px solid #f3f4f6;">
            <td style="padding: 15px 0; text-align: left;">
                <span style="font-weight: 600; font-size: 14px; display: block;">{{ $item->product_name }}</span>
                @if($item->variant_name)
                    <span style="font-size: 11px; color: #9ca3af; text-transform: uppercase;">{{ $item->variant_name }}</span>
                @endif
            </td>
            <td style="padding: 15px 0; text-align: right; font-size: 14px;">{{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <div style="margin: 50px 0;">
        <a href="{{ route('account.orders.show', $order->id) }}" class="btn">View Your Order Details</a>
    </div>

    <p style="font-size: 13px; font-style: italic; color: #9ca3af; margin-top: 40px;">
        You will receive another notification as soon as your items have been shipped.
    </p>
</div>
@endsection
