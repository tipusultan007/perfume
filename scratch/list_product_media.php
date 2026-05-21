<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::all();
$hasFeaturedCount = 0;
$noFeaturedCount = 0;

echo "Products with Featured Images:\n";
foreach ($products as $p) {
    if ($p->hasMedia('featured')) {
        $hasFeaturedCount++;
        $media = $p->getFirstMedia('featured');
        echo "ID: {$p->id} | Name: {$p->name} | Media ID: {$media->id} | File Name: {$media->file_name}\n";
    } else {
        $noFeaturedCount++;
    }
}

echo "\nSummary:\n";
echo "Total products: " . count($products) . "\n";
echo "With featured: $hasFeaturedCount\n";
echo "Without featured: $noFeaturedCount\n";
