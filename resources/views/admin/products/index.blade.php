@extends('admin.layouts.app')

@section('title', 'Manage Products')
@section('page_title', 'Products')

@section('content')
<div class="flex justify-between items-center mb-10">
    <h3 class="font-sans font-semibold text-lg">All Products</h3>
    <div class="flex gap-3">
        <a href="{{ route('admin.products.import') }}" class="px-6 py-3 bg-white text-slate-900 border border-slate-200 text-[11px] uppercase tracking-widest hover:bg-slate-50 transition-all rounded-lg shadow-sm font-bold">
            Import Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="px-6 py-3 bg-slate-900 text-white text-[11px] uppercase tracking-widest hover:bg-slate-800 transition-all rounded-lg shadow-sm font-bold">
            Add New Product
        </a>
    </div>
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
<div class="bg-white p-8 mb-10 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-6 items-end">
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2 font-semibold">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or SKU..." 
                class="w-full px-4 py-3 bg-white border border-slate-200 text-sm rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all outline-none">
        </div>
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2 font-semibold">Category</label>
            <select name="category_id" class="w-full px-4 py-3 bg-white border border-slate-200 text-sm rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all outline-none">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2 font-semibold">Brand</label>
            <select name="brand_id" class="w-full px-4 py-3 bg-white border border-slate-200 text-sm rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all outline-none">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[10px] uppercase tracking-widest text-slate-500 mb-2 font-semibold">Type</label>
            <select name="product_type" class="w-full px-4 py-3 bg-white border border-slate-200 text-sm rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 transition-all outline-none">
                <option value="">All Types</option>
                <option value="simple" {{ request('product_type') == 'simple' ? 'selected' : '' }}>Simple</option>
                <option value="variable" {{ request('product_type') == 'variable' ? 'selected' : '' }}>Variable</option>
                <option value="bundle" {{ request('product_type') == 'bundle' ? 'selected' : '' }}>Bundle</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-4 py-3 bg-slate-900 text-white text-[11px] uppercase tracking-[0.2em] hover:bg-slate-800 transition-all rounded-lg shadow-sm font-semibold">
                Filter
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-3 bg-slate-50 text-slate-600 border border-slate-200 text-[11px] uppercase tracking-[0.2em] hover:bg-slate-100 transition-all text-center rounded-lg font-semibold">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white p-0 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-8 py-5 text-[11px] uppercase tracking-widest text-slate-500 font-semibold">Product</th>
                    <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-semibold">Category</th>
                    <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-semibold">Type</th>
                    <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-semibold">Base Price</th>
                    <th class="py-5 text-[11px] uppercase tracking-widest text-slate-500 font-semibold text-center">Featured</th>
                    <th class="px-8 py-5 text-[11px] uppercase tracking-widest text-slate-500 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-slate-100">
                @forelse($products as $product)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex flex-col">
                            <span>{{ $product->name }}</span>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] opacity-40 uppercase tracking-tighter">{{ $product->brand->name ?? 'No Brand' }}</span>
                                @if($product->size)
                                    <span class="text-[10px] bg-slate-100 px-1.5 py-0.5 rounded text-slate-500 font-bold uppercase tracking-tighter">{{ $product->size }}</span>
                                @endif
                            </div>
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
                    <td class="text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" {{ $product->is_featured ? 'checked' : '' }} 
                                onchange="toggleFeatured('{{ $product->slug }}', this)">
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900"></div>
                        </label>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.products.show', $product) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:text-blue-500 hover:bg-blue-50 transition-all">
                                <i class="ri-eye-line text-lg"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:text-amber-500 hover:bg-amber-50 transition-all">
                                <i class="ri-edit-line text-lg"></i>
                            </a>
                            <form id="delete-form-{{ $product->slug }}" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" onclick="confirmDelete('{{ $product->slug }}', '{{ addslashes($product->name) }}')" class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all">
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
    
    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
        {{ $products->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFeatured(id, checkbox) {
        const isChecked = checkbox.checked;
        
        fetch(`/admin/products/${id}/toggle-featured`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ featured: isChecked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
            } else {
                checkbox.checked = !isChecked; // Revert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Something went wrong.'
                });
            }
        })
        .catch(error => {
            checkbox.checked = !isChecked; // Revert
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Internal Server Error'
            });
        });
    }

    function confirmDelete(slug, name) {
        Swal.fire({
            title: 'Delete Product?',
            text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0F172A',
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
                document.getElementById('delete-form-' + slug).submit();
            }
        });
    }
</script>
@endsection
