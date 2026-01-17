@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page_title', 'Update Product')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 200px; font-family: 'Inter', sans-serif; font-size: 14px; }
    .ql-toolbar.ql-snow { border-color: rgba(0,0,0,0.1); border-bottom: none; }
    .ql-container.ql-snow { border-color: rgba(0,0,0,0.1); }
    
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
        <div class="bg-red-50 text-red-600 p-4 mb-8 text-xs uppercase tracking-widest border border-red-100">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left: Basic Info -->
        <div class="lg:col-span-2 space-y-10">
            <div class="bg-white border border-black/5 p-10">
                <div class="flex items-center gap-4 mb-8 border-b border-black/5 pb-4">
                    <a href="{{ route('admin.products.index') }}" class="w-8 h-8 border border-black/5 flex items-center justify-center hover:bg-black hover:text-white transition-all"><i class="ri-arrow-left-line"></i></a>
                    <h3 class="font-serif text-xl">General Information</h3>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Category</label>
                            <select name="category_id" required class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Brand (Optional)</label>
                            <select name="brand_id" class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Short Description</label>
                        <textarea name="short_description" rows="3" class="w-full p-4 border border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Tags (Comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags', $product->tags->pluck('name')->implode(', ')) }}" placeholder="Perfume, Luxury, Summer, Oudh"
                            class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Full Description</label>
                        <div id="description-editor">{!! $product->description !!}</div>
                        <input type="hidden" name="description" id="description-input">
                    </div>
                </div>
            </div>

            <!-- Perfume Scent Profile -->
            <div class="bg-white border border-black/5 p-10">
                <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Scent Profile</h3>
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Gender</label>
                            <select name="gender" class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender', $product->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $product->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Concentration</label>
                            <select name="concentration" class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                                <option value="">Select Concentration</option>
                                <option value="Parfum" {{ old('concentration', $product->concentration) == 'Parfum' ? 'selected' : '' }}>Parfum</option>
                                <option value="EDP" {{ old('concentration', $product->concentration) == 'EDP' ? 'selected' : '' }}>Eau de Parfum (EDP)</option>
                                <option value="EDT" {{ old('concentration', $product->concentration) == 'EDT' ? 'selected' : '' }}>Eau de Toilette (EDT)</option>
                                <option value="EDC" {{ old('concentration', $product->concentration) == 'EDC' ? 'selected' : '' }}>Eau de Cologne (EDC)</option>
                                <option value="Oil" {{ old('concentration', $product->concentration) == 'Oil' ? 'selected' : '' }}>Perfume Oil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Season</label>
                            <select name="season" class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
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
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Top Notes</label>
                            <textarea name="top_notes" rows="2" placeholder="Citrus, Bergamot..." class="w-full p-3 border border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">{{ old('top_notes', $product->top_notes) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Heart Notes</label>
                            <textarea name="heart_notes" rows="2" placeholder="Rose, Jasmine..." class="w-full p-3 border border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">{{ old('heart_notes', $product->heart_notes) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Base Notes</label>
                            <textarea name="base_notes" rows="2" placeholder="Musk, Amber..." class="w-full p-3 border border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">{{ old('base_notes', $product->base_notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Section -->
            <div class="bg-white border border-black/5 p-10">
                <h3 class="font-serif text-xl mb-8 border-b border-black/5 pb-4">Search Engine Optimization</h3>
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                            class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full p-4 border border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent text-xs">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Product Type & Variants Section -->
            <div class="bg-white border border-black/5 p-10">
                <div class="flex justify-between items-center mb-8 border-b border-black/5 pb-4">
                    <h3 class="font-serif text-xl">Product Type & Pricing</h3>
                    <span class="text-[10px] uppercase tracking-widest font-semibold bg-luxury-cream px-4 py-2 rounded">{{ ucfirst($product->product_type) }} Product</span>
                    <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                </div>

                @if($product->product_type == 'simple')
                <div id="simple-pricing" class="space-y-8">
                    <!-- Simple Pricing Fields (Keep as is) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="PRD-XXXX"
                                class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Regular Price ($)</label>
                            <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                                class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Sale Price (Optional)</label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}"
                                class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock_quantity) }}"
                                class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        </div>
                    </div>
                </div>
                @elseif($product->product_type == 'variable')
                <div id="variable-pricing" class="space-y-10">
                    <!-- Base Price for Variable Product -->
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Display / Starting Price ($)</label>
                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                            class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        <p class="text-[10px] opacity-40 mt-2">This price is used for display purposes in product listings.</p>
                    </div>

                    <!-- Variant Generator Tools -->
                    <div class="bg-gray-50/50 p-6 border border-black/5">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-[10px] uppercase tracking-widest font-semibold opacity-60">Variant Configuration</h4>
                            <button type="button" onclick="document.getElementById('attribute-selector').classList.toggle('hidden')" class="text-[10px] uppercase tracking-widest underline decoration-black/20 hover:text-luxury-black transition-all">
                                Manage Attributes
                            </button>
                        </div>
                        
                        <div id="attribute-selector" class="hidden space-y-6 mb-8 border-b border-black/5 pb-8">
                            @foreach($attributes as $attribute)
                            <div class="p-4 bg-white border border-black/5">
                                <span class="text-xs font-semibold uppercase tracking-wider mb-3 block">{{ $attribute->name }}</span>
                                <div class="flex flex-wrap gap-2">
                                    <input type="checkbox" class="attribute-checkbox hidden" value="{{ $attribute->id }}" data-name="{{ $attribute->name }}" id="attr-{{ $attribute->id }}">
                                    @foreach($attribute->values as $val)
                                    <label class="inline-flex items-center bg-gray-50 px-3 py-2 border border-black/5 cursor-pointer hover:border-luxury-accent transition-all value-label">
                                        <input type="checkbox" class="value-checkbox mr-2 hidden" value="{{ $val->id }}" data-text="{{ $val->value }}" data-parent="attr-{{ $attribute->id }}">
                                        <span class="text-[10px] uppercase tracking-widest opacity-60">{{ $val->value }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            <button type="button" onclick="generateVariants()" class="w-full py-4 border border-luxury-black text-luxury-black text-[10px] uppercase tracking-widest hover:bg-luxury-black hover:text-white transition-all">
                                Generate Variations from Selection
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left" id="variants-table">
                            <thead>
                                <tr class="border-b border-black/5">
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Variant</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">SKU</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Price ($)</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Sale Price ($)</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Stock</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Image</th>
                                    <th class="py-4 text-[9px] uppercase tracking-widest text-black/40">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs" id="variants-tbody">
                                @foreach($product->variants as $index => $variant)
                                <tr class="border-b border-black/5 hover:bg-gray-50/50 transition-all variant-row">
                                    <td class="py-6 pr-4">
                                        <span class="uppercase tracking-widest font-semibold text-[10px]">
                                            {{ $variant->attributeValues->pluck('value')->join(' / ') }}
                                        </span>
                                        @foreach($variant->attributeValues as $val)
                                            <input type="hidden" name="variants[{{ $index }}][attributes][]" value="{{ $val->id }}">
                                        @endforeach
                                    </td>
                                    <td class="pr-4">
                                        <input type="text" name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}" required class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]">
                                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    </td>
                                    <td class="pr-4"><input type="number" step="0.01" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" required class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                                    <td class="pr-4"><input type="number" step="0.01" name="variants[{{ $index }}][sale_price]" value="{{ $variant->sale_price }}" class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                                    <td class="pr-4"><input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock_quantity }}" required class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                                    <td class="pr-4">
                                        <input type="file" name="variants[{{ $index }}][image]" class="hidden" id="var-img-{{ $index }}" onchange="previewVariantImage(this, {{ $index }})">
                                        <div onclick="document.getElementById('var-img-{{ $index }}').click()" 
                                            class="w-10 h-10 border border-dashed border-black/10 flex items-center justify-center cursor-pointer hover:bg-gray-50 overflow-hidden">
                                            @if($variant->getFirstMediaUrl('variant_image'))
                                                <img src="{{ $variant->getFirstMediaUrl('variant_image') }}" id="var-preview-{{ $index }}" class="w-full h-full object-cover">
                                                <i class="ri-image-add-line opacity-20 hidden" id="var-icon-{{ $index }}"></i>
                                            @else
                                                <i class="ri-image-add-line opacity-20" id="var-icon-{{ $index }}"></i>
                                                <img id="var-preview-{{ $index }}" class="hidden w-full h-full object-cover">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <button type="button" onclick="removeVariant(this)" class="text-red-300 hover:text-red-500 transition-colors"><i class="ri-delete-bin-line text-lg"></i></button>
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
                             <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Base Price ($)</label>
                             <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}"
                                 class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        </div>
                        <div>
                             <label class="block text-[10px] uppercase tracking-widest mb-3 opacity-60">Stock Quantity</label>
                             <input type="number" name="stock" value="{{ old('stock', $product->stock_quantity) }}"
                                 class="w-full py-4 border-b border-black/10 focus:border-luxury-black outline-none transition-colors text-sm bg-transparent">
                        </div>
                    </div>

                    <div class="bg-gray-50/50 p-6 border border-black/5">
                        <h4 class="text-[10px] uppercase tracking-widest mb-6 font-semibold opacity-60 text-center">Manage Bundle Content</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                            @foreach($simpleProducts as $sProduct)
                            <label class="flex items-center space-x-3 p-4 bg-white border border-black/5 hover:border-black/20 cursor-pointer transition-all">
                                <input type="checkbox" name="bundle_items[]" value="{{ $sProduct->id }}" 
                                    {{ $product->bundledProducts->contains($sProduct->id) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-luxury-black border-gray-300 focus:ring-0">
                                <div>
                                    <span class="block text-xs font-medium">{{ $sProduct->name }}</span>
                                    <span class="block text-[10px] opacity-50">{{ $sProduct->sku }} • ${{ number_format($sProduct->base_price, 2) }}</span>
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
            <div class="bg-white border border-black/5 p-8 sticky top-24">
                <h3 class="font-serif text-lg mb-6">Publish</h3>
                <button type="submit" class="w-full py-4 bg-luxury-black text-white text-[11px] uppercase tracking-widest hover:bg-opacity-90 transition-all shadow-lg">
                    Update Product
                </button>
            </div>

            <!-- Primary Image -->
            <div class="bg-white border border-black/5 p-8">
                <h3 class="font-serif text-lg mb-6">Featured Image</h3>
                <div onclick="document.getElementById('primary_image').click()" 
                    class="border border-dashed border-black/10 aspect-square flex flex-col items-center justify-center p-4 cursor-pointer hover:bg-gray-50 transition-all relative">
                    <div id="primary-preview" class="{{ $product->getFirstMediaUrl('featured') ? '' : 'hidden' }} absolute inset-0 bg-white">
                        <img src="{{ $product->getFirstMediaUrl('featured') }}" class="w-full h-full object-cover">
                        <button type="button" onclick="removePrimaryPreview(event)" class="remove-btn absolute top-2 right-2 flex items-center justify-center bg-white/80 rounded-full w-6 h-6 border border-black/5"><i class="ri-close-line"></i></button>
                    </div>
                    <i class="ri-image-add-line text-3xl opacity-20"></i>
                    <p class="text-[10px] uppercase tracking-widest mt-4 opacity-40">Choose Image</p>
                </div>
                <input type="file" name="primary_image" id="primary_image" class="hidden" onchange="previewPrimary(this)">
            </div>

            <!-- Gallery -->
            <div class="bg-white border border-black/5 p-8">
                <h3 class="font-serif text-lg mb-6">Product Gallery</h3>
                <div class="preview-container mb-6" id="gallery-preview">
                    @foreach($product->getMedia('gallery') as $media)
                    <div class="preview-item">
                        <img src="{{ $media->getUrl() }}">
                        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
                            <input type="hidden" name="existing_media[]" value="{{ $media->id }}">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <div onclick="document.getElementById('gallery_input').click()" 
                    class="border border-dashed border-black/10 py-6 text-center cursor-pointer hover:bg-gray-50 transition-all">
                    <i class="ri-add-line text-xl opacity-40"></i>
                    <p class="text-[9px] uppercase tracking-widest mt-1 opacity-40">Add More Images</p>
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
            row.className = 'border-b border-black/5 hover:bg-gray-50/50 transition-all variant-row';
            row.innerHTML = `
                <td class="py-6 pr-4">
                    <span class="uppercase tracking-widest font-semibold text-[10px]">${label}</span>
                    ${ids.map(id => `<input type="hidden" name="variants[${index}][attributes][]" value="${id}">`).join('')}
                    <input type="hidden" name="variants[${index}][new]" value="1">
                </td>
                <td class="pr-4"><input type="text" name="variants[${index}][sku]" value="${variantSku}" required class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                <td class="pr-4"><input type="number" step="0.01" name="variants[${index}][price]" value="0.00" required class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                <td class="pr-4"><input type="number" step="0.01" name="variants[${index}][sale_price]" placeholder="Optional" class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                <td class="pr-4"><input type="number" name="variants[${index}][stock]" value="0" required class="w-full py-2 bg-transparent border-b border-black/5 focus:border-black outline-none font-mono text-[11px]"></td>
                <td class="pr-4">
                    <input type="file" name="variants[${index}][image]" class="hidden" id="var-img-${index}" onchange="previewVariantImage(this, ${index})">
                    <div onclick="document.getElementById('var-img-${index}').click()" 
                        class="w-10 h-10 border border-dashed border-black/10 flex items-center justify-center cursor-pointer hover:bg-gray-50 overflow-hidden">
                        <i class="ri-image-add-line opacity-20" id="var-icon-${index}"></i>
                        <img id="var-preview-${index}" class="hidden w-full h-full object-cover">
                    </div>
                </td>
                <td class="text-right">
                    <button type="button" onclick="removeVariant(this)" class="text-red-300 hover:text-red-500 transition-colors"><i class="ri-delete-bin-line text-lg"></i></button>
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
