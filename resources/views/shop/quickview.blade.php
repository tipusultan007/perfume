@php
    // Prepare attributes from variants
    $attributes = collect();
    if($product->variants->isNotEmpty()) {
        $attributes = $product->variants->pluck('attributeValues')->flatten()->unique('id')->groupBy('attribute.name');
    }
    
    // Prepare JS data
    $variantData = $product->variants->map(function($variant) {
        return [
            'id' => $variant->id,
            'price' => $variant->price,
            'stock' => $variant->stock_quantity,
            'attributes' => $variant->attributeValues->mapWithKeys(function($av) {
                return [$av->attribute->name => $av->id];
            })
        ];
    });
@endphp

<div class="flex flex-col md:flex-row gap-8 h-full">
    <!-- Gallery Section (Left) -->
    <div class="md:w-1/2 h-full flex flex-col gap-4">
        <!-- Main Slider -->
        <div class="swiper mySwiper2 w-full flex-1 rounded-sm overflow-hidden bg-gray-50 aspect-[1/1.2]">
            <div class="swiper-wrapper">
                <!-- Featured -->
                <div class="swiper-slide bg-white flex items-center justify-center">
                    @if($product->hasMedia('featured'))
                        <img src="{{ $product->getFirstMediaUrl('featured') }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?random={{ $product->id }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <!-- Gallery -->
                @foreach($product->getMedia('gallery') as $image)
                <div class="swiper-slide bg-white flex items-center justify-center">
                    <img src="{{ $image->getUrl() }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            <div class="swiper-button-next text-black/50 hover:text-black after:text-lg bg-white/50 p-6 rounded-full"></div>
            <div class="swiper-button-prev text-black/50 hover:text-black after:text-lg bg-white/50 p-6 rounded-full"></div>
        </div>

        <!-- Thumbs Slider -->
        <div class="swiper mySwiper w-full h-24">
            <div class="swiper-wrapper">
                <!-- Featured Thumb -->
                <div class="swiper-slide w-20 h-24 opacity-40 cursor-pointer hover:opacity-100 transition-opacity rounded-sm overflow-hidden border border-transparent swiper-slide-thumb-active:opacity-100 swiper-slide-thumb-active:border-black">
                    @if($product->hasMedia('featured'))
                        <img src="{{ $product->getFirstMediaUrl('featured') }}" class="w-full h-full object-cover">
                    @else
                        <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?random={{ $product->id }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <!-- Gallery Thumbs -->
                @foreach($product->getMedia('gallery') as $image)
                <div class="swiper-slide w-20 h-24 opacity-40 cursor-pointer hover:opacity-100 transition-opacity rounded-sm overflow-hidden border border-transparent swiper-slide-thumb-active:opacity-100 swiper-slide-thumb-active:border-black">
                    <img src="{{ $image->getUrl() }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Details Section (Right) -->
    <div class="md:w-1/2 flex flex-col h-full overflow-y-auto pr-2 custom-scrollbar">
        <!-- Breadcrumb / Category -->
        <h4 class="font-mono text-[10px] uppercase tracking-[0.2em] text-gray-500 mb-4">
            {{ $product->category ? $product->category->name : 'Collection' }}
        </h4>

        <!-- Title -->
        <h2 class="font-serif text-4xl mb-4 text-black font-light leading-none">
            {{ $product->name }}
        </h2>

        <!-- Price -->
        <div class="text-xl mb-6 font-light tracking-wide text-gray-900" id="main-price-display">
            @if($product->product_type == 'variable')
               From ${{ number_format($product->base_price, 2) }}
            @else
               ${{ number_format($product->base_price, 2) }}
            @endif
        </div>

        <!-- Short Description -->
        <div class="font-sans text-sm text-gray-600 leading-relaxed mb-8 font-light text-justify">
            @if($product->short_description)
                {!! nl2br(e($product->short_description)) !!}
            @else
                {!! Str::limit(strip_tags($product->description), 250) !!}
            @endif
        </div>

        <form action="#" method="POST" class="mt-auto space-y-8" id="add-to-cart-form" data-variants="{{ json_encode($variantData) }}">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="variant_id" id="selected-variant-id" value="">
            
            <!-- Attribute Selectors -->
            @if($attributes->isNotEmpty())
                @foreach($attributes as $name => $values)
                <div class="space-y-3 attribute-group" data-attribute="{{ $name }}">
                    <span class="text-[10px] uppercase tracking-widest font-bold text-gray-400 block mb-2">{{ $name }}</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach($values as $value)
                            <label class="cursor-pointer relative inline-flex items-center justify-center">
                                <input type="radio" 
                                       name="attribute_{{ $name }}" 
                                       value="{{ $value->id }}" 
                                       class="peer sr-only attribute-input"
                                       onchange="handleAttributeChange()">
                                
                                <div class="min-w-[70px] px-5 py-3 border border-gray-200 text-sm font-medium uppercase tracking-wider text-gray-700 bg-white transition-all 
                                          hover:border-black hover:bg-gray-50
                                          peer-checked:bg-black peer-checked:text-white peer-checked:border-black">
                                    {{ $value->value }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
                <p id="variant-error" class="text-red-500 text-xs mt-2 hidden">Please select all options</p>
            @endif

            <!-- Add to Cart Row -->
            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <!-- Quantity -->
                <div class="flex items-center border border-gray-200 w-32 h-12">
                    <button type="button" class="w-10 h-full flex items-center justify-center text-gray-500 hover:text-black hover:bg-gray-50 transition" onclick="qvDecrement()">-</button>
                    <input type="number" name="quantity" id="qv-qty" value="1" min="1" class="w-full h-full text-center border-none p-0 text-sm focus:ring-0 appearance-none bg-transparent">
                    <button type="button" class="w-10 h-full flex items-center justify-center text-gray-500 hover:text-black hover:bg-gray-50 transition" onclick="qvIncrement()">+</button>
                </div>

                <!-- Submit Button -->
                <button type="button" id="add-to-cart-btn" class="flex-1 bg-black text-white h-12 text-xs uppercase tracking-[0.2em] hover:bg-gray-800 transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span>Add to Bag</span>
                </button>
            </div>
            
            <div class="text-center pt-2">
                <a href="#" class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-black border-b border-transparent hover:border-black transition-all pb-0.5">View Full Details</a>
            </div>
        </form>
    </div>
</div>
