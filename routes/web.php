<?php

use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;

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
Route::prefix('admin')->name('admin.')->group(function () {
    
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
        Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::resource('products', ProductController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('announcements', \App\Http\Controllers\Admin\AnnouncementController::class);
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);

        // Home Page Settings
        Route::get('/home-settings', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'index'])->name('home-settings.index');
        Route::post('/home-settings/hero', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateHero'])->name('home-settings.hero');
        Route::post('/home-settings/heritage', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateHeritage'])->name('home-settings.heritage');
        Route::post('/home-settings/curation', [\App\Http\Controllers\Admin\HomeSettingsController::class, 'updateCuration'])->name('home-settings.curation');

        // Tax & Settings
        Route::resource('taxes', \App\Http\Controllers\Admin\TaxController::class);
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Customers
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'show', 'destroy']);
        
        // Coupons
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);

        // Newsletter
        Route::post('/newsletter/{id}/send', [\App\Http\Controllers\Admin\NewsletterController::class, 'send'])->name('newsletter.send');
        Route::resource('newsletter', \App\Http\Controllers\Admin\NewsletterController::class);

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('index');
            Route::get('/sales', [\App\Http\Controllers\Admin\ReportController::class, 'sales'])->name('sales');
            Route::get('/products', [\App\Http\Controllers\Admin\ReportController::class, 'products'])->name('products');
            Route::get('/customers', [\App\Http\Controllers\Admin\ReportController::class, 'customers'])->name('customers');
        });

        // Contact Submissions
        Route::resource('contact-submissions', \App\Http\Controllers\Admin\ContactSubmissionController::class)->only(['index', 'show', 'destroy']);
    });
});

require __DIR__.'/auth.php';
