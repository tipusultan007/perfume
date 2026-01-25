@extends('layouts.store')

@section('styles')
    @vite(['resources/css/frontend.css'])
    <style>
        /* Scoped adjustments to prevent homepage-v4 styles from breaking layouts.store navbar/footer */
        .site-header, .site-footer {
            /* Ensure old header/footer keep their expected behavior if theme.css overrides them */
            font-family: 'Montserrat', sans-serif !important;
        }
        
        /* Remove top padding from main since store layout might have different spacing needs */
        #navbar {
            position: fixed !important;
        }
        
        /* Redesigned Banner Styles (150-200px) */
        .lux-banner {
            position: relative;
            height: 180px;
            overflow: hidden;
            border-radius: 8px;
            margin: 30px 0;
            background: #000;
            display: flex;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .banner-bg-img {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            opacity: 0.6;
            transition: transform 10s linear;
            z-index: 1;
        }
        
        .lux-banner:hover .banner-bg-img {
            transform: scale(1.15);
        }
        
        .banner-shimmer {
            position: absolute;
            top: 0; left: -100%; width: 50%; height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);
            transform: skewX(-25deg);
            animation: shimmer-anim 4s infinite;
            z-index: 2;
        }
        
        @keyframes shimmer-anim {
            0% { left: -100%; }
            50% { left: 150%; }
            100% { left: 150%; }
        }

        .banner-content-lux {
            position: relative;
            z-index: 3;
            width: 100%;
            padding: 0 40px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            color: #fff;
        }
        
        .banner-text-group {
            text-align: right;
            animation: slide-in-right 1s ease-out;
        }
        
        @keyframes slide-in-right {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .banner-title-lux-v2 {
            font-family: var(--font-primary);
            font-size: 2.2rem;
            color: #fff;
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .banner-desc-lux {
            display: flex;
            align-items: center;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn-pill-lux {
            border: 1px solid rgba(255,255,255,0.8);
            padding: 4px 20px;
            border-radius: 50px;
            font-size: 0.85rem;
            background: rgba(0,0,0,0.3);
            color: #fff;
            backdrop-filter: blur(5px);
            transition: all 0.3s;
        }
        
        .btn-pill-lux:hover {
            background: #fff;
            color: #000;
        }

        .banner-tagline {
            font-size: 1.1rem;
            opacity: 0.9;
            font-family: var(--font-secondary);
        }

        @media (max-width: 991px) {
            .banner-title-lux-v2 { font-size: 1.8rem; }
        }

        @media (max-width: 768px) {
            .lux-banner { height: 160px; margin: 20px 0; }
            .banner-title-lux-v2 { font-size: 1.4rem; margin-bottom: 5px; }
            .banner-tagline { font-size: 0.85rem; }
            .banner-content-lux { padding: 0 25px; }
            .btn-pill-lux { padding: 3px 15px; font-size: 0.75rem; }
        }

        @media (max-width: 480px) {
            .lux-banner { height: auto; min-height: 140px; padding: 20px 0; }
            .banner-content-lux { justify-content: center; text-align: center; }
            .banner-text-group { text-align: center; }
            .banner-desc-lux { justify-content: center; flex-direction: column; gap: 8px; }
            .banner-title-lux-v2 { font-size: 1.2rem; }
        }
    </style>
@endsection

@section('content')

    <!-- Hero Section (Animated Slider) -->
    @if(\App\Models\Setting::get('home_show_hero', 1))
    @if(isset($heroStyle) && $heroStyle === 'modern')
        @include('partials.hero-modern')
    @else
        <section class="hero-section">
            <div class="swiper hero-swiper">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                        <div class="swiper-slide hero-slide" style="background-image: url('{{ asset('storage/' . $slider->image_path) }}');">
                            <div class="container hero-content">
                                <span class="hero-subtitle">{{ $slider->subtitle }}</span>
                                <h1 class="hero-title">{{ $slider->title }}</h1>
                                <p class="hero-description">{{ $slider->description }}</p>
                                @if($slider->button_text)
                                    <a href="{{ $slider->button_link }}" class="btn-hero">{{ $slider->button_text }}</a>
                                @endif
                            </div>
                            <div class="hero-overlay"></div>
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
    @endif
    @endif

    <!-- Category Section -->
    @if(\App\Models\Setting::get('home_show_categories', 1))
    <section class="category-section section-padding bg-accent-soft">
        <div class="container">
            <h2 class="section-title">New Collection</h2>
            <div class="swiper category-slider">
                <div class="swiper-wrapper">
                    <!-- Cat 1 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-2.jpg"
                                    alt="Citrus Perfume"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Citrus Perfume</a></h3>
                    </div>
                    <!-- Cat 2 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-5.jpg"
                                    alt="Lemon"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Lemon</a></h3>
                    </div>
                    <!-- Cat 3 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-6.jpg"
                                    alt="Orange"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Orange</a></h3>
                    </div>
                    <!-- Cat 4 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-4.jpg"
                                    alt="Scents"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Scents</a></h3>
                    </div>
                    <!-- Cat 5 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-1.jpg"
                                    alt="Bertrand"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Bertrand</a></h3>
                    </div>
                    <!-- Cat 6 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-4.jpg"
                                    alt="Eau de Toilette"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Eau de Toilette</a></h3>
                    </div>
                    <!-- Cat 7 -->
                    <div class="swiper-slide category-item">
                        <div class="cat-thumb">
                            <a href="#"><img
                                    src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/categories-3.jpg"
                                    alt="Duchaufour"></a>
                        </div>
                        <h3 class="cat-title"><a href="#">Duchaufour</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Promo Banners Section -->
    @if(\App\Models\Setting::get('home_show_promo_banners', 1))
    <section class="promo-banners">
        <div class="container banner-grid">
            <!-- Banner 1 -->
            <div class="promo-banner">
                <img src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/banner-1.jpg"
                    alt="Banner 1">
                <div class="banner-content">
                    <p class="promo-text">35% off all items!</p>
                    <h2 class="banner-title">Maybe You ‘ve<br>Earned It</h2>
                    <a href="#" class="btn-shop-now">Shop Now</a>
                </div>
            </div>
            <!-- Banner 2 -->
            <div class="promo-banner">
                <img src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/banner-2.jpg"
                    alt="Banner 2">
                <div class="banner-content">
                    <p class="promo-text">35% off all items!</p>
                    <h2 class="banner-title">Maybe You ‘ve<br>Earned It</h2>
                    <a href="#" class="btn-shop-now">Shop Now</a>
                </div>
            </div>
            <!-- Banner 3 -->
            <div class="promo-banner">
                <img src="https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/banner-3.jpg"
                    alt="Banner 3">
                <div class="banner-content">
                    <p class="promo-text">35% off all items!</p>
                    <h2 class="banner-title">Maybe You ‘ve<br>Earned It</h2>
                    <a href="#" class="btn-shop-now">Shop Now</a>
                </div>
            </div>
        </div>
    </section>
    @endif

      <!-- Banner 2: Signature Scents -->
    @if(\App\Models\Setting::get('home_show_banner_signature', 1))
    <div class="container">
        <div class="lux-banner">
            <img src="{{ asset('images/banners/wide_2.png') }}" alt="" class="banner-bg-img">
            <div class="banner-shimmer"></div>
            <div class="banner-content-lux">
                <div class="banner-text-group">
                    <h2 class="banner-title-lux-v2">Signature Scents</h2>
                    <div class="banner-desc-lux">
                        <span class="btn-pill-lux">Free Shipping</span>
                        <span class="banner-tagline">Excellence in every single drop.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(\App\Models\Setting::get('home_show_recent_arrivals', 1))
    <section class="new-collection section-padding">
        <div class="container">
            <h2 class="section-title">Recent Arrivals</h2>

            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @forelse($recentProducts as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" :badge="$product->base_price > 100 ? 'NEW' : null" />
                    </div>
                    @empty
                    <div class="swiper-slide text-center py-20">
                        <p class="opacity-50">No recent arrivals found.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif


    <!-- CTA Section -->
    @if(\App\Models\Setting::get('home_show_cta', 1))
    <section class="cta-section"
        style="background-image: url('https://wordpressthemes.live/WCM9/WCM204_purfemos/default/wp-content/uploads/2024/09/CMS-banner-2.1.jpg');">
        <div class="container">
            <div class="cta-content">
                <h1 class="cta-title">Become More Confident &amp;<br>Show your Better Self</h1>
                <p class="cta-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br> Aenean commodo
                    ligula eget dolor. Aenean massa.</p>
                <a href="#" class="btn-read-more">Read More</a>
            </div>
        </div>
    </section>
    @endif

    {{-- <!-- Featured Collection -->
    <section class="featured-collection section-padding">
        <div class="container">
            <h2 class="section-title">Best Sellers</h2>
            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @forelse($bestSellers as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" :badge="$product->is_featured ? 'BEST' : null" />
                    </div>
                    @empty
                    <div class="swiper-slide text-center py-20">
                        <p class="opacity-50">No best sellers found.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section> --}}

    <!-- Featured Highlights -->
    @if(\App\Models\Setting::get('home_show_featured', 1))
    <section class="featured-highlights section-padding">
        <div class="container">
            <h2 class="section-title">Featured Highlights</h2>
            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @forelse($featuredProducts as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" :badge="'FEATURED'" />
                    </div>
                    @empty
                    <div class="swiper-slide text-center py-20">
                        <p class="opacity-50">No featured highlights found.</p>
                    </div>
                    @endforelse
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif

    <!-- Banner 3: Seasonal Picks -->
    @if(\App\Models\Setting::get('home_show_banner_seasonal', 1))
    <div class="container">
        <div class="lux-banner">
            <img src="{{ asset('images/banners/wide_3.png') }}" alt="" class="banner-bg-img">
            <div class="banner-shimmer"></div>
            <div class="banner-content-lux">
                <div class="banner-text-group">
                    <h2 class="banner-title-lux-v2">Seasonal Picks</h2>
                    <div class="banner-desc-lux">
                        <span class="btn-pill-lux">Limited Edition</span>
                        <span class="banner-tagline">Captured for the cooling breeze.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Special Offers -->
    @if(\App\Models\Setting::get('home_show_special_offers', 1))
    <section class="special-offers section-padding">
        <div class="container">
            <h2 class="section-title">Special Offers</h2>
            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @forelse($onSaleProducts as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" :badge="'SALE'" />
                    </div>
                    @empty
                    <div class="swiper-slide text-center py-20">
                        <p class="opacity-50">No special offers found.</p>
                    </div>
                    @endforelse
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif

    <!-- Banner 4: Exclusive Engraving -->
    @if(\App\Models\Setting::get('home_show_banner_engraving', 1))
    <div class="container">
        <div class="lux-banner">
            <img src="{{ asset('images/banners/wide_4.png') }}" alt="" class="banner-bg-img">
            <div class="banner-shimmer"></div>
            <div class="banner-content-lux">
                <div class="banner-text-group">
                    <h2 class="banner-title-lux-v2">Exclusive Engraving</h2>
                    <div class="banner-desc-lux">
                        <span class="btn-pill-lux">Claim Offer</span>
                        <span class="banner-tagline">Make your gift truly unforgettable.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Limited Remaining -->
    @if(\App\Models\Setting::get('home_show_clearance', 1))
    <section class="limited-remaining section-padding">
        <div class="container">
            <h2 class="section-title">Limited Remaining</h2>
            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @forelse($clearanceProducts as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" :badge="'CLEARANCE'" />
                    </div>
                    @empty
                    <div class="swiper-slide text-center py-20">
                        <p class="opacity-50">No clearance items found.</p>
                    </div>
                    @endforelse
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif

    <!-- Banner 5: Final Call -->
    @if(\App\Models\Setting::get('home_show_banner_final', 1))
    <div class="container">
        <div class="lux-banner">
            <img src="{{ asset('images/banners/wide_5.png') }}" alt="" class="banner-bg-img">
            <div class="banner-shimmer"></div>
            <div class="banner-content-lux">
                <div class="banner-text-group">
                    <h2 class="banner-title-lux-v2">Final Call</h2>
                    <div class="banner-desc-lux">
                        <span class="btn-pill-lux">Up to 40% Off</span>
                        <span class="banner-tagline">Secure your favorites before they're gone.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif


    <!-- Testimonials Section -->
    @if(\App\Models\Setting::get('home_show_testimonials', 1))
    <section class="testimonials-section section-padding">
        <div class="container">
            <h2 class="section-title">What Customer says About Us!</h2>
            <div class="swiper testimonials-slider">
                <div class="swiper-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide testimonial-card bg-accent-soft">
                        <div class="testimonial-content">
                            <h3 class="testimonial-heading">Great Product!</h3>
                            <div class="quote-icon">
                                <i class="fa-solid fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                I wanted to take a moment to express my gratitude for the outstanding job. It's rare
                                to find such a dedicated team.
                            </p>
                            <div class="testimonial-author">
                                <span class="author-name">Alison Wood</span>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="swiper-slide testimonial-card bg-accent-soft">
                        <div class="testimonial-content">
                            <h3 class="testimonial-heading">Great Product!</h3>
                            <div class="quote-icon">
                                <i class="fa-solid fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                I wanted to take a moment to express my gratitude for the outstanding job. It's rare
                                to find such a dedicated team.
                            </p>
                            <div class="testimonial-author">
                                <span class="author-name">Alison Wood</span>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="swiper-slide testimonial-card bg-accent-soft">
                        <div class="testimonial-content">
                            <h3 class="testimonial-heading">Great Product!</h3>
                            <div class="quote-icon">
                                <i class="fa-solid fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                I wanted to take a moment to express my gratitude for the outstanding job. It's rare
                                to find such a dedicated team.
                            </p>
                            <div class="testimonial-author">
                                <span class="author-name">Alison Wood</span>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 4 -->
                    <div class="swiper-slide testimonial-card bg-accent-soft">
                        <div class="testimonial-content">
                            <h3 class="testimonial-heading">Great Product!</h3>
                            <div class="quote-icon">
                                <i class="fa-solid fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                I wanted to take a moment to express my gratitude for the outstanding job. It's rare
                                to find such a dedicated team.
                            </p>
                            <div class="testimonial-author">
                                <span class="author-name">Alison Wood</span>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 5 -->
                    <div class="swiper-slide testimonial-card bg-accent-soft">
                        <div class="testimonial-content">
                            <h3 class="testimonial-heading">Great Product!</h3>
                            <div class="quote-icon">
                                <i class="fa-solid fa-quote-left"></i>
                            </div>
                            <p class="testimonial-text">
                                I wanted to take a moment to express my gratitude for the outstanding job. It's rare
                                to find such a dedicated team.
                            </p>
                            <div class="testimonial-author">
                                <span class="author-name">Alison Wood</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    @endif
 <!-- Banner 1: Elite Collection -->
    @if(\App\Models\Setting::get('home_show_banner_elite', 1))
    <div class="container">
        <div class="lux-banner">
            <img src="{{ asset('images/banners/wide_1.png') }}" alt="" class="banner-bg-img">
            <div class="banner-shimmer"></div>
            <div class="banner-content-lux">
                <div class="banner-text-group">
                    <h2 class="banner-title-lux-v2">Elite Collection</h2>
                    <div class="banner-desc-lux">
                        <span class="btn-pill-lux">20% Off Storewide</span>
                        <span class="banner-tagline">Crafted with Passion & Precision.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Services Section -->
    @if(\App\Models\Setting::get('home_show_services', 1))
    <section class="services-section section-padding">
        <div class="container">
            <div class="services-grid">
                <!-- Service 1 -->
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">Free Shipping</h4>
                        <p class="service-desc">Free Shipping for orders over $199</p>
                    </div>
                </div>
                <!-- Service 2 -->
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa-solid fa-rotate-left"></i>
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">Return Policy</h4>
                        <p class="service-desc">Within 30 days for an exchange</p>
                    </div>
                </div>
                <!-- Service 3 -->
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">Online Support</h4>
                        <p class="service-desc">24 hours a day, 7 days a week</p>
                    </div>
                </div>
                <!-- Service 4 -->
                <div class="service-item">
                    <div class="service-icon">
                        <i class="fa-regular fa-credit-card"></i>
                    </div>
                    <div class="service-content">
                        <h4 class="service-title">Flexible Payment</h4>
                        <p class="service-desc">Pay with Multiple Credit cards</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    @if(\App\Models\Setting::get('home_show_newsletter', 1))
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-wrapper">
                <div class="newsletter-text">
                    <p class="sub-heading">Our Newsletter</p>
                    <h2 class="heading">Join Our Newsletter</h2>
                </div>
                <div class="newsletter-form-container">
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form" id="newsletterForm">
                        @csrf
                        <div class="input-group">
                            <input type="email" name="email" id="newsletterEmail" placeholder="Your Email Here" required>
                            <button type="submit" class="btn-submit" id="newsletterSubmitBtn">Submit</button>
                        </div>
                        <div id="newsletterMessage" style="margin-top: 10px; font-size: 14px; display: none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @endif

    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('newsletterEmail').value;
            const btn = document.getElementById('newsletterSubmitBtn');
            const msg = document.getElementById('newsletterMessage');
            const form = this;

            // Basic UI State
            btn.disabled = true;
            btn.innerText = 'Sending...';
            msg.style.display = 'none';
            msg.className = ''; // Reset classes

            fetch('{{ route("newsletter.subscribe") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerText = 'Submit';
                
                msg.style.display = 'block';
                msg.innerText = data.message;

                if (data.status === 'success') {
                    msg.style.color = 'green';
                    form.reset();
                } else {
                    msg.style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerText = 'Submit';
                msg.style.display = 'block';
                msg.innerText = 'Something went wrong. Please try again.';
                msg.style.color = 'red';
            });
        });
    </script>
@endsection
