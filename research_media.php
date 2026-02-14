<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Product;
use Illuminate\Support\Facades\File;

$dbIds = Media::pluck('id')->toArray();
$productIds = Product::pluck('id', 'id')->toArray();

$paths = [
    'featured' => storage_path('app/public/products/featured'),
    'gallery' => storage_path('app/public/products/gallery'),
];

echo "Researching Gallery Media Orphans...\n";

foreach ($paths as $key => $path) {
    echo "\nProcessing: $path\n";
    if (!File::isDirectory($path)) {
        echo "Path does not exist.\n";
        continue;
    }

    $dirs = File::directories($path);
    $collections = [];
    $missingFromDb = [];
    $missingProduct = [];

    foreach ($dirs as $idDir) {
        $id = basename($idDir);
        if (!is_numeric($id)) continue;
        $id = (int)$id;

        $media = Media::find($id);
        if ($media) {
            $currentCollection = $media->collection_name;
            $expectedCollection = ($key === 'featured') ? 'featured' : 'gallery';

            if ($currentCollection !== $expectedCollection) {
                $missingProduct[] = "ID $id: In folder '$key' but collection is '$currentCollection'";
            }
        } else {
            $missingFromDb[] = $id;
        }
    }

    echo "Path: $path\n";
    echo "Total Folders: " . count($dirs) . "\n";
    echo "Folders in WRONG collection folder: " . count($missingProduct) . "\n";
    if (count($missingProduct) > 0) {
        echo "  Sample: " . implode("\n  ", array_slice($missingProduct, 0, 5)) . "\n";
    }
}
