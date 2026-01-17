@extends('admin.layouts.app')

@section('title', 'Manage Products')
@section('page_title', 'Products')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-sans font-semibold text-lg">All Products</h3>
    <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all">
        Add New Product
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 text-emerald-700 p-4 mb-8 text-xs uppercase tracking-widest border border-emerald-100">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-10 shadow-sm border border-black/[0.03]">

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-black/5">
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Product</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Category</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Type</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium">Base Price</th>
                    <th class="py-4 text-[11px] uppercase tracking-widest text-black/40 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($products as $product)
                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-colors">
                    <td class="py-6 font-medium">
                        <div class="flex flex-col">
                            <span>{{ $product->name }}</span>
                            <span class="text-[10px] opacity-40 uppercase tracking-tighter">{{ $product->brand->name ?? 'No Brand' }}</span>
                        </div>
                    </td>
                    <td class="opacity-60">{{ $product->category->name }}</td>
                    <td>
                        <span class="inline-block px-2 py-1 {{ $product->product_type == 'variable' ? 'bg-purple-50 text-purple-700' : 'bg-blue-50 text-blue-700' }} text-[10px] rounded uppercase tracking-wider">
                            {{ $product->product_type }}
                            @if($product->product_type == 'variable')
                                ({{ $product->variants_count ?? $product->variants->count() }})
                            @endif
                        </span>
                    </td>
                    <td class="font-mono">${{ number_format($product->base_price, 2) }}</td>
                    <td class="text-right">
                        <div class="flex justify-end gap-4">
                            <a href="{{ route('admin.products.show', $product) }}" class="text-blue-400 hover:text-blue-600 transition-colors">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-luxury-accent hover:text-luxury-black transition-colors">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition-colors">
                                    <i class="ri-delete-bin-line text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-black/40 text-xs uppercase tracking-widest">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-10">
        {{ $products->links() }}
    </div>
</div>
@endsection
