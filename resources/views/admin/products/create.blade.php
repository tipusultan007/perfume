@extends('admin.layouts.app')

@section('title', 'Add Product')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 250px; font-size: 14px; background: white; }
    .preview-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 16px; }
    .preview-item { position: relative; aspect-ratio: 1; border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
    .preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .preview-item .remove-btn { position: absolute; top: 4px; right: 4px; background: rgba(255,255,255,0.9); border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #dc3545; border: 1px solid #f8d7da; transition: all 0.2s; }
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
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Product</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf
        
        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="ri-error-warning-fill me-2 fs-18"></i>
                    <span class="fw-bold text-uppercase tracking-wider fs-11">Submission Errors</span>
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
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-control form-control-lg fs-14">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Category</label>
                                <select name="category_id" required class="form-select fs-14">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Brand (Optional)</label>
                                <select name="brand_id" class="form-select fs-14">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Short Description</label>
                            <textarea name="short_description" rows="3" class="form-control fs-14">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Tags (Comma separated)</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="Perfume, Luxury, Summer, Oudh" class="form-control fs-14">
                        </div>

                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold mb-2 d-block border-bottom pb-2">Full Description</label>
                            <div id="description-editor" class="bg-white"></div>
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
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Concentration</label>
                                <select name="concentration" class="form-select fs-13">
                                    <option value="">Select Concentration</option>
                                    <option value="Parfum" {{ old('concentration') == 'Parfum' ? 'selected' : '' }}>Parfum</option>
                                    <option value="EDP" {{ old('concentration') == 'EDP' ? 'selected' : '' }}>Eau de Parfum (EDP)</option>
                                    <option value="EDT" {{ old('concentration') == 'EDT' ? 'selected' : '' }}>Eau de Toilette (EDT)</option>
                                    <option value="EDC" {{ old('concentration') == 'EDC' ? 'selected' : '' }}>Eau de Cologne (EDC)</option>
                                    <option value="Oil" {{ old('concentration') == 'Oil' ? 'selected' : '' }}>Perfume Oil</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Size</label>
                                <select name="size" class="form-select fs-13">
                                    <option value="">Select Size</option>
                                    @foreach(['0.07FL.OZ/2ML', '0.17FL.OZ/5ML', '0.34FL.OZ/10ML', '1FL.OZ/30ML', '1.7FL.OZ/50ML', '2.5FL.OZ/75ML', '3.4FL.OZ/100ML', '4.2FL.OZ/125ML', '5FL.OZ/150ML', '6.8FL.OZ/200ML'] as $sizeOption)
                                        <option value="{{ $sizeOption }}" {{ old('size') == $sizeOption ? 'selected' : '' }}>{{ $sizeOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Season</label>
                                <select name="season" class="form-select fs-13">
                                    <option value="">Select Season</option>
                                    <option value="Spring" {{ old('season') == 'Spring' ? 'selected' : '' }}>Spring</option>
                                    <option value="Summer" {{ old('season') == 'Summer' ? 'selected' : '' }}>Summer</option>
                                    <option value="Fall" {{ old('season') == 'Fall' ? 'selected' : '' }}>Fall</option>
                                    <option value="Winter" {{ old('season') == 'Winter' ? 'selected' : '' }}>Winter</option>
                                    <option value="All Season" {{ old('season') == 'All Season' ? 'selected' : '' }}>All Season</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Top Notes</label>
                                <textarea name="top_notes" rows="2" placeholder="Citrus, Bergamot..." class="form-control fs-13">{{ old('top_notes') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Heart Notes</label>
                                <textarea name="heart_notes" rows="2" placeholder="Rose, Jasmine..." class="form-control fs-13">{{ old('heart_notes') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Base Notes</label>
                                <textarea name="base_notes" rows="2" placeholder="Musk, Amber..." class="form-control fs-13">{{ old('base_notes') }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Intensity/Sillage</label>
                            <input type="text" name="intensity" value="{{ old('intensity') }}" placeholder="e.g. Moderate, Strong, Heavy" class="form-control fs-13">
                        </div>
                    </div>
                </div>

                <!-- Product Type & Pricing -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0 fs-15 text-uppercase tracking-wider">Type & Pricing</h5>
                        <div style="width: 200px;">
                            <select name="product_type" id="product_type" onchange="toggleVariantSection()" class="form-select form-select-sm fs-11 text-uppercase tracking-wider fw-bold">
                                <option value="simple">Simple Product</option>
                                <option value="variable">Variable Product</option>
                                <option value="bundle">Group Product (Bundle)</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Simple Product Pricing -->
                        <div id="simple-pricing">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">SKU</label>
                                    <input type="text" name="sku" value="{{ old('sku') }}" placeholder="PRD-XXXX" class="form-control fs-13">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Regular Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="base_price" value="{{ old('base_price', '0.00') }}" class="form-control fs-13">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Sale Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" class="form-control fs-13">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Stock</label>
                                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="form-control fs-13">
                                </div>
                            </div>
                        </div>

                        <!-- Variable Product Setup -->
                        <div id="variable-setup" class="d-none mt-3">
                            <div class="alert alert-info border-0 shadow-sm mb-4">
                                <h6 class="alert-heading fs-12 text-uppercase tracking-wider mb-2">Step 1: Select Attributes</h6>
                                <div class="row g-3">
                                    @foreach($attributes as $attribute)
                                    <div class="col-12">
                                        <div class="p-3 bg-white rounded border shadow-sm">
                                            <span class="d-block fs-11 fw-bold text-uppercase tracking-wider mb-2 text-primary border-bottom pb-1">{{ $attribute->name }}</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                <input type="checkbox" class="attribute-checkbox d-none" value="{{ $attribute->id }}" data-name="{{ $attribute->name }}" id="attr-{{ $attribute->id }}">
                                                @foreach($attribute->values as $val)
                                                <label class="btn btn-outline-light btn-sm attribute-badge border fs-10 text-uppercase tracking-widest fw-bold text-muted py-2 px-3">
                                                    <input type="checkbox" class="value-checkbox d-none" value="{{ $val->id }}" data-text="{{ $val->value }}" data-parent="attr-{{ $attribute->id }}">
                                                    {{ $val->value }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" onclick="generateVariants()" class="btn btn-dark w-100 mt-3 text-uppercase tracking-widest fs-11 py-2 fw-bold shadow-lg">
                                    Generate All Combinations
                                </button>
                            </div>

                            <div id="variants-table-container" class="d-none">
                                <h6 class="fs-12 text-uppercase tracking-wider mb-3 text-center text-muted">Step 2: Configure Variants</h6>
                                <div class="table-responsive rounded border">
                                    <table class="table table-sm align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="ps-3 py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Variant</th>
                                                <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">SKU</th>
                                                <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Price</th>
                                                <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Sale</th>
                                                <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Stock</th>
                                                <th class="py-2 fs-10 text-uppercase tracking-wider text-muted border-0">Image</th>
                                                <th class="pe-3 py-2 fs-10 text-uppercase tracking-wider text-muted border-0 text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variants-tbody" class="fs-12">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Bundle Product Setup -->
                        <div id="bundle-setup" class="d-none mt-3">
                            <div class="bg-light p-3 rounded border shadow-sm">
                                <h6 class="fs-12 text-uppercase tracking-wider mb-3 text-center text-muted">Select Products for Bundle</h6>
                                <div class="row g-2 overflow-auto" style="max-height: 400px;">
                                    @foreach($simpleProducts as $sProduct)
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center gap-3 p-3 bg-white border rounded cursor-pointer hover-shadow transition-all w-100">
                                            <input type="checkbox" name="bundle_items[]" value="{{ $sProduct->id }}" class="form-check-input flex-shrink-0">
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
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-12 text-uppercase tracking-widest fw-bold shadow-lg">
                            <i class="ri-save-line me-1"></i> Create Product
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
                            <div id="primary-preview" class="d-none position-absolute top-0 start-0 w-100 h-100 bg-white z-2">
                                <img src="" class="w-100 h-100 object-fit-cover">
                                <button type="button" onclick="removePrimaryPreview(event)" class="btn btn-danger btn-sm rounded-circle position-absolute top-2 end-2 z-3 shadow">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 py-4">
                                <i class="ri-image-add-line fs-1 text-muted mb-2"></i>
                                <p class="fs-10 text-muted text-uppercase tracking-widest mb-0 fw-bold">Click to upload</p>
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
                        <div class="preview-container mb-3" id="gallery-preview"></div>
                        <div onclick="document.getElementById('gallery_input').click()" 
                            class="border border-dashed rounded p-3 text-center cursor-pointer hover-bg-light transition-all">
                            <i class="ri-add-line fs-2 text-muted"></i>
                            <p class="fs-10 text-muted text-uppercase tracking-widest mb-0 fw-bold mt-1">Add Gallery Images</p>
                        </div>
                        <input type="file" name="gallery[]" id="gallery_input" class="d-none" multiple onchange="previewGallery(this)">
                    </div>
                </div>

                <!-- SEO Section -->
                <div class="card border-0 shadow-sm mb-4 bg-light-subtle">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h5 class="card-title mb-0 fs-14 text-uppercase tracking-wider">SEO Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" class="form-control fs-13">
                        </div>
                        <div>
                            <label class="form-label text-muted fs-11 text-uppercase tracking-widest fw-bold">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control fs-12">{{ old('meta_description') }}</textarea>
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
        simpleSection.classList.add('d-none');
        variableSection.classList.add('d-none');
        bundleSection.classList.add('d-none');

        if (type === 'variable') {
            variableSection.classList.remove('d-none');
        } else if (type === 'bundle') {
            bundleSection.classList.remove('d-none');
            simpleSection.classList.remove('d-none');
        } else {
            simpleSection.classList.remove('d-none');
        }
    }

    // Image Previews
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

    function removePrimaryPreview(e) {
        e.stopPropagation();
        document.getElementById('primary-preview').classList.add('d-none');
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
            const attrContainer = cb.closest('.p-3');
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
                confirmButtonColor: '#3e60d5'
            });
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
        tbody.innerHTML = '';
        document.getElementById('variants-table-container').classList.remove('d-none');

        combinations.forEach((combo, index) => {
            const label = combo.map(c => c.text).join(' / ');
            const ids = combo.map(c => c.id);
            const baseSku = document.getElementsByName('name')[0].value.replace(/\s+/g, '-').toUpperCase().substring(0,5) || 'PROD';
            const variantSku = baseSku + '-' + label.replace(/ \/ /g, '-').toUpperCase().replace(/\s+/g, '-');

            const row = document.createElement('tr');
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
                <td>
                    <input type="file" name="variants[${index}][image]" class="d-none" id="var-img-${index}" onchange="previewVariantImage(this, ${index})">
                    <div onclick="document.getElementById('var-img-${index}').click()" 
                        class="border rounded d-flex align-items-center justify-content-center cursor-pointer overflow-hidden bg-light" style="width: 32px; height: 32px;">
                        <i class="ri-image-add-line text-muted" id="var-icon-${index}"></i>
                        <img id="var-preview-${index}" class="d-none w-100 h-100 object-fit-cover">
                    </div>
                </td>
                <td class="pe-3 text-end">
                    <button type="button" onclick="this.closest('tr').remove()" class="btn btn-soft-danger btn-sm p-1"><i class="ri-close-line"></i></button>
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
                preview.classList.remove('d-none');
                if(icon) icon.classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Badge toggle styling
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
