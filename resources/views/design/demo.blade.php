<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scent of Elegance - Infinite Collection</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,800;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Montserrat"', 'sans-serif'],
                    },
                    colors: {
                        gold: { 100: '#F9F1D8', 300: '#EAD49B', 500: '#D4AF37' },
                        midnight: { 500: '#1A237E', 900: '#0D0F2E' },
                        rose: { 100: '#FDF2F4', 300: '#F48FB1', 500: '#EC407A', 900: '#880E4F' },
                    }
                }
            }
        }
    </script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        body { margin: 0; overflow: hidden; background: #000; }
        .slide { position: absolute; inset: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; opacity: 0; z-index: 0; pointer-events: none; }
        .slide.active { opacity: 1; z-index: 10; pointer-events: auto; }
        .c-text-outline { -webkit-text-stroke: 1px rgba(255,255,255,0.2); color: transparent; }
        .c-text-outline-dark { -webkit-text-stroke: 1px rgba(0,0,0,0.1); color: transparent; }
        .transition-circle { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0); width: 150vmax; height: 150vmax; border-radius: 50%; z-index: 20; pointer-events: none; }
        .nav-dot { width: 3px; height: 24px; background: rgba(0,0,0,0.3); margin: 8px 0; transition: all 0.3s; cursor: pointer; }
        .nav-dot.active { height: 48px; background: currentColor; }
    </style>
