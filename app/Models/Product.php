<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasTags;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'base_price',
        'sale_price',
        'stock_quantity',
        'description',
        'short_description',
        'status',
        'product_type',
        'gender',
        'concentration',
        'season',
        'meta_title',
        'meta_description',
        'top_notes',
        'heart_notes',
        'base_notes',
        'intensity',
        'is_featured',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getDetail($key, $default = null)
    {
        if ($key == 'intensity_percent') {
            return ($this->intensity ?? 50) . '%';
        }
        
        return $this->{$key} ?? $default;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
    }

    public function bundledItems()
    {
        return $this->hasMany(BundleItem::class, 'parent_product_id');
    }

    public function bundledProducts()
    {
        return $this->belongsToMany(Product::class, 'bundle_items', 'parent_product_id', 'child_product_id')
                    ->withPivot('quantity', 'id');
    }
}
