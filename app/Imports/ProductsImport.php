<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $name = $row['name'] ?? null;
        if (!$name) {
            return null;
        }

        $brandName = $row['brand'] ?? null;
        $brandId = null;
        if ($brandName) {
            $brand = Brand::firstOrCreate(
                ['name' => $brandName],
                ['slug' => Str::slug($brandName)]
            );
            $brandId = $brand->id;
        }

        $category = Category::firstOrCreate(
            ['name' => 'Perfumes'],
            ['slug' => 'perfumes']
        );

        return new Product([
            'brand_id' => $brandId,
            'category_id' => $category->id,
            'name' => $name,
            'slug' => Str::slug($name . '-' . Str::random(4)),
            'sku' => 'PRF-' . strtoupper(Str::random(8)),
            'base_price' => 0.00,
            'size' => $row['size'] ?? null,
            'gender' => $row['gender'] ?? null,
            'short_description' => $row['notes'] ?? null,
            'description' => $row['description'] ?? null,
            'concentration' => $row['concentration'] ?? null,
            'season' => $row['season'] ?? null,
            'top_notes' => $row['top_notes'] ?? null,
            'heart_notes' => $row['heart_notes'] ?? null,
            'base_notes' => $row['base_notes'] ?? null,
            'intensity' => $row['intensity'] ?? null,
            'status' => 'published',
            'product_type' => 'simple',
        ]);
    }
}
