<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\File;

$extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$matchingFiles = [];

// Recursively find all files in the project, ignoring vendor, node_modules, .git
$allFiles = File::allFiles(base_path());

$keywords = ['armaf', 'milano', 'afnan', 'french', '9-pm', '9-am', 'spades', 'turathi', 'odyssey', 'equestrian'];

foreach ($allFiles as $file) {
    $ext = strtolower($file->getExtension());
    if (in_array($ext, $extensions)) {
        $filename = strtolower($file->getFilename());
        $path = $file->getRealPath();
        
        // Ignore vendor, node_modules, .git, storage/framework, storage/logs
        if (str_contains($path, 'vendor') || 
            str_contains($path, 'node_modules') || 
            str_contains($path, '.git') ||
            str_contains($path, 'storage\\framework') ||
            str_contains($path, 'storage\\logs')
        ) {
            continue;
        }
        
        $matchedKeyword = null;
        foreach ($keywords as $kw) {
            if (str_contains($filename, $kw)) {
                $matchedKeyword = $kw;
                break;
            }
        }
        
        $matchingFiles[] = [
            'filename' => $file->getFilename(),
            'path' => $path,
            'keyword' => $matchedKeyword ? $matchedKeyword : 'none'
        ];
    }
}

echo "Total matching files found: " . count($matchingFiles) . "\n";
foreach ($matchingFiles as $mf) {
    echo "- File: {$mf['filename']} | Keyword: {$mf['keyword']} | Path: {$mf['path']}\n";
}
