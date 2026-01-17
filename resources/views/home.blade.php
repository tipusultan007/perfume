@extends('layouts.store')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/frontend.css'])
    <style>
        /* Scoped adjustments to prevent homepage-v4 styles from breaking layouts.store navbar/footer */
        .site-header, .site-footer {
            /* Ensure old header/footer keep their expected behavior if theme.css overrides them */
            font-family: 'Inter', sans-serif !important;
        }
        
        /* Remove top padding from main since store layout might have different spacing needs */
        #navbar {
            position: fixed !important;
        }
        
        /* Prevent theme.css from overriding topbar/header height globally if possible */
        :root {
            --header-height: 80px; /* Adjust if needed for store layout */
        }
    </style>
@endsection

@section('content')

    <!-- Hero Section (Animated Slider) -->
    <section class="hero-section">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                <div class="swiper-slide hero-slide" style="background-image: url('{{ $slider->image_path }}');">
                    <div class="container ">
                        <div class="hero-content">
                            <h4 class="hero-subtitle">{{ $slider->subtitle }}</h4>
                            <h1 class="hero-title">{!! nl2br(e($slider->title)) !!}</h1>
                            <p class="hero-desc">{{ $slider->description }}</p>
                            @if($slider->button_text)
                            <a href="{{ $slider->button_link ?? '#' }}" class="btn-shop">{{ $slider->button_text }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!-- Navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="category-section section-padding">
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

    <!-- Promo Banners Section -->
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
    <section class="new-collection section-padding">
        <div class="container">
            <h2 class="section-title">Recent Arrivals</h2>

            <div class="swiper product-slider">
                <div class="swiper-wrapper">
                    @forelse($recentProducts as $product)
                    <div class="swiper-slide product-card">
                        <div class="product-thumb">
                            @if($product->base_price > 100)
                            <span class="badge sale">NEW</span>
                            @endif
                            <a href="{{ route('shop.product.show', $product->slug) }}">
                                <img src="{{ $product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400/F5F1EE/885a39?text=' . urlencode($product->name) }}"
                                    alt="{{ $product->name }}" class="main-img">
                            </a>
                            <div class="product-actions">
                                <button class="action-btn" onclick="addToWishlist({{ $product->id }})"><i class="fa-regular fa-heart"></i></button>
                                <button class="action-btn" onclick="openQuickView('{{ $product->slug }}')"><i class="fa-regular fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="product-info text-center">
                            <h3 class="product-title font-serif"><a href="{{ route('shop.product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div class="product-rating">
                                @for($i=0; $i<5; $i++)
                                <i class="fa-solid fa-star text-xs"></i>
                                @endfor
                            </div>
                            <div class="product-price">
                                <span class="price font-mono">${{ number_format($product->base_price, 2) }}</span>
                            </div>
                            <div class="product-action-btn mt-4">
                                <button class="btn-add-cart w-full" onclick="quickAdd({{ $product->id }})">Add To Cart</button>
                            </div>
                        </div>
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


    <!-- CTA Section -->
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

    <!-- Featured Collection -->
    <section class="featured-collection section-padding">
        <div class="container">
            <h2 class="section-title">Best Sellers</h2>
            <div class="swiper featured-slider">
                <div class="swiper-wrapper">
                    @forelse($bestSellers as $product)
                    <div class="swiper-slide product-card">
                        <div class="product-thumb">
                            @if($product->is_featured)
                            <span class="badge sale">BEST</span>
                            @endif
                            <a href="{{ route('shop.product.show', $product->slug) }}">
                                <img src="{{ $product->getFirstMediaUrl('featured') ?: 'https://placehold.co/400x400/F5F1EE/885a39?text=' . urlencode($product->name) }}"
                                    alt="{{ $product->name }}" class="main-img">
                            </a>
                            <div class="product-actions">
                                <button class="action-btn" onclick="addToWishlist({{ $product->id }})"><i class="fa-regular fa-heart"></i></button>
                                <button class="action-btn" onclick="openQuickView('{{ $product->slug }}')"><i class="fa-regular fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="product-info text-center">
                            <h3 class="product-title font-serif"><a href="{{ route('shop.product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                            <div class="product-rating">
                                @for($i=0; $i<5; $i++)
                                <i class="fa-solid fa-star text-xs"></i>
                                @endfor
                            </div>
                            <div class="product-price">
                                <span class="price font-mono">${{ number_format($product->base_price, 2) }}</span>
                            </div>
                            <div class="product-action-btn mt-4">
                                <button class="btn-add-cart w-full" onclick="quickAdd({{ $product->id }})">Add To Cart</button>
                            </div>
                        </div>
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
    </section>


    <!-- Testimonials Section -->
    <section class="testimonials-section section-padding">
        <div class="container">
            <h2 class="section-title">What Customer says About Us!</h2>
            <div class="swiper testimonials-slider">
                <div class="swiper-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide testimonial-card">
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
                    <div class="swiper-slide testimonial-card">
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
                    <div class="swiper-slide testimonial-card">
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
                    <div class="swiper-slide testimonial-card">
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
                    <div class="swiper-slide testimonial-card">
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

    <!-- Services Section -->
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

    <!-- Newsletter Section -->
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
                </div>
            </div>
        </div>
    </section>
@endsection
