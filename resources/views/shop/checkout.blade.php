@extends('layouts.store')

@section('title', 'Checkout')

@section('styles')
<style>
    /* Checkout Specific Styles */
    /* Container Styles */
    .checkout-wrapper {
        padding-bottom: 80px;
    }

    .checkout-content-container {
        max-width: 1600px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        min-height: 100vh;
        padding: 0 5%;
    }

    /* Left Side: Forms */
    .checkout-main {
        padding: 40px 5% 60px 0; /* Adjusted padding */
    }

    .express-checkout {
        margin-bottom: 50px;
        text-align: center;
    }

    .express-btns {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .express-btn {
        flex: 1;
        padding: 14px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-apple { background: black; color: white; }
    .btn-shop { background: #5a31f4; color: white; }

    .form-section { margin-bottom: 35px; }
    .form-section h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        margin-bottom: 15px;
        border-bottom: 1px solid var(--accent);
        padding-bottom: 10px;
    }

    .input-row { display: flex; gap: 10px; margin-bottom: 10px; }
    .input-group { margin-bottom: 10px; flex: 1; }

    input, select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid rgba(0,0,0,0.1);
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
        background: transparent; /* match theme */
    }

    input:focus { border-color: var(--accent); }

    .payment-box {
        border: 1px solid rgba(0,0,0,0.1);
        padding: 20px;
        background: #fafafa;
    }

    /* Right Side: Order Summary */
    .order-summary {
        background: #f9f7f2;
        padding: 60px 10%; /* Adjusted padding */
        border-left: 1px solid rgba(0,0,0,0.1);
        position: sticky;
        top: 140px;
        height: fit-content;
    }

    .summary-list {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 30px;
    }

    .summary-item {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        align-items: center;
    }

    .item-thumb {
        width: 80px;
        height: 100px;
        background: white;
        position: relative;
        border: 1px solid rgba(0,0,0,0.1);
        flex-shrink: 0;
    }

    .item-thumb img { width: 100%; height: 100%; object-fit: contain; }

    .item-count {
        position: absolute;
        top: 0px;
        right: -10px;
        background: #d4af37;
        color: white;
        font-size: 10px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    .item-info h4 { font-family: 'Cormorant Garamond', serif; font-size: 18px; }
    .item-info p { font-size: 12px; opacity: 0.6; }
    .item-price { margin-left: auto; font-size: 14px; font-weight: 500; }

    .totals-area {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .total-final {
        margin-top: 25px;
        font-size: 22px;
        font-weight: 600;
    }

    .complete-purchase-btn {
        width: 100%;
        padding: 22px;
        background: linear-gradient(135deg, #d4af37 0%, #aa8429 100%);
        color: white;
        border: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 40px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
    }

    .complete-purchase-btn:hover { opacity: 0.9; letter-spacing: 3px; transform: translateY(-1px); }

    /* Custom Radio Buttons */
    .radio-container {
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
        padding: 20px;
        border: 1px solid rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .radio-container:hover { border-color: var(--accent); }
    .radio-container input { display: none; }

    .radio-check {
        width: 18px;
        height: 18px;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        flex-shrink: 0;
        background: white;
    }

    .radio-container input:checked + .radio-check {
        border-color: var(--accent);
        background: var(--accent);
    }

    .radio-container input:checked + .radio-check::after {
        content: '';
        width: 6px;
        height: 6px;
        background: white;
        border-radius: 50%;
    }

    .radio-container.active { border-color: var(--accent); background: #fafafa; }
    .radio-label-text { flex: 1; }
    .radio-label-text strong { display: block; font-size: 13px; margin-bottom: 2px; }
    .radio-label-text p { font-size: 12px; opacity: 0.5; }

    .coupon-btn {
        background: linear-gradient(135deg, #d4af37 0%, #aa8429 100%);
        color: white;
        min-width: 120px;
        height: 48px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 500;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.1);
    }
    .coupon-btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .coupon-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }

    .checkout-header-section {
        background: var(--cream);
        padding: 180px 5% 60px; /* 130px for navbar + 50px spacing */
        margin-bottom: 50px;
        border-bottom: 1px solid var(--border);
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    /* Responsive */
    @media (max-width: 1100px) {
        .checkout-content-container { grid-template-columns: 1fr; }
        .order-summary { 
            order: -1; 
            padding: 40px 5%; 
            border-left: none; 
            border-bottom: 1px solid rgba(0,0,0,0.1); 
            position: static; 
            top: auto;
            height: auto;
        }
        .checkout-main { padding: 40px 5%; }
    }
</style>
@endsection

@section('content')
<div class="checkout-wrapper"> <!-- Added padding for navbar -->
    <div class="checkout-header-section text-center">
        <h1 class="font-serif text-5xl mb-2">Checkout</h1>
        <p class="mono opacity-50 text-xs">Complete your order</p>
        <div class="w-20 h-[1px] bg-accent mx-auto mt-6"></div>
    </div>
    
    <div class="checkout-content-container">
        <!-- Left Side: Forms -->
        <section class="checkout-main">
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <ul class="list-disc list-inside text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <div class="form-section">
                    <div class="flex justify-between items-center">
                        <h2>Contact</h2>
                        @guest
                            <p class="text-[13px]">Already have an account? <a href="{{ route('login') }}" class="underline">Log in</a></p>
                        @endguest
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email or mobile phone number" value="{{ auth()->user()->email ?? '' }}" required>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Shipping Address</h2>
                    
                    @if(auth()->check() && $savedShipping)
                    <div class="saved-addresses-toggle mb-6">
                        <label class="radio-container {{ old('address_selection', 'saved') == 'saved' ? 'active' : '' }}">
                            <input type="radio" name="address_selection" value="saved" {{ old('address_selection', 'saved') == 'saved' ? 'checked' : '' }} onclick="toggleAddressFields('saved'); updateRadioClass(this)">
                            <span class="radio-check"></span>
                            <div class="radio-label-text">
                                <strong>Use saved shipping address</strong>
                                <p>{{ $savedShipping['address'] }}, {{ $savedShipping['city'] }}</p>
                            </div>
                        </label>
                        <label class="radio-container {{ old('address_selection') == 'new' ? 'active' : '' }} mt-3">
                            <input type="radio" name="address_selection" value="new" {{ old('address_selection') == 'new' ? 'checked' : '' }} onclick="toggleAddressFields('new'); updateRadioClass(this)">
                            <span class="radio-check"></span>
                            <div class="radio-label-text">
                                <strong>Use a different address</strong>
                            </div>
                        </label>
                    </div>
                    @endif

                    <div id="new-address-fields" @if(auth()->check() && $savedShipping) style="display: none;" @endif>
                        <div class="input-row">
                            <select name="country">
                                <option value="US" {{ (auth()->check() && ($savedShipping['country'] ?? '') == 'US') ? 'selected' : '' }}>United States</option>
                                <option value="UK" {{ (auth()->check() && ($savedShipping['country'] ?? '') == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                                <option value="CA" {{ (auth()->check() && ($savedShipping['country'] ?? '') == 'CA') ? 'selected' : '' }}>Canada</option>
                            </select>
                            <input type="tel" name="phone" placeholder="Phone" value="{{ $savedShipping['phone'] ?? '' }}" required>
                        </div>
                        <div class="input-row">
                            <input type="text" name="first_name" placeholder="First name" value="{{ $savedShipping['first_name'] ?? '' }}" required>
                            <input type="text" name="last_name" placeholder="Last name" value="{{ $savedShipping['last_name'] ?? '' }}" required>
                        </div>
                        <div class="input-row">
                            <input type="text" name="address" placeholder="Address" value="{{ $savedShipping['address'] ?? '' }}" required>
                            <input type="text" name="apartment" placeholder="Apartment, suite, etc. (optional)" value="{{ $savedShipping['apartment'] ?? '' }}">
                        </div>
                        <div class="input-row">
                            <input type="text" name="city" placeholder="City" value="{{ $savedShipping['city'] ?? '' }}" required style="flex: 1;">
                            <input type="text" name="state" placeholder="State/Province" value="{{ $savedShipping['state'] ?? '' }}" required style="flex: 1;">
                            <input type="text" name="zip" placeholder="ZIP code" value="{{ $savedShipping['zip'] ?? '' }}" required style="flex: 1;">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Billing Address</h2>
                    <div class="billing-toggle mb-6">
                        <label class="radio-container {{ old('billing_selection', 'same') == 'same' ? 'active' : '' }}">
                            <input type="radio" name="billing_selection" value="same" {{ old('billing_selection', 'same') == 'same' ? 'checked' : '' }} onclick="toggleBillingFields('same'); updateRadioClass(this)">
                            <span class="radio-check"></span>
                            <div class="radio-label-text">
                                <strong>Same as shipping address</strong>
                            </div>
                        </label>
                        <label class="radio-container {{ old('billing_selection') == 'different' ? 'active' : '' }} mt-3">
                            <input type="radio" name="billing_selection" value="different" {{ old('billing_selection') == 'different' ? 'checked' : '' }} onclick="toggleBillingFields('different'); updateRadioClass(this)">
                            <span class="radio-check"></span>
                            <div class="radio-label-text">
                                <strong>Use a different billing address</strong>
                            </div>
                        </label>
                    </div>

                    <div id="billing-address-fields" style="display: none; padding-top: 10px;">
                        <div class="input-row">
                            <select name="billing_country">
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="CA">Canada</option>
                            </select>
                            <input type="tel" name="billing_phone" placeholder="Phone">
                        </div>
                        <div class="input-row">
                            <input type="text" name="billing_first_name" placeholder="First name">
                            <input type="text" name="billing_last_name" placeholder="Last name">
                        </div>
                        <div class="input-row">
                            <input type="text" name="billing_address" placeholder="Address">
                            <input type="text" name="billing_apartment" placeholder="Apartment, suite, etc. (optional)">
                        </div>
                        <div class="input-row">
                            <input type="text" name="billing_city" placeholder="City" style="flex: 1;">
                            <input type="text" name="billing_state" placeholder="State/Province" style="flex: 1;">
                            <input type="text" name="billing_zip" placeholder="ZIP code" style="flex: 1;">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Payment</h2>
                    <p class="text-xs opacity-50 mb-4">All transactions are secure and encrypted.</p>
                    
                    <div class="payment-method-selection mb-4">
                        <label class="radio-container active">
                            <input type="radio" name="payment_method" value="credit_card" checked>
                            <span class="radio-check"></span>
                            <div class="radio-label-text">
                                <strong>Credit Card</strong>
                            </div>
                            <div class="flex gap-2 opacity-50">
                                <i class="ri-visa-fill text-xl"></i>
                                <i class="ri-mastercard-fill text-xl"></i>
                            </div>
                        </label>
                    </div>

                    <div class="payment-box mb-8">
                        <div class="input-group">
                            <input type="text" placeholder="Card number">
                        </div>
                        <div class="input-row">
                            <input type="text" placeholder="Expiration date (MM / YY)">
                            <input type="text" placeholder="Security code">
                        </div>
                    </div>
                </div>

                <button type="submit" class="complete-purchase-btn">Pay Now</button>
            </form>
        </section>

        <!-- Right Side: Order Summary -->
        <aside class="order-summary">
            <h3 class="font-serif text-2xl mb-6">Order Summary</h3>
            <div class="summary-list">
                @foreach($cartItems as $item)
                <div class="summary-item">
                    <div class="item-thumb">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                        <div class="item-count">{{ $item['quantity'] }}</div>
                    </div>
                    <div class="item-info">
                        <h4>{{ $item['name'] }}</h4>
                        <p>{{ $item['options'] }}</p>
                    </div>
                    <div class="item-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                </div>
                @endforeach
            </div>

            <div class="mt-10">
                <h4 class="mono mb-2">Personal Gift Message</h4>
                <textarea name="gift_message" placeholder="Write a message for the recipient..."
                    style="height: 100px; resize: none; background: white;"></textarea>
            </div>
            
            <!-- Coupon Section -->
            <div class="mt-8 pt-5 border-t border-black/5">
                <div class="input-row mb-0">
                    <div class="input-group mb-0">
                        <input type="text" id="couponCode" placeholder="Discount code" style="background: white;" {{ $coupon ? 'disabled' : '' }} value="{{ $coupon ? $coupon->code : '' }}">
                    </div>
                    <button type="button" id="applyCouponBtn" onclick="applyCoupon()" class="coupon-btn" {{ $coupon ? 'disabled' : '' }}>
                        {{ $coupon ? 'Applied' : 'Apply' }}
                    </button>
                    @if($coupon)
                    <form action="{{ route('checkout.remove-coupon') }}" method="POST" class="ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-full flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors" title="Remove Coupon">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </form>
                    @endif
                </div>
                <div id="couponMessage" class="mt-2 text-xs"></div>
            </div>

            <div class="totals-area">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                 
                <div class="total-row" id="discountRow" style="{{ $discount > 0 ? '' : 'display: none;' }}">
                    <span class="flex items-center gap-2">Discount <span class="bg-gray-200 text-[10px] px-1 rounded">{{ $coupon ? $coupon->code : '' }}</span></span>
                    <span class="text-green-700">- ${{ number_format($discount, 2) }}</span>
                </div>

                <div class="total-row">
                    <span>Shipping</span>
                    <span class="opacity-50">{{ $shipping > 0 ? '$'.number_format($shipping, 2) : 'Free' }}</span>
                </div>
                <div class="total-row">
                    <span>Estimated taxes</span>
                    <span>${{ number_format($taxes, 2) }}</span>
                </div>
                <div class="total-row total-final">
                    <span>Total</span>
                    <span id="finalTotal">USD ${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </aside>

    </div>
</div>

<script>
    function updateRadioClass(input) {
        const containers = input.closest('div').querySelectorAll('.radio-container');
        containers.forEach(container => container.classList.remove('active'));
        input.closest('.radio-container').classList.add('active');
    }

    function toggleAddressFields(type) {
        const container = document.getElementById('new-address-fields');
        const inputs = container.querySelectorAll('input, select');
        
        if (type === 'saved') {
            container.style.display = 'none';
            inputs.forEach(input => input.disabled = true);
        } else {
            container.style.display = 'block';
            inputs.forEach(input => input.disabled = false);
        }
    }

    function toggleBillingFields(type) {
        const container = document.getElementById('billing-address-fields');
        const inputs = container.querySelectorAll('input, select');
        
        if (type === 'same') {
            container.style.display = 'none';
            inputs.forEach(input => input.disabled = true);
        } else {
            container.style.display = 'block';
            inputs.forEach(input => input.disabled = false);
        }
    }

    @if(auth()->check() && $savedShipping)
    document.addEventListener('DOMContentLoaded', function() {
        toggleAddressFields('saved');
    });
    @endif

    function applyCoupon() {
        const code = document.getElementById('couponCode').value;
        const btn = document.getElementById('applyCouponBtn');
        const msg = document.getElementById('couponMessage');

        if (!code) return;

        btn.disabled = true;
        btn.innerText = 'Checking...';
        msg.innerText = '';
        msg.className = 'mt-2 text-xs';

        fetch('{{ route("checkout.apply-coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                msg.innerText = data.message;
                msg.classList.add('text-green-600');
                setTimeout(() => window.location.reload(), 1000); // Reload to update totals
            } else {
                msg.innerText = data.message;
                msg.classList.add('text-red-500');
                btn.disabled = false;
                btn.innerText = 'Apply';
            }
        })
        .catch(error => {
            msg.innerText = 'Error applying coupon.';
            msg.classList.add('text-red-500');
            btn.disabled = false;
            btn.innerText = 'Apply';
        });
    }
</script>
@endsection
