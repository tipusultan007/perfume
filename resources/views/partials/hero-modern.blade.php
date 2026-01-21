@if(isset($sliders) && $sliders->count() > 0)
@push('styles')
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Montserrat', sans-serif; }
        .modern-slider-wrap { position: relative; width: 100%; height: 100vh; height: 100svh; overflow: hidden; background: #000; }
        .slide { position: absolute; inset: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; opacity: 0; z-index: 0; pointer-events: none; }
        .slide.active { opacity: 1; z-index: 10; pointer-events: auto; }
        .c-text-outline { -webkit-text-stroke: 1px rgba(255,255,255,0.2); color: transparent; }
        .c-text-outline-dark { -webkit-text-stroke: 1px rgba(0,0,0,0.1); color: transparent; }
        .transition-circle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0); width: 150vmax; height: 150vmax; border-radius: 50%; z-index: 20; pointer-events: none; }
        .nav-dot { width: 3px; height: 24px; background: rgba(128,128,128,0.3); margin: 8px 0; transition: all 0.3s; cursor: pointer; }
        .nav-dot.active { height: 48px; }

        .ui-btn { transition: all 0.3s ease; }
        .ui-btn:hover { transform: scale(1.1); }

        @media (max-width: 768px) {
            .modern-slider-wrap { height: auto; min-height: 100vh; overflow: visible; }
            .slide { position: relative; padding: 100px 0 140px; height: auto; min-height: 100vh; display: none; }
            .slide.active { display: flex; }
            .c-text-outline, .c-text-outline-dark { display: none; }
        }

        @media (max-width: 430px) {
            .slide { padding-bottom: 160px; }
            .ui-btn { transform: scale(0.85); }
            .ui-btn:hover { transform: scale(0.95); }
            #dots-container { right: 4px; transform: scale(0.8) translateY(-50%); }
            
            /* Reduce typography slightly for ultra-mobile */
            .slide h2 { font-size: 3.5rem !important; }
            .slide p { font-size: 0.85rem !important; }
        }
    </style>
@endpush

