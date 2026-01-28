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
    <section class="cart-items" id="page-cart-items">
        @include('shop.partials.cart-items')
    </section>

    <aside class="cart-summary">
        <h2 class="summary-title">Summary</h2>
        <div class="summary-row">
            <span>Subtotal</span>
            <span id="page-cart-subtotal" class="mono">${{ number_format($subtotal, 2) }}</span>
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
            <span id="page-cart-total" class="mono">${{ number_format($subtotal, 2) }}</span>
        </div>

        <div class="gift-note-toggle">
            <input type="checkbox" id="gift">
            <label for="gift">Include a complimentary handwritten gift note and premium Manhattan packaging.</label>
        </div>

        <button class="checkout-btn" onclick="location.href='{{ route('checkout') }}'">Begin Checkout</button>

        <p style="text-align: center; font-size: 10px; margin-top: 20px; opacity: 0.5; text-transform: uppercase; letter-spacing: 1px;">
            Secure Checkout &middot; SSL Encrypted
        </p>
    </aside>
    @else
        <div class="text-center py-20 w-full" style="grid-column: span 2;">
            <h2 class="serif text-2xl mb-4">Your bag is empty</h2>
            <a href="{{ route('shop') }}" class="btn-luxe text-black border-black hover:bg-black hover:text-white">Continue Shopping</a>
        </div>
    @endif
</main>
@endsection

@section('scripts')
<script>
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
            updatePageCart(data);
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
            updatePageCart(data);
        });
    }

    function updatePageCart(data) {
        // Update Drawer
        document.getElementById('cart-drawer-body').innerHTML = data.html;
        document.getElementById('cart-subtotal').innerText = '$' + data.subtotal;
        updateCartCount(data.count);

        // Update Main Page
        const itemsContainer = document.getElementById('page-cart-items');
        if (itemsContainer) {
            if (data.count > 0) {
                itemsContainer.innerHTML = data.page_html;
                document.getElementById('page-cart-subtotal').innerText = '$' + data.subtotal;
                document.getElementById('page-cart-total').innerText = '$' + data.subtotal;
            } else {
                // If cart is empty, redirect or refresh to show empty state
                window.location.reload();
            }
        }
    }
</script>
@endsection
