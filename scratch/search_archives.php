<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;

$allFiles = File::allFiles(base_path());
$archives = [];

foreach ($allFiles as $file) {
    $ext = strtolower($file->getExtension());
    if (in_array($ext, ['zip', 'rar', 'tar', 'gz', '7z'])) {
        $archives[] = $file->getRealPath();
    }
}

if (empty($archives)) {
    echo "No archive files found in the workspace.\n";
} else {
    echo "Found archives:\n";
    foreach ($archives as $archive) {
        echo "- $archive\n";
    }
}
