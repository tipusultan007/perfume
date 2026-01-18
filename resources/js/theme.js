
document.addEventListener('DOMContentLoaded', () => {
    const cartOpen = document.getElementById('cart-open');
    const cartClose = document.getElementById('cart-close');
    const cartDrawer = document.getElementById('cart-drawer');
    const cartOverlay = document.getElementById('cart-overlay');

    // Cart Toggle
    const toggleCart = () => {
        cartDrawer.classList.toggle('active');
        cartOverlay.classList.toggle('active');
        document.body.style.overflow = cartDrawer.classList.contains('active') ? 'hidden' : '';
    };

    if (cartOpen) cartOpen.addEventListener('click', toggleCart);
    if (cartClose) cartClose.addEventListener('click', toggleCart);
    if (cartOverlay) cartOverlay.addEventListener('click', toggleCart);

    // Mobile Menu Toggle
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-open');
    const mobileMenu = document.getElementById('mobile-nav-drawer');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuOverlay = document.getElementById('mobile-overlay');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            mobileMenuOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        const closeMenu = () => {
            mobileMenu.classList.remove('active');
            mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        mobileMenuClose.addEventListener('click', closeMenu);
        mobileMenuOverlay.addEventListener('click', closeMenu);
    }

    // Hero Slider (Animated)
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            speed: 1000,
            navigation: {
                nextEl: '.hero-swiper .swiper-button-next',
                prevEl: '.hero-swiper .swiper-button-prev',
            },
            pagination: {
                el: '.hero-swiper .swiper-pagination',
                clickable: true,
            },
        });
    }

    // Product Slider Initialization
    if (document.querySelector('.product-slider')) {
        const productSlider = new Swiper('.product-slider', {
            slidesPerView: 2,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                }
            }
        });
    }

    // Category Slider
    if (document.querySelector('.category-slider')) {
        new Swiper('.category-slider', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: false,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 30,
                },
            },
        });
    }

    // Featured Slider
    if (document.querySelector('.featured-slider')) {
        new Swiper('.featured-slider', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.featured-slider .swiper-button-next',
                prevEl: '.featured-slider .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1200: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                }
            }
        });
    }

    // Testimonials Slider
    if (document.querySelector('.testimonials-slider')) {
        new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.testimonials-slider .swiper-button-next',
                prevEl: '.testimonials-slider .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                }
            }
        });
    }

});

// Global Helper Functions
window.addToWishlist = function (productId) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ product_id: productId })
    })
        .then(response => {
            if (response.status === 401) {
                toastr.error('Please login to add items to your wishlist');
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.status) {
                // Find all buttons for this product
                const buttons = document.querySelectorAll(`.wishlist-btn-${productId} i`);
                buttons.forEach(icon => {
                    if (data.status === 'added') {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                });
                // Update counter if exists
                const wishlistCounts = document.querySelectorAll('.wishlist-count-display');
                wishlistCounts.forEach(el => el.innerText = data.count);
            }
        })
        .catch(error => console.error('Error:', error));
};

