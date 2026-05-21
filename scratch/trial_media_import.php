<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

function get_vqd($query) {
    $url = 'https://duckduckgo.com/?q=' . urlencode($query);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    
    $html = curl_exec($ch);
    curl_close($ch);
    
    if (!$html) return false;
    
    if (preg_match('/vqd=([0-9-]+)/', $html, $matches)) {
        return $matches[1];
    }
    if (preg_match('/vqd\s*[:=]\s*[\'"]([0-9-]+)[\'"]/', $html, $matches)) {
        return $matches[1];
    }
    
    return false;
}

function get_first_image_url($query) {
    $vqd = get_vqd($query);
    if (!$vqd) return false;
    
    $searchUrl = "https://duckduckgo.com/i.js?q=" . urlencode($query) . "&vqd=" . $vqd . "&o=json&l=wt-wt";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_REFERER, "https://duckduckgo.com/");
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (!$response) return false;
    
    $data = json_decode($response, true);
    if (isset($data['results']) && count($data['results']) > 0) {
        return $data['results'][0]['image'];
    }
    
    return false;
}

function download_image($url, $savePath) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode == 200 && $data) {
        file_put_contents($savePath, $data);
        return true;
    }
    return false;
}

// Target Product: ID 43 (9 PM - Rebel)
$product = Product::find(43);

if (!$product) {
    echo "Product ID 43 not found.\n";
    exit;
}

// Clear existing featured if any
$product->clearMediaCollection('featured');

$brandName = $product->brand ? $product->brand->name : '';
$query = trim("$brandName {$product->name} perfume");

echo "Target Product: {$product->name} (ID: {$product->id})\n";
echo "Search Query: \"$query\"\n";

$imageUrl = get_first_image_url($query);
if ($imageUrl) {
    echo "Found Image URL: $imageUrl\n";
    
    // Save to temp file
    $tempDir = storage_path('app/public/temp');
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0755, true);
    }
    
    $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (empty($extension)) {
        $extension = 'jpg';
    }
    
    $tempFile = $tempDir . '/temp_import_' . $product->id . '.' . $extension;
    
    echo "Downloading image to: $tempFile\n";
    if (download_image($imageUrl, $tempFile)) {
        echo "Download successful! Size: " . filesize($tempFile) . " bytes\n";
        
        // Add to MediaLibrary
        try {
            $media = $product->addMedia($tempFile)
                             ->toMediaCollection('featured');
            
            echo "Successfully imported to media library!\n";
            echo "Media ID: {$media->id}\n";
            echo "File Name: {$media->file_name}\n";
            echo "Mime Type: {$media->mime_type}\n";
            echo "URL: " . $product->getFirstMediaUrl('featured') . "\n";
            
            // Check disk path
            echo "File Path: " . $media->getPath() . "\n";
            if (file_exists($media->getPath())) {
                echo "File exists on disk!\n";
            } else {
                echo "Warning: File does not exist on disk!\n";
            }
        } catch (\Exception $e) {
            echo "Failed to add media to product: " . $e->getMessage() . "\n";
        }
    } else {
        echo "Failed to download image.\n";
    }
} else {
    echo "Image URL not found.\n";
}
