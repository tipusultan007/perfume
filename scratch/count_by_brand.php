<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Brand;

$brands = Brand::all();

echo "Brand counts:\n";
foreach ($brands as $brand) {
    $total = Product::where('brand_id', $brand->id)->count();
    $hasFeatured = Product::where('brand_id', $brand->id)
        ->whereHas('media', function($q) {
            $q->where('collection_name', 'featured');
        })->count();
    $noFeatured = $total - $hasFeatured;
    
    echo "- Name: {$brand->name} | Total Products: $total | Has Featured: $hasFeatured | No Featured: $noFeatured\n";
}
