<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #111;
            line-height: 1.5;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #D4AF37;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-info h1 {
            margin: 0;
            color: #D4AF37;
            font-size: 28px;
            text-transform: uppercase;
        }
        .grid {
            width: 100%;
            margin-bottom: 40px;
        }
        .grid td {
            vertical-align: top;
            width: 50%;
        }
        .section-title {
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 5px;
            display: block;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        table.items th {
            background: #fdf9f4;
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
            text-transform: uppercase;
        }
        table.items td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .totals {
            width: 300px;
            margin-left: auto;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 5px 0;
        }
        .totals .grand-total {
            border-top: 1px solid #D4AF37;
            font-weight: bold;
            font-size: 18px;
            padding-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">L'ESSENCE NYC</div>
        <div class="invoice-info">
            <h1>Invoice</h1>
            <p>#{{ $order->order_number }}<br>Date: {{ $order->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <table class="grid">
        <tr>
            <td>
                <span class="section-title">Billed To:</span>
                <strong>{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</strong><br>
                {{ $order->shipping_address['email'] }}<br>
                {{ $order->shipping_address['phone'] ?? '' }}
            </td>
            <td>
                <span class="section-title">Shipping Address:</span>
                {{ $order->shipping_address['address'] }}<br>
                @if(!empty($order->shipping_address['apartment'])) {{ $order->shipping_address['apartment'] }}<br> @endif
                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zip'] }}<br>
                {{ $order->shipping_address['country'] }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Product</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Price</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <strong>{{ $item->product_name }}</strong>
                    @if($item->variant_name)
                        <br><span style="font-size: 11px; color: #666;">{{ $item->variant_name }}</span>
                    @endif
                </td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td style="text-align: right;">${{ number_format($item->price, 2) }}</td>
                <td style="text-align: right;">${{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td style="text-align: right;">${{ number_format($order->grand_total - $order->tax_amount - $order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td>Shipping:</td>
                <td style="text-align: right;">${{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td>Tax:</td>
                <td style="text-align: right;">${{ number_format($order->tax_amount, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td>Total:</td>
                <td style="text-align: right;">${{ number_format($order->grand_total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for choosing L'ESSENCE NYC.</p>
        <p>&copy; {{ date('Y') }} L'ESSENCE NYC Atelier. All rights reserved.</p>
    </div>
</body>
</html>
