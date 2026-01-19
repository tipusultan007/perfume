<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
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
        // Headers: Brand, Title, Description, Main Image, Gallery Images
        
        $brandName = $row['brand'] ?? null;
        $title = $row['title'] ?? null;
        $description = $row['description'] ?? null;
        $mainImageUrl = $row['main_image'] ?? null;
        $galleryImages = $row['gallery_images'] ?? null;

        if (!$title) {
            return null;
        }

        // Handle Brand
        $brandId = null;
        if ($brandName) {
            $brand = Brand::firstOrCreate(
                ['name' => $brandName],
                ['slug' => Str::slug($brandName)]
            );
            $brandId = $brand->id;
        }

        // Create Product
        $product = Product::create([
            'brand_id' => $brandId,
            'category_id' => 1, // Default: Perfumes
            'name' => $title,
            'slug' => Str::slug($title . '-' . Str::random(4)),
            'sku' => 'PRF-' . strtoupper(Str::random(8)),
            'base_price' => 0.00, // Default price
            'description' => $description,
            'status' => 'published',
            'product_type' => 'simple',
        ]);

        // Handle Main Image (Spatie Media Library)
        if ($mainImageUrl) {
            try {
                $product->addMediaFromUrl($mainImageUrl)
                    ->toMediaCollection('featured');
            } catch (\Exception $e) {
                Log::error("Failed to import main image for product {$title}: " . $e->getMessage());
            }
        }

        // Handle Gallery Images
        if ($galleryImages) {
            $urls = explode('|', $galleryImages);
            foreach ($urls as $url) {
                $url = trim($url);
                if ($url) {
                    try {
                        $product->addMediaFromUrl($url)
                            ->toMediaCollection('gallery');
                    } catch (\Exception $e) {
                        Log::error("Failed to import gallery image {$url} for product {$title}: " . $e->getMessage());
                    }
                }
            }
        }

        return $product;
    }
}
