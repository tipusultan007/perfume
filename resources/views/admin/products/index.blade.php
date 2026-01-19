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
    <div class="bg-emerald-50 text-emerald-700 p-4 mb-8 text-xs uppercase tracking-widest border border-emerald-100 flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif

<!-- Filters -->
<div class="bg-white p-8 mb-10 shadow-sm border border-black/[0.03]">
    <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-black/40 mb-2">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or SKU..." 
                class="w-full px-4 py-3 bg-[#fcfaf7] border border-black/5 text-sm focus:border-luxury-accent transition-all outline-none">
        </div>
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-black/40 mb-2">Category</label>
            <select name="category_id" class="w-full px-4 py-3 bg-[#fcfaf7] border border-black/5 text-sm focus:border-luxury-accent transition-all outline-none">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-black/40 mb-2">Brand</label>
            <select name="brand_id" class="w-full px-4 py-3 bg-[#fcfaf7] border border-black/5 text-sm focus:border-luxury-accent transition-all outline-none">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-black/40 mb-2">Type</label>
            <select name="product_type" class="w-full px-4 py-3 bg-[#fcfaf7] border border-black/5 text-sm focus:border-luxury-accent transition-all outline-none">
                <option value="">All Types</option>
                <option value="simple" {{ request('product_type') == 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="variable" {{ request('product_type') == 'variable' ? 'selected' : '' }}>Variable</option>
                <option value="bundle" {{ request('product_type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-4 py-3 bg-luxury-accent text-white text-[11px] uppercase tracking-[0.2em] hover:bg-opacity-90 transition-all">
                Filter
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-3 bg-gray-100 text-black/60 text-[11px] uppercase tracking-[0.2em] hover:bg-gray-200 transition-all text-center">
                Reset
            </a>
        </div>
    </form>
</div>

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
                            <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" onclick="confirmDelete('{{ $product->id }}', '{{ addslashes($product->name) }}')" class="text-red-400 hover:text-red-600 transition-colors">
                                <i class="ri-delete-bin-line text-lg"></i>
                            </button>
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

@section('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Delete Product?',
            text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0A0A0A',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-none border-t-4 border-black',
                confirmButton: 'rounded-none px-6 py-3 uppercase tracking-widest text-[11px]',
                cancelButton: 'rounded-none px-6 py-3 uppercase tracking-widest text-[11px]'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
