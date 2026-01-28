<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'grand_total', 'tax_amount', 'shipping_cost',
        'payment_method', 'payment_status', 'shipping_address', 'billing_address', 'notes'
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderNotes()
    {
        return $this->hasMany(OrderNote::class, 'order_id')->latest();
    }
}
