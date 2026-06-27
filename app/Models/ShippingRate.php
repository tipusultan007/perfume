<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'name',
        'cost',
        'state_code',
        'zip_code',
        'is_active',
    ];
}
