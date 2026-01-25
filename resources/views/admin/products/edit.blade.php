@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page_title', 'Update Product')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 200px; font-family: 'Inter', sans-serif; font-size: 14px; }
    .ql-toolbar.ql-snow { border-color: #e2e8f0; border-bottom: none; border-radius: 8px 8px 0 0; }
    .ql-container.ql-snow { border-color: #e2e8f0; border-radius: 0 0 8px 8px; }
    
    .preview-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; }
    .preview-item { position: relative; aspect-ratio: 1; border: 1px solid rgba(0,0,0,0.05); overflow: hidden; }
    .preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .preview-item .remove-btn { position: absolute; top: 2px; right: 2px; background: rgba(255,255,255,0.8); border-radius: 50%; width: 20px; height: 20px; display: flex; items-center; justify-center; cursor: pointer; font-size: 12px; border: none; }
</style>
@endsection

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="product-form">
    @csrf
    @method('PUT')

    @if ($errors->any())
        <div class="bg-rose-50 text-rose-600 p-6 mb-10 rounded-xl border border-rose-100 shadow-sm">
            <h4 class="text-[11px] uppercase tracking-widest font-bold mb-3">Please correct the following:</h4>
            <ul class="list-disc list-inside text-sm font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left: Basic Info -->
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
                <div class="flex items-center gap-6 mb-10 border-b border-slate-100 pb-6">
                    <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-slate-50 border border-slate-200 flex items-center justify-center rounded-lg hover:bg-slate-900 hover:text-white transition-all shadow-sm"><i class="ri-arrow-left-line text-lg"></i></a>
                    <h3 class="font-bold text-xl text-slate-900">General Information</h3>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Category</label>
                            <select name="category_id" required class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Brand (Optional)</label>
                            <select name="brand_id" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Short Description</label>
                        <textarea name="short_description" rows="3" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Tags (Comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', $product->tags->pluck('name')->implode(', ')) }}" placeholder="Perfume, Luxury, Summer, Oudh"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Full Description</label>
                        <div id="description-editor" class="bg-white rounded-lg">{!! $product->description !!}</div>
                        <input type="hidden" name="description" id="description-input">
                    </div>
                </div>
            </div>

            <!-- Scent Profile -->
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
                <h3 class="font-bold text-xl text-slate-900 mb-8 border-b border-slate-100 pb-6">Scent Profile</h3>
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Gender</label>
                            <select name="gender" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $product->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $product->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Concentration</label>
                            <select name="concentration" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                                <option value="">Select Concentration</option>
                                <option value="Parfum" {{ old('concentration', $product->concentration) == 'Parfum' ? 'selected' : '' }}>Parfum</option>
                                <option value="EDP" {{ old('concentration', $product->concentration) == 'EDP' ? 'selected' : '' }}>Eau de Parfum (EDP)</option>
                                <option value="EDT" {{ old('concentration', $product->concentration) == 'EDT' ? 'selected' : '' }}>Eau de Toilette (EDT)</option>
                                <option value="EDC" {{ old('concentration', $product->concentration) == 'EDC' ? 'selected' : '' }}>Eau de Cologne (EDC)</option>
                                <option value="Oil" {{ old('concentration', $product->concentration) == 'Oil' ? 'selected' : '' }}>Perfume Oil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Size (e.g. 100ml)</label>
                            <input type="text" name="size" value="{{ old('size', $product->size) }}" placeholder="100ml"
                                class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Season</label>
                            <select name="season" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                                <option value="">Select Season</option>
                                <option value="Spring" {{ old('season', $product->season) == 'Spring' ? 'selected' : '' }}>Spring</option>
                                <option value="Summer" {{ old('season', $product->season) == 'Summer' ? 'selected' : '' }}>Summer</option>
                                <option value="Fall" {{ old('season', $product->season) == 'Fall' ? 'selected' : '' }}>Fall</option>
                                <option value="Winter" {{ old('season', $product->season) == 'Winter' ? 'selected' : '' }}>Winter</option>
                                <option value="All Season" {{ old('season', $product->season) == 'All Season' ? 'selected' : '' }}>All Season</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Top Notes</label>
                            <textarea name="top_notes" rows="2" placeholder="Citrus, Bergamot..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('top_notes', $product->top_notes) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Heart Notes</label>
                            <textarea name="heart_notes" rows="2" placeholder="Rose, Jasmine..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('heart_notes', $product->heart_notes) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Base Notes</label>
                            <textarea name="base_notes" rows="2" placeholder="Musk, Amber..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('base_notes', $product->base_notes) }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Intensity/Sillage</label>
                        <input type="text" name="intensity" value="{{ old('intensity', $product->intensity) }}" placeholder="e.g. Moderate, Strong, Heavy"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
                <h3 class="font-bold text-xl text-slate-900 mb-8 border-b border-slate-100 pb-6">Search Engine Optimization</h3>
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium text-xs">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Product Type & Pricing -->
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-6">
                    <h3 class="font-bold text-xl text-slate-900">Type & Pricing</h3>
                    <span class="text-[10px] uppercase tracking-widest font-bold bg-slate-900 text-white px-4 py-2 rounded-lg shadow-sm">{{ ucfirst($product->product_type) }} Product</span>
                    <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                </div>

                @if($product->product_type == 'simple')
                <div id="simple-pricing" class="space-y-8">
                    <!-- Simple Pricing Fields (Keep as is) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="PRD-XXXX"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Regular Price ($)</label>
                            <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Sale Price (Optional)</label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock_quantity) }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                    </div>
                </div>
                @elseif($product->product_type == 'variable')
                <div id="variable-pricing" class="space-y-10">
                    <!-- Base Price for Variable Product -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Display / Starting Price ($)</label>
                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        <p class="text-[10px] text-slate-400 mt-2 font-medium italic">This price is used for display purposes in product listings.</p>
                    </div>

                    <!-- Variant Setup -->
                    <div class="bg-slate-50/50 p-8 rounded-xl border border-slate-200">
                        <div class="flex justify-between items-center mb-8">
                            <h4 class="text-[10px] uppercase tracking-[0.2em] font-bold text-slate-500">Variant Configuration</h4>
                            <button type="button" onclick="document.getElementById('attribute-selector').classList.toggle('hidden')" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-[10px] uppercase tracking-widest font-bold text-slate-700 hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                                Manage Attributes
                            </button>
                        </div>
                        
                        <div id="attribute-selector" class="hidden space-y-8 mb-10 border-b border-slate-200 pb-10">
                            @foreach($attributes as $attribute)
                            <div class="p-6 bg-white border border-slate-200 rounded-xl shadow-sm">
                                <span class="text-[11px] font-bold uppercase tracking-widest text-slate-900 mb-5 block border-b border-slate-100 pb-3">{{ $attribute->name }}</span>
                                <div class="flex flex-wrap gap-3">
                                    <input type="checkbox" class="attribute-checkbox hidden" value="{{ $attribute->id }}" data-name="{{ $attribute->name }}" id="attr-{{ $attribute->id }}">
                                    @foreach($attribute->values as $val)
                                    <label class="inline-flex items-center px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:border-slate-900 hover:bg-slate-100 transition-all value-label shadow-sm">
                                        <input type="checkbox" class="value-checkbox mr-2 hidden" value="{{ $val->id }}" data-text="{{ $val->value }}" data-parent="attr-{{ $attribute->id }}">
                                        <span class="text-[10px] uppercase tracking-widest font-bold text-slate-500">{{ $val->value }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            <button type="button" onclick="generateVariants()" class="w-full py-4 bg-slate-900 border border-slate-900 rounded-xl text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-slate-800 transition-all shadow-xl">
                                Generate Variations from Selection
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-slate-200 mt-10">
                        <table class="w-full text-left border-collapse" id="variants-table">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold">Variant</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold">SKU</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold">Price ($)</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold">Sale Price ($)</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold">Stock</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold">Image</th>
                                    <th class="px-6 py-4 text-[9px] uppercase tracking-widest text-slate-500 font-bold text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs divide-y divide-slate-100" id="variants-tbody">
                                @foreach($product->variants as $index => $variant)
                                <tr class="hover:bg-slate-50/50 transition-all variant-row">
                                    <td class="px-6 py-6 pr-4">
                                        <span class="uppercase tracking-widest font-bold text-[10px] text-slate-900">
                                            {{ $variant->attributeValues->pluck('value')->join(' / ') }}
                                        </span>
                                        @foreach($variant->attributeValues as $val)
                                            <input type="hidden" name="variants[{{ $index }}][attributes][]" value="{{ $val->id }}">
                                        @endforeach
                                    </td>
                                    <td class="pr-4">
                                        <input type="text" name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold">
                                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    </td>
                                    <td class="pr-4"><input type="number" step="0.01" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                                    <td class="pr-4"><input type="number" step="0.01" name="variants[{{ $index }}][sale_price]" value="{{ $variant->sale_price }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                                    <td class="pr-4"><input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock_quantity }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                                    <td class="pr-4">
                                        <input type="file" name="variants[{{ $index }}][image]" class="hidden" id="var-img-{{ $index }}" onchange="previewVariantImage(this, {{ $index }})">
                                        <div onclick="document.getElementById('var-img-{{ $index }}').click()" 
                                            class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center cursor-pointer hover:bg-slate-100 overflow-hidden shadow-sm">
                                            @if($variant->getFirstMediaUrl('variant_image'))
                                                <img src="{{ $variant->getFirstMediaUrl('variant_image') }}" id="var-preview-{{ $index }}" class="w-full h-full object-cover">
                                                <i class="ri-image-add-line text-slate-400 hidden" id="var-icon-{{ $index }}"></i>
                                            @else
                                                <i class="ri-image-add-line text-slate-400" id="var-icon-{{ $index }}"></i>
                                                <img id="var-preview-{{ $index }}" class="hidden w-full h-full object-cover">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 text-right">
                                        <button type="button" onclick="removeVariant(this)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm"><i class="ri-delete-bin-line text-base"></i></button>
                                        @if($variant)
                                            <input type="hidden" name="variants[{{ $index }}][delete]" value="0" class="delete-flag">
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @elseif($product->product_type == 'bundle')
                <div id="bundle-pricing" class="space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                             <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Base Price ($)</label>
                             <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                                 class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                             <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Stock Quantity</label>
                             <input type="number" name="stock" value="{{ old('stock', $product->stock_quantity) }}"
                                 class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                    </div>

                    <div class="bg-slate-50/50 p-8 rounded-xl border border-slate-200">
                        <h4 class="text-[10px] uppercase tracking-[0.2em] mb-8 font-bold text-slate-500 text-center">Manage Bundle Content</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($simpleProducts as $sProduct)
                            <label class="flex items-center space-x-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-slate-900 cursor-pointer transition-all shadow-sm group">
                                <input type="checkbox" name="bundle_items[]" value="{{ $sProduct->id }}" 
                                    {{ $product->bundledProducts->contains($sProduct->id) ? 'checked' : '' }}
                                    class="form-checkbox h-5 w-5 rounded border-slate-300 text-slate-900 focus:ring-slate-900/10">
                                <div>
                                    <span class="block text-sm font-bold text-slate-900 group-hover:text-slate-900 transition-colors">{{ $sProduct->name }}</span>
                                    <span class="block text-[10px] text-slate-400 font-bold tracking-widest mt-0.5 uppercase">{{ $sProduct->sku }} • ${{ number_format($sProduct->base_price, 2) }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                   </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Gallery & Actions -->
        <div class="space-y-10">
            <div class="bg-white border border-slate-200 p-8 sticky top-24 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-8 border-b border-slate-100 pb-4">Actions</h3>
                <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                    Update Product
                </button>
            </div>

            <!-- Primary Image -->
            <div class="bg-white border border-slate-200 p-8 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-8 border-b border-slate-100 pb-4">Featured Image</h3>
                <div onclick="document.getElementById('primary_image').click()" 
                    class="border border-dashed border-slate-300 rounded-xl aspect-square flex flex-col items-center justify-center p-6 cursor-pointer hover:bg-slate-50 transition-all relative overflow-hidden group">
                    <div id="primary-preview" class="{{ $product->getFirstMediaUrl('featured') ? '' : 'hidden' }} absolute inset-0 bg-white group-hover:scale-105 transition-transform duration-500">
                        <img src="{{ $product->getFirstMediaUrl('featured') }}" class="w-full h-full object-cover">
                        <button type="button" onclick="removePrimaryPreview(event)" class="absolute top-3 right-3 flex items-center justify-center bg-white/90 rounded-full w-8 h-8 border border-slate-200 text-slate-900 shadow-xl hover:bg-rose-500 hover:text-white transition-all z-10"><i class="ri-close-line text-lg"></i></button>
                    </div>
                    <i class="ri-image-add-line text-4xl text-slate-300 mb-4"></i>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold text-center">Click to upload brand imagery</p>
                </div>
                <input type="file" name="primary_image" id="primary_image" class="hidden" onchange="previewPrimary(this)">
            </div>

            <!-- Gallery -->
            <div class="bg-white border border-slate-200 p-8 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-8 border-b border-slate-100 pb-4">Product Gallery</h3>
                <div class="preview-container mb-10" id="gallery-preview">
                    @foreach($product->getMedia('gallery') as $media)
                    <div class="preview-item rounded-lg border border-slate-200 shadow-sm group">
                        <img src="{{ $media->getUrl() }}" class="group-hover:scale-110 transition-transform duration-500">
                        <button type="button" class="remove-btn group-hover:bg-rose-500 group-hover:text-white transition-all shadow-xl" onclick="this.parentElement.remove()">
                            <input type="hidden" name="existing_media[]" value="{{ $media->id }}">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div onclick="document.getElementById('gallery_input').click()" 
                    class="border border-dashed border-slate-300 rounded-xl py-8 text-center cursor-pointer hover:bg-slate-50 transition-all border-spacing-2 group">
                    <i class="ri-add-line text-2xl text-slate-300 group-hover:text-slate-900 transition-colors"></i>
                    <p class="text-[10px] uppercase tracking-widest mt-2 text-slate-400 font-bold group-hover:text-slate-900 transition-colors">Add Gallery Images</p>
                </div>
                <input type="file" name="gallery[]" id="gallery_input" class="hidden" multiple onchange="previewGallery(this)">
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#description-editor', {
        theme: 'snow',
        placeholder: 'Update product story...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        }
    });

    document.getElementById('product-form').onsubmit = function() {
        document.getElementById('description-input').value = quill.root.innerHTML;
    };

    function previewPrimary(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('primary-preview');
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePrimaryPreview(event) {
        event.stopPropagation();
        const preview = document.getElementById('primary-preview');
        preview.classList.add('hidden');
        document.getElementById('primary_image').value = '';
    }

    function previewGallery(input) {
        const container = document.getElementById('gallery-preview');
        if (input.files) {
            Array.from(input.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = `<img src="${e.target.result}"><button type="button" class="remove-btn" onclick="this.parentElement.remove()"><i class="ri-close-line"></i></button>`;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }


    // Modern JS variant generation engine
    function generateVariants() {
        const attributeGroups = {};
        document.querySelectorAll('.value-checkbox:checked').forEach(cb => {
            const attrId = cb.dataset.parent.replace('attr-', '');
            const attrName = document.querySelector(`.value-checkbox[data-parent="attr-${attrId}"]`).closest('.p-4').querySelector('span').innerText;
            if(!attributeGroups[attrName]) attributeGroups[attrName] = [];
            attributeGroups[attrName].push({ id: cb.value, text: cb.dataset.text });
        });

        const keys = Object.keys(attributeGroups);
        if(keys.length === 0) {
            alert('Please select some options.');
            return;
        }

        function cartesian(args) {
            var r = [], max = args.length-1;
            function helper(arr, i) {
                for (var j=0, l=args[i].length; j<l; j++) {
                    var a = arr.slice(0);
                    a.push(args[i][j]);
                    if (i==max) r.push(a);
                    else helper(a, i+1);
                }
            }
            helper([], 0);
            return r;
        }

        const combinations = cartesian(keys.map(k => attributeGroups[k]));
        const tbody = document.getElementById('variants-tbody');
        // Do not clear existing rows, append new ones
        
        let existingCount = document.querySelectorAll('.variant-row').length;

        combinations.forEach((combo) => {
            const index = existingCount++;
            const label = combo.map(c => c.text).join(' / ');
            const ids = combo.map(c => c.id);
            const baseSku = document.getElementsByName('name')[0].value.replace(/\s+/g, '-').toUpperCase().substring(0,5);
            const variantSku = baseSku + '-' + label.replace(/ \/ /g, '-').toUpperCase();

            // Check if this combination already exists (based on label text is weak but works for now, ideally check IDs)
            let exists = false;
            document.querySelectorAll('.variant-row span').forEach(span => {
                if(span.innerText.trim() === label) exists = true;
            });

            if(exists) return; // Skip existing

            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50/50 transition-all variant-row';
            row.innerHTML = `
                <td class="px-6 py-6 pr-4">
                    <span class="uppercase tracking-widest font-bold text-[10px] text-slate-900">${label}</span>
                    ${ids.map(id => `<input type="hidden" name="variants[${index}][attributes][]" value="${id}">`).join('')}
                    <input type="hidden" name="variants[${index}][new]" value="1">
                </td>
                <td class="pr-4"><input type="text" name="variants[${index}][sku]" value="${variantSku}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                <td class="pr-4"><input type="number" step="0.01" name="variants[${index}][price]" value="0.00" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                <td class="pr-4"><input type="number" step="0.01" name="variants[${index}][sale_price]" placeholder="Optional" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                <td class="pr-4"><input type="number" name="variants[${index}][stock]" value="0" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-md focus:border-slate-900 outline-none font-mono text-[11px] font-bold"></td>
                <td class="pr-4">
                    <input type="file" name="variants[${index}][image]" class="hidden" id="var-img-${index}" onchange="previewVariantImage(this, ${index})">
                    <div onclick="document.getElementById('var-img-${index}').click()" 
                        class="w-10 h-10 border border-slate-200 rounded-lg flex items-center justify-center cursor-pointer hover:bg-slate-100 overflow-hidden shadow-sm">
                        <i class="ri-image-add-line text-slate-400" id="var-icon-${index}"></i>
                        <img id="var-preview-${index}" class="hidden w-full h-full object-cover">
                    </div>
                </td>
                <td class="px-6 text-right">
                    <button type="button" onclick="removeVariant(this)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm"><i class="ri-delete-bin-line text-base"></i></button>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.getElementById('attribute-selector').classList.add('hidden');
    }

    function removeVariant(btn) {
        const row = btn.closest('tr');
        const deleteFlag = row.querySelector('.delete-flag');
        if(deleteFlag) {
            // It's an existing variant, just mark for deletion and hide
            deleteFlag.value = "1";
            row.style.display = 'none';
        } else {
            // It's a new variant, Remove from DOM
            row.remove();
        }
    }

    function previewVariantImage(input, index) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(`var-preview-${index}`);
                const icon = document.getElementById(`var-icon-${index}`);
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(icon) icon.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Toggle color for selected labels
    document.addEventListener('change', function(e) {
        if(e.target.classList.contains('value-checkbox')) {
            const label = e.target.parentElement;
            if(e.target.checked) {
                label.classList.add('bg-luxury-black', 'border-luxury-black');
                label.querySelector('span').classList.remove('opacity-60');
                label.querySelector('span').classList.add('text-white');
            } else {
                label.classList.remove('bg-luxury-black', 'border-luxury-black');
                label.querySelector('span').classList.add('opacity-60');
                label.querySelector('span').classList.remove('text-white');
            }
        }
    });
</script>
@endsection
