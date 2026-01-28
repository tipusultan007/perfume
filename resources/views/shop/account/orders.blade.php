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
                    <span style="margin: 0 5px; opacity: 0.3;">|</span>
                    <a href="{{ route('account.orders.invoice', $order->id) }}" class="mono" style="font-size: 10px; text-decoration: underline;">Download</a>
                    <span style="margin: 0 5px; opacity: 0.3;">|</span>
                    <form action="{{ route('account.orders.reorder', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="mono" style="font-size: 10px; text-decoration: underline; background: none; border: none; padding: 0; cursor: pointer; color: inherit;">Order Again</button>
                    </form>
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
