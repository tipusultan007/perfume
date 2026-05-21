<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::with('brand', 'category')->get();

foreach ($products as $p) {
    $hasFeatured = $p->hasMedia('featured') ? 'YES' : 'NO';
    $brandName = $p->brand ? $p->brand->name : 'No Brand';
    $categoryName = $p->category ? $p->category->name : 'No Category';
    echo "ID: {$p->id} | Name: {$p->name} | Brand: {$brandName} | Category: {$categoryName} | Featured: {$hasFeatured}\n";
}
