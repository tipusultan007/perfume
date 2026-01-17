@extends('layouts.store')

@section('title', $product->name . " | L'ESSENCE NYC")

@section('styles')
<style>
    /* General Styles */
    .pdp-main-section {
        padding: 140px 0 50px; /* Increased top padding to clear fixed navbar */
        background: var(--white);
    }

    .pdp-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
        width: 100%;
    }

    /* LEFT SIDE: GALLERY (Swiper) */
    .pdp-gallery {
        position: relative;
        display: flex;
        gap: 20px;
    }

    .thumbs-container {
        width: 80px;
        flex-shrink: 0;
    }

    .mySwiperThumbs {
        height: 500px;
    }

    .mySwiperThumbs .swiper-slide {
        width: 100%;
        height: auto;
        opacity: 0.4;
        cursor: pointer;
        transition: 0.3s;
        border: 1px solid transparent;
    }

    .mySwiperThumbs .swiper-slide-thumb-active {
        opacity: 1;
        border-color: var(--black);
    }

    .mySwiperThumbs img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-slider-container {
        flex-grow: 1;
        overflow: hidden;
        background: var(--cream);
    }

    .mySwiperMain {
        width: 100%;
        height: 600px;
    }

    .mySwiperMain .swiper-slide {
        overflow: hidden;
        cursor: zoom-in;
    }

    .mySwiperMain img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease-out;
    }

    /* RIGHT SIDE: PRODUCT INFO */
    .pdp-details {
        padding-left: 20px;
    }

    div.pdp-breadcrumb {
        position: static;
        width: auto;
        padding: 0;
        margin-bottom: 15px;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.5;
        display: block;
        z-index: 1;
    }

    .pdp-title {
        font-family: 'Cormorant Garamond';
        font-size: 3rem;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .pdp-price {
        font-family: 'Space Mono', monospace;
        font-size: 1.5rem;
        margin-bottom: 30px;
        color: var(--black);
    }

    .pdp-description-short {
        font-size: 14px;
        line-height: 1.8;
        opacity: 0.7;
        margin-bottom: 30px;
    }

    /* Attributes & Actions */
    .attribute-group {
        margin-bottom: 25px;
    }

    .attribute-label {
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 1.5px;
        margin-bottom: 12px;
        display: block;
    }

    .options-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .option-item input { display: none; }
    .option-item label {
        display: inline-block;
        padding: 10px 20px;
        border: 1px solid #ddd;
        font-size: 11px;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.3s;
    }

    .option-item input:checked + label {
        border-color: var(--black);
        background: var(--black);
        color: white;
    }

    .actions-row {
        display: flex;
        gap: 15px;
        margin-top: 40px;
        margin-bottom: 30px;
    }

    .qty-selector {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        padding: 0 15px;
        height: 55px;
    }

    .qty-selector button {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        padding: 0 10px;
    }

    .qty-selector input {
        width: 40px;
        text-align: center;
        border: none;
        background: none;
        outline: none;
        font-family: 'Space Mono';
    }

    .btn-add-cart, .btn-buy-now {
        flex: 1;
        height: 55px;
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 2px;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-add-cart {
        background: var(--black);
        color: white;
    }

    .btn-buy-now {
        background: var(--cream);
        color: var(--black);
        border: 1px solid var(--black);
    }

    .btn-add-cart:hover { opacity: 0.8; }
    .btn-buy-now:hover { background: var(--black); color: white; }

    /* Meta: Categories, Tags, Share */
    .pdp-meta {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #eee;
    }

    .meta-item {
        font-size: 11px;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .meta-item strong {
        font-weight: 600;
        margin-right: 5px;
    }

    .share-links {
        display: flex;
        gap: 15px;
        margin-top: 15px;
    }

    .share-links a {
        font-size: 16px;
        opacity: 0.5;
        transition: 0.3s;
    }

    .share-links a:hover { opacity: 1; color: var(--accent); }

    /* Tabs Section */
    .pdp-tabs-section {
        margin-top: 80px;
        border-top: 1px solid #eee;
    }

    .tabs-nav {
        display: flex;
        justify-content: center;
        gap: 60px;
        border-bottom: 1px solid #eee;
    }

    .tab-trigger {
        padding: 30px 0;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 3px;
        font-weight: 600;
        color: rgba(0,0,0,0.4);
        cursor: pointer;
        position: relative;
    }

    .tab-trigger::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--black);
        transition: 0.3s;
    }

    .tab-trigger.active {
        color: var(--black);
    }

    .tab-trigger.active::after {
        width: 100%;
    }

    .tab-panel {
        display: none;
        padding: 60px 15%;
        animation: fadeIn 0.5s ease;
    }

    .tab-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Related Products Section */
    .related-products {
        padding: 100px 0;
    }

    .related-products h2 {
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 60px;
    }

    @media (max-width: 1024px) {
        .pdp-gallery { flex-direction: column-reverse; }
        .thumbs-container { width: 100%; }
        .mySwiperThumbs { height: auto; }
        .mySwiperThumbs .swiper-slide { width: 80px; }
        .pdp-details { padding-left: 0; margin-top: 40px; }
        .tab-trigger { gap: 20px; font-size: 10px; }
    }
</style>

@endsection

@section('content')
<main class="pdp-main-section pb-20">
    <div class="pdp-container">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            {{-- Left Side: Gallery --}}
            <div class="pdp-gallery">
                <!-- Thumbnails Slider -->
                <div class="thumbs-container">
                    <div class="swiper mySwiperThumbs">
                        <div class="swiper-wrapper">
                            @php
                                $mainImage = $product->getFirstMediaUrl('featured') ?: 'https://via.placeholder.com/800x1000';
                            @endphp
                            <div class="swiper-slide">
                                <img src="{{ $mainImage }}" alt="{{ $product->name }}">
                            </div>
                            @foreach($product->getMedia('gallery') as $media)
                                <div class="swiper-slide">
                                    <img src="{{ $media->getUrl() }}" alt="Gallery Image">
                                </div>
                            @endforeach
                            @foreach($product->variants as $variant)
                                @if($variant->hasMedia('variant_media'))
                                     <div class="swiper-slide">
                                         <img src="{{ $variant->getFirstMediaUrl('variant_media') }}" alt="Variant Image">
                                     </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Slider -->
                <div class="main-slider-container">
                    <div class="swiper mySwiperMain" id="zoomContainer">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ $mainImage }}" alt="{{ $product->name }}" class="zoom-img">
                            </div>
                            @foreach($product->getMedia('gallery') as $media)
                                <div class="swiper-slide">
                                    <img src="{{ $media->getUrl() }}" alt="Gallery Image" class="zoom-img">
                                </div>
                            @endforeach
                            @foreach($product->variants as $variant)
                                @if($variant->hasMedia('variant_media'))
                                     <div class="swiper-slide">
                                         <img src="{{ $variant->getFirstMediaUrl('variant_media') }}" alt="Variant Image" class="zoom-img">
                                     </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Details --}}
            <div class="pdp-details">
                <div class="pdp-breadcrumb">
                    <a href="{{ route('home') }}">Home</a> / 
                    @if($product->category)
                        <a href="{{ route('shop') }}?category={{ $product->category->slug }}">{{ $product->category->name }}</a>
                    @endif
                    @if($product->brand)
                        / <a href="{{ route('shop') }}?brand={{ $product->brand->slug }}">{{ $product->brand->name }}</a>
                    @endif
                </div>

                <h1 class="pdp-title">{{ $product->name }}</h1>
                <div class="pdp-price" id="main-price-display">
                    ${{ number_format($product->base_price, 2) }}
                </div>

                <div class="pdp-description-short">
                    {{ Str::limit(strip_tags($product->description), 200) }}
                </div>

                @if($product->product_type == 'bundle')
                <div class="mb-8 border-t border-b border-gray-100 py-6">
                    <h4 class="text-[10px] font-bold uppercase tracking-widest mb-4 opacity-80">This Set Contains:</h4>
                    <div class="space-y-3">
                        @foreach($product->bundledProducts as $bItem)
                        <div class="flex items-center gap-4 p-3 border border-gray-100 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                            <img src="{{ $bItem->getFirstMediaUrl('featured') ?: 'https://via.placeholder.com/100' }}" class="w-12 h-12 object-cover border border-gray-200">
                            <div>
                                <a href="{{ route('shop.product.show', $bItem->slug) }}" class="text-xs font-semibold uppercase tracking-wider block hover:underline hover:text-luxury-accent transition-colors">{{ $bItem->name }}</a>
                                <span class="text-[10px] opacity-60">
                                    {{ $bItem->concentration }} 
                                    @if($bItem->pivot->quantity > 1) x {{ $bItem->pivot->quantity }} @endif
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <form id="add-to-cart-form" data-variants="{{ json_encode($product->variants->map(function($v) {
                    return [
                        'id' => $v->id,
                        'price' => $v->price,
                        'attributes' => $v->attributeValues->pluck('id', 'attribute.name')
                    ];
                })) }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="variant_id" id="selected-variant-id" value="">

                    @if($product->product_type == 'variable')
                    @php
                        $attributes = $product->variants->flatMap->attributeValues->groupBy('attribute.name');
                    @endphp

                    @foreach($attributes as $name => $values)
                    <div class="attribute-group" data-attribute="{{ $name }}">
                        <span class="attribute-label">Select {{ $name }}</span>
                        <div class="options-grid">
                            @foreach($values->unique('id') as $value)
                            <div class="option-item">
                                <input type="radio" name="attr_{{ strtolower($name) }}" value="{{ $value->id }}" id="val_{{ $value->id }}" onchange="handleAttributeChange()">
                                <label for="val_{{ $value->id }}">{{ $value->value }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <div class="actions-row">
                        <div class="qty-selector">
                            <button type="button" onclick="qvDecrement()">-</button>
                            <input type="number" id="qv-qty" name="quantity" value="1" min="1">
                            <button type="button" onclick="qvIncrement()">+</button>
                        </div>
                        <button type="button" class="btn-add-cart" id="add-to-cart-btn" onclick="submitAddToCart()">Add to Bag</button>
                        <button type="button" class="btn-buy-now" onclick="submitBuyNow()">Buy Now</button>
                    </div>
                    <p id="variant-error" class="hidden text-red-500 text-xs mb-4"></p>
                </form>

                <div class="pdp-meta">
                    <div class="meta-item">
                        <strong>Category:</strong> 
                        {{ $product->category->name ?? 'N/A' }}
                    </div>
                    <div class="meta-item">
                        <strong>SKU:</strong> 
                        {{ $product->sku ?: 'N/A' }}
                    </div>
                    <div class="meta-item">
                        <strong>Availability:</strong> 
                        <span class="text-green-600">In Stock</span>
                    </div>

                    <div class="share-links">
                        <span class="meta-item font-bold mr-2">Share:</span>
                        <a href="#"><i class="ri-facebook-fill"></i></a>
                        <a href="#"><i class="ri-twitter-x-fill"></i></a>
                        <a href="#"><i class="ri-pinterest-fill"></i></a>
                        <a href="#"><i class="ri-mail-line"></i></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs Section --}}
        <div class="pdp-tabs-section">
            <div class="tabs-nav">
                <div class="tab-trigger active" onclick="switchTab(this, 'tab-desc')">Description</div>
                <div class="tab-trigger" onclick="switchTab(this, 'tab-info')">Additional Information</div>
                <div class="tab-trigger" onclick="switchTab(this, 'tab-reviews')">Reviews ({{ $product->reviews->count() }})</div>
            </div>

            <div class="tab-content">
                <!-- Description -->
                <div class="tab-panel active" id="tab-desc">
                    <div class="prose max-w-none">
                        {!! $product->description !!}
                    </div>
                </div>

                <!-- Info -->
                <div class="tab-panel" id="tab-info">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="serif text-xl mb-4">Product Details</h4>
                           
                            <table class="w-full text-sm">
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Brand</td>
                                    <td class="py-3 opacity-70">{{ $product->brand->name ?? 'N/A' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Category</td>
                                    <td class="py-3 opacity-70">{{ $product->category->name ?? 'N/A' }}</td>
                                </tr>
                                @if($product->gender)
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Gender</td>
                                    <td class="py-3 opacity-70">{{ $product->gender }}</td>
                                </tr>
                                @endif
                                @if($product->concentration)
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Concentration</td>
                                    <td class="py-3 opacity-70">{{ $product->concentration }}</td>
                                </tr>
                                @endif
                                @if($product->season)
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Season</td>
                                    <td class="py-3 opacity-70">{{ $product->season }}</td>
                                </tr>
                                @endif
                                @if($product->top_notes)
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Top Notes</td>
                                    <td class="py-3 opacity-70">{{ $product->top_notes }}</td>
                                </tr>
                                @endif
                                @if($product->heart_notes)
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Heart Notes</td>
                                    <td class="py-3 opacity-70">{{ $product->heart_notes }}</td>
                                </tr>
                                @endif
                                @if($product->base_notes)
                                <tr class="border-b">
                                    <td class="py-3 font-semibold uppercase text-[10px] tracking-wider">Base Notes</td>
                                    <td class="py-3 opacity-70">{{ $product->base_notes }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div>
                            <h4 class="serif text-xl mb-4">Scent Intensity</h4>
                            @if($product->getDetail('intensity'))
                                <div class="mb-4">
                                    <div class="h-1 bg-gray-100 w-full relative mb-2">
                                        <div class="absolute inset-0 bg-black" style="width: {{ $product->getDetail('intensity_percent', '50%') }}"></div>
                                    </div>
                                    <div class="flex justify-between text-[10px] uppercase tracking-wider opacity-50">
                                        <span>Subtle</span>
                                        <span>Powerful</span>
                                    </div>
                                </div>
                            @endif
                            <p class="text-sm opacity-60">Every fragrance reveals different facets over time. We recommend testing on skin to experience the complete dry-down.</p>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="tab-panel" id="tab-reviews">
                     <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <div>
                            <h4 class="serif text-xl mb-6">Customer Experience</h4>
                            @if($product->reviews->count() > 0)
                                <div class="space-y-8">
                                    @foreach($product->reviews as $review)
                                    <div class="review-item border-b border-gray-100 pb-8 last:border-0">
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-xs uppercase tracking-wider">{{ $review->user_name }}</span>
                                                <span class="text-[9px] opacity-40 uppercase">{{ $review->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex gap-1 text-[10px] text-black">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= $review->rating ? 'ri-star-fill' : 'ri-star-line' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-sm opacity-70 leading-relaxed">{{ $review->comment }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="opacity-50 italic">No reviews yet. Be the first to share your experience.</p>
                            @endif
                        </div>
                        
                        <div>
                            @if($canReview)
                                <div class="bg-cream p-8">
                                    <h4 class="serif text-xl mb-2">Write a Review</h4>
                                    <p class="text-[10px] opacity-40 uppercase tracking-widest mb-8 text-center">Your review matters to us</p>
                                    <form action="{{ route('shop.product.review', $product->slug) }}" method="POST">
                                        @csrf
                                        <div class="mb-6">
                                            <label class="attribute-label">Rating</label>
                                            <div class="star-rating flex flex-row-reverse justify-end gap-2">
                                                @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                                                <label for="star{{ $i }}" class="cursor-pointer text-xl text-gray-300 hover:text-black transition-colors"><i class="ri-star-fill"></i></label>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="mb-6">
                                            <label class="attribute-label">Your Comment</label>
                                            <textarea name="comment" rows="4" class="w-full bg-white border border-gray-200 p-4 text-sm focus:outline-none" placeholder="Share your thoughts..."></textarea>
                                        </div>
                                        <button type="submit" class="btn-add-cart w-full">Submit Review</button>
                                    </form>
                                </div>
                            @else
                                <div class="border border-gray-100 p-8 text-center">
                                    <p class="text-xs uppercase tracking-widest opacity-40">
                                        Only customers who have purchased this product can leave a review.
                                    </p>
                                </div>
                            @endif
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</main>

@if(count($relatedProducts) > 0)
<section class="related-products">
    <h2 class="serif">You May Also Like</h2>
    <div class="product-grid">
        @foreach($relatedProducts as $rel)
        <div class="p-card group">
            <div class="p-img">
                @if($rel->created_at->gt(now()->subDays(7)))
                    <span class="p-badge">New</span>
                @endif
                <a href="{{ route('shop.product.show', $rel->slug) }}">
                    <img src="{{ $rel->getFirstMediaUrl('featured') ?: 'https://via.placeholder.com/400x500' }}" alt="{{ $rel->name }}">
                </a>
                <div class="p-actions">
                    <button class="action-btn" title="Quick View" onclick="openQuickView('{{ $rel->slug }}')"><i class="ri-eye-line"></i></button>
                    <button class="action-btn" title="Add to Cart" onclick="quickAdd({{ $rel->id }})"><i class="ri-shopping-bag-line"></i></button>
                    <button class="action-btn" title="Wishlist"><i class="ri-heart-line"></i></button>
                </div>
            </div>
            <a href="{{ route('shop.product.show', $rel->slug) }}" class="p-title">{{ $rel->name }}</a>
            <div class="p-price-container">
                <span class="p-price">${{ number_format($rel->base_price, 2) }}</span>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // 1. Initialize Swiper Gallery
        const swiperThumbs = new Swiper(".mySwiperThumbs", {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            direction: 'vertical',
            breakpoints: {
                320: { direction: 'horizontal', slidesPerView: 4 },
                1024: { direction: 'vertical', slidesPerView: 4 }
            }
        });

        const swiperMain = new Swiper(".mySwiperMain", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });

        // 2. Zoom Effect on Hover
        const zoomContainers = document.querySelectorAll('.mySwiperMain .swiper-slide');
        zoomContainers.forEach(container => {
            const img = container.querySelector('img');
            
            container.addEventListener('mousemove', (e) => {
                if (window.innerWidth > 1024) {
                    const { left, top, width, height } = container.getBoundingClientRect();
                    const x = ((e.pageX - left) / width) * 100;
                    const y = ((e.pageY - top - window.scrollY) / height) * 100;

                    img.style.transformOrigin = `${x}% ${y}%`;
                    img.style.transform = 'scale(2)';
                }
            });

            container.addEventListener('mouseleave', () => {
                img.style.transform = 'scale(1)';
                img.style.transformOrigin = 'center center';
            });
        });

        // 3. Initialize Attributes
        document.querySelectorAll('.attribute-group').forEach(group => {
            const first = group.querySelector('input[type="radio"]');
            if (first) first.checked = true;
        });
        handleAttributeChange();
    });

    // 4. Tab Switching Logic
    function switchTab(element, panelId) {
        // Removes active class from all triggers and panels
        document.querySelectorAll('.tab-trigger').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

        // Adds active class to clicked trigger and target panel
        element.classList.add('active');
        document.getElementById(panelId).classList.add('active');
    }

    // 5. Variant & Price Logic
    function handleAttributeChange() {
        const form = document.getElementById('add-to-cart-form');
        if (!form) return;

        const variantsData = form.getAttribute('data-variants');
        if (!variantsData) return;
        
        const variants = JSON.parse(variantsData);
        if (variants.length === 0) return;

        const selected = {};
        let allSelected = true;

        document.querySelectorAll('.attribute-group').forEach(group => {
            const name = group.getAttribute('data-attribute');
            const checked = group.querySelector('input:checked');
            if(checked) {
                selected[name] = parseInt(checked.value);
            } else {
                allSelected = false;
            }
        });

        const btn = document.getElementById('add-to-cart-btn');
        const priceDisplay = document.getElementById('main-price-display');
        const hiddenInput = document.getElementById('selected-variant-id');
        const errorMsg = document.getElementById('variant-error');

        if(!allSelected) {
            if(btn) { btn.disabled = true; btn.innerText = 'Select Options'; }
            return;
        }

        const match = variants.find(variant => {
            return Object.entries(selected).every(([key, value]) => {
                return variant.attributes[key] === value;
            });
        });

        if(match) {
            if(priceDisplay) priceDisplay.innerText = '$' + parseFloat(match.price).toFixed(2);
            if(hiddenInput) hiddenInput.value = match.id;
            if(btn) { btn.disabled = false; btn.innerText = 'Add to Bag'; }
            if(errorMsg) errorMsg.classList.add('hidden');
        } else {
            if(priceDisplay) priceDisplay.innerText = 'Unavailable';
            if(hiddenInput) hiddenInput.value = '';
            if(btn) { btn.disabled = true; btn.innerText = 'Unavailable'; }
            if(errorMsg) { 
                errorMsg.innerText = 'This combination is currently unavailable.'; 
                errorMsg.classList.remove('hidden'); 
            }
        }
    }

    // 6. Quantity Logic
    function qvIncrement() {
        const input = document.getElementById('qv-qty');
        if(input) input.value = parseInt(input.value) + 1;
    }

    function qvDecrement() {
        const input = document.getElementById('qv-qty');
        if(input && parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    }

    // 7. Cart Actions
    function submitAddToCart() {
        const form = document.getElementById('add-to-cart-form');
        const formData = new FormData(form);
        
        if (typeof window.addToCart === 'function') {
            window.addToCart(formData);
        } else {
            console.error('Global addToCart function not found');
        }
    }

    function submitBuyNow() {
        const form = document.getElementById('add-to-cart-form');
        const formData = new FormData(form);
        formData.append('buy_now', '1');
        
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                window.location.href = '{{ route("checkout") }}';
            } else {
                toastr.error(data.message || 'Error processing request');
            }
        })
        .catch(err => console.error(err));
    }
</script>
@endsection