<section class="modern-slider-wrap">

    <!-- UI Interaction Layer (Global Overlay) -->
    <div class="absolute inset-0 z-50 pointer-events-none" id="ui-overlay">
        <div class="max-w-7xl mx-auto h-full relative px-6">
            
            <!-- Social Icons (Bottom Left of Content) -->
            <div class="absolute left-6 bottom-12 flex gap-4 pointer-events-auto" id="social-container">
                <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" class="ui-btn w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="ri-facebook-fill text-lg"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" class="ui-btn w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="ri-instagram-line text-lg"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_linkedin', '#') }}" target="_blank" class="ui-btn w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="ri-linkedin-fill text-lg"></i>
                </a>
            </div>

            <!-- Side Navigation (Arrows Grouped - Now Bottom Right of Content) -->
            <div class="absolute right-6 bottom-12 flex gap-4 pointer-events-auto" id="nav-container">
                <!-- Prev -->
                <button id="side-prev" onclick="prevSlide()" class="ui-btn w-14 h-14 rounded-full flex items-center justify-center shadow-lg cursor-pointer">
                     <i class="ri-arrow-left-line text-xl"></i>
                </button>
                <!-- Next -->
                <button id="side-next" onclick="nextSlide()" class="ui-btn w-14 h-14 rounded-full flex items-center justify-center shadow-lg cursor-pointer">
                    <i class="ri-arrow-right-line text-xl"></i>
                </button>
            </div>

        </div>

        <!-- Center Indicator (Dots & Counter - Vertically Centered on Right) -->
        <div class="absolute right-8 top-1/2 -translate-y-1/2 flex flex-col items-center pointer-events-auto" id="dots-container">
            <span class="mb-4 text-[10px] tracking-widest rotate-90 w-4 h-4 block origin-center transform -translate-y-8" id="slide-count">01</span>
            <div class="flex flex-col items-center" id="nav-dots">
                @foreach($sliders as $index => $slider)
                    <div class="nav-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Transition Overlay -->
    <div id="transition-bg" class="transition-circle"></div>

    <div class="relative w-full h-full">

        @foreach($sliders as $index => $slider)
        <!-- SLIDE {{ $index + 1 }}: {{ $slider->title }} -->
        <div class="slide {{ $index === 0 ? 'active' : '' }}" 
             id="slide-{{ $index }}" 
             style="background-color: {{ $slider->bg_color }}; color: {{ $slider->title_color }};"
             data-bg="{{ $slider->bg_color }}" 
             data-ui-theme="{{ $slider->ui_theme }}"
             data-accent-color="{{ $slider->accent_color }}"
             data-social-color="{{ $slider->social_color }}"
             data-nav-color="{{ $slider->nav_color }}"
             data-line-color="{{ $slider->line_color }}"
             data-title-color="{{ $slider->title_color }}"
             data-desc-color="{{ $slider->description_color }}"
             data-price-color="{{ $slider->price_color }}">
            
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-[10%] -left-[10%] w-[40vw] h-[40vw] rounded-full blur-[100px] opacity-60" style="background-color: {{ $slider->accent_color }}; filter: blur(100px); opacity: 0.2;"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 {{ $slider->ui_theme === 'dark' ? 'c-text-outline-dark' : 'c-text-outline' }} uppercase tracking-tighter">
                    {{ Str::words($slider->title, 1, '') }}
                </h1>
            </div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 w-full max-w-7xl mx-auto items-center px-6 gap-8 md:gap-0">
                <div class="col-span-1 md:col-span-4 space-y-6 slide-content order-2 md:order-1 text-center md:text-left">
                    <p class="tracking-[0.4em] text-sm font-bold uppercase" style="color: {{ $slider->accent_color }}">No. 0{{ $index + 1 }}</p>
                    <h2 class="text-4xl md:text-8xl font-serif leading-[1.1]">{!! str_replace(' ', '<br class="hidden md:block">', $slider->title) !!}</h2>
                    <p class="font-light leading-relaxed max-w-xs mx-auto md:mx-0 opacity-80" style="color: {{ $slider->description_color }}">{{ $slider->description }}</p>
                    
                    @if($slider->button_text)
                    <a href="{{ $slider->button_link }}" class="btn-next mt-[2rem] flex items-center gap-[2rem] group cursor-pointer justify-center md:justify-start mx-auto md:mx-0">
                        <div class="w-12 h-12 rounded-full border flex items-center justify-center group-hover:bg-current transition-all duration-500" style="border-color: {{ $slider->accent_color }}; color: {{ $slider->accent_color }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                        <span class="text-xs uppercase tracking-widest font-bold" style="color: {{ $slider->title_color }}">{{ $slider->button_text }}</span>
                    </a>
                    @endif
                </div>

                <div class="col-span-1 md:col-span-4 flex justify-center order-1 md:order-2">
                    <img src="{{ $slider->getFirstMediaUrl('slider') }}" class="h-[40vh] md:h-[75vh] object-contain bottle transform origin-bottom">
                </div>

                <div class="col-span-1 md:col-span-4 md:pl-[3rem] space-y-8 md:space-y-12 slide-content order-3 text-center md:text-left">
                    @if($slider->top_notes)
                    <div>
                        <h4 class="text-xs uppercase tracking-widest opacity-40 mb-2">Top Notes</h4>
                        <p class="font-serif text-xl border-l-2 pl-4 inline-block md:block" style="border-color: {{ $slider->accent_color }}">
                            {!! str_replace('&', '&<br>', $slider->top_notes) !!}
                        </p>
                    </div>
                    @endif
                    
                    @if($slider->price)
                    <div class="md:text-right">
                        <span class="text-4xl font-serif" style="color: {{ $slider->price_color }}">{{ $slider->price }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentSlideIdx = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        let isAnimating = false;

        if (totalSlides === 0) return;

        window.updateUI = function(idx) {
            const slide = document.getElementById(`slide-${idx}`);
            if (!slide) return;
            const data = slide.dataset;

            // 1. Update Navigation Buttons
            const sideNext = document.getElementById('side-next');
            const sidePrev = document.getElementById('side-prev');
            
            [sideNext, sidePrev].forEach(btn => {
                if (btn) {
                    btn.style.backgroundColor = data.navColor;
                    btn.style.color = data.uiTheme === 'dark' ? '#ffffff' : '#000000';
                }
            });

            if (sidePrev) {
                sidePrev.style.opacity = (idx === 0) ? "0.3" : "1";
                sidePrev.style.pointerEvents = (idx === 0) ? "none" : "auto";
            }
            if (sideNext) {
                sideNext.style.opacity = (idx === totalSlides - 1) ? "0.3" : "1";
                sideNext.style.pointerEvents = (idx === totalSlides - 1) ? "none" : "auto";
            }

            // 2. Update Social Icons
            const socialLinks = document.querySelectorAll('#social-container a');
            socialLinks.forEach(link => {
                link.style.backgroundColor = data.socialColor;
                link.style.color = data.uiTheme === 'dark' ? '#ffffff' : '#000000';
            });

            // 3. Update Dots & Counter
            const dots = document.querySelectorAll('.nav-dot');
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === idx);
                dot.style.backgroundColor = (i === idx) ? data.lineColor : 'rgba(128,128,128,0.3)';
            });

            const counter = document.getElementById('slide-count');
            if(counter) {
                counter.innerText = `0${idx + 1}`;
                counter.style.color = data.lineColor;
            }

            // 4. Update Discover Next buttons in slides
            const inSlideNext = document.querySelectorAll('.btn-next');
            inSlideNext.forEach(btn => {
                btn.style.opacity = (idx === totalSlides - 1) ? "0.3" : "1";
                btn.style.pointerEvents = (idx === totalSlides - 1) ? "none" : "auto";
            });
        }

        window.nextSlide = function() {
            if (currentSlideIdx >= totalSlides - 1) return;
            goToSlide(currentSlideIdx + 1, 'next');
        }

        window.prevSlide = function() {
            if (currentSlideIdx <= 0) return;
            goToSlide(currentSlideIdx - 1, 'prev');
        }

        window.goToSlide = function(nextIdx, direction = 'next') {
            if (isAnimating || nextIdx === currentSlideIdx) return;
            isAnimating = true;

            const currentSlideEl = document.getElementById(`slide-${currentSlideIdx}`);
            const nextSlideEl = document.getElementById(`slide-${nextIdx}`);
            const nextBgColor = nextSlideEl.getAttribute('data-bg');

            const tl = gsap.timeline({
                onComplete: () => {
                    currentSlideEl.classList.remove('active');
                    nextSlideEl.classList.add('active');
                    gsap.set([currentSlideEl, nextSlideEl], { clearProps: "zIndex,opacity" });
                    currentSlideIdx = nextIdx;
                    updateUI(nextIdx);
                    isAnimating = false;
                    gsap.set("#transition-bg", { scale: 0 });
                }
            });

            tl.to(currentSlideEl.querySelectorAll('.bottle'), { y: -100, opacity: 0, rotation: -10, duration: 0.8, ease: "power2.in" }, 0);
            tl.to(currentSlideEl.querySelectorAll('.slide-content'), { y: -50, opacity: 0, stagger: 0.1, duration: 0.6 }, 0);

            tl.set("#transition-bg", { backgroundColor: nextBgColor }, 0.2);
            tl.to("#transition-bg", { scale: 1, duration: 1, ease: "circ.inOut" }, 0.2);

            tl.set(nextSlideEl, { zIndex: 20, opacity: 1 }, 0.5); 
            
            tl.fromTo(nextSlideEl.querySelectorAll('.bottle'), 
                { y: 200, opacity: 0, rotation: 10, scale: 0.8 },
                { y: 0, opacity: 1, rotation: 0, scale: 1, duration: 1.2, ease: "back.out(1.2)" }, 0.6
            );

            tl.fromTo(nextSlideEl.querySelectorAll('.slide-content'),
                { y: 50, opacity: 0 },
                { y: 0, opacity: 1, stagger: 0.1, duration: 0.8 }, 0.8
            );
        }

        // Initial setup
        updateUI(0);
        gsap.from("#slide-0 .bottle", { y: 50, opacity: 0, duration: 1.5, ease: "power2.out" });
        gsap.from("#slide-0 .slide-content", { y: 20, opacity: 0, stagger: 0.2, duration: 1, delay: 0.5 });
    });
</script>
@endpush
@endif
