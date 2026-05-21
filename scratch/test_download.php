<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

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
        // Return first image URL
        return $data['results'][0]['image'];
    }
    
    return false;
}

// Find first 3 products missing featured image
$products = Product::whereDoesntHave('media', function($query) {
    $query->where('collection_name', 'featured');
})->with('brand')->take(3)->get();

echo "Running trial search & download for 3 products:\n\n";

foreach ($products as $p) {
    $brandName = $p->brand ? $p->brand->name : '';
    $query = trim("$brandName {$p->name} perfume");
    
    echo "Product ID: {$p->id} | Name: {$p->name} | Brand: $brandName\n";
    echo "Query: \"$query\"\n";
    
    $imageUrl = get_first_image_url($query);
    if ($imageUrl) {
        echo "Found Image URL: $imageUrl\n";
        
        // Try to download the image headers to see if it's accessible
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imageUrl);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
        
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        echo "Image HTTP Status Code: $httpCode\n";
    } else {
        echo "Image not found.\n";
    }
    echo "----------------------------------------\n";
}
