<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$totalProducts = Product::count();
$missingFeatured = [];
$missingGallery = [];

foreach (Product::all() as $product) {
    $hasFeatured = $product->hasMedia('featured');
    $galleryCount = $product->getMedia('gallery')->count();

    if (!$hasFeatured) {
        $missingFeatured[] = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug
        ];
    }
    if ($galleryCount === 0) {
        $missingGallery[] = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug
        ];
    }
}

echo "Total Products: " . $totalProducts . "\n";
echo "Products missing featured image: " . count($missingFeatured) . "\n";
echo "Products missing gallery images: " . count($missingGallery) . "\n";

echo "\nFirst 10 products missing featured image:\n";
foreach (array_slice($missingFeatured, 0, 10) as $p) {
    echo "- ID: {$p['id']} | Name: {$p['name']} | Slug: {$p['slug']}\n";
}