</head>
<body class="text-gray-900 transition-colors duration-500" id="body-theme">

    <!-- Navigation Top -->
    <nav class="fixed w-full z-50 top-0 left-0 p-8 flex justify-between items-center mix-blend-difference text-white">
        <div class="text-2xl font-serif font-bold tracking-widest uppercase">Lumière</div>
        <div class="hidden md:flex space-x-12 text-xs tracking-[0.2em] font-medium">
            <a href="#" class="hover:opacity-70 transition">COLLECTION</a>
            <a href="#" class="hover:opacity-70 transition">STORY</a>
        </div>
        <button class="border border-white/50 px-8 py-3 rounded-full hover:bg-white hover:text-black transition duration-300 text-xs tracking-widest uppercase">
            Shop Series
        </button>
    </nav>

    <!-- Side Navigation (Arrows Grouped) -->
    <div class="fixed right-12 top-1/2 -translate-y-1/2 z-50 flex flex-col gap-6 mix-blend-difference">
        <!-- Next (Up/Forward visual) -->
        <button onclick="nextSlide()" class="w-16 h-16 rounded-full bg-white text-black flex items-center justify-center hover:scale-110 transition duration-300 shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
        <!-- Prev (Down/Back visual) -->
        <button onclick="prevSlide()" class="w-16 h-16 rounded-full border border-white text-white flex items-center justify-center hover:bg-white hover:text-black transition duration-300">
             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>
    </div>

    <!-- Side Navigation (Dots - Adjusted Position) -->
    <div class="fixed right-8 bottom-12 z-50 flex flex-col items-center mix-blend-difference text-white" id="nav-dots">
        <div class="nav-dot active" onclick="goToSlide(0)"></div>
        <div class="nav-dot" onclick="goToSlide(1)"></div>
        <div class="nav-dot" onclick="goToSlide(2)"></div>
        <span class="mt-4 text-[10px] tracking-widest rotate-90 w-4 h-4 block origin-center transform translate-y-8" id="slide-count">01</span>
    </div>

    <!-- Transition Overlay -->
    <div id="transition-bg" class="transition-circle bg-midnight-900"></div>

    <main class="relative w-full h-screen">

        <!-- SLIDE 1: GOLDEN AMBER -->
        <div class="slide active bg-[#FDFCF8] text-gray-900" id="slide-0" data-bg="#FDFCF8" data-dot-color="bg-black">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-[10%] -left-[10%] w-[40vw] h-[40vw] bg-[#F9F1D8] rounded-full blur-[100px] opacity-60"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 c-text-outline-dark">ROYALE</h1>
            </div>
            <div class="relative z-10 grid grid-cols-12 w-full max-w-7xl mx-auto items-center px-6">
                <div class="col-span-4 space-y-6 slide-content">
                    <p class="text-gold-500 tracking-[0.4em] text-sm font-bold uppercase">No. 01</p>
                    <h2 class="text-6xl md:text-8xl font-serif">Golden<br>Amber</h2>
                    <p class="text-gray-500 font-light leading-relaxed max-w-xs">Warm, resonant, and unmistakably elegant. Sun-drenched jasmine and Madagascar vanilla.</p>
                    <button onclick="nextSlide()" class="btn-next mt-8 flex items-center space-x-4 group cursor-pointer">
                        <div class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center group-hover:bg-black group-hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                        <span class="text-xs uppercase tracking-widest font-bold">Discover Next</span>
                    </button>
                </div>
                <div class="col-span-4 flex justify-center"><img src="{{ asset('images/demo-perfume.png') }}" class="h-[75vh] object-contain bottle transform origin-bottom"></div>
                <div class="col-span-4 pl-12 space-y-12 slide-content">
                    <div><h4 class="text-xs uppercase tracking-widest text-gray-400 mb-2">Top Notes</h4><p class="font-serif text-xl border-l-2 border-gold-500 pl-4">Bergamot &<br>White Peach</p></div>
                    <div class="text-right"><span class="text-4xl font-serif">$145</span></div>
                </div>
            </div>
        </div>

        <!-- SLIDE 2: MIDNIGHT RAIN -->
        <div class="slide bg-[#0D0F2E] text-white" id="slide-1" data-bg="#0D0F2E" data-dot-color="bg-white">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-0 right-0 w-[50vw] h-[50vw] bg-[#1A237E] rounded-full blur-[120px] opacity-40"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 c-text-outline">MYSTIQUE</h1>
            </div>
            <div class="relative z-10 grid grid-cols-12 w-full max-w-7xl mx-auto items-center px-6">
                <div class="col-span-4 space-y-6 slide-content">
                    <p class="text-cyan-400 tracking-[0.4em] text-sm font-bold uppercase">No. 02</p>
                    <h2 class="text-6xl md:text-8xl font-serif">Midnight<br>Rain</h2>
                    <p class="text-gray-300 font-light leading-relaxed max-w-xs">Cool, mysterious, and deeply refreshing. A blend of crisp mint, ozone, and silver birch.</p>
                     <button onclick="nextSlide()" class="btn-next mt-8 flex items-center space-x-4 group cursor-pointer">
                        <div class="w-12 h-12 rounded-full border border-white/30 flex items-center justify-center group-hover:bg-white group-hover:text-black transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                        <span class="text-xs uppercase tracking-widest font-bold">Discover Next</span>
                    </button>
                </div>
                <div class="col-span-4 flex justify-center"><img src="{{ asset('images/demo-perfume-2.png') }}" class="h-[75vh] object-contain bottle transform origin-bottom"></div>
                <div class="col-span-4 pl-12 space-y-12 slide-content">
                    <div><h4 class="text-xs uppercase tracking-widest text-gray-500 mb-2">Top Notes</h4><p class="font-serif text-xl border-l-2 border-cyan-400 pl-4">Mint Leaf &<br>Cool Ozone</p></div>
                    <div class="text-right"><span class="text-4xl font-serif">$165</span></div>
                </div>
            </div>
        </div>

        <!-- SLIDE 3: VELVET ROSE -->
        <div class="slide bg-[#FDF2F4] text-gray-900" id="slide-2" data-bg="#FDF2F4" data-dot-color="bg-black">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute bottom-0 left-0 w-[50vw] h-[50vw] bg-pink-300 rounded-full blur-[120px] opacity-40"></div>
                <h1 class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[18vw] font-serif font-bold leading-none select-none opacity-5 c-text-outline-dark">PASSION</h1>
            </div>
            <div class="relative z-10 grid grid-cols-12 w-full max-w-7xl mx-auto items-center px-6">
                <div class="col-span-4 space-y-6 slide-content">
                    <p class="text-rose-500 tracking-[0.4em] text-sm font-bold uppercase">No. 03</p>
                    <h2 class="text-6xl md:text-8xl font-serif">Velvet<br>Rose</h2>
                    <p class="text-gray-500 font-light leading-relaxed max-w-xs">A romantic embrace of petals and spice. Damask rose meets the subtle heat of pink pepper.</p>
                     <button onclick="nextSlide()" class="btn-next mt-8 flex items-center space-x-4 group cursor-pointer">
                        <div class="w-12 h-12 rounded-full border border-gray-300 flex items-center justify-center group-hover:bg-black group-hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></div>
                        <span class="text-xs uppercase tracking-widest font-bold">Discover Next</span>
                    </button>
                </div>
                <div class="col-span-4 flex justify-center"><img src="{{ asset('images/demo-perfume-3.png') }}" class="h-[75vh] object-contain bottle transform origin-bottom"></div>
                <div class="col-span-4 pl-12 space-y-12 slide-content">
                    <div><h4 class="text-xs uppercase tracking-widest text-gray-400 mb-2">Top Notes</h4><p class="font-serif text-xl border-l-2 border-rose-500 pl-4">Damask Rose &<br>Pink Pepper</p></div>
                    <div class="text-right"><span class="text-4xl font-serif">$155</span></div>
                </div>
            </div>
        </div>

    </main>

    <script>
        let currentSlideIdx = 0;
        const totalSlides = 3;
        let isAnimating = false;

        function updateDots(idx) {
            document.querySelectorAll('.nav-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === idx);
            });
            document.getElementById('slide-count').innerText = `0${idx + 1}`;
        }

        function nextSlide() {
            let nextIdx = (currentSlideIdx + 1) % totalSlides;
            goToSlide(nextIdx, 'next');
        }

        function prevSlide() {
            let prevIdx = (currentSlideIdx - 1 + totalSlides) % totalSlides;
            goToSlide(prevIdx, 'prev');
        }

        function goToSlide(nextIdx, direction = 'next') {
            if (isAnimating || nextIdx === currentSlideIdx) return;
            isAnimating = true;

            const currentSlideEl = document.getElementById(`slide-${currentSlideIdx}`);
            const nextSlideEl = document.getElementById(`slide-${nextIdx}`);
            const nextBgColor = nextSlideEl.getAttribute('data-bg');

            const tl = gsap.timeline({
                onComplete: () => {
                    currentSlideEl.classList.remove('active');
                    nextSlideEl.classList.add('active');
                    currentSlideIdx = nextIdx;
                    updateDots(nextIdx);
                    isAnimating = false;
                    // Reset Transition Circle
                    gsap.set("#transition-bg", { scale: 0 });
                }
            });

            // 1. Elements Exit
            tl.to(currentSlideEl.querySelectorAll('.bottle'), { y: -100, opacity: 0, rotation: -10, duration: 0.8, ease: "power2.in" }, 0);
            tl.to(currentSlideEl.querySelectorAll('.slide-content'), { y: -50, opacity: 0, stagger: 0.1, duration: 0.6 }, 0);

            // 2. Circle Transition
            tl.set("#transition-bg", { backgroundColor: nextBgColor }, 0.2);
            tl.to("#transition-bg", { scale: 1, duration: 1, ease: "circ.inOut" }, 0.2);

            // 3. New Elements Enter
            tl.set(nextSlideEl, { zIndex: 20, opacity: 1 }, 0.5); // Bring to front visually inside the circle
            
            tl.fromTo(nextSlideEl.querySelectorAll('.bottle'), 
                { y: 200, opacity: 0, rotation: 10, scale: 0.8 },
                { y: 0, opacity: 1, rotation: 0, scale: 1, duration: 1.2, ease: "back.out(1.2)" }, 0.6
            );

            tl.fromTo(nextSlideEl.querySelectorAll('.slide-content'),
                { y: 50, opacity: 0 },
                { y: 0, opacity: 1, stagger: 0.1, duration: 0.8 }, 0.8
            );
        }

        // Auto play (optional, but requested "infinite loop" implying users can loop it manually or auto)
        // Leaving manual for now as it's better for interaction demo.

        // Init
        gsap.from("#slide-0 .bottle", { y: 50, opacity: 0, duration: 1.5, ease: "power2.out" });
        gsap.from("#slide-0 .slide-content", { y: 20, opacity: 0, stagger: 0.2, duration: 1, delay: 0.5 });

    </script>
</body>
</html>
