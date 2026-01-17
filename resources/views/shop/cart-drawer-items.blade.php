@forelse($cart as $key => $item)
<div class="cart-item flex gap-5 mb-8 pb-8 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
    <div class="item-img w-[90px] aspect-[2/2.8] bg-[#f9f7f2] overflow-hidden flex-shrink-0">
        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
    </div>
    <div class="item-info flex-1 flex flex-col">
        <div class="flex justify-between items-start">
            <h4 class="font-serif text-[1.3rem] mb-1 leading-tight"><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></h4>
            <button class="text-gray-400 hover:text-black transition-colors" onclick="removeFromCart('{{ $key }}')">&times;</button>
        </div>
        
        @if($item['options'])
        <p class="text-[10px] uppercase tracking-wider opacity-50 mb-auto">{{ $item['options'] }}</p>
        @endif

        <div class="item-qty-price flex justify-between items-end mt-4">
            <div class="qty-controls flex gap-3 text-xs border border-gray-200 px-3 py-1 items-center">
                <span class="cursor-pointer px-1 hover:text-gray-500" onclick="updateCartQty('{{ $key }}', {{ $item['quantity'] - 1 }})">&minus;</span>
                <span class="w-4 text-center">{{ $item['quantity'] }}</span>
                <span class="cursor-pointer px-1 hover:text-gray-500" onclick="updateCartQty('{{ $key }}', {{ $item['quantity'] + 1 }})">&plus;</span>
            </div>
            <span class="mono text-sm">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
        </div>
    </div>
</div>
@empty
<div class="h-full flex flex-col items-center justify-center text-center opacity-50">
    <p class="mb-4">Your bag is empty.</p>
    <a href="{{ route('home') }}" class="underline hover:no-underline">Continue Shopping</a>
</div>
@endforelse
