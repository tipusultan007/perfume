<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

// Run with: php scratch/import_featured_images.php [limit] [dry-run:1|0] [include-gallery:1|0]
$limit = isset($argv[1]) ? (int)$argv[1] : 0; // 0 means all
$dryRun = isset($argv[2]) && $argv[2] === '1';
$includeGallery = isset($argv[3]) && $argv[3] === '1';

echo "=== PERFUME IMAGE IMPORTER ===\n";
echo "Dry Run: " . ($dryRun ? "YES" : "NO") . "\n";
echo "Include Gallery: " . ($includeGallery ? "YES" : "NO") . "\n";
echo "Limit: " . ($limit > 0 ? $limit : "No Limit") . "\n\n";

function get_vqd($query) {
    $url = 'https://duckduckgo.com/?q=' . urlencode($query);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
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

function get_image_results($query) {
    $vqd = get_vqd($query);
    if (!$vqd) return [];
    
    $searchUrl = "https://duckduckgo.com/i.js?q=" . urlencode($query) . "&vqd=" . $vqd . "&o=json&l=wt-wt";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_REFERER, "https://duckduckgo.com/");
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (!$response) return [];
    
    $data = json_decode($response, true);
    return $data['results'] ?? [];
}

function download_image($url, $savePath) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
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

// Find products missing featured image
$queryBuilder = Product::whereDoesntHave('media', function($q) {
    $q->where('collection_name', 'featured');
})->with('brand');

if ($limit > 0) {
    $queryBuilder->take($limit);
}

$products = $queryBuilder->get();
$total = count($products);

echo "Found $total products missing a featured image.\n\n";

$successCount = 0;
$failCount = 0;
$tempDir = storage_path('app/public/temp');
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0755, true);
}

foreach ($products as $index => $product) {
    $num = $index + 1;
    $brandName = $product->brand ? $product->brand->name : '';
    $searchQuery = trim("$brandName {$product->name} perfume");
    
    echo "[$num/$total] Processing: ID {$product->id} | {$product->name} | Brand: $brandName\n";
    echo "      Search query: \"$searchQuery\"\n";
    
    $results = get_image_results($searchQuery);
    
    if (empty($results)) {
        echo "      [FAIL] No image search results found.\n";
        $failCount++;
        echo "----------------------------------------\n";
        sleep(2); // Rate limit spacing
        continue;
    }
    
    // 1. Process Featured Image
    $featuredImgUrl = $results[0]['image'];
    echo "      Found Featured URL: $featuredImgUrl\n";
    
    if ($dryRun) {
        echo "      [DRY RUN] Would download and set as featured.\n";
        
        if ($includeGallery && count($results) > 2) {
            echo "      [DRY RUN] Would also download gallery images:\n";
            echo "        - Gallery 1: " . $results[1]['image'] . "\n";
            echo "        - Gallery 2: " . $results[2]['image'] . "\n";
        }
        $successCount++;
    } else {
        $extension = pathinfo(parse_url($featuredImgUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (empty($extension)) $extension = 'jpg';
        // Clean extension if query parameters are attached
        $extension = explode('?', $extension)[0];
        if (strlen($extension) > 4 || empty($extension)) $extension = 'jpg';
        
        $tempFile = $tempDir . '/temp_featured_' . $product->id . '.' . $extension;
        
        if (download_image($featuredImgUrl, $tempFile)) {
            try {
                $product->clearMediaCollection('featured');
                $product->addMedia($tempFile)->toMediaCollection('featured');
                echo "      [SUCCESS] Featured image imported successfully.\n";
                $successCount++;
                
                // 2. Process Gallery Images
                if ($includeGallery && count($results) > 2) {
                    $product->clearMediaCollection('gallery');
                    $galleryImported = 0;
                    
                    // Try to import next 2 images
                    for ($g = 1; $g <= 2; $g++) {
                        if (isset($results[$g])) {
                            $galUrl = $results[$g]['image'];
                            $galExt = pathinfo(parse_url($galUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                            if (empty($galExt)) $galExt = 'jpg';
                            $galExt = explode('?', $galExt)[0];
                            if (strlen($galExt) > 4 || empty($galExt)) $galExt = 'jpg';
                            
                            $galTempFile = $tempDir . '/temp_gal_' . $product->id . '_' . $g . '.' . $galExt;
                            
                            if (download_image($galUrl, $galTempFile)) {
                                $product->addMedia($galTempFile)->toMediaCollection('gallery');
                                $galleryImported++;
                            }
                        }
                    }
                    echo "      [INFO] Imported $galleryImported gallery images.\n";
                }
            } catch (\Exception $e) {
                echo "      [FAIL] Failed to add media: " . $e->getMessage() . "\n";
                $failCount++;
            }
        } else {
            echo "      [FAIL] Failed to download image.\n";
            $failCount++;
        }
    }
    
    echo "----------------------------------------\n";
    sleep(2); // Rate limit spacing to avoid blocking
}

echo "\n=== IMPORT COMPLETED ===\n";
echo "Total processed: $total\n";
echo "Successes: $successCount\n";
echo "Failures: $failCount\n";
