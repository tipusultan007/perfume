<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        return view('shop.cart', compact('cartItems', 'subtotal'));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity', 1);
        $buyNow = $request->input('buy_now', false);

        if ($buyNow) {
            if (auth()->check()) {
                \App\Models\CartItem::where('user_id', '=', auth()->id())->delete();
            } else {
                Session::forget('cart');
            }
        }

        $product = Product::with('media')->findOrFail($productId);
        $variant = null;

        if ($variantId) {
            $variant = ProductVariant::with('attributeValues.attribute')->findOrFail($variantId);
        }

        if (auth()->check()) {
            $this->addToDbCart(auth()->id(), $product, $variant, $quantity);
        } else {
            $this->addToSessionCart($product, $variant, $quantity);
        }

        return response()->json([
            'success' => true,
            'cart_count' => $this->getCartCount(),
            'message' => 'Product added to cart'
        ]);
    }

    public function getCart()
    {
        $cartItems = $this->getCartItems();
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $html = view('shop.cart-drawer-items', ['cart' => $cartItems])->render();

        return response()->json([
            'html' => $html,
            'count' => count($cartItems),
            'subtotal' => number_format($total, 2)
        ]);
    }
    
    public function removeFromCart(Request $request) 
    {
        $key = $request->input('key');
        
        if (auth()->check()) {
            // Key is CartItem ID for DB
            \App\Models\CartItem::where('id', '=', $key)->where('user_id', '=', auth()->id())->delete();
        } else {
            // Key is session key
            $cart = Session::get('cart', []);
            if(isset($cart[$key])) {
                unset($cart[$key]);
                Session::put('cart', $cart);
            }
        }
        
        return $this->getCart();
    }
    
    public function updateQuantity(Request $request)
    {
        $key = $request->input('key');
        $quantity = $request->input('quantity');
        
        if (auth()->check()) {
            if($quantity > 0) {
                \App\Models\CartItem::where('id', '=', $key)
                    ->where('user_id', '=', auth()->id())
                    ->update(['quantity' => $quantity]);
            } else {
                \App\Models\CartItem::where('id', '=', $key)
                    ->where('user_id', '=', auth()->id())
                    ->delete();
            }
        } else {
            $cart = Session::get('cart', []);
            if(isset($cart[$key])) {
                if($quantity > 0) {
                     $cart[$key]['quantity'] = $quantity;
                } else {
                     unset($cart[$key]);
                }
                Session::put('cart', $cart);
            }
        }
        
        return $this->getCart();
    }

    // --- Private Helpers ---

    private function addToDbCart($userId, $product, $variant, $quantity)
    {
        $itemId = $variant ? $variant->id : null;
        
        $cartItem = \App\Models\CartItem::where('user_id', '=', $userId)
            ->where('product_id', '=', $product->id)
            ->where('variant_id', '=', $itemId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            \App\Models\CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'variant_id' => $itemId,
                'quantity' => $quantity
            ]);
        }
    }

    private function addToSessionCart($product, $variant, $quantity)
    {
        $cart = Session::get('cart', []);
        $cartKey = $product->id . ($variant ? '-' . $variant->id : '');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'quantity' => $quantity,
            ];
        }
        Session::put('cart', $cart);
    }

    private function getCartItems()
    {
        if (auth()->check()) {
            return $this->getDbCartItems();
        }
        return $this->getSessionCartItems();
    }

    private function getDbCartItems()
    {
        $items = \App\Models\CartItem::with(['product.media', 'variant.attributeValues.attribute'])
            ->where('user_id', auth()->id())
            ->get();
            
        return $items->map(function($item) {
             $product = $item->product;
             $variant = $item->variant;
             $price = $variant ? $variant->price : $product->base_price;
             
             // Construct options string from DB relationships
             $options = '';
             if ($variant) {
                 $options = $variant->attributeValues->map(function($av) {
                     return $av->attribute->name . ': ' . $av->value;
                 })->join(', ');
             }

             return [
                'key' => $item->id, // Use ID as key for delete/update
                'name' => $product->name,
                'options' => $options,
                'price' => $price,
                'quantity' => $item->quantity,
                'image' => $product->getFirstMediaUrl('featured') ?: 'https://via.placeholder.com/150',
                'url' => route('shop.product.show', $product->id) // Using ID route as placeholder
             ];
        })->toArray();
    }

    private function getSessionCartItems()
    {
        $cart = Session::get('cart', []);
        $results = [];

        foreach ($cart as $key => $item) {
            $product = Product::with('media')->find($item['product_id']);
            if(!$product) continue;
            
            $variant = null;
            $options = '';
            $price = $product->base_price;

            if ($item['variant_id']) {
                $variant = ProductVariant::with('attributeValues.attribute')->find($item['variant_id']);
                if($variant) {
                    $price = $variant->price;
                    $options = $variant->attributeValues->map(function($av) {
                        return $av->attribute->name . ': ' . $av->value;
                    })->join(', ');
                }
            }
            
            $results[$key] = [
                'key' => $key,
                'name' => $product->name,
                'options' => $options,
                'price' => $price,
                'quantity' => $item['quantity'],
                'image' => $product->getFirstMediaUrl('featured') ?: 'https://via.placeholder.com/150',
                'url' => route('shop.product.show', $product->id)
            ];
        }
        return $results;
    }

    private function getCartCount()
    {
        if(auth()->check()) {
            return \App\Models\CartItem::where('user_id', '=', auth()->id())->count(); // Count unique items or sum quantity? Usually unique items for badge
        }
        return count(Session::get('cart', []));
    }
}
