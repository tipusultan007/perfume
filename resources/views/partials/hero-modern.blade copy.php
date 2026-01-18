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
        
        /* Dynamic Theme Classes */
        .ui-theme-dark .nav-dot.active { height: 48px; background: #000; }
        .ui-theme-dark #slide-count { color: #000; }
        .ui-theme-dark .ui-btn { background: #000; color: #fff; }
        .ui-theme-dark .ui-btn:hover { background: #333; }

        .ui-theme-light .nav-dot.active { height: 48px; background: #fff; }
        .ui-theme-light #slide-count { color: #fff; }
        .ui-theme-light .ui-btn { background: #fff; color: #000; }
        .ui-theme-light .ui-btn:hover { background: #f3f3f3; }

        @media (max-width: 768px) {
            .modern-slider-wrap { height: auto; min-height: 100vh; overflow: visible; }
            .slide { position: relative; padding: 80px 0; height: auto; min-height: 100vh; display: none; }
            .slide.active { display: flex; }
            .c-text-outline, .c-text-outline-dark { display: none; }
        }
        
    </style>
@endpush

<section class="modern-slider-wrap">

    <!-- UI Interaction Layer -->
    <div class="absolute inset-0 z-50 pointer-events-none ui-theme-dark" id="ui-overlay">
        <div class="max-w-7xl mx-auto h-full relative px-6">
            
            <!-- Social Icons (Bottom Left of Content) -->
            <div class="absolute left-6 bottom-12 flex gap-4 pointer-events-auto">
                <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" class="ui-btn w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="ri-facebook-fill text-lg"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" class="ui-btn w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="ri-instagram-line text-lg"></i>
                </a>
                <a href="{{ \App\Models\Setting::get('social_linkedin', '#') }}" target="_blank" class="ui-btn w-10 h-10 rounded-full flex items-center justify-center hover:scale-110 transition duration-300">
                    <i class="ri-linkedin-fill text-lg"></i>
                </a>
            </div>

            <!-- Side Navigation (Arrows Grouped - Now Bottom Right of Content) -->
            <div class="absolute right-6 bottom-12 flex gap-4 pointer-events-auto">
                <!-- Prev (Left visual) -->
                <button id="side-prev" onclick="prevSlide()" class="ui-btn w-14 h-14 rounded-full flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg cursor-pointer">
                     <i class="ri-arrow-left-line text-xl"></i>
                </button>
                <!-- Next (Right visual) -->
                <button id="side-next" onclick="nextSlide()" class="ui-btn w-14 h-14 rounded-full flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg cursor-pointer">
                    <i class="ri-arrow-right-line text-xl"></i>
                </button>
            </div>

        </div>

        <!-- Center Indicator (Dots & Counter - Vertically Centered on Right) -->
        <div class="absolute right-8 top-1/2 -translate-y-1/2 flex flex-col items-center pointer-events-auto" id="nav-dots">
            <span class="mb-4 text-[10px] tracking-widest rotate-90 w-4 h-4 block origin-center transform -translate-y-8" id="slide-count">01</span>
            <div class="flex flex-col items-center">
                <div class="nav-dot active" onclick="goToSlide(0)"></div>
                <div class="nav-dot" onclick="goToSlide(1)"></div>
                <div class="nav-dot" onclick="goToSlide(2)"></div>
            </div>
        </div>
    </div>

    <!-- Transition Overlay -->
    <div id="transition-bg" class="transition-circle bg-midnight-900"></div>

    <div class="relative w-full h-full">

        <!-- SLIDE 1: GOLDEN AMBER -->
        <div class="slide active bg-[#FDFCF8] text-gray-900" id="slide-0" data-bg="#FDFCF8" data-ui-theme="dark">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-[10%] -left-[10%] w-[40vw] h-[40vw] bg-[#F9F1D8] rounded-full blur-[100px] opacity-60"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 c-text-outline-dark">ROYALE</h1>
            </div>
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 w-full max-w-7xl mx-auto items-center px-6 gap-8 md:gap-0">
                <div class="col-span-1 md:col-span-4 space-y-6 slide-content order-2 md:order-1 text-center md:text-left">
                    <p class="text-gold-500 tracking-[0.4em] text-sm font-bold uppercase">No. 01</p>
                    <h2 class="text-4xl md:text-8xl font-serif">Golden<br class="hidden md:block">Amber</h2>
                    <p class="text-gray-500 font-light leading-relaxed max-w-xs mx-auto md:mx-0">Warm, resonant, and unmistakably elegant. Sun-drenched jasmine and Madagascar vanilla.</p>
                    <button onclick="nextSlide()" class="btn-next mt-[2rem] flex items-center gap-[2rem] group cursor-pointer justify-center md:justify-start mx-auto md:mx-0">
                        <div class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center group-hover:bg-black group-hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                        <span class="text-xs uppercase tracking-widest font-bold">Discover Next</span>
                    </button>
                </div>
                <div class="col-span-1 md:col-span-4 flex justify-center order-1 md:order-2">
                    <img src="{{ asset('images/demo-perfume.png') }}" class="h-[40vh] md:h-[75vh] object-contain bottle transform origin-bottom">
                </div>
                <div class="col-span-1 md:col-span-4 md:pl-[3rem] space-y-8 md:space-y-12 slide-content order-3 text-center md:text-left">
                    <div><h4 class="text-xs uppercase tracking-widest text-gray-400 mb-2">Top Notes</h4><p class="font-serif text-xl border-l-2 border-gold-500 pl-4 inline-block md:block">Bergamot &<br>White Peach</p></div>
                    <div class="md:text-right"><span class="text-4xl font-serif">$145</span></div>
                </div>
            </div>
        </div>

        <!-- SLIDE 2: MIDNIGHT RAIN -->
        <div class="slide bg-[#0D0F2E] text-white" id="slide-1" data-bg="#0D0F2E" data-ui-theme="light">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-0 right-0 w-[50vw] h-[50vw] bg-[#1A237E] rounded-full blur-[120px] opacity-40"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 c-text-outline">MYSTIQUE</h1>
            </div>
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 w-full max-w-7xl mx-auto items-center px-6 gap-8 md:gap-0">
                <div class="col-span-1 md:col-span-4 space-y-6 slide-content order-2 md:order-1 text-center md:text-left">
                    <p class="text-cyan-400 tracking-[0.4em] text-sm font-bold uppercase">No. 02</p>
                    <h2 class="text-4xl md:text-8xl font-serif">Midnight<br class="hidden md:block">Rain</h2>
                    <p class="text-gray-300 font-light leading-relaxed max-w-xs mx-auto md:mx-0">Cool, mysterious, and deeply refreshing. A blend of crisp mint, ozone, and silver birch.</p>
                     <button onclick="nextSlide()" class="btn-next mt-[2rem] flex items-center gap-[2rem] group cursor-pointer justify-center md:justify-start mx-auto md:mx-0">
                        <div class="w-12 h-12 rounded-full border border-white/30 flex items-center justify-center group-hover:bg-white group-hover:text-black transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                        <span class="text-xs uppercase tracking-widest font-bold">Discover Next</span>
                    </button>
                </div>
                <div class="col-span-1 md:col-span-4 flex justify-center order-1 md:order-2">
                    <img src="{{ asset('images/demo-perfume-2.png') }}" class="h-[40vh] md:h-[75vh] object-contain bottle transform origin-bottom">
                </div>
                <div class="col-span-1 md:col-span-4 md:pl-[3rem] space-y-8 md:space-y-12 slide-content order-3 text-center md:text-left">
                    <div><h4 class="text-xs uppercase tracking-widest text-gray-500 mb-2">Top Notes</h4><p class="font-serif text-xl border-l-2 border-cyan-400 pl-4 inline-block md:block">Mint Leaf &<br>Cool Ozone</p></div>
                    <div class="md:text-right"><span class="text-4xl font-serif">$165</span></div>
                </div>
            </div>
        </div>

        <!-- SLIDE 3: VELVET ROSE -->
        <div class="slide bg-[#FDF2F4] text-gray-900" id="slide-2" data-bg="#FDF2F4" data-ui-theme="dark">
             <div class="absolute inset-0 overflow-hidden">
                <div class="absolute bottom-0 left-0 w-[50vw] h-[50vw] bg-pink-300 rounded-full blur-[120px] opacity-40"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 c-text-outline-dark">PASSION</h1>
            </div>
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 w-full max-w-7xl mx-auto items-center px-6 gap-8 md:gap-0">
                <div class="col-span-1 md:col-span-4 space-y-6 slide-content order-2 md:order-1 text-center md:text-left">
                    <p class="text-rose-500 tracking-[0.4em] text-sm font-bold uppercase">No. 03</p>
                    <h2 class="text-4xl md:text-8xl font-serif">Velvet<br class="hidden md:block">Rose</h2>
                    <p class="text-gray-500 font-light leading-relaxed max-w-xs mx-auto md:mx-0">A romantic embrace of petals and spice. Damask rose meets the subtle heat of pink pepper.</p>
                     <button onclick="nextSlide()" class="btn-next mt-[2rem] flex items-center gap-[2rem] group cursor-pointer justify-center md:justify-start mx-auto md:mx-0">
                        <div class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center group-hover:bg-black group-hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                        <span class="text-xs uppercase tracking-widest font-bold">Discover Next</span>
                    </button>
                </div>
                <div class="col-span-1 md:col-span-4 flex justify-center order-1 md:order-2">
                    <img src="{{ asset('images/demo-perfume-3.png') }}" class="h-[40vh] md:h-[75vh] object-contain bottle transform origin-bottom">
                </div>
                <div class="col-span-1 md:col-span-4 md:pl-[3rem] space-y-8 md:space-y-12 slide-content order-3 text-center md:text-left">
                    <div><h4 class="text-xs uppercase tracking-widest text-gray-400 mb-2">Top Notes</h4><p class="font-serif text-xl border-l-2 border-rose-500 pl-4 inline-block md:block">Damask Rose &<br>Pink Pepper</p></div>
                    <div class="md:text-right"><span class="text-4xl font-serif">$155</span></div>
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentSlideIdx = 0;
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;
        let isAnimating = false;

        window.updateButtonStates = function(idx) {
            const sideNext = document.getElementById('side-next');
            const sidePrev = document.getElementById('side-prev');
            const inSlideNext = document.querySelectorAll('.btn-next');

            // Side Buttons
            if (sidePrev) {
                sidePrev.style.opacity = (idx === 0) ? "0.3" : "1";
                sidePrev.style.pointerEvents = (idx === 0) ? "none" : "auto";
            }
            if (sideNext) {
                sideNext.style.opacity = (idx === totalSlides - 1) ? "0.3" : "1";
                sideNext.style.pointerEvents = (idx === totalSlides - 1) ? "none" : "auto";
            }

            // In-slide "Discover Next" buttons
            inSlideNext.forEach(btn => {
                btn.style.opacity = (idx === totalSlides - 1) ? "0.3" : "1";
                btn.style.pointerEvents = (idx === totalSlides - 1) ? "none" : "auto";
            });
        }

        window.updateDots = function(idx) {
            document.querySelectorAll('.nav-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === idx);
            });
            const counter = document.getElementById('slide-count');
            if(counter) counter.innerText = `0${idx + 1}`;

            // Update UI Theme
            const currentSlide = document.getElementById(`slide-${idx}`);
            const theme = currentSlide.getAttribute('data-ui-theme');
            const overlay = document.getElementById('ui-overlay');
            if (overlay) {
                overlay.className = `absolute inset-0 z-50 pointer-events-none ui-theme-${theme}`;
            }
        }

        window.nextSlide = function() {
            if (currentSlideIdx >= totalSlides - 1) return;
            let nextIdx = currentSlideIdx + 1;
            goToSlide(nextIdx, 'next');
        }

        window.prevSlide = function() {
            if (currentSlideIdx <= 0) return;
            let prevIdx = currentSlideIdx - 1;
            goToSlide(prevIdx, 'prev');
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
                    
                    // Critical: Clear inline z-index/opacity so DOM order doesn't block older slides
                    gsap.set([currentSlideEl, nextSlideEl], { clearProps: "zIndex,opacity" });

                    currentSlideIdx = nextIdx;
                    updateDots(nextIdx);
                    updateButtonStates(nextIdx);
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

        updateButtonStates(0);
        gsap.from("#slide-0 .bottle", { y: 50, opacity: 0, duration: 1.5, ease: "power2.out" });
        gsap.from("#slide-0 .slide-content", { y: 20, opacity: 0, stagger: 0.2, duration: 1, delay: 0.5 });
    });
</script>
@endpush
