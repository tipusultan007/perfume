<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Brand;

$brands = Brand::all();
foreach ($brands as $b) {
    echo "ID: {$b->id} | Name: {$b->name} | Slug: {$b->slug}\n";
}
