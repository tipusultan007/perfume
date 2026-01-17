<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        if (!auth()->check()) {
            return back()->with('error', 'Please login to leave a review.');
        }

        $user = auth()->user();

        if (!$user->hasPurchased($product)) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        $review = new ProductReview($validated);
        $review->product_id = $product->id;
        $review->user_id = $user->id;
        $review->user_name = $user->name;
        $review->user_email = $user->email;
        $review->variant_name = $user->getPurchasedVariantName($product);
        $review->save();

        return back()->with('success', 'Thank you for your review!');
    }
}
