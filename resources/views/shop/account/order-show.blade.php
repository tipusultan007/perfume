@extends('shop.account.layout')

@section('account_content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h3>Order #{{ $order->order_number }}</h3>
        <span class="status-badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span>
    </div>

    <p style="opacity: 0.6; margin-bottom: 30px;">Order was placed on <strong>{{ $order->created_at->format('M d, Y') }}</strong> and is currently <strong>{{ $order->status }}</strong>.</p>

    <h4 class="mono" style="margin-bottom: 20px; opacity: 0.5;">Order Details</h4>
    <table class="account-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item->product->name }} x {{ $item->quantity }}
                    @if($item->variant_name)
                        <br><small style="opacity: 0.5;">{{ $item->variant_name }}</small>
                    @endif
                </td>
                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td style="padding-top: 30px; border-bottom: none;">Subtotal:</td>
                <td style="padding-top: 30px; border-bottom: none;">${{ number_format($order->grand_total - $order->tax_amount - $order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td style="border-bottom: none;">Shipping:</td>
                <td style="border-bottom: none;">${{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td style="border-bottom: none;">Tax:</td>
                <td style="border-bottom: none;">${{ number_format($order->tax_amount, 2) }}</td>
            </tr>
            <tr>
                <td style="font-weight: 600; font-size: 1.2rem;">Total:</td>
                <td style="font-weight: 600; font-size: 1.2rem;">${{ number_format($order->grand_total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="dashboard-grid" style="margin-top: 60px;">
        <div class="stat-card">
            <h4>Billing Address</h4>
            <div style="font-size: 14px; opacity: 0.7; line-height: 1.8;">
                @if($order->billing_address)
                    {{ $order->billing_address['first_name'] }} {{ $order->billing_address['last_name'] }}<br>
                    {{ $order->billing_address['address'] ?? '' }}<br>
                    {{ $order->billing_address['city'] ?? '' }}, {{ $order->billing_address['state'] ?? '' }} {{ $order->billing_address['zip'] ?? '' }}<br>
                    {{ $order->billing_address['country'] ?? '' }}
                @else
                    No billing address specified.
                @endif
            </div>
        </div>
        <div class="stat-card">
            <h4>Shipping Address</h4>
            <div style="font-size: 14px; opacity: 0.7; line-height: 1.8;">
                @if($order->shipping_address)
                    {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}<br>
                    {{ $order->shipping_address['address'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zip'] ?? '' }}<br>
                    {{ $order->shipping_address['country'] ?? '' }}
                @else
                    No shipping address specified.
                @endif
            </div>
        </div>
    </div>
@endsection
