@props(['product', 'badge' => null])

<div class="product-card group relative">
    <div class="product-card-border-vertical pointer-events-none absolute inset-0 z-30"></div>
    <div class="product-thumb">
        @if($badge)
            <span class="badge sale">{{ $badge }}</span>
        @elseif($product->stock_quantity < 5 && $product->stock_quantity > 0)
            <span class="badge sale">Low Stock</span>
        @elseif($product->created_at->gt(now()->subDays(7)))
            <span class="badge sale">New</span>
        @endif

        <a href="{{ route('shop.product.show', $product->slug) }}">
            <img src="{{ $product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400/F5F1EE/D4AF37?text=' . urlencode($product->name) }}"
                alt="{{ $product->name }}" class="main-img">
        </a>

        <div class="product-actions">
            @php
                $isInWishlist = auth()->check() && auth()->user()->wishlists && auth()->user()->wishlists->contains('product_id', $product->id);
            @endphp
            
            @if($product->variants->count() > 0)
                <button class="action-btn" title="Select Options" onclick="openQuickView('{{ $product->slug }}')">
                    <i class="ri-sound-module-line"></i>
                </button>
            @else
                <button class="action-btn" title="Add to Cart" onclick="quickAdd({{ $product->id }})">
                    <i class="ri-shopping-cart-line"></i>
                </button>
            @endif

            <button class="action-btn wishlist-btn-{{ $product->id }}" onclick="addToWishlist({{ $product->id }})" title="Add to Wishlist">
                <i class="{{ $isInWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
            </button>
            
            <button class="action-btn" onclick="openQuickView('{{ $product->slug }}')" title="Quick View">
                <i class="ri-eye-line"></i>
            </button>
        </div>
    </div>

    <div class="product-info-wrapper text-left">
        <div class="product-info-content">
            <h3 class="product-title font-sans">
                <a href="{{ route('shop.product.show', $product->slug) }}">{{ $product->name }}</a>
                @if($product->brand)
                    <span class="text-[10px] opacity-100 uppercase tracking-wider block -mt-1">{{ $product->brand->name }}</span>
                @endif
            </h3>
            {{-- <div class="product-rating">
                @for($i=0; $i<5; $i++)
                    <i class="fa-solid fa-star text-xs"></i>
                @endfor
            </div> --}}
            <div class="product-price mt-2">
                @if($product->product_type == 'variable')
                    <span class="price font-sans">From ${{ number_format($product->base_price, 2) }}</span>
                @else
                    <span class="price font-sans">${{ number_format($product->base_price, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="product-action-btn-slide">
        <button class="btn-add-cart w-full" onclick="quickAdd({{ $product->id }})">
            <span class="btn-text">Add To Cart</span>
            <span class="btn-icon"><i class="ri-shopping-cart-line"></i></span>
        </button>
    </div>
</div>
