<?php

function get_vqd($query) {
    $url = 'https://duckduckgo.com/?q=' . urlencode($query);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    
    $html = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    if (!$html) {
        return false;
    }
    
    if (preg_match('/vqd=([0-9-]+)/', $html, $matches)) {
        return $matches[1];
    }
    if (preg_match('/vqd\s*[:=]\s*[\'"]([0-9-]+)[\'"]/', $html, $matches)) {
        return $matches[1];
    }
    
    return false;
}

$query = 'Afnan 9 PM perfume';
echo "Searching for: $query\n";
$vqd = get_vqd($query);
if ($vqd) {
    echo "Found vqd token: $vqd\n";
    
    $searchUrl = "https://duckduckgo.com/i.js?q=" . urlencode($query) . "&vqd=" . $vqd . "&o=json&l=wt-wt";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
    curl_setopt($ch, CURLOPT_REFERER, "https://duckduckgo.com/");
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    
    echo "HTTP Status Code: $httpCode\n";
    if ($err) {
        echo "cURL Error: $err\n";
    }
    
    if ($response) {
        echo "Response length: " . strlen($response) . "\n";
        echo "Response snippet:\n" . substr($response, 0, 500) . "\n";
        
        $data = json_decode($response, true);
        if (isset($data['results']) && count($data['results']) > 0) {
            echo "Total results: " . count($data['results']) . "\n";
            echo "First result URL: " . $data['results'][0]['image'] . "\n";
        } else {
            echo "No results found in JSON.\n";
        }
    } else {
        echo "Empty response.\n";
    }
} else {
    echo "Failed to get vqd token.\n";
}
