@extends('layouts.store')

@section('title', 'Your Bag | L\'ESSENCE NYC')

@section('styles')
<style>
    /* Cart Layout from static template */
    .cart-container {
        max-width: 1200px;
        margin: 140px auto 100px;
        padding: 0 5%;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 80px;
    }

    .cart-header {
        grid-column: span 2;
        margin-bottom: 40px;
    }

    .cart-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.5rem;
        margin-bottom: 10px;
        font-weight: 300;
    }

    /* Cart Items */
    .cart-items {
        border-top: 1px solid rgba(0,0,0,0.1);
    }

    .cart-item {
        display: flex;
        gap: 30px;
        padding: 20px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }

    .item-img {
        aspect-ratio: 1/1.2;
        background: #f9f7f2;
        overflow: hidden;
    }

    .item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .item-top {
        display: flex;
        justify-content: space-between;
    }

    .item-title h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .item-meta {
        font-size: 12px;
        opacity: 0.5;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .item-price {
        font-size: 14px;
        font-weight: 500;
    }

    .item-actions {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .qty-box {
        display: flex;
        align-items: center;
        border: 1px solid rgba(0,0,0,0.1);
        padding: 5px 15px;
        gap: 20px;
        font-size: 13px;
    }

    .qty-box button {
        cursor: pointer;
        background: none;
        border: none;
        font-size: 16px;
    }

    .remove-link {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid black;
        padding-bottom: 2px;
        cursor: pointer;
    }

    /* Summary Panel */
    .cart-summary {
        background: #f9f7f2;
        padding: 40px;
        height: fit-content;
        position: sticky;
        top: 120px;
    }

    .summary-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        margin-bottom: 30px;
        font-weight: 300;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .summary-total {
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        font-size: 20px;
        font-weight: 600;
    }

    .checkout-btn {
        width: 100%;
        padding: 20px;
        background: #0a0a0a;
        color: white;
        border: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        margin-top: 30px;
        cursor: pointer;
        transition: opacity 0.3s;
    }

    .checkout-btn:hover {
        opacity: 0.9;
    }

    .gift-note-toggle {
        margin-top: 30px;
        font-size: 12px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
        opacity: 0.8;
    }

    @media (max-width: 1024px) {
        .cart-container {
            grid-template-columns: 1fr;
            gap: 40px;
            margin-top: 120px;
        }
        .cart-summary { position: static; }
    }

    @media (max-width: 768px) {
        .cart-container { margin-top: 100px; }
        .cart-item { flex-direction: column; gap: 15px; padding: 25px 0; }
        .item-img { width: 100%; max-width: 200px; margin: 0 auto; }
        .item-top { flex-direction: column; gap: 10px; align-items: flex-start; }
        .item-actions { flex-direction: column; align-items: flex-start; gap: 15px; }
        .qty-box { width: 100%; justify-content: center; }
    }
</style>
@endsection

@section('content')
<main class="cart-container">
    <header class="cart-header">
        <p class="mono" style="opacity: 0.5; margin-bottom: 10px;">Your Selection</p>
        <h1>Shopping Bag</h1>
    </header>

    @if(count($cartItems) > 0)
    <section class="cart-items">
        @foreach($cartItems as $key => $item)
        <div class="cart-item" data-key="{{ $key }}">
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
                        <button onclick="updateCartQty('{{ $key }}', {{ $item['quantity'] - 1 }})">&minus;</button>
                        <p>{{ $item['quantity'] }}</p>
                        <button onclick="updateCartQty('{{ $key }}', {{ $item['quantity'] + 1 }})">&plus;</button>
                    </div>
                    <span class="remove-link" onclick="removeFromCart('{{ $key }}')">Remove</span>
                </div>
            </div>
        </div>
        @endforeach
    </section>

    <aside class="cart-summary">
        <h2 class="summary-title">Summary</h2>
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="page-cart-subtotal">${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="summary-row">
            <span>Estimated Shipping</span>
            <span class="mono" style="font-size: 9px;">Complimentary</span>
        </div>
        <div class="summary-row">
            <span>Estimated Tax</span>
            <span>Calculated at checkout</span>
        </div>
        <div class="summary-row summary-total">
            <span>Total</span>
            <span id="page-cart-total">${{ number_format($subtotal, 2) }}</span>
        </div>

        <div class="gift-note-toggle">
            <input type="checkbox" id="gift">
            <label for="gift">Include a complimentary handwritten gift note and premium Manhattan packaging.</label>
        </div>

        <button class="checkout-btn" onclick="location.href='#'">Begin Checkout</button>

        <p style="text-align: center; font-size: 10px; margin-top: 20px; opacity: 0.5; text-transform: uppercase; letter-spacing: 1px;">
            Secure Checkout &middot; SSL Encrypted
        </p>
    </aside>
    @else
        <div class="text-center py-20">
            <h2 class="serif text-2xl mb-4">Your bag is empty</h2>
            <a href="{{ route('shop') }}" class="btn-luxe text-black border-black hover:bg-black hover:text-white">Continue Shopping</a>
        </div>
    @endif
</main>
@endsection

@section('scripts')
<script>
    // Override global functions to reload page on change if needed, or update DOM dynamically
    // Actually our global functions update the drawer. 
    // We should probably redirect the global functions to reload the page or update this specific view as well
    // For simplicity, let's reuse the global functions but add a listener or override them for this page?
    // No, the global functions in layout.store use AJAX and update #cart-drawer-body. 
    // On this page, we want to update the page content.
    
    // Let's create specific functions for this page or modify global ones.
    // Since global ones are in layout, we can overwrite them here for this specific page context.
    
    // Overwriting global removeFromCart to reload page
    window.removeFromCart = function(key) {
        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ key: key })
        })
        .then(res => res.json())
        .then(data => {
            toastr.success('Item removed');
            window.location.reload(); 
        });
    }

    window.updateCartQty = function(key, quantity) {
        if(quantity < 1) return;
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ key: key, quantity: quantity })
        })
        .then(res => res.json())
        .then(data => {
            window.location.reload();
        });
    }
</script>
@endsection
