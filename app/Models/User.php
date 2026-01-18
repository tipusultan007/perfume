<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'shipping_address',
        'billing_address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'shipping_address' => 'array',
            'billing_address' => 'array',
        ];
    }
    public function hasPurchased(Product $product)
    {
        return \App\Models\OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', $this->id)
                  ->where('status', 'completed');
        })->where('product_id', $product->id)->exists();
    }

    public function getPurchasedVariantName(Product $product)
    {
        $item = \App\Models\OrderItem::whereHas('order', function ($query) {
            $query->where('user_id', $this->id)
                  ->where('status', 'completed');
        })->where('product_id', $product->id)
          ->latest()
          ->first();

        return $item ? $item->variant_name : null;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
