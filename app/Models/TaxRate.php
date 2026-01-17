<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'state_code',
        'zip_code',
        'city',
        'priority',
        'is_compounded',
        'is_shipping_taxable',
        'is_active',
    ];

    protected $casts = [
        'is_compounded' => 'boolean',
        'is_shipping_taxable' => 'boolean',
        'is_active' => 'boolean',
        'rate' => 'decimal:4',
    ];
}
