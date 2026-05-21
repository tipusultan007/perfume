<?php

use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('/product/{product:slug}/quick-view', [App\Http\Controllers\ShopController::class, 'quickView'])->name('shop.quickView');
Route::get('/product/{product:slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.product.show');
Route::get('/shop/product/{product:slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.product.show'); // Compatibility
Route::post('/product/{product:slug}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('shop.product.review');
Route::get('/design-demo', [App\Http\Controllers\DesignController::class, 'index'])->name('design.demo');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/privacy-policy', [App\Http\Controllers\PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [App\Http\Controllers\PageController::class, 'terms'])->name('terms');

// Cart Routes
Route::group(['prefix' => 'cart'], function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/get', [\App\Http\Controllers\CartController::class, 'getCart'])->name('cart.get');
    Route::post('/remove', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/update', [\App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update');
});

Route::get('/api/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('api.search');

// Checkout Routes
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/coupon', [\App\Http\Controllers\CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
Route::delete('/checkout/coupon', [\App\Http\Controllers\CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
Route::get('/thank-you', [\App\Http\Controllers\CheckoutController::class, 'thankYou'])->name('checkout.thank-you');

// Public Order Tracking
Route::get('/track-order', [\App\Http\Controllers\OrderTrackingController::class, 'index'])->name('order.track');
Route::post('/track-order', [\App\Http\Controllers\OrderTrackingController::class, 'track'])->name('order.track.process');
Route::get('/track-order/view', [\App\Http\Controllers\OrderTrackingController::class, 'showGuestOrder'])->name('order.track.guest');

// Site Status Splash Pages
Route::get('/maintenance', function() { return view('shop.maintenance'); })->name('maintenance');
Route::get('/coming-soon', function() { return view('shop.coming-soon'); })->name('coming-soon');

// Customer Account Routes
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{email}/{hash}', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AccountController::class, 'index'])->name('index');
    Route::get('/orders', [\App\Http\Controllers\AccountController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [\App\Http\Controllers\AccountController::class, 'orderShow'])->name('orders.show');
    Route::get('/addresses', [\App\Http\Controllers\AccountController::class, 'addresses'])->name('addresses');
    Route::get('/addresses/edit/{type}', [\App\Http\Controllers\AccountController::class, 'editAddress'])->name('addresses.edit');
    Route::post('/addresses/edit/{type}', [\App\Http\Controllers\AccountController::class, 'updateAddress']);
    Route::get('/details', [\App\Http\Controllers\AccountController::class, 'editDetails'])->name('details');
    Route::post('/details', [\App\Http\Controllers\AccountController::class, 'updateDetails']);
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\AccountController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::post('/orders/{order}/reorder', [\App\Http\Controllers\AccountController::class, 'reorder'])->name('orders.reorder');
});

// Profile Routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Wishlist Routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Admin Routes
Route::prefix('newkirk-management')->name('admin.')->group(function () {
    
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('attributes', AttributeController::class);
        Route::post('products/import', [ProductController::class, 'processImport'])->name('products.import.process');
        Route::get('products/import', [ProductController::class, 'import'])->name('products.import');
        Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
        Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::resource('products', ProductController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
    // Orders
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::get('/orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    Route::post('/orders/{order}/resend-details', [\App\Http\Controllers\Admin\OrderController::class, 'resendDetails'])->name('orders.resend-details');
    Route::post('/orders/{order}/notes', [\App\Http\Controllers\Admin\OrderController::class, 'addNote'])->name('orders.notes.store');

        // Home Page Settings
        Route::get('/home-settings', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'index'])->name('home-settings.index');
        Route::post('/home-settings/hero', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateHero'])->name('home-settings.hero');
        Route::post('/home-settings/heritage', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateHeritage'])->name('home-settings.heritage');
        Route::post('/home-settings/curation', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateCuration'])->name('home-settings.curation');
        Route::post('/home-settings/visibility', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateVisibility'])->name('home-settings.visibility');

        // Tax & Settings
        Route::resource('taxes', \App\Http\Controllers\Admin\TaxController::class);
    // Global Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/clear-cache', [\App\Http\Controllers\Admin\SettingController::class, 'clearCache'])->name('settings.clear-cache');
    Route::post('/settings/storage-link', [\App\Http\Controllers\Admin\SettingController::class, 'createStorageLink'])->name('settings.storage-link');
    Route::post('/settings/test-smtp', [\App\Http\Controllers\Admin\SettingController::class, 'testSmtp'])->name('settings.test-smtp');
    Route::post('/settings/generate-sitemap', [\App\Http\Controllers\Admin\SettingController::class, 'generateSitemap'])->name('settings.generate-sitemap');

        // Customers
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'show', 'destroy']);
        
        // Coupons
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

        // Newsletter
        Route::post('/newsletter/{id}/send', [\App\Http\Controllers\Admin\NewsletterController::class, 'send'])->name('newsletter.send');
        Route::resource('newsletter', \App\Http\Controllers\Admin\NewsletterController::class);

        // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'readAll'])->name('notifications.read-all');

        // Popups
        Route::post('/popups/{popup}/toggle-status', [\App\Http\Controllers\Admin\PopupController::class, 'toggleStatus'])->name('popups.toggle-status');
        Route::resource('popups', \App\Http\Controllers\Admin\PopupController::class);

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
            Route::get('/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('sales');
            Route::get('/products', [\App\Http\Controllers\Admin\ReportController::class, 'products'])->name('products');
            Route::get('/customers', [\App\Http\Controllers\Admin\ReportController::class, 'customers'])->name('customers');
        });

        // Reviews
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'destroy']);
        Route::post('reviews/{review}/toggle-approval', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleApproval'])->name('reviews.toggle-approval');

        // Contact Submissions
        Route::resource('contact-submissions', \App\Http\Controllers\Admin\ContactSubmissionController::class)->only(['index', 'show', 'destroy']);
    });
});

require __DIR__.'/auth.php';

// One-shot fix for product ID 69 - Odyssey MandarinSky
Route::get('/newkirk-management/temp-fix-id69', function() {
    ignore_user_abort(true);
    set_time_limit(300);
    $logFile = base_path('scratch/web_import_log.txt');
    file_put_contents($logFile, "=== FIXING ID 69: Odyssey MandarinSky ===\n");

    $product = \App\Models\Product::find(69);
    if (!$product) {
        file_put_contents($logFile, "Product ID 69 not found!\n", FILE_APPEND);
        return response()->json(['error' => 'Product not found']);
    }

    // Known good URLs to try for this product
    $urlsToTry = [
        'https://www.perfumenz.co.nz/cdn/shop/files/armaf-odyssey-mandarin-sky_1024x1024.png',
        'https://cdn.shopify.com/s/files/1/0259/7733/products/armaf-odyssey-mandarin-sky_1024x1024.png',
        'https://perfumeonline.ca/cdn/shop/files/Armaf-Odyssey-Mandarin-Sky_1024x1024.png',
        'https://m.media-amazon.com/images/I/81oFf2VyTaL.jpg',
        'https://fimgs.net/mdimg/secundar/o.77534.jpg',
    ];

    $tempDir = storage_path('app/public/temp');
    if (!is_dir($tempDir)) mkdir($tempDir, 0755, true);

    foreach ($urlsToTry as $i => $url) {
        file_put_contents($logFile, "Trying [" . ($i+1) . "]: $url\n", FILE_APPEND);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36");
        $data = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code == 200 && $data && strlen($data) > 5000) {
            $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
            $ext = explode('?', $ext)[0];
            if (strlen($ext) > 4) $ext = 'jpg';
            $tempFile = $tempDir . '/fix_69.' . $ext;
            file_put_contents($tempFile, $data);
            try {
                $product->clearMediaCollection('featured');
                $product->addMedia($tempFile)->toMediaCollection('featured');
                file_put_contents($logFile, "[SUCCESS] Imported from URL #" . ($i+1) . "\n", FILE_APPEND);
                return response()->json(['status' => 'success', 'url' => $url]);
            } catch (\Exception $e) {
                file_put_contents($logFile, "[FAIL] Media error: " . $e->getMessage() . "\n", FILE_APPEND);
            }
        } else {
            file_put_contents($logFile, "[SKIP] HTTP $code / size " . strlen($data ?? '') . " bytes\n", FILE_APPEND);
        }
    }
    file_put_contents($logFile, "[FAIL] All URLs failed.\n", FILE_APPEND);
    return response()->json(['status' => 'failed']);
});

