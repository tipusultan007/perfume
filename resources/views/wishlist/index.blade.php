@extends('layouts.store')

@section('title', 'My Wishlist | L\'ESSENCE')

@section('content')
<!-- Spacer for Fixed Header -->
<div class="h-[140px] md:h-[180px]"></div>

<!-- Page Header -->
<div class="relative w-full h-[250px] flex items-center justify-center bg-gray-100 overflow-hidden mb-12">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-80" alt="Wishlist Header">
        <div class="absolute inset-0 bg-black/10"></div>
    </div>
    <div class="relative z-10 text-center">
        <span class="block text-sm font-bold tracking-[3px] text-brand-gold uppercase mb-2">Curated For You</span>
        <h1 class="text-4xl md:text-5xl font-serif text-white drop-shadow-md">My Wishlist</h1>
    </div>
</div>

<div class="container section-padding pb-24 mx-auto">
    @if($wishlistItems->count() > 0)
        <!-- Control Bar -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 border-b border-gray-200 pb-5 gap-4">
            <h2 class="text-xl font-serif">Saved Items ({{ $wishlistItems->count() }})</h2>
            <a href="{{ route('shop') }}" class="text-xs uppercase tracking-widest hover:text-brand-brown transition-colors flex items-center gap-2">
                <i class="ri-arrow-left-line"></i> Continue Shopping
            </a>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-xs uppercase tracking-widest text-gray-500">
                        <th class="py-4 font-normal w-[45%]">Product</th>
                        <th class="py-4 font-normal w-[15%]">Price</th>
                        <th class="py-4 font-normal w-[15%]">Status</th>
                        <th class="py-4 font-normal w-[25%] text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($wishlistItems as $item)
                        <tr class="group hover:bg-gray-50 transition-colors duration-300">
                            <!-- Product Info -->
                            <td class="py-6 pr-6">
                                <div class="flex items-center gap-6">
                                    <a href="{{ route('shop.product.show', $item->product->slug) }}" class="block w-24 aspect-[3/4] overflow-hidden bg-gray-100 shrink-0">
                                        <img src="{{ $item->product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400/F5F1EE/885a39?text=' . urlencode($item->product->name) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </a>
                                    <div>
                                        <a href="{{ route('shop.product.show', $item->product->slug) }}" class="text-lg font-serif hover:text-brand-brown transition-colors block mb-1">
                                            {{ $item->product->name }}
                                        </a>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $item->product->category->name ?? 'Fragrance' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Price -->
                            <td class="py-6">
                                <span class="font-medium text-brand-brown">${{ number_format($item->product->price, 2) }}</span>
                            </td>

                            <!-- Stock Status -->
                            <td class="py-6">
                                <span class="text-xs uppercase tracking-wide px-2 py-1 bg-green-100 text-green-800">In Stock</span>
                            </td>

                            <!-- Actions -->
                            <td class="py-6 text-right">
                                <div class="flex items-center justify-end gap-4">
                                    <button class="relative overflow-hidden group bg-black text-white text-xs uppercase tracking-widest px-6 py-3 transition-all duration-300 hover:shadow-lg" onclick="quickAdd({{ $item->product->id }})">
                                        <span class="relative z-10 group-hover:text-black transition-colors duration-300">Add to Bag</span>
                                        <div class="absolute inset-0 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300 ease-out"></div>
                                    </button>
                                    <button onclick="addToWishlist({{ $item->product->id }}); this.closest('tr').remove();" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-200 text-gray-400 hover:text-red-500 transition-all font-mono" title="Remove">
                                        <i class="ri-close-line text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile List View -->
        <div class="md:hidden flex flex-col gap-8">
            @foreach($wishlistItems as $item)
                <div class="flex gap-4 border-b border-gray-100 pb-6 relative">
                    <button onclick="addToWishlist({{ $item->product->id }}); this.closest('.flex').remove();" class="absolute top-0 right-0 p-2 text-gray-400 hover:text-red-500">
                        <i class="ri-close-line"></i>
                    </button>
                    
                    <a href="{{ route('shop.product.show', $item->product->slug) }}" class="w-24 aspect-[3/4] bg-gray-100 shrink-0">
                        <img src="{{ $item->product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400/F5F1EE/885a39?text=' . urlencode($item->product->name) }}" class="w-full h-full object-cover" alt="{{ $item->product->name }}">
                    </a>
                    
                    <div class="flex flex-col justify-center flex-1">
                        <h3 class="font-serif text-lg mb-1 leading-tight">{{ $item->product->name }}</h3>
                        <p class="text-brand-brown font-medium mb-3">${{ number_format($item->product->price, 2) }}</p>
                        
                        <button onclick="quickAdd({{ $item->product->id }})" class="self-start text-[10px] uppercase tracking-widest bg-black text-white px-4 py-2 hover:bg-brand-brown transition-colors">
                            Add to Bag
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="flex flex-col items-center justify-center py-20 text-center border border-dashed border-gray-300 rounded-sm">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <i class="ri-heart-line text-2xl text-gray-300"></i>
            </div>
            <h2 class="text-2xl font-serif mb-2">Your wishlist is empty</h2>
            <p class="text-gray-500 text-sm max-w-sm mx-auto mb-8 font-light">Explore our collection and save your favorite essences for later.</p>
            <a href="{{ route('shop') }}" class="text-xs uppercase tracking-[2px] border-b border-black pb-1 hover:text-brand-brown hover:border-brand-brown transition-all">
                Discover Collection
            </a>
        </div>
    @endif
</div>
@endsection
