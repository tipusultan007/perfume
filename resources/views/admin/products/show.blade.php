@extends('admin.layouts.app')

@section('title', 'Product Details')
@section('page_title', 'Product: ' . $product->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.index') }}" class="w-10 h-10 border border-black/5 flex items-center justify-center hover:bg-black hover:text-white transition-all">
                <i class="ri-arrow-left-line"></i>
            </a>
            <div>
                <h3 class="font-serif text-2xl">{{ $product->name }}</h3>
                <p class="text-[10px] uppercase tracking-widest opacity-60 mt-1">
                    {{ ucfirst($product->product_type) }} Product • {{ $product->sku ?? 'No SKU' }}
                </p>
            </div>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.products.edit', $product) }}" class="px-6 py-3 border border-black text-[11px] uppercase tracking-widest hover:bg-black hover:text-white transition-all">
                Edit Product
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Left Column: Media & Gallery -->
        <div class="space-y-8">
            <div class="bg-white border border-black/5 p-2">
                @if($product->getFirstMediaUrl('featured'))
                    <img src="{{ $product->getFirstMediaUrl('featured') }}" class="w-full h-auto object-cover aspect-square">
                @else
                    <div class="w-full aspect-square bg-gray-50 flex items-center justify-center text-xs uppercase tracking-widest opacity-40">No Image</div>
                @endif
            </div>

            @if($product->getMedia('gallery')->count() > 0)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->getMedia('gallery') as $media)
                <div class="aspect-square border border-black/5 p-1">
                    <img src="{{ $media->getUrl() }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Right Column: Details -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Basic Info -->
            <div class="bg-white border border-black/5 p-10">
                <h4 class="font-serif text-lg mb-6 border-b border-black/5 pb-4">Product Overview</h4>
                
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Category</span>
                        <span class="font-medium">{{ $product->category->name }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Brand</span>
                        <span class="font-medium">{{ $product->brand->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Base Price</span>
                        <span class="font-mono">${{ number_format($product->base_price, 2) }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Total Stock</span>
                        <span class="font-mono">{{ $product->product_type == 'variable' ? $product->variants->sum('stock_quantity') : $product->stock_quantity }}</span>
                    </div>
                </div>

                <div class="mb-8">
                    <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-2">Short Description</span>
                    <p class="text-sm leading-relaxed opacity-80">{{ $product->short_description ?? 'No short description.' }}</p>
                </div>

                <div>
                    <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-2">Description</span>
                    <div class="prose prose-sm max-w-none text-opacity-80 font-light">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>

            <!-- Scent Profile -->
            <div class="bg-white border border-black/5 p-10">
                <h4 class="font-serif text-lg mb-6 border-b border-black/5 pb-4">Scent Profile</h4>
                <div class="space-y-8">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Gender</span>
                            <span class="font-medium">{{ $product->gender ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Concentration</span>
                            <span class="font-medium">{{ $product->concentration ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Size</span>
                            <span class="font-medium">{{ $product->size ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Season</span>
                            <span class="font-medium">{{ $product->season ?? 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Top Notes</span>
                            <p class="text-sm opacity-80">{{ $product->top_notes ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Heart Notes</span>
                            <p class="text-sm opacity-80">{{ $product->heart_notes ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase tracking-widest opacity-40 mb-1">Base Notes</span>
                            <p class="text-sm opacity-80">{{ $product->base_notes ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Variants / Options -->
            @if($product->product_type === 'variable')
            <div class="bg-white border border-black/5 p-10">
                <h4 class="font-serif text-lg mb-6 border-b border-black/5 pb-4">Variants ({{ $product->variants->count() }})</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-black/5">
                                <th class="py-3 text-[9px] uppercase tracking-widest opacity-40">Combination</th>
                                <th class="py-3 text-[9px] uppercase tracking-widest opacity-40">SKU</th>
                                <th class="py-3 text-[9px] uppercase tracking-widest opacity-40">Price</th>
                                <th class="py-3 text-[9px] uppercase tracking-widest opacity-40">Stock</th>
                                <th class="py-3 text-[9px] uppercase tracking-widest opacity-40">Image</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            @foreach($product->variants as $variant)
                            <tr class="border-b border-black/5 last:border-0 hover:bg-gray-50/50">
                                <td class="py-4 font-medium">
                                    {{ $variant->attributeValues->pluck('value')->join(' / ') }}
                                </td>
                                <td class="py-4 font-mono opacity-60">{{ $variant->sku }}</td>
                                <td class="py-4 font-mono">
                                    @if($variant->sale_price)
                                        <span class="text-red-500 mr-1">${{ number_format($variant->sale_price, 2) }}</span>
                                        <strike class="opacity-40 text-[10px]">${{ number_format($variant->price, 2) }}</strike>
                                    @else
                                        ${{ number_format($variant->price, 2) }}
                                    @endif
                                </td>
                                <td class="py-4 {{ $variant->stock_quantity < 10 ? 'text-red-500' : 'text-emerald-600' }}">
                                    {{ $variant->stock_quantity }}
                                </td>
                                <td class="py-4">
                                    @if($variant->getFirstMediaUrl('variant_image'))
                                        <img src="{{ $variant->getFirstMediaUrl('variant_image') }}" class="w-8 h-8 object-cover border border-black/5">
                                    @else
                                        <span class="opacity-20">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- SEO Data -->
            <div class="bg-gray-50 border border-black/5 p-8">
                <span class="text-[10px] uppercase tracking-widest font-semibold block mb-4 border-b border-black/5 pb-2">SEO Preview</span>
                <div class="space-y-4">
                    <div>
                        <span class="block text-[9px] uppercase tracking-widest opacity-40 mb-1">Meta Title</span>
                        <p class="text-sm font-medium">{{ $product->meta_title ?? $product->name }}</p>
                    </div>
                    <div>
                        <span class="block text-[9px] uppercase tracking-widest opacity-40 mb-1">Meta Description</span>
                        <p class="text-xs opacity-70">{{ $product->meta_description ?? Str::limit(strip_tags($product->description), 150) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