Route::get('/newkirk-management/temp-run-import', function() {
    // Basic PHP configuration to try to keep it alive
    @ignore_user_abort(true);
    @set_time_limit(120); // 2 minutes is plenty for 3-5 images

    $chunkSize = (int)request('chunk_size', 3);
    if ($chunkSize < 1) $chunkSize = 3;
    if ($chunkSize > 10) $chunkSize = 10; // Prevent setting too high

    $reset = request('reset') == 1;

    if ($reset) {
        session()->forget([
            'import_attempted_ids',
            'import_success_count',
            'import_fail_count',
            'import_initial_missing'
        ]);
        return redirect('/newkirk-management/temp-run-import');
    }

    $attemptedIds = session()->get('import_attempted_ids', []);
    $successCount = session()->get('import_success_count', 0);
    $failCount = session()->get('import_fail_count', 0);

    // Get current missing count
    $totalMissing = \App\Models\Product::whereDoesntHave('media', function($q) {
        $q->where('collection_name', 'featured');
    })->count();

    // If initial missing is not in session, set it now
    $initialMissing = session()->get('import_initial_missing');
    if ($initialMissing === null) {
        $initialMissing = $totalMissing;
        session()->put('import_initial_missing', $initialMissing);
    }

    // Query next chunk
    $queryBuilder = \App\Models\Product::whereDoesntHave('media', function($q) {
        $q->where('collection_name', 'featured');
    });

    if (!empty($attemptedIds)) {
        $queryBuilder->whereNotIn('id', $attemptedIds);
    }

    $products = $queryBuilder->with('brand')
        ->take($chunkSize)
        ->get();

    $currentBatch = [];
    $logFile = base_path('scratch/web_import_log.txt');
    
    // Helper scraping functions
    $get_vqd = function($query) {
        $url = 'https://duckduckgo.com/?q=' . urlencode($query);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        $html = curl_exec($ch);
        curl_close($ch);
        if (!$html) return false;
        if (preg_match('/vqd=([0-9-]+)/', $html, $matches)) return $matches[1];
        if (preg_match('/vqd\s*[:=]\s*[\'"]([0-9-]+)[\'"]/', $html, $matches)) return $matches[1];
        return false;
    };

    $get_image_results = function($query) use ($get_vqd) {
        $vqd = $get_vqd($query);
        if (!$vqd) return [];
        $searchUrl = "https://duckduckgo.com/i.js?q=" . urlencode($query) . "&vqd=" . $vqd . "&o=json&l=wt-wt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $searchUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
        curl_setopt($ch, CURLOPT_REFERER, "https://duckduckgo.com/");
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) return [];
        $data = json_decode($response, true);
        return $data['results'] ?? [];
    };

    $download_image = function($url, $savePath) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode == 200 && $data) {
            file_put_contents($savePath, $data);
            return true;
        }
        return false;
    };

    $tempDir = storage_path('app/public/temp');
    if (!is_dir($tempDir)) {
        @mkdir($tempDir, 0755, true);
    }

    if ($products->isNotEmpty()) {
        if (!file_exists($logFile)) {
            file_put_contents($logFile, "=== CHUNKED IMPORT LOG ===\n");
        }
        
        foreach ($products as $product) {
            $brandName = $product->brand ? $product->brand->name : '';
            $searchQuery = trim("$brandName {$product->name} perfume");
            
            $logMsg = date('Y-m-d H:i:s') . " | Processing ID {$product->id} | {$product->name}\n";
            file_put_contents($logFile, $logMsg, FILE_APPEND);
            
            $results = $get_image_results($searchQuery);
            $imported = false;
            $successUrl = null;
            $attemptedUrlsLog = [];

            if (!empty($results)) {
                $maxTries = min(5, count($results));
                for ($try = 0; $try < $maxTries; $try++) {
                    $featuredImgUrl = $results[$try]['image'];
                    file_put_contents($logFile, "  Trying URL [" . ($try+1) . "]: $featuredImgUrl\n", FILE_APPEND);

                    $extension = pathinfo(parse_url($featuredImgUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                    if (empty($extension)) $extension = 'jpg';
                    $extension = explode('?', $extension)[0];
                    if (strlen($extension) > 4 || empty($extension)) $extension = 'jpg';

                    $tempFile = $tempDir . '/temp_web_featured_' . $product->id . '.' . $extension;

                    if ($download_image($featuredImgUrl, $tempFile)) {
                        try {
                            $product->clearMediaCollection('featured');
                            $product->addMedia($tempFile)->toMediaCollection('featured');
                            file_put_contents($logFile, "  [SUCCESS] Imported successfully.\n", FILE_APPEND);
                            $imported = true;
                            $successUrl = $featuredImgUrl;
                            $successCount++;
                            break;
                        } catch (\Exception $e) {
                            $errorMsg = "Media library error: " . $e->getMessage();
                            file_put_contents($logFile, "  [FAIL] $errorMsg\n", FILE_APPEND);
                            $attemptedUrlsLog[] = ['url' => $featuredImgUrl, 'status' => $errorMsg];
                        }
                    } else {
                        file_put_contents($logFile, "  [SKIP] Download failed.\n", FILE_APPEND);
                        $attemptedUrlsLog[] = ['url' => $featuredImgUrl, 'status' => 'HTTP download failed'];
                    }
                }
            } else {
                file_put_contents($logFile, "  [FAIL] No image search results found.\n", FILE_APPEND);
                $attemptedUrlsLog[] = ['url' => 'DuckDuckGo Search', 'status' => 'No image results found'];
            }

            if (!$imported) {
                $failCount++;
            }

            $attemptedIds[] = $product->id;

            $currentBatch[] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $brandName,
                'status' => $imported ? 'success' : 'failed',
                'url' => $successUrl,
                'logs' => $attemptedUrlsLog
            ];

            // Brief pause between products to be gentle on DuckDuckGo
            usleep(500000); // 0.5s
        }

        // Store back in session
        session()->put('import_attempted_ids', $attemptedIds);
        session()->put('import_success_count', $successCount);
        session()->put('import_fail_count', $failCount);
    }

    // Calculate progress percentage
    $progressPercent = 0;
    if ($initialMissing > 0) {
        $processedCount = $initialMissing - $totalMissing;
        // Make sure it doesn't exceed 100% or go negative
        $progressPercent = round(max(0, min(100, ($processedCount / $initialMissing) * 100)));
    } else {
        $progressPercent = 100;
    }

    $attemptedCount = count($attemptedIds);

    // Build the beautiful UI response
    $isFinished = $products->isEmpty();
    
    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfume Image Auto-Importer</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0d0f14;
            --card-bg: rgba(22, 28, 38, 0.6);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #f3f4f6;
            --text-secondary: #9ca3af;
            --accent-color: #6366f1;
            --accent-glow: rgba(99, 102, 241, 0.15);
            --success-color: #10b981;
            --success-glow: rgba(16, 185, 129, 0.15);
            --fail-color: #ef4444;
            --fail-glow: rgba(239, 68, 68, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.05) 0px, transparent 50%);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
        }

        .header-title h1 {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-title p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        .badge {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            padding: 0.4rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.25rem;
            text-align: center;
            transition: transform 0.2s, border-color 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .stat-val {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
        }

        .stat-success .stat-val { color: var(--success-color); }
        .stat-fail .stat-val { color: var(--fail-color); }
        .stat-remaining .stat-val { color: #f59e0b; }

        .progress-section {
            margin-bottom: 2.5rem;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .progress-bar {
            height: 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--accent-color) 0%, #a5b4fc 100%);
            width: 0%;
            border-radius: 6px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 12px var(--accent-glow);
        }

        .batch-section h2 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .batch-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.01);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
        }

        .product-thumbnail {
            width: 54px;
            height: 54px;
            border-radius: 10px;
            object-fit: cover;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .product-details h3 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .product-details p {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.15rem;
        }

        .product-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.25rem;
        }

        .status-badge {
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .status-badge.success {
            background: var(--success-glow);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .status-badge.failed {
            background: var(--fail-glow);
            color: var(--fail-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .status-desc {
            font-size: 0.7rem;
            color: var(--text-secondary);
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: right;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
            gap: 1rem;
        }

        .btn {
            font-family: inherit;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--accent-color);
            color: white;
            box-shadow: 0 4px 12px var(--accent-glow);
        }

        .btn-primary:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.03);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-danger {
            background: var(--fail-glow);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--fail-color);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.25);
        }

        .countdown-text {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        /* Finished Screen Styling */
        .finished-container {
            text-align: center;
            padding: 1.5rem 0;
        }

        .finished-icon {
            font-size: 3rem;
            color: var(--success-color);
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }

        .finished-title {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .finished-desc {
            font-size: 0.95rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
HTML;

    if ($isFinished) {
        $html .= <<<HTML
        <div class="finished-container">
            <div class="finished-icon">✓</div>
            <h1 class="finished-title">Import Finished!</h1>
            <p class="finished-desc">All products have been processed. Excellent job!</p>
            
            <div class="stats-grid" style="margin-bottom: 2.5rem;">
                <div class="stat-card">
                    <div class="stat-val">$attemptedCount</div>
                    <div class="stat-label">Total Attempted</div>
                </div>
                <div class="stat-card stat-success">
                    <div class="stat-val">$successCount</div>
                    <div class="stat-label">Successes</div>
                </div>
                <div class="stat-card stat-fail">
                    <div class="stat-val">$failCount</div>
                    <div class="stat-label">Failures</div>
                </div>
            </div>

            <div style="display: flex; justify-content: center; gap: 1rem;">
                <a href="/newkirk-management/temp-run-import?reset=1" class="btn btn-primary">Restart / Scan Again</a>
                <a href="/newkirk-management/dashboard" class="btn btn-secondary">Go to Dashboard</a>
            </div>
        </div>
HTML;
    } else {
        $currentBatchHtml = '';
        foreach ($currentBatch as $item) {
            $statusClass = $item['status'];
            $statusText = $item['status'] == 'success' ? 'Success' : 'Failed';
            
            $imgHtml = '<div class="product-thumbnail">?</div>';
            if ($item['status'] == 'success' && $item['url']) {
                $imgHtml = '<img class="product-thumbnail" src="' . htmlspecialchars($item['url']) . '" alt="' . htmlspecialchars($item['name']) . '" onerror="this.outerHTML=\'<div class=\\\'product-thumbnail\\\'>✓</div>\'">';
            }

            $subtext = 'Skipped / All attempts failed';
            if ($item['status'] == 'success') {
                $subtext = 'Image assigned successfully';
            } elseif (!empty($item['logs'])) {
                $lastLog = end($item['logs']);
                $subtext = $lastLog['status'];
            }

            $currentBatchHtml .= <<<HTML
            <div class="product-card">
                <div class="product-info">
                    $imgHtml
                    <div class="product-details">
                        <h3>{$item['name']}</h3>
                        <p>{$item['brand']} (ID: {$item['id']})</p>
                    </div>
                </div>
                <div class="product-status">
                    <span class="status-badge {$statusClass}">{$statusText}</span>
                    <span class="status-desc" title="{$subtext}">{$subtext}</span>
                </div>
            </div>
HTML;
        }

        $html .= <<<HTML
        <div class="header">
            <div class="header-title">
                <h1>Perfume Image Auto-Importer</h1>
                <p>Importing missing featured images automatically in small chunks</p>
            </div>
            <span class="badge">Running Chunk</span>
        </div>

        <div class="stats-grid">
            <div class="stat-card stat-remaining">
                <div class="stat-val">$totalMissing</div>
                <div class="stat-label">Missing in DB</div>
            </div>
            <div class="stat-card">
                <div class="stat-val">$attemptedCount</div>
                <div class="stat-label">Attempted</div>
            </div>
            <div class="stat-card stat-success">
                <div class="stat-val">$successCount</div>
                <div class="stat-label">Successes</div>
            </div>
            <div class="stat-card stat-fail">
                <div class="stat-val">$failCount</div>
                <div class="stat-label">Failures</div>
            </div>
        </div>

        <div class="progress-section">
            <div class="progress-header">
                <span>Database Completion</span>
                <span>$progressPercent%</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill" style="width: 0%"></div>
            </div>
        </div>

        <div class="batch-section">
            <h2>Current Batch Results ({$chunkSize} items)</h2>
            <div class="batch-list">
                $currentBatchHtml
            </div>
        </div>

        <div class="controls">
            <div>
                <span class="countdown-text" id="countdown">Redirecting in 3s...</span>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button id="pauseBtn" class="btn btn-secondary">Pause</button>
                <button id="resumeBtn" class="btn btn-primary" style="display: none;">Resume</button>
                <a href="/newkirk-management/temp-run-import?reset=1" class="btn btn-danger">Reset Run</a>
            </div>
        </div>

        <script>
            // Smoothly animate progress bar
            setTimeout(() => {
                document.getElementById('progressFill').style.width = '{$progressPercent}%';
            }, 100);

            // Auto-redirect countdown driving the loop
            let seconds = 3;
            const countdownEl = document.getElementById('countdown');
            const pauseBtn = document.getElementById('pauseBtn');
            const resumeBtn = document.getElementById('resumeBtn');
            let paused = false;

            pauseBtn.addEventListener('click', () => {
                paused = true;
                pauseBtn.style.display = 'none';
                resumeBtn.style.display = 'inline-block';
                countdownEl.innerText = 'Paused';
            });

            resumeBtn.addEventListener('click', () => {
                paused = false;
                resumeBtn.style.display = 'none';
                pauseBtn.style.display = 'inline-block';
                tick();
            });

            function tick() {
                if (paused) return;
                if (seconds <= 0) {
                    // Retain chunk_size and session settings
                    window.location.href = window.location.pathname + window.location.search;
                } else {
                    countdownEl.innerText = 'Redirecting in ' + seconds + 's...';
                    seconds--;
                    setTimeout(tick, 1000);
                }
            }
            setTimeout(tick, 1000);
        </script>
HTML;
    }

    $html .= <<<HTML
    </div>
</body>
</html>
HTML;

    return response($html);
});

Route::middleware(['auth:admin'])->prefix('newkirk-management')->group(function () {
    Route::get('/create-storage-link', function () {
        try {
            $storagePath = storage_path('app/public');
            $publicPath = public_path('storage');

            if (file_exists($publicPath)) {
                if (is_link($publicPath)) {
                    @unlink($publicPath);
                } else {
                    @rename($publicPath, $publicPath . '_old_' . time());
                }
            }

            // Try manual symlink first on shared hosting to avoid exec() issues
            try {
                if (@symlink($storagePath, $publicPath)) {
                    return "Storage link created successfully via manual symlink!<br><a href='".route('admin.dashboard')."'>Go to Dashboard</a>";
                }
            } catch (\Throwable $t) {
                // Ignore and try Artisan
            }

            // Fallback to Artisan
            try {
                Artisan::call('storage:link');
                return "Storage link created successfully via Artisan!<br><a href='".route('admin.dashboard')."'>Go to Dashboard</a>";
            } catch (\Throwable $e) {
                return "Error creating storage link: " . $e->getMessage() . "<br>Manual Fix: Log in to Hostinger SSH and run:<br><code>ln -s " . $storagePath . " " . $publicPath . "</code>";
            }

        } catch (\Throwable $e) {
            return "General Error: " . $e->getMessage();
        }
    })->name('admin.storage.link');
});