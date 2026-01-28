@extends('layouts.store')

@section('content')
<div class="checkout-wrapper">
    <div class="checkout-header-section text-center">
        <h1 class="font-serif text-5xl mb-2">Track Your Order</h1>
        <p class="mono opacity-50 text-xs">Enter your details to view progress</p>
        <div class="w-20 h-[1px] bg-accent mx-auto mt-6"></div>
    </div>

    <div class="checkout-content-container" style="display: block; max-width: 600px; margin: 0 auto; padding: 40px 5% 100px;">
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('order.track.process') }}" method="POST" class="bg-white p-10 border border-black/5 shadow-sm">
            @csrf
            <div class="form-section">
                <div class="input-group mb-6">
                    <label class="block mono text-[10px] uppercase tracking-widest mb-2 opacity-50">Order Number</label>
                    <input type="text" name="order_number" placeholder="e.g. ORD-12345" value="{{ old('order_number') }}" required>
                </div>
                
                <div class="input-group mb-8">
                    <label class="block mono text-[10px] uppercase tracking-widest mb-2 opacity-50">Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" value="{{ old('email') }}" required>
                </div>

                <button type="submit" class="complete-purchase-btn" style="margin-top: 0;">Track Order</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
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
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
    }
    .complete-purchase-btn:hover { opacity: 0.9; transform: translateY(-1px); }

    input {
        width: 100%;
        padding: 15px;
        border: 1px solid rgba(0,0,0,0.1);
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
        background: transparent;
    }
    input:focus { border-color: var(--accent); }
</style>
@endpush
