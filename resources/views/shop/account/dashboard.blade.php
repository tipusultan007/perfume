@extends('shop.account.layout')

@section('account_content')
    <div class="dashboard-welcome">
        <h3>Hello, {{ $user->name }}</h3>
        <p style="opacity: 0.7; margin-bottom: 40px;">From your account dashboard you can view your <a href="{{ route('account.orders') }}" style="text-decoration: underline;">recent orders</a>, manage your <a href="{{ route('account.addresses') }}" style="text-decoration: underline;">shipping and billing addresses</a>, and <a href="{{ route('account.details') }}" style="text-decoration: underline;">edit your password and account details</a>.</p>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card">
            <h4>Total Orders</h4>
            <div class="value">{{ \App\Models\Order::where('user_id', $user->id)->count() }}</div>
        </div>
        <div class="stat-card">
            <h4>Account Status</h4>
            <div class="value">Active</div>
        </div>
        <div class="stat-card">
            <h4>Email Address</h4>
            <div class="value" style="font-size: 16px;">{{ $user->email }}</div>
        </div>
    </div>

    @if($recentOrders->count() > 0)
    <div class="recent-orders">
        <h4 class="mono" style="margin-bottom: 20px; opacity: 0.5;">Recent Orders</h4>
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
                @foreach($recentOrders as $order)
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
    </div>
    @endif
@endsection
