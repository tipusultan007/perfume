@extends('admin.layouts.app')

@section('title', 'Add Product')
@section('page_title', 'Create Product')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 250px; font-family: 'Inter', sans-serif; font-size: 14px; background: white; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
    .ql-toolbar.ql-snow { border-color: #e2e8f0; border-top-left-radius: 8px; border-top-right-radius: 8px; background: #f8fafc; }
    .ql-container.ql-snow { border-color: #e2e8f0; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px; }
    
    .preview-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 16px; }
    .preview-item { position: relative; aspect-ratio: 1; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
    .preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .preview-item .remove-btn { position: absolute; top: 4px; right: 4px; background: rgba(255,255,255,0.9); border-radius: 50%; width: 24px; height: 24px; display: flex; items-center; justify-center; cursor: pointer; color: #ef4444; border: 1px solid #fee2e2; shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transition: all 0.2s; }
    .preview-item .remove-btn:hover { background: #ef4444; color: white; transform: scale(1.1); }
</style>
@endsection

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
    @csrf
    
    @if ($errors->any())
        <div class="bg-rose-50 text-rose-600 p-6 mb-10 rounded-xl border border-rose-100 shadow-sm">
            <div class="flex items-center mb-3">
                <i class="ri-error-warning-fill mr-2 text-xl"></i>
                <span class="font-bold uppercase tracking-widest text-xs">Submission Errors</span>
            </div>
            <ul class="list-disc list-inside text-sm font-medium space-y-1">
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
                <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-6">
                    <h3 class="font-bold text-xl text-slate-900">General Information</h3>
                    <a href="{{ route('admin.products.index') }}" class="w-10 h-10 bg-slate-50 border border-slate-200 flex items-center justify-center rounded-lg hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                        <i class="ri-arrow-left-line"></i>
                    </a>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Product Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Category</label>
                            <select name="category_id" required class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium cursor-pointer appearance-none">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Brand (Optional)</label>
                            <select name="brand_id" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium cursor-pointer appearance-none">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Short Description</label>
                        <textarea name="short_description" rows="3" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('short_description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Tags (Comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Perfume, Luxury, Summer, Oudh"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Full Description</label>
                        <div id="description-editor" class="bg-white rounded-lg"></div>
                        <input type="hidden" name="description" id="description-input">
                    </div>
                </div>
            </div>

            <!-- Perfume Scent Profile -->
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
                <h3 class="font-bold text-xl text-slate-900 mb-8 border-b border-slate-100 pb-6">Scent Profile</h3>
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Gender</label>
                            <select name="gender" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium cursor-pointer appearance-none">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Concentration</label>
                            <select name="concentration" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium cursor-pointer appearance-none">
                                <option value="">Select Concentration</option>
                                <option value="Parfum" {{ old('concentration') == 'Parfum' ? 'selected' : '' }}>Parfum</option>
                                <option value="EDP" {{ old('concentration') == 'EDP' ? 'selected' : '' }}>Eau de Parfum (EDP)</option>
                                <option value="EDT" {{ old('concentration') == 'EDT' ? 'selected' : '' }}>Eau de Toilette (EDT)</option>
                                <option value="EDC" {{ old('concentration') == 'EDC' ? 'selected' : '' }}>Eau de Cologne (EDC)</option>
                                <option value="Oil" {{ old('concentration') == 'Oil' ? 'selected' : '' }}>Perfume Oil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Size (e.g. 100ml)</label>
                            <input type="text" name="size" value="{{ old('size') }}" placeholder="100ml"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Season</label>
                            <select name="season" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium cursor-pointer appearance-none">
                                <option value="">Select Season</option>
                                <option value="Spring" {{ old('season') == 'Spring' ? 'selected' : '' }}>Spring</option>
                                <option value="Summer" {{ old('season') == 'Summer' ? 'selected' : '' }}>Summer</option>
                                <option value="Fall" {{ old('season') == 'Fall' ? 'selected' : '' }}>Fall</option>
                                <option value="Winter" {{ old('season') == 'Winter' ? 'selected' : '' }}>Winter</option>
                                <option value="All Season" {{ old('season') == 'All Season' ? 'selected' : '' }}>All Season</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Top Notes</label>
                            <textarea name="top_notes" rows="2" placeholder="Citrus, Bergamot..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('top_notes') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Heart Notes</label>
                            <textarea name="heart_notes" rows="2" placeholder="Rose, Jasmine..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('heart_notes') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Base Notes</label>
                            <textarea name="base_notes" rows="2" placeholder="Musk, Amber..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">{{ old('base_notes') }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Intensity/Sillage</label>
                        <input type="text" name="intensity" value="{{ old('intensity') }}" placeholder="e.g. Moderate, Strong, Heavy"
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
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                            class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="w-full px-5 py-4 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium text-xs">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Product Type & Pricing -->
            <div class="bg-white border border-slate-200 p-10 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-10 border-b border-slate-100 pb-6">
                    <h3 class="font-bold text-xl text-slate-900">Type & Pricing</h3>
                    <select name="product_type" id="product_type" onchange="toggleVariantSection()" 
                        class="text-[10px] uppercase tracking-widest font-bold bg-slate-900 text-white px-4 py-2 rounded-lg shadow-sm focus:ring-0 cursor-pointer appearance-none">
                        <option value="simple">Simple Product</option>
                        <option value="variable">Variable Product</option>
                        <option value="bundle">Group Product (Bundle)</option>
                    </select>
                </div>

                <!-- Simple Product Pricing -->
                <div id="simple-pricing" class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" placeholder="PRD-XXXX"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Regular Price ($)</label>
                            <input type="number" step="0.01" name="base_price" value="{{ old('base_price', '0.00') }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Sale Price (Optional)</label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest mb-3 text-slate-500 font-bold">Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}"
                                class="w-full px-4 py-3 bg-white border border-slate-200 rounded-lg focus:border-slate-900 focus:ring-4 focus:ring-slate-900/5 outline-none transition-all text-sm text-slate-900 font-medium">
                        </div>
                    </div>
                </div>

                <!-- Variable Product Setup -->
                <div id="variable-setup" class="hidden space-y-10">
                    <div class="bg-slate-50/50 p-8 rounded-xl border border-slate-200">
                        <h4 class="text-[10px] uppercase tracking-[0.2em] mb-8 font-bold text-slate-500 text-center">Step 1: Select Attributes</h4>
                        <div class="space-y-8">
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
                        </div>
                        <button type="button" onclick="generateVariants()" class="w-full mt-10 py-4 bg-slate-900 border border-slate-900 rounded-xl text-white text-[10px] uppercase tracking-[0.3em] font-bold hover:bg-slate-800 transition-all shadow-xl">
                            Generate All Combinations
                        </button>
                    </div>

                    <div id="variants-table-container" class="hidden">
                        <h4 class="text-[10px] uppercase tracking-[0.2em] mb-8 font-bold text-slate-500 text-center">Step 2: Configure Variants</h4>
                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full text-left">
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
                                <tbody id="variants-tbody" class="text-xs divide-y divide-slate-100">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bundle Product Setup -->
                <div id="bundle-setup" class="hidden space-y-10">
                   <div class="bg-slate-50/50 p-8 rounded-xl border border-slate-200">
                        <h4 class="text-[10px] uppercase tracking-[0.2em] mb-8 font-bold text-slate-500 text-center">Select Products for Bundle</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($simpleProducts as $sProduct)
                            <label class="flex items-center space-x-4 p-5 bg-white border border-slate-200 rounded-xl hover:border-slate-900 cursor-pointer transition-all shadow-sm group">
                                <input type="checkbox" name="bundle_items[]" value="{{ $sProduct->id }}" class="form-checkbox h-5 w-5 rounded border-slate-300 text-slate-900 focus:ring-slate-900/10">
                                <div>
                                    <span class="block text-sm font-bold text-slate-900 group-hover:text-slate-900 transition-colors">{{ $sProduct->name }}</span>
                                    <span class="block text-[10px] text-slate-400 font-bold tracking-widest mt-0.5 uppercase">{{ $sProduct->sku }} • ${{ number_format($sProduct->base_price, 2) }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                   </div>
                </div>
            </div>
        </div>

        <!-- Right: Gallery & Actions -->
        <div class="space-y-10">
            <div class="bg-white border border-slate-200 p-8 sticky top-24 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-8 border-b border-slate-100 pb-4">Publish</h3>
                <button type="submit" class="w-full py-4 bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold rounded-lg hover:bg-slate-800 transition-all shadow-xl">
                    Create Product
                </button>
            </div>

            <!-- Primary Image -->
            <div class="bg-white border border-slate-200 p-8 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg text-slate-900 mb-8 border-b border-slate-100 pb-4">Featured Image</h3>
                <div onclick="document.getElementById('primary_image').click()" 
                    class="border border-dashed border-slate-300 rounded-xl aspect-square flex flex-col items-center justify-center p-6 cursor-pointer hover:bg-slate-50 transition-all relative overflow-hidden group">
                    <div id="primary-preview" class="hidden absolute inset-0 bg-white group-hover:scale-105 transition-transform duration-500">
                        <img src="" class="w-full h-full object-cover">
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
                <div class="preview-container mb-10" id="gallery-preview"></div>
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
    // Initialize Quill
    var quill = new Quill('#description-editor', {
        theme: 'snow',
        placeholder: 'Enter full product story and details...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'clean']
            ]
        }
    });

    // On form submit, copy quill html to hidden input
    document.getElementById('product-form').onsubmit = function() {
        document.getElementById('description-input').value = quill.root.innerHTML;
    };

    function toggleVariantSection() {
        const type = document.getElementById('product_type').value;
        const simpleSection = document.getElementById('simple-pricing');
        const variableSection = document.getElementById('variable-setup');
        const bundleSection = document.getElementById('bundle-setup');
        
        // Reset all
        simpleSection.classList.add('hidden');
        variableSection.classList.add('hidden');
        bundleSection.classList.add('hidden');

        if (type === 'variable') {
            variableSection.classList.remove('hidden');
        } else if (type === 'bundle') {
            bundleSection.classList.remove('hidden');
            // Show simple pricing for bundle base price
            simpleSection.classList.remove('hidden');
        } else {
            simpleSection.classList.remove('hidden');
        }
    }

    // Image Previews
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

    function removePrimaryPreview(e) {
        e.stopPropagation();
        document.getElementById('primary-preview').classList.add('hidden');
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
        // Find which values are checked and group them by attribute
        const attributeGroups = {};
        document.querySelectorAll('.value-checkbox:checked').forEach(cb => {
            const attrId = cb.dataset.parent.replace('attr-', '');
            const attrContainer = document.querySelector(`.value-checkbox[data-parent="attr-${attrId}"]`).closest('.p-6');
            if (!attrContainer) return;
            const attrLabel = attrContainer.querySelector('span').innerText;
            if(!attributeGroups[attrLabel]) attributeGroups[attrLabel] = [];
            attributeGroups[attrLabel].push({ id: cb.value, text: cb.dataset.text });
        });

        const keys = Object.keys(attributeGroups);
        if(keys.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Attributes Selected',
                text: 'Please select at least one attribute value to generate variants.',
                confirmButtonColor: '#0f172a'
            });
            return;
        }

        // Cartesian product
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
        tbody.innerHTML = '';
        document.getElementById('variants-table-container').classList.remove('hidden');

        combinations.forEach((combo, index) => {
            const label = combo.map(c => c.text).join(' / ');
            const ids = combo.map(c => c.id);
            const baseSku = document.getElementsByName('name')[0].value.replace(/\s+/g, '-').toUpperCase().substring(0,5) || 'PROD';
            const variantSku = baseSku + '-' + label.replace(/ \/ /g, '-').toUpperCase().replace(/\s+/g, '-');

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
                    <button type="button" onclick="this.closest('tr').remove()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm"><i class="ri-close-line text-lg"></i></button>
                </td>
            `;
            tbody.appendChild(row);
        });
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
                label.classList.add('bg-slate-900', 'border-slate-900');
                label.querySelector('span').classList.remove('text-slate-500');
                label.querySelector('span').classList.add('text-white');
            } else {
                label.classList.remove('bg-slate-900', 'border-slate-900');
                label.querySelector('span').classList.add('text-slate-500');
                label.querySelector('span').classList.remove('text-white');
            }
        }
    });
</script>
@endsection
