<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$products = Product::whereDoesntHave('media', function($query) {
    $query->where('collection_name', 'featured');
})->with('brand')->get();

$brandCounts = [];
foreach ($products as $p) {
    $bName = $p->brand ? $p->brand->name : 'No Brand';
    if (!isset($brandCounts[$bName])) {
        $brandCounts[$bName] = 0;
    }
    $brandCounts[$bName]++;
}

arsort($brandCounts);
print_r($brandCounts);
