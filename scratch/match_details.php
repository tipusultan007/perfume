<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$imageDir = public_path('products');
$images = array_diff(scandir($imageDir), ['.', '..']);

$products = Product::with('brand')->get();

echo "=== PRODUCTS LIST ===\n";
foreach ($products as $p) {
    $hasFeatured = $p->hasMedia('featured') ? 'YES' : 'NO';
    $brandName = $p->brand ? $p->brand->name : 'No Brand';
    echo "ID: {$p->id} | Name: {$p->name} | Brand: {$brandName} | Slug: {$p->slug} | Featured: {$hasFeatured}\n";
}

echo "\n=== IMAGES LIST ===\n";
foreach ($images as $img) {
    echo "- $img\n";
}
