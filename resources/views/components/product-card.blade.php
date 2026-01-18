@props(['product', 'badge' => null])

<div class="product-card">
    <div class="product-thumb">
        @if($badge)
        <span class="badge sale">{{ $badge }}</span>
        @endif
        <a href="{{ route('shop.product.show', $product->slug) }}">
            <img src="{{ $product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400/F5F1EE/885a39?text=' . urlencode($product->name) }}"
                alt="{{ $product->name }}" class="main-img">
        </a>
        <div class="product-actions">
            @php
                $isInWishlist = auth()->check() && auth()->user()->wishlists && auth()->user()->wishlists->contains('product_id', $product->id);
            @endphp
            <button class="action-btn wishlist-btn-{{ $product->id }}" onclick="addToWishlist({{ $product->id }})">
                <i class="{{ $isInWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
            </button>
            <button class="action-btn" onclick="openQuickView('{{ $product->slug }}')"><i class="fa-regular fa-eye"></i></button>
        </div>
    </div>
    <div class="product-info text-center">
        <h3 class="product-title font-serif"><a href="{{ route('shop.product.show', $product->slug) }}">{{ $product->name }}</a></h3>
        <div class="product-rating">
            @for($i=0; $i<5; $i++)
            <i class="fa-solid fa-star text-xs"></i>
            @endfor
        </div>
        <div class="product-price">
            <span class="price font-mono">${{ number_format($product->base_price, 2) }}</span>
        </div>
        <div class="product-action-btn">
            <button class="btn-add-cart w-full" onclick="quickAdd({{ $product->id }})">Add To Cart</button>
        </div>
    </div>
</div>
