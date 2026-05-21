<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\MediaLibrary\MediaCollections\Models\Media;

$mediaItems = Media::where('model_type', 'App\\Models\\Product')
                   ->where('collection_name', 'featured')
                   ->take(10)
                   ->get();

echo "Sample Featured Media Items for Products:\n";
foreach ($mediaItems as $media) {
    echo "ID: {$media->id} | Model ID: {$media->model_id} | Name: {$media->name} | File: {$media->file_name} | Path: {$media->getPath()} | URL: {$media->getUrl()}\n";
}
