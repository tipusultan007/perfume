<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem;

class MergeCartOnLogin
{
    public function handle(Login $event)
    {
        if (!Session::has('cart')) {
            return;
        }

        $sessionCart = Session::get('cart');
        $userId = $event->user->id;

        foreach ($sessionCart as $item) {
            $existingItem = CartItem::where('user_id', $userId)
                ->where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'])
                ->first();

            if ($existingItem) {
                // Determine logic: add session qty to db qty, or replace? Usually add.
                $existingItem->increment('quantity', $item['quantity']);
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        Session::forget('cart');
    }
}
