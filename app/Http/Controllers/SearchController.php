<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $products = \App\Models\Product::with('media')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->where('status', 'published')
            ->take(8)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => number_format($product->base_price, 2),
                    'sale_price' => $product->sale_price ? number_format($product->sale_price, 2) : null,
                    'image' => $product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400?text=' . urlencode($product->name),
                    'url' => route('shop.product.show', $product->slug)
                ];
            });

        return response()->json($products);
    }
}
