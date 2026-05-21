<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProductImage;

$count = ProductImage::count();
echo "Total records in product_images: " . $count . "\n";

if ($count > 0) {
    $samples = ProductImage::take(10)->get();
    foreach ($samples as $s) {
        echo "Product ID: {$s->product_id} | Path: {$s->image_path} | Order: {$s->sort_order}\n";
    }
}
