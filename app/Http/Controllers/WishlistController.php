<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with('product') // Eager load product
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Store or remove a product from the wishlist (toggle).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete(); // Remove if exists
            return response()->json([
                'status' => 'removed',
                'message' => 'Product removed from wishlist.',
                'count' => Wishlist::where('user_id', $userId)->count()
            ]);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId, // Create if not exists
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Product added to wishlist.',
                'count' => Wishlist::where('user_id', $userId)->count()
            ]);
        }
    }
}
