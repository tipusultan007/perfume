@foreach($cartItems as $key => $item)
<div class="cart-item" data-key="{{ $item['key'] }}">
    <div class="item-img">
        @if(isset($item['image']))
            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
        @else
            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                <i class="ri-image-line text-2xl opacity-20"></i>
            </div>
        @endif
    </div>
    <div class="item-details">
        <div class="item-top">
            <div class="item-title">
                <h3>{{ $item['name'] }}</h3>
                <p class="item-meta">{{ $item['options'] }}</p>
            </div>
            <span class="item-price">${{ number_format($item['price'], 2) }}</span>
        </div>
        <div class="item-actions">
            <div class="qty-box">
                <button onclick="updateCartQty('{{ $item['key'] }}', {{ $item['quantity'] - 1 }})">&minus;</button>
                <p>{{ $item['quantity'] }}</p>
                <button onclick="updateCartQty('{{ $item['key'] }}', {{ $item['quantity'] + 1 }})">&plus;</button>
            </div>
            <span class="remove-link" onclick="removeFromCart('{{ $item['key'] }}')">Remove</span>
        </div>
    </div>
</div>
@endforeach
