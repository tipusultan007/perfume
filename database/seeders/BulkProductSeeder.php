<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BulkProductSeeder extends Seeder
{
    public function run(): void
    {
        $imagePath = public_path('products');
        if (!is_dir($imagePath)) {
            $this->command->error("Directory public/products not found.");
            return;
        }

        $files = array_diff(scandir($imagePath), ['.', '..']);
        $count = 0;

        foreach ($files as $file) {
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp'])) {
                continue;
            }

            // Cleanup title
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $title = ucwords(str_replace('_', ' ', $filename));

            // Create Product
            $product = \App\Models\Product::create([
                'name' => $title,
                'slug' => \Illuminate\Support\Str::slug($title . '-' . \Illuminate\Support\Str::random(4)),
                'sku' => 'PRF-' . strtoupper(\Illuminate\Support\Str::random(8)),
                'base_price' => rand(85, 450),
                'sale_price' => rand(0, 1) ? rand(60, 80) : null,
                'stock_quantity' => rand(5, 50),
                'description' => "Experience the premium essence of " . $title . ". A masterpiece crafted for those who appreciate the finer things in life.",
                'short_description' => "Luxury fragrance: " . $title,
                'status' => 'published',
                'product_type' => 'simple',
                'category_id' => rand(1, 4),
                'brand_id' => rand(1, 3),
                'gender' => ['Male', 'Female', 'Unisex'][rand(0, 2)],
                'concentration' => ['Eau de Parfum', 'Eau de Toilette', 'Extrait de Parfum', 'Pure Oil'][rand(0, 3)],
                'season' => ['Spring/Summer', 'Autumn/Winter', 'All Season'][rand(0, 2)],
            ]);

            // Add Media
            try {
                $fullPath = $imagePath . DIRECTORY_SEPARATOR . $file;
                $product->addMedia($fullPath)
                    ->preservingOriginal()
                    ->toMediaCollection('featured');
                
                $count++;
                $this->command->info("Created: " . $title);
            } catch (\Exception $e) {
                $this->command->error("Failed to add media for: " . $title . " - " . $e->getMessage());
            }
        }

        $this->command->info("Finished seeding $count products.");
    }
}
