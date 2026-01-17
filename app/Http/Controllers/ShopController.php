<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['media', 'variants', 'category', 'brand']);
        $activeCategory = null;
        $activeBrands = $request->input('brands', []);
        $searchQuery = $request->input('search');

        if ($request->has('category')) {
            $activeCategory = \App\Models\Category::where('slug', $request->category)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        if (!empty($activeBrands)) {
            $query->whereIn('brand_id', function($q) use ($activeBrands) {
                $q->select('id')->from('brands')->whereIn('slug', $activeBrands);
            });
        }

        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();

        return view('shop.index', compact('products', 'categories', 'brands', 'activeCategory', 'activeBrands', 'searchQuery'));
    }

    public function quickView(Product $product)
    {
        $product->load(['media', 'category', 'variants.media', 'variants.attributeValues.attribute']);
        return view('shop.quickview', compact('product'));
    }

    public function show(Product $product)
    {
        $product->load(['media', 'category', 'variants.media', 'variants.attributeValues.attribute', 'brand', 'reviews.user']);
        
        $relatedProducts = Product::with(['media', 'variants'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();

        $canReview = auth()->check() && auth()->user()->hasPurchased($product);

        return view('shop.product-show', compact('product', 'relatedProducts', 'canReview'));
    }
}
