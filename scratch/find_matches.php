<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Str;

$imageDir = public_path('products');
$images = array_diff(scandir($imageDir), ['.', '..']);

$missingFeatured = [];
foreach (Product::all() as $product) {
    if (!$product->hasMedia('featured')) {
        $missingFeatured[] = $product;
    }
}

echo "Total products missing featured image: " . count($missingFeatured) . "\n";
echo "Total image files in public/products: " . count($images) . "\n\n";

$matched = [];
$unmatched = [];

foreach ($missingFeatured as $product) {
    $slug = $product->slug;
    $name = strtolower($product->name);
    
    // Attempt to match
    $bestMatch = null;
    $bestScore = 0;
    
    foreach ($images as $image) {
        $imgName = pathinfo($image, PATHINFO_FILENAME);
        $normalizedImg = str_replace('_', '-', strtolower($imgName));
        
        // Exact slug match
        if ($normalizedImg === $slug) {
            $bestMatch = $image;
            break;
        }
        
        // Check if slug is a substring of the image name or vice versa
        if (str_contains($normalizedImg, $slug) || str_contains($slug, $normalizedImg)) {
            $bestMatch = $image;
            break;
        }

        // Fuzzy match: check how many words overlap
        $productWords = explode('-', $slug);
        $imageWords = explode('-', $normalizedImg);
        $intersect = array_intersect($productWords, $imageWords);
        $score = count($intersect);
        if ($score > $bestScore) {
            $bestScore = $score;
            $bestMatch = $image;
        }
    }
    
    if ($bestMatch) {
        $matched[] = [
            'product' => $product->name,
            'slug' => $product->slug,
            'image' => $bestMatch,
        ];
    } else {
        $unmatched[] = $product->name;
    }
}

echo "Matched Products: " . count($matched) . "\n";
foreach ($matched as $m) {
    echo "- Product: '{$m['product']}' ({$m['slug']}) -> Image: {$m['image']}\n";
}

echo "\nUnmatched Products: " . count($unmatched) . "\n";
foreach ($unmatched as $u) {
    echo "- $u\n";
}
