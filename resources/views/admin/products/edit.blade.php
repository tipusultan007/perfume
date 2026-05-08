@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 250px; font-size: 14px; background: white; }
    .preview-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; }
    .preview-item { position: relative; aspect-ratio: 1; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
    .preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .preview-item .remove-btn { position: absolute; top: 2px; right: 2px; background: rgba(255,255,255,0.9); border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #dc3545; border: none; transition: all 0.2s; }
    .preview-item .remove-btn:hover { background: #dc3545; color: white; }
    .attribute-badge { cursor: pointer; transition: all 0.2s; }
    .attribute-badge.active { background-color: #3e60d5 !important; color: white !important; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
                <h4 class="page-title">Update Product</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="ri-error-warning-fill me-2 fs-18"></i>
                    <span class="fw-bold text-uppercase tracking-wider fs-11">Please correct the following:</span>
                </div>
                <ul class="mb-0 fs-13">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <!-- Left: Basic Info -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">General Information</h5>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">
                            <i class="ri-arrow-left-line me-1"></i> Back
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-control form-control-lg fs-14">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Category</label>
                                <select name="category_id" required class="form-select fs-14">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Brand (Optional)</label>
                                <select name="brand_id" class="form-select fs-14">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Short Description</label>
                            <textarea name="short_description" rows="3" class="form-control fs-14">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Tags (Comma separated)</label>
                            <input type="text" name="tags" value="{{ old('tags', $product->tags->pluck('name')->implode(', ')) }}" placeholder="Perfume, Luxury, Summer, Oudh" class="form-control fs-14">
                        </div>

                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold mb-2 d-block border-bottom pb-2">Full Description</label>
                            <div id="description-editor" class="bg-white">{!! $product->description !!}</div>
                            <input type="hidden" name="description" id="description-input">
                        </div>
                    </div>
                </div>

                <!-- Scent Profile -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Scent Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Gender</label>
                                <select name="gender" class="form-select fs-13">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $product->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $product->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Concentration</label>
                                <select name="concentration" class="form-select fs-13">
                                    <option value="">Select Concentration</option>
                                    <option value="Parfum" {{ old('concentration', $product->concentration) == 'Parfum' ? 'selected' : '' }}>Parfum</option>
                                    <option value="EDP" {{ old('concentration', $product->concentration) == 'EDP' ? 'selected' : '' }}>Eau de Parfum (EDP)</option>
                                    <option value="EDT" {{ old('concentration', $product->concentration) == 'EDT' ? 'selected' : '' }}>Eau de Toilette (EDT)</option>
                                    <option value="EDC" {{ old('concentration', $product->concentration) == 'EDC' ? 'selected' : '' }}>Eau de Cologne (EDC)</option>
                                    <option value="Oil" {{ old('concentration', $product->concentration) == 'Oil' ? 'selected' : '' }}>Perfume Oil</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Size</label>
                                <select name="size" class="form-select fs-13">
                                    <option value="">Select Size</option>
                                    @foreach(['0.07FL.OZ/2ML', '0.17FL.OZ/5ML', '0.34FL.OZ/10ML', '1FL.OZ/30ML', '1.7FL.OZ/50ML', '2.5FL.OZ/75ML', '3.4FL.OZ/100ML', '4.2FL.OZ/125ML', '5FL.OZ/150ML', '6.8FL.OZ/200ML'] as $sizeOption)
                                        <option value="{{ $sizeOption }}" {{ old('size', $product->size) == $sizeOption ? 'selected' : '' }}>{{ $sizeOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Season</label>
                                <select name="season" class="form-select fs-13">
                                    <option value="">Select Season</option>
                                    <option value="Spring" {{ old('season', $product->season) == 'Spring' ? 'selected' : '' }}>Spring</option>
                                    <option value="Summer" {{ old('season', $product->season) == 'Summer' ? 'selected' : '' }}>Summer</option>
                                    <option value="Fall" {{ old('season', $product->season) == 'Fall' ? 'selected' : '' }}>Fall</option>
                                    <option value="Winter" {{ old('season', $product->season) == 'Winter' ? 'selected' : '' }}>Winter</option>
                                    <option value="All Season" {{ old('season', $product->season) == 'All Season' ? 'selected' : '' }}>All Season</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Top Notes</label>
                                <textarea name="top_notes" rows="2" placeholder="Citrus, Bergamot..." class="form-control fs-13">{{ old('top_notes', $product->top_notes) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Heart Notes</label>
                                <textarea name="heart_notes" rows="2" placeholder="Rose, Jasmine..." class="form-control fs-13">{{ old('heart_notes', $product->heart_notes) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Base Notes</label>
                                <textarea name="base_notes" rows="2" placeholder="Musk, Amber..." class="form-control fs-13">{{ old('base_notes', $product->base_notes) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Intensity/Sillage</label>
                            <input type="text" name="intensity" value="{{ old('intensity', $product->intensity) }}" placeholder="e.g. Moderate, Strong, Heavy" class="form-control fs-13">
                        </div>
                    </div>
                </div>

                <!-- Type & Pricing -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Type & Pricing</h5>
                        <span class="badge bg-dark text-uppercase tracking-widest fs-10 px-3 py-2 fw-bold shadow-sm">{{ ucfirst($product->product_type) }} Product</span>
                        <input type="hidden" name="product_type" value="{{ $product->product_type }}">
                    </div>
                    <div class="card-body">
                        @if($product->product_type == 'simple')
                        <div id="simple-pricing">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">SKU</label>
                                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="PRD-XXXX" class="form-control fs-13">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Regular Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" class="form-control fs-13">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Sale Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="form-control fs-13">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Stock</label>
                                    <input type="number" name="stock" value="{{ old('stock', $product->stock_quantity) }}" class="form-control fs-13">
                                </div>
                            </div>
                        </div>
                        @elseif($product->product_type == 'variable')
                        <div id="variable-pricing">
                            <div class="mb-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Display / Starting Price ($)</label>
                                <div class="input-group" style="max-width: 300px;">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" class="form-control fs-13">
                                </div>
                                <p class="text-muted fs-10 mt-1 mb-0 italic">Display price for listings.</p>
                            </div>

                            <div class="alert alert-info border-0 shadow-sm mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="alert-heading fs-12 text-uppercase tracking-wider mb-0">Variant Management</h6>
                                    <button type="button" onclick="document.getElementById('attribute-selector').classList.toggle('d-none')" class="btn btn-white btn-sm fs-10 text-uppercase tracking-widest fw-bold shadow-sm">
                                        Manage Attributes
                                    </button>
                                </div>
                                
                                <div id="attribute-selector" class="d-none mt-3 p-3 bg-white rounded border shadow-sm mb-3">
                                    @foreach($attributes as $attribute)
                                    <div class="mb-3 last-child-mb-0">
                                        <span class="d-block fs-11 fw-bold text-uppercase tracking-wider mb-2 text-primary border-bottom pb-1">{{ $attribute->name }}</span>
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($attribute->values as $val)
                                            <label class="btn btn-outline-light btn-sm attribute-badge border fs-10 text-uppercase tracking-widest fw-bold text-muted py-2 px-3">
                                                <input type="checkbox" class="value-checkbox d-none" value="{{ $val->id }}" data-text="{{ $val->value }}" data-parent="attr-{{ $attribute->id }}">
                                                {{ $val->value }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                    <button type="button" onclick="generateVariants()" class="btn btn-dark w-100 mt-2 text-uppercase tracking-widest fs-11 py-2 fw-bold">
                                        Generate From Selection
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive rounded border mt-4">
                                <table class="table table-sm align-middle mb-0" id="variants-table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3 py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Variant</th>
                                            <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">SKU</th>
                                            <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Price</th>
                                            <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Sale</th>
                                            <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Stock</th>
                                            <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0 text-center">Image</th>
                                            <th class="pe-3 py-2 fs-10 text-uppercase tracking-wider text-muted border-0 text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="variants-tbody" class="fs-12">
                                        @foreach($product->variants as $index => $variant)
                                        <tr class="variant-row">
                                            <td class="ps-3 py-3">
                                                <span class="fw-bold text-uppercase fs-10 text-dark">{{ $variant->attributeValues->pluck('value')->join(' / ') }}</span>
                                                @foreach($variant->attributeValues as $val)
                                                    <input type="hidden" name="variants[{{ $index }}][attributes][]" value="{{ $val->id }}">
                                                @endforeach
                                            </td>
                                            <td>
                                                <input type="text" name="variants[{{ $index }}][sku]" value="{{ $variant->sku }}" required class="form-control form-control-sm fs-11 font-monospace">
                                                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                            </td>
                                            <td><input type="number" step="0.01" name="variants[{{ $index }}][price]" value="{{ $variant->price }}" required class="form-control form-control-sm fs-11 font-monospace"></td>
                                            <td><input type="number" step="0.01" name="variants[{{ $index }}][sale_price]" value="{{ $variant->sale_price }}" class="form-control form-control-sm fs-11 font-monospace"></td>
                                            <td><input type="number" name="variants[{{ $index }}][stock]" value="{{ $variant->stock_quantity }}" required class="form-control form-control-sm fs-11 font-monospace"></td>
                                            <td class="text-center">
                                                <input type="file" name="variants[{{ $index }}][image]" class="d-none" id="var-img-{{ $index }}" onchange="previewVariantImage(this, {{ $index }})">
                                                <div onclick="document.getElementById('var-img-{{ $index }}').click()" 
                                                    class="border rounded d-inline-flex align-items-center justify-content-center cursor-pointer overflow-hidden bg-light shadow-sm" style="width: 32px; height: 32px;">
                                                    @if($variant->getFirstMediaUrl('variant_image'))
                                                        <img src="{{ $variant->getFirstMediaUrl('variant_image') }}" id="var-preview-{{ $index }}" class="w-100 h-100 object-fit-cover">
                                                        <i class="ri-image-add-line text-muted d-none" id="var-icon-{{ $index }}"></i>
                                                    @else
                                                        <i class="ri-image-add-line text-muted" id="var-icon-{{ $index }}"></i>
                                                        <img id="var-preview-{{ $index }}" class="d-none w-100 h-100 object-fit-cover">
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="pe-3 text-end">
                                                <button type="button" onclick="removeVariant(this)" class="btn btn-soft-danger btn-sm p-1"><i class="ri-delete-bin-line"></i></button>
                                                <input type="hidden" name="variants[{{ $index }}][delete]" value="0" class="delete-flag">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @elseif($product->product_type == 'bundle')
                        <div id="bundle-pricing">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                     <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Base Price ($)</label>
                                     <div class="input-group">
                                         <span class="input-group-text">$</span>
                                         <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $product->base_price) }}" class="form-control fs-14">
                                     </div>
                                </div>
                                <div class="col-md-6">
                                     <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Stock</label>
                                     <input type="number" name="stock" value="{{ old('stock', $product->stock_quantity) }}" class="form-control fs-14">
                                </div>
                            </div>

                            <div class="bg-light p-3 rounded border shadow-sm">
                                <h6 class="fs-12 text-uppercase tracking-wider mb-3 text-center text-muted">Bundle Content</h6>
                                <div class="row g-2 overflow-auto" style="max-height: 400px;">
                                    @foreach($simpleProducts as $sProduct)
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center gap-3 p-3 bg-white border rounded cursor-pointer hover-shadow transition-all w-100">
                                            <input type="checkbox" name="bundle_items[]" value="{{ $sProduct->id }}" 
                                                {{ $product->bundledProducts->contains($sProduct->id) ? 'checked' : '' }}
                                                class="form-check-input flex-shrink-0">
                                            <div class="min-width-0">
                                                <span class="d-block fs-13 fw-bold text-truncate">{{ $sProduct->name }}</span>
                                                <span class="d-block fs-10 text-muted text-uppercase tracking-wider">{{ $sProduct->sku }} • ${{ number_format($sProduct->base_price, 2) }}</span>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                           </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-12 text-uppercase tracking-widest fw-bold shadow-lg">
                            <i class="ri-save-line me-1"></i> Update Product
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Featured Image</h5>
                    </div>
                    <div class="card-body">
                        <div onclick="document.getElementById('primary_image').click()" 
                            class="border border-dashed rounded p-4 text-center cursor-pointer hover-bg-light transition-all position-relative overflow-hidden" style="min-height: 200px;">
                            <div id="primary-preview" class="{{ $product->getFirstMediaUrl('featured') ? '' : 'd-none' }} position-absolute top-0 start-0 w-100 h-100 bg-white z-2">
                                <img src="{{ $product->getFirstMediaUrl('featured') }}" class="w-100 h-100 object-fit-cover">
                                <button type="button" onclick="removePrimaryPreview(event)" class="btn btn-danger btn-sm rounded-circle position-absolute top-2 end-2 z-3 shadow">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 py-4">
                                <i class="ri-image-add-line fs-1 text-muted mb-2"></i>
                                <p class="fs-10 text-muted text-uppercase tracking-widest mb-0 fw-bold">Click to change</p>
                            </div>
                        </div>
                        <input type="file" name="primary_image" id="primary_image" class="d-none" onchange="previewPrimary(this)">
                    </div>
                </div>

                <!-- Gallery -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Gallery Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="preview-container mb-3" id="gallery-preview">
                            @foreach($product->getMedia('gallery') as $media)
                            <div class="preview-item rounded border shadow-sm position-relative">
                                <img src="{{ $media->getUrl() }}" class="w-100 h-100 object-fit-cover">
                                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">
                                    <input type="hidden" name="existing_media[]" value="{{ $media->id }}">
                                    <i class="ri-close-line fs-12"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <div onclick="document.getElementById('gallery_input').click()" 
                            class="border border-dashed rounded p-3 text-center cursor-pointer hover-bg-light transition-all">
                            <i class="ri-add-line fs-2 text-muted"></i>
                            <p class="fs-10 text-muted text-uppercase tracking-widest mb-0 fw-bold mt-1">Add Gallery Images</p>
                        </div>
                        <input type="file" name="gallery[]" id="gallery_input" class="d-none" multiple onchange="previewGallery(this)">
                    </div>
                </div>

                <!-- SEO Details -->
                <div class="card border-0 shadow-sm mb-4 bg-light-subtle">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fs-14 text-uppercase tracking-wider">SEO Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="form-control fs-13">
                        </div>
                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control fs-12">{{ old('meta_description', $product->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
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
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removePrimaryPreview(event) {
        event.stopPropagation();
        const preview = document.getElementById('primary-preview');
        preview.classList.add('d-none');
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

    function generateVariants() {
        const attributeGroups = {};
        document.querySelectorAll('.value-checkbox:checked').forEach(cb => {
            const attrId = cb.dataset.parent.replace('attr-', '');
            const attrContainer = cb.closest('.mb-3');
            if (!attrContainer) return;
            const attrLabel = attrContainer.querySelector('span').innerText;
            if(!attributeGroups[attrLabel]) attributeGroups[attrLabel] = [];
            attributeGroups[attrLabel].push({ id: cb.value, text: cb.dataset.text });
        });

        const keys = Object.keys(attributeGroups);
        if(keys.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Selection Empty', text: 'Select at least one option.' });
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
        
        let existingCount = document.querySelectorAll('.variant-row').length;

        combinations.forEach((combo) => {
            const index = existingCount++;
            const label = combo.map(c => c.text).join(' / ');
            const ids = combo.map(c => c.id);
            const baseSku = document.getElementsByName('name')[0].value.replace(/\s+/g, '-').toUpperCase().substring(0,5);
            const variantSku = baseSku + '-' + label.replace(/ \/ /g, '-').toUpperCase().replace(/\s+/g, '-');

            let exists = false;
            document.querySelectorAll('.variant-row td span.fw-bold').forEach(span => {
                if(span.innerText.trim() === label) exists = true;
            });

            if(exists) return; 

            const row = document.createElement('tr');
            row.className = 'variant-row';
            row.innerHTML = `
                <td class="ps-3 py-3">
                    <span class="fw-bold text-uppercase fs-10 text-dark">${label}</span>
                    ${ids.map(id => `<input type="hidden" name="variants[${index}][attributes][]" value="${id}">`).join('')}
                    <input type="hidden" name="variants[${index}][new]" value="1">
                </td>
                <td><input type="text" name="variants[${index}][sku]" value="${variantSku}" required class="form-control form-control-sm fs-11 font-monospace"></td>
                <td><input type="number" step="0.01" name="variants[${index}][price]" value="0.00" required class="form-control form-control-sm fs-11 font-monospace"></td>
                <td><input type="number" step="0.01" name="variants[${index}][sale_price]" placeholder="Opt" class="form-control form-control-sm fs-11 font-monospace"></td>
                <td><input type="number" name="variants[${index}][stock]" value="0" required class="form-control form-control-sm fs-11 font-monospace"></td>
                <td class="text-center">
                    <input type="file" name="variants[${index}][image]" class="d-none" id="var-img-${index}" onchange="previewVariantImage(this, ${index})">
                    <div onclick="document.getElementById('var-img-${index}').click()" 
                        class="border rounded d-inline-flex align-items-center justify-content-center cursor-pointer overflow-hidden bg-light shadow-sm" style="width: 32px; height: 32px;">
                        <i class="ri-image-add-line text-muted" id="var-icon-${index}"></i>
                        <img id="var-preview-${index}" class="d-none w-100 h-100 object-fit-cover">
                    </div>
                </td>
                <td class="pe-3 text-end">
                    <button type="button" onclick="removeVariant(this)" class="btn btn-soft-danger btn-sm p-1"><i class="ri-close-line"></i></button>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.getElementById('attribute-selector').classList.add('d-none');
    }

    function removeVariant(btn) {
        const row = btn.closest('tr');
        const deleteFlag = row.querySelector('.delete-flag');
        if(deleteFlag) {
            deleteFlag.value = "1";
            row.style.display = 'none';
        } else {
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
                preview.classList.remove('d-none');
                if(icon) icon.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('change', function(e) {
        if(e.target.classList.contains('value-checkbox')) {
            const label = e.target.parentElement;
            if(e.target.checked) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        }
    });
</script>
@endsection
