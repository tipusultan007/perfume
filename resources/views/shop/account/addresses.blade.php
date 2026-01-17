@extends('shop.account.layout')

@section('account_content')
    <h3>Addresses</h3>
    
    @if(session('success'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; margin-bottom: 30px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <p style="opacity: 0.6; margin-bottom: 40px;">The following addresses will be used on the checkout page by default.</p>

    <div class="dashboard-grid">
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="margin-bottom: 0;">Billing Address</h4>
                <a href="{{ route('account.addresses.edit', 'billing') }}" class="mono" style="font-size: 10px; text-decoration: underline;">Edit</a>
            </div>
            <div style="font-size: 14px; opacity: 0.7; line-height: 1.8;">
                @if($billingAddress)
                    {{ $billingAddress['first_name'] }} {{ $billingAddress['last_name'] }}<br>
                    {{ $billingAddress['address'] ?? '' }} ({{ $billingAddress['apartment'] ?? '' }})<br>
                    {{ $billingAddress['city'] ?? '' }}, {{ $billingAddress['state'] ?? '' }} {{ $billingAddress['zip'] ?? '' }}<br>
                    {{ $billingAddress['country'] ?? '' }}
                @else
                    You have not set up this type of address yet.
                @endif
            </div>
        </div>
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="margin-bottom: 0;">Shipping Address</h4>
                <a href="{{ route('account.addresses.edit', 'shipping') }}" class="mono" style="font-size: 10px; text-decoration: underline;">Edit</a>
            </div>
            <div style="font-size: 14px; opacity: 0.7; line-height: 1.8;">
                @if($shippingAddress)
                    {{ $shippingAddress['first_name'] }} {{ $shippingAddress['last_name'] }}<br>
                    {{ $shippingAddress['address'] ?? '' }} ({{ $shippingAddress['apartment'] ?? '' }})<br>
                    {{ $shippingAddress['city'] ?? '' }}, {{ $shippingAddress['state'] ?? '' }} {{ $shippingAddress['zip'] ?? '' }}<br>
                    {{ $shippingAddress['country'] ?? '' }}
                @else
                    You have not set up this type of address yet.
                @endif
            </div>
        </div>
    </div>
@endsection
