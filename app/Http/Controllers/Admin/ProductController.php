<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'brand', 'variants']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('brand_id') && $request->brand_id != '') {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('product_type') && $request->product_type != '') {
            $query->where('product_type', $request->product_type);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $attributes = Attribute::with('values')->get();
        $simpleProducts = Product::where('product_type', 'simple')->where('status', 'published')->get(['id', 'name', 'sku', 'base_price']);
        return view('admin.products.create', compact('categories', 'brands', 'attributes', 'simpleProducts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'base_price' => 'required|numeric',
            'sale_price' => 'nullable|numeric|lt:base_price',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'product_type' => 'required|in:simple,variable,bundle',
            'primary_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'sku' => 'nullable|string|unique:products,sku',
            'stock' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Unisex',
            'concentration' => 'nullable|string',
            'size' => 'nullable|string|max:50',
            'season' => 'nullable|string',
            'top_notes' => 'nullable|string',
            'heart_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'variants' => 'required_if:product_type,variable|array',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.price' => 'required|numeric',
            'variants.*.sale_price' => 'nullable|numeric',
            'variants.*.stock' => 'required|integer',
            'variants.*.image' => 'nullable|image|max:1024',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'base_price' => $request->base_price,
                'sale_price' => $request->sale_price,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'product_type' => $request->product_type,
                'sku' => $request->sku,
                'stock_quantity' => $request->stock ?? 0,
                'gender' => $request->gender,
                'concentration' => $request->concentration,
                'size' => $request->size,
                'season' => $request->season,
                'top_notes' => $request->top_notes,
                'heart_notes' => $request->heart_notes,
                'base_notes' => $request->base_notes,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'status' => 'published',
            ]);

            // SEO Tags
            if ($request->tags) {
                $tags = array_map('trim', explode(',', $request->tags));
                $product->attachTags($tags);
            }

            // MediaLibrary Primary Image
            if ($request->hasFile('primary_image')) {
                $product->addMediaFromRequest('primary_image')->toMediaCollection('featured');
            }

            // MediaLibrary Gallery
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $product->addMedia($image)->toMediaCollection('gallery');
                }
            }

            if ($request->product_type == 'variable') {
                foreach ($request->variants as $index => $variantData) {
                    $variant = $product->variants()->create([
                        'sku' => $variantData['sku'],
                        'price' => $variantData['price'],
                        'sale_price' => $variantData['sale_price'],
                        'stock_quantity' => $variantData['stock'],
                    ]);

                    if (isset($variantData['attributes'])) {
                        $variant->attributeValues()->attach($variantData['attributes']);
                    }

                    // Variant Specific Image
                    if ($request->hasFile("variants.{$index}.image")) {
                        $variant->addMediaFromRequest("variants.{$index}.image")->toMediaCollection('variant_image');
                    }
                }
            }

            if ($request->product_type == 'bundle' && $request->has('bundle_items')) {
                foreach ($request->bundle_items as $childId) {
                    $product->bundledItems()->create([
                        'child_product_id' => $childId,
                        'quantity' => 1
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Product $product)
    {
        $product->load(['variants.attributeValues', 'category', 'brand', 'media', 'tags']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load(['variants.attributeValues', 'category', 'brand', 'media']);
        $categories = Category::all();
        $brands = Brand::all();
        $attributes = Attribute::with('values')->get();
        $simpleProducts = Product::where('product_type', 'simple')->where('status', 'published')->where('id', '!=', $product->id)->get(['id', 'name', 'sku', 'base_price']);
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'attributes', 'simpleProducts'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'base_price' => 'required|numeric',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'primary_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'stock' => 'nullable|integer',
            'gender' => 'nullable|in:Male,Female,Unisex',
            'concentration' => 'nullable|string',
            'size' => 'nullable|string|max:50',
            'season' => 'nullable|string',
            'top_notes' => 'nullable|string',
            'heart_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'variants.*.sku' => 'required|string',
            'variants.*.price' => 'required|numeric',
            'variants.*.sale_price' => 'nullable|numeric',
            'variants.*.stock' => 'required|integer',
            'variants.*.image' => 'nullable|image|max:1024',
            'bundle_items' => 'required_if:product_type,bundle|array',
            'bundle_items.*' => 'exists:products,id',
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'base_price' => $request->base_price,
                'sale_price' => $request->sale_price,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'gender' => $request->gender,
                'concentration' => $request->concentration,
                'size' => $request->size,
                'season' => $request->season,
                'top_notes' => $request->top_notes,
                'heart_notes' => $request->heart_notes,
                'base_notes' => $request->base_notes,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            if ($product->product_type == 'simple') {
                $updateData['sku'] = $request->sku;
                $updateData['stock_quantity'] = $request->stock ?? 0;
            }

            $product->update($updateData);

            // Sync Tags
            if ($request->tags) {
                $tags = array_map('trim', explode(',', $request->tags));
                $product->syncTags($tags);
            }

            // Handle Gallery Update
            if ($request->has('existing_media')) {
                $product->getMedia('gallery')->whereNotIn('id', $request->existing_media)->each->delete();
            } else {
                $product->clearMediaCollection('gallery');
            }

            // Sync Primary Image
            if ($request->hasFile('primary_image')) {
                $product->clearMediaCollection('featured');
                $product->addMediaFromRequest('primary_image')->toMediaCollection('featured');
            }

            // Add to Gallery
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $product->addMedia($image)->toMediaCollection('gallery');
                }
            }

            // Update Variants
            if ($request->has('variants')) {
                foreach ($request->variants as $index => $variantData) {
                    
                    // Handle Deletion
                    if (isset($variantData['delete']) && $variantData['delete'] == '1') {
                        if (isset($variantData['id'])) {
                            ProductVariant::find($variantData['id'])->delete();
                        }
                        continue;
                    }

                    if (isset($variantData['id'])) {
                        // Update Existing
                        $variant = ProductVariant::find($variantData['id']);
                        $variant->update([
                            'sku' => $variantData['sku'],
                            'price' => $variantData['price'],
                            'sale_price' => $variantData['sale_price'],
                            'stock_quantity' => $variantData['stock'],
                        ]);
                    } elseif (isset($variantData['new']) && $variantData['new'] == '1') {
                        // Create New
                        $variant = $product->variants()->create([
                            'sku' => $variantData['sku'],
                            'price' => $variantData['price'],
                            'sale_price' => $variantData['sale_price'],
                            'stock_quantity' => $variantData['stock'],
                        ]);

                        if (isset($variantData['attributes'])) {
                            $variant->attributeValues()->attach($variantData['attributes']);
                        }
                    }

                    // Handle Image
                    if (isset($variant) && $request->hasFile("variants.{$index}.image")) {
                        $variant->clearMediaCollection('variant_image');
                        $variant->addMediaFromRequest("variants.{$index}.image")->toMediaCollection('variant_image');
                    }
                }
            }

            if ($request->product_type == 'bundle') {
                // Sync bundle items
                $product->bundledProducts()->detach();
                if ($request->has('bundle_items')) {
                    foreach ($request->bundle_items as $childId) {
                        $product->bundledItems()->create([
                            'child_product_id' => $childId,
                            'quantity' => 1
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleFeatured(Product $product)
    {
        try {
            $product->is_featured = !$product->is_featured;
            $product->save();

            return response()->json([
                'success' => true,
                'is_featured' => $product->is_featured,
                'message' => 'Product featured status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status.'
            ], 500);
        }
    }

    public function import()
    {
        return view('admin.products.import');
    }

    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return redirect()->route('admin.products.index')->with('success', 'Products imported successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Import failed: ' . $e->getMessage()]);
        }
    }
}
