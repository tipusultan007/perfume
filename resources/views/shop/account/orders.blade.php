@extends('shop.account.layout')

@section('account_content')
    <h3>Orders</h3>

    @if($orders->count() > 0)
    <table class="account-table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                    <span class="status-badge status-{{ strtolower($order->status) }}">
                        {{ $order->status }}
                    </span>
                </td>
                <td>${{ number_format($order->grand_total, 2) }}</td>
                <td>
                    <a href="{{ route('account.orders.show', $order->id) }}" class="mono" style="font-size: 10px; text-decoration: underline;">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        {{ $orders->links('pagination::simple-tailwind') }}
    </div>
    @else
    <p style="opacity: 0.6;">No orders placed yet. <a href="{{ route('shop') }}" style="text-decoration: underline;">Go to Shop</a></p>
    @endif
@endsection
