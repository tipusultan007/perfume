<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['media', 'variants', 'category', 'brand']);
        
        // --- filter: Search ---
        $searchQuery = $request->input('search');
        if ($searchQuery) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('name', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%')
                  ->orWhere('top_notes', 'like', '%' . $searchQuery . '%')
                  ->orWhere('heart_notes', 'like', '%' . $searchQuery . '%')
                  ->orWhere('base_notes', 'like', '%' . $searchQuery . '%');
            });
        }

        // --- Filter: Category ---
        $activeCategory = null;
        if ($request->has('category')) {
            $activeCategory = \App\Models\Category::where('slug', $request->category)->first();
            if ($activeCategory) {
                $query->where('category_id', $activeCategory->id);
            }
        }

        // --- Filter: Brands ---
        $activeBrands = $request->input('brands', []);
        if (!empty($activeBrands)) {
            $query->whereIn('brand_id', function($q) use ($activeBrands) {
                $q->select('id')->from('brands')->whereIn('slug', $activeBrands);
            });
        }

        // --- Filter: Gender ---
        $activeGenders = $request->input('genders', []);
        if (!empty($activeGenders)) {
            $query->whereIn('gender', $activeGenders);
        }

        // --- Filter: Concentration ---
        $activeConcentrations = $request->input('concentrations', []);
        if (!empty($activeConcentrations)) {
            $query->whereIn('concentration', $activeConcentrations);
        }

        // --- Filter: Season ---
        $activeSeasons = $request->input('seasons', []);
        if (!empty($activeSeasons)) {
            $query->whereIn('season', $activeSeasons);
        }

        // --- Filter: Notes (Simple LIKE search for now) ---
        foreach (['top_notes', 'heart_notes', 'base_notes'] as $noteField) {
            if ($request->filled($noteField)) {
                $term = $request->input($noteField);
                $query->where($noteField, 'like', '%' . $term . '%');
            }
        }

        // --- Filter: Size (Attribute via Variants) ---
        $activeSizes = $request->input('sizes', []);
        if (!empty($activeSizes)) {
            $query->whereHas('variants', function($q) use ($activeSizes) {
                $q->whereHas('attributeValues', function($qv) use ($activeSizes) {
                    $qv->whereIn('value', $activeSizes)
                       ->whereHas('attribute', function($qa) {
                           $qa->where('name', 'Size');
                       });
                });
            });
        }

        // --- Filter: Price Range ---
        if ($request->filled('min_price')) {
            $query->where('base_price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('base_price', '<=', $request->input('max_price'));
        }

        // --- Execute Query ---
        $products = $query->latest()->paginate(20)->withQueryString();

        // --- Fetch Filter Options for View ---
        $categories = \App\Models\Category::withCount('products')->get();
        $brands = \App\Models\Brand::orderBy('name')->get();
        
        $genders = Product::select('gender')->whereNotNull('gender')->distinct()->pluck('gender');
        $concentrations = Product::select('concentration')->whereNotNull('concentration')->distinct()->pluck('concentration');
        $seasons = Product::select('season')->whereNotNull('season')->distinct()->pluck('season');
        
        $sizeAttribute = \App\Models\Attribute::where('name', 'Size')->first();
        $sizes = $sizeAttribute ? $sizeAttribute->values : collect();

        return view('shop.index', compact(
            'products', 'categories', 'brands', 'activeCategory', 
            'activeBrands', 'searchQuery', 'genders', 'concentrations', 
            'seasons', 'sizes', 'activeGenders', 'activeConcentrations', 
            'activeSeasons', 'activeSizes'
        ));
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
