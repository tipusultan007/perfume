<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Brands
        $brands = [
            ['name' => "L'Essence", 'slug' => 'lessence', 'description' => 'Our signature luxury collection.'],
            ['name' => 'Al Haramain', 'slug' => 'al-haramain', 'description' => 'Traditional Arabian oils and perfumes.'],
            ['name' => 'Swiss Arabian', 'slug' => 'swiss-arabian', 'description' => 'Fusion of East and West.'],
        ];

        foreach ($brands as $b) {
            \App\Models\Brand::firstOrCreate(['slug' => $b['slug']], $b);
        }
        $brand = \App\Models\Brand::first();

        // 2. Categories
        $categories = [
            ['name' => 'Perfumes', 'slug' => 'perfumes'],
            ['name' => 'Attar / Oils', 'slug' => 'oils'],
            ['name' => 'Incense (Bakhoor)', 'slug' => 'incense'],
            ['name' => 'Gift Sets', 'slug' => 'gift-sets'],
        ];

        foreach ($categories as $c) {
            \App\Models\Category::firstOrCreate(['slug' => $c['slug']], $c);
        }
        $perfumeCat = \App\Models\Category::where('slug', 'perfumes')->first();
        $oilCat = \App\Models\Category::where('slug', 'oils')->first();

        // 3. Attributes & Values
        $sizeAttr = \App\Models\Attribute::firstOrCreate(['name' => 'Size']);
        $sizes = ['3ml', '6ml', '12ml', '50ml', '100ml'];
        foreach ($sizes as $size) {
            \App\Models\AttributeValue::firstOrCreate([
                'attribute_id' => $sizeAttr->id,
                'value' => $size
            ]);
        }

        $intensityAttr = \App\Models\Attribute::firstOrCreate(['name' => 'Intensity']);
        $intensities = ['Light', 'Medium', 'Strong'];
        foreach ($intensities as $intensity) {
            \App\Models\AttributeValue::firstOrCreate([
                'attribute_id' => $intensityAttr->id,
                'value' => $intensity
            ]);
        }

        // 4. Simple Product
        \App\Models\Product::firstOrCreate([
            'slug' => 'midnight-oud-50ml',
        ], [
            'name' => 'Midnight Oud 50ml',
            'category_id' => $perfumeCat->id,
            'brand_id' => $brand->id,
            'base_price' => 120.00,
            'sku' => 'MD-OUD-50',
            'stock_quantity' => 50,
            'short_description' => 'A mysterious and captivating scent.',
            'description' => '<p>Experience the depth of Midnight Oud.</p>',
            'product_type' => 'simple',
            'status' => 'published',
            'meta_title' => 'Midnight Oud - Luxury Perfume',
            'meta_description' => 'Buy Midnight Oud online.',
        ]);

        // 5. Variable Product
        $varProduct = \App\Models\Product::firstOrCreate([
            'slug' => 'pure-musk-oil',
        ], [
            'name' => 'Pure Musk Oil',
            'category_id' => $oilCat->id,
            'brand_id' => $brand->id,
            'base_price' => 25.00, // Base price for display
            'short_description' => 'Pure white musk oil.',
            'description' => '<p>Classic white musk.</p>',
            'product_type' => 'variable',
            'status' => 'published',
        ]);

        // Create variants for 3ml, 6ml, 12ml
        $sizeValues = $sizeAttr->values->whereIn('value', ['3ml', '6ml', '12ml']);
        
        foreach ($sizeValues as $val) {
            $price = match($val->value) {
                '3ml' => 15.00,
                '6ml' => 25.00,
                '12ml' => 45.00,
                default => 25.00
            };

            $variant = \App\Models\ProductVariant::firstOrCreate([
                'product_id' => $varProduct->id,
                'sku' => 'MUSK-' . strtoupper($val->value),
            ], [
                'price' => $price,
                'stock_quantity' => 100,
            ]);

            // Attach attribute value
            if (!$variant->attributeValues()->where('attribute_value_id', $val->id)->exists()) {
                $variant->attributeValues()->attach($val->id);
            }
        }
        $user = \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::factory()->create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
            ]);
        }

        $order = \App\Models\Order::firstOrCreate([
            'order_number' => 'ORD-10001',
        ], [
            'user_id' => $user->id,
            'status' => 'processing',
            'grand_total' => 145.00,
            'tax_amount' => 0.00,
            'shipping_cost' => 0.00,
            'payment_method' => 'Credit Card',
            'payment_status' => 'paid',
            'shipping_address' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'address' => '123 Luxury Ave, Beverly Hills',
                'city' => 'Los Angeles',
                'zip' => '90210',
                'phone' => '+15551234567'
            ],
            'billing_address' => [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'address' => '123 Luxury Ave, Beverly Hills',
                'city' => 'Los Angeles',
                'zip' => '90210',
                'phone' => '+15551234567'
            ],
        ]);

        // Add Items to Order
        if ($order->items()->count() == 0) {
            // Add Simple Product
            $simpleProduct = \App\Models\Product::where('sku', 'MD-OUD-50')->first();
            if ($simpleProduct) {
                $order->items()->create([
                    'product_id' => $simpleProduct->id,
                    'product_name' => $simpleProduct->name,
                    'sku' => $simpleProduct->sku,
                    'quantity' => 1,
                    'price' => 120.00,
                    'total' => 120.00,
                ]);
            }

            // Add Variable Product (e.g., 6ml variant)
            $variant = \App\Models\ProductVariant::where('sku', 'MUSK-6ML')->first();
            if ($variant) {
                $order->items()->create([
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'product_name' => $variant->product->name,
                    'variant_name' => '6ml',
                    'sku' => $variant->sku,
                    'quantity' => 1,
                    'price' => 25.00,
                    'total' => 25.00,
                ]);
            }
        }
    }
}