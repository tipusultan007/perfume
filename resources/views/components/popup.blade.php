@php
    $popups = $activePopups ?? collect();
    $isPreview = $isPreview ?? false;
@endphp

@if($popups->count() > 0 || $isPreview)
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Cinzel:wght@400;500;600;700;800;900&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Outfit:wght@100;200;300;400;500;600;700;800;900&family=Prata&family=La+Belle+Aurore&family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Syncopate:wght@400;700&display=swap');

    .popup-luxury-font-Cormorant-Garamond { font-family: 'Cormorant Garamond', serif !important; }
    .popup-luxury-font-Playfair-Display { font-family: 'Playfair Display', serif !important; }
    .popup-luxury-font-Cinzel { font-family: 'Cinzel', serif !important; }
    .popup-luxury-font-Montserrat { font-family: 'Montserrat', sans-serif !important; }
    .popup-luxury-font-Outfit { font-family: 'Outfit', sans-serif !important; }
    .popup-luxury-font-Prata { font-family: 'Prata', serif !important; }
    .popup-luxury-font-La-Belle-Aurore { font-family: 'La Belle Aurore', cursive !important; }
    .popup-luxury-font-Bodoni-Moda { font-family: 'Bodoni Moda', serif !important; }
    .popup-luxury-font-Josefin-Sans { font-family: 'Josefin Sans', sans-serif !important; }
    .popup-luxury-font-Syncopate { font-family: 'Syncopate', sans-serif !important; }
</style>

<div x-data="{
    show: false,
    popups: {{ json_encode($popups->map(fn($p) => [
        'id' => $p->id,
        'title' => $p->title,
        'subtitle' => $p->subtitle,
        'description' => $p->description,
        'template_id' => $p->template_id,
        'font_family' => $p->font_family,
        'link' => $p->link,
        'cta_text' => $p->cta_text,
        'show_newsletter' => (bool)$p->show_newsletter,
        'image' => $p->hasMedia('popup') ? $p->getFirstMediaUrl('popup') : ''
    ])) }},
    id: 0,
    loading: false,
    message: '',
    status: '',
    email: '',
    isPreview: {{ $isPreview ? 'true' : 'false' }},
    
    // UI Data
    p_title: '',
    p_subtitle: '',
    p_description: '',
    p_template: 'luxury-minimalist',
    p_font: 'Cormorant Garamond',
    p_link: '',
    p_cta: '',
    p_show_newsletter: false,
    p_image: '',

    init() {
        if (!this.isPreview) {
            const nextPopup = this.popups.find(p => !localStorage.getItem('popup_closed_' + p.id));
            if (nextPopup) {
                this.loadPopup(nextPopup);
                setTimeout(() => {
                    this.show = true;
                }, 3000);
            }
        }

        @if($isPreview)
            window.addEventListener('open-popup-preview', (e) => {
                this.loadPopup(e.detail);
                if(e.detail.image_preview) this.p_image = e.detail.image_preview;
                this.show = true;
            });
        @endif
    },
    loadPopup(p) {
        this.id = p.id;
        this.p_title = p.title;
        this.p_subtitle = p.subtitle;
        this.p_description = p.description;
        this.p_template = p.template_id;
        this.p_font = p.font_family;
        this.p_link = p.link;
        this.p_cta = p.cta_text;
        this.p_show_newsletter = p.show_newsletter;
        this.p_image = p.image || '';
    },
    close() {
        this.show = false;
        if (!this.isPreview) {
            localStorage.setItem('popup_closed_' + this.id, 'true');
        }
    },
    async subscribe() {
        if (this.isPreview) {
            this.status = 'success';
            this.message = 'Test: Subscription successful!';
            return;
        }
        if (!this.email) return;
        this.loading = true;
        try {
            const response = await fetch('{{ route('newsletter.subscribe') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: this.email })
            });
            const data = await response.json();
            this.status = data.status;
            this.message = data.message;
            if (data.status === 'success') {
                this.email = '';
                setTimeout(() => this.close(), 3000);
            }
        } catch (error) {
            this.status = 'error';
            this.message = 'Something went wrong. Please try again.';
        }
        this.loading = false;
    },
    getFontClass() {
        return 'popup-luxury-font-' + (this.p_font || 'Cormorant Garamond').replace(/ /g, '-');
    }
}"
x-show="show"
x-transition:enter="transition ease-out duration-700"
x-transition:enter-start="opacity-0 scale-90 blur-sm"
x-transition:enter-end="opacity-100 scale-100 blur-0"
x-transition:leave="transition ease-in duration-500"
x-transition:leave-start="opacity-100 scale-100 blur-0"
x-transition:leave-end="opacity-0 scale-90 blur-sm"
style="display: none;"
class="fixed inset-0 z-[9999] flex items-center justify-center px-4 sm:px-0">
    
    <!-- Backdrop (Locked: clicking outside won't close) -->
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity"></div>
    
    <!-- Modal -->
    <div 
        :class="{
            'max-w-4xl bg-white shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)] overflow-hidden rounded-3xl border border-white/20': p_template !== 'floating-minimalist',
            'max-w-md': p_template === 'floating-minimalist'
        }"
        class="relative w-full transform transition-all">
        
        <!-- Close Button -->
        <button @click="close()" 
                'bg-slate-900/5 text-slate-400 border-slate-100 hover:text-slate-900 hover:bg-slate-900/10': p_template === 'floating-minimalist' || p_template === 'elegant-sidebar',
                'bg-white/10 text-white border-white/20 hover:bg-white/20': p_template === 'modern-glass',
                'bg-slate-900 text-white border-slate-800 hover:bg-black': p_template === 'luxury-minimalist',
                'bg-[#b4975a] text-white border-[#c5a96b] hover:bg-[#a38649]': p_template === 'dark-gold',
                'bg-[#4a3728] text-[#fdf6e3] border-[#3a2a1a] hover:bg-[#3a2a1a]': p_template === 'vintage-classic'
            }"
            class="absolute top-6 right-6 z-50 w-10 h-10 flex items-center justify-center backdrop-blur-xl rounded-full border transition-all shadow-xl group">
            <i class="ri-close-line text-xl group-hover:rotate-90 transition-transform"></i>
        </button>


        <template x-if="p_template === 'luxury-minimalist'">
            <!-- Luxury Minimalist Template -->
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-[400px] md:min-h-[500px]">
                <div class="relative overflow-hidden group h-[250px] md:h-auto">
                    <img :src="p_image" x-show="p_image" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors"></div>
                </div>
                <div class="flex flex-col justify-center p-8 md:p-20 text-center md:text-left bg-white relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 -z-10 rounded-bl-full"></div>
                    <span class="text-[10px] uppercase tracking-[0.4em] text-slate-400 font-bold mb-4 md:mb-6 italic" x-text="p_subtitle || 'Exclusive Offer'"></span>
                    <h2 :class="getFontClass()" class="text-3xl md:text-5xl lg:text-6xl text-slate-900 mb-6 md:mb-8 leading-tight" x-text="p_title"></h2>
                    <p class="text-slate-500 text-xs md:text-base mb-8 md:mb-10 leading-relaxed max-w-md mx-auto md:mx-0" x-text="p_description"></p>
                    
                    <div x-show="p_show_newsletter" class="space-y-4">
                        <div class="relative">
                            <input type="email" x-model="email" placeholder="Your Email Address" class="w-full bg-slate-50 border-b-2 border-slate-200 py-3 md:py-4 px-0 focus:border-slate-900 outline-none transition-all text-sm font-medium">
                            <button @click="subscribe()" :disabled="loading" style="color: #0f172a !important;" class="absolute right-0 bottom-4 text-slate-900 font-bold uppercase text-[10px] tracking-widest hover:translate-x-1 transition-transform">
                                <span x-show="!loading">Join Now</span>
                                <i x-show="loading" class="ri-loader-4-line animate-spin"></i>
                            </button>
                        </div>
                        <p x-show="message" :class="status === 'success' ? 'text-emerald-600' : 'text-rose-600'" class="text-[10px] font-bold uppercase tracking-widest" x-text="message"></p>
                    </div>
                    
                    <div x-show="!p_show_newsletter && p_link">
                        <a :href="p_link" style="color: white !important;" class="inline-block px-10 md:px-12 py-4 md:py-5 bg-slate-900 text-white text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-slate-800 transition-all shadow-xl hover:shadow-slate-900/30" x-text="p_cta || 'Discover Collection'">
                        </a>
                    </div>
                </div>
            </div>
        </template>



        <template x-if="p_template === 'elegant-sidebar'">
            <!-- Elegant Sidebar Template -->
             <div class="grid grid-cols-1 md:grid-cols-12 min-h-[400px] md:min-h-[550px]">
                <div class="md:col-span-4 relative group h-[200px] md:h-auto">
                    <img :src="p_image" x-show="p_image" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-slate-900/20"></div>
                </div>
                <div class="md:col-span-8 flex flex-col justify-center p-8 md:p-24 bg-white">
                    <div class="max-w-xl">
                        <i class="ri-vip-diamond-line text-3xl md:text-4xl text-slate-200 mb-6 md:mb-8 block"></i>
                        <h2 :class="getFontClass()" class="text-3xl md:text-7xl text-slate-900 mb-4 md:mb-6 font-medium" x-text="p_title"></h2>
                        <h3 class="text-lg md:text-2xl text-slate-400 mb-6 md:mb-8 font-light italic" x-text="p_subtitle"></h3>
                        <div class="w-16 md:w-20 h-px bg-slate-900 mb-8 md:mb-10"></div>
                        <p class="text-slate-600 mb-10 md:mb-12 text-base md:text-lg leading-relaxed" x-text="p_description"></p>
                        
                        <div x-show="p_show_newsletter">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <input type="email" x-model="email" placeholder="Enter your email" class="flex-1 px-8 py-4 md:py-5 bg-slate-50 border border-slate-100 focus:border-slate-900 outline-none rounded-full text-sm font-medium">
                                <button @click="subscribe()" :disabled="loading" style="color: white !important;" class="px-10 py-4 md:py-5 bg-slate-900 text-white rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all whitespace-nowrap">
                                    <span x-show="!loading">Subscribe</span>
                                    <i x-show="loading" class="ri-loader-4-line animate-spin"></i>
                                </button>
                            </div>
                            <p x-show="message" :class="status === 'success' ? 'text-emerald-600' : 'text-rose-600'" class="mt-4 text-[10px] font-bold uppercase tracking-widest px-4" x-text="message"></p>
                        </div>
                        <div x-show="!p_show_newsletter && p_link">
                            <a :href="p_link" class="inline-flex items-center gap-4 text-slate-900 font-bold uppercase text-xs tracking-[0.2em] group">
                                <span x-text="p_cta || 'View Details'"></span>
                                <i class="ri-arrow-right-line group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>



        <template x-if="p_template === 'modern-glass'">
            <!-- Modern Glass Template -->
            <div class="relative min-h-[400px] md:min-h-[450px] flex items-center justify-center p-4 md:p-6 overflow-hidden group">
                <img :src="p_image" x-show="p_image" class="absolute inset-0 w-full h-full object-cover blur-[1px] scale-105 group-hover:scale-100 transition-transform duration-1000">
                <div class="absolute inset-0 bg-slate-900/40 md:bg-slate-900/30"></div>
                
                <div class="relative z-10 w-full max-w-lg bg-white/10 backdrop-blur-xl p-8 md:p-14 rounded-[28px] md:rounded-[32px] border border-white/20 text-center text-white shadow-2xl">
                    <span class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/20 text-[9px] uppercase tracking-widest mb-4 md:mb-6 font-bold" x-text="p_subtitle || 'New Arrival'"></span>
                    <h2 :class="getFontClass()" class="text-2xl md:text-5xl mb-4 md:mb-6 font-bold tracking-tight leading-tight text-white" x-text="p_title"></h2>
                    <p class="text-xs md:text-sm text-white/80 mb-6 md:mb-8 max-w-xs md:max-w-sm mx-auto font-light leading-relaxed" x-text="p_description"></p>
                    
                    <div x-show="p_show_newsletter" class="max-w-xs mx-auto relative group/input">
                        <input type="email" x-model="email" placeholder="Enter your email" class="w-full bg-white/10 border border-white/20 px-6 py-4 rounded-xl focus:bg-white/20 outline-none transition-all text-white placeholder:text-white/40 mb-3 text-sm">
                        <button @click="subscribe()" :disabled="loading" class="w-full py-4 bg-white text-slate-900 rounded-xl font-bold uppercase text-[9px] tracking-widest hover:bg-slate-50 transition-all shadow-xl">
                            <span x-show="!loading" x-text="p_cta || 'Join Now'"></span>
                            <i x-show="loading" class="ri-loader-4-line animate-spin mr-2"></i>
                        </button>
                        <p x-show="message" :class="status === 'success' ? 'text-emerald-400' : 'text-rose-400'" class="mt-3 text-[9px] font-bold uppercase tracking-widest" x-text="message"></p>
                    </div>
                    <div x-show="!p_show_newsletter && p_link">
                        <a :href="p_link" class="inline-block px-10 py-4 bg-white text-slate-900 rounded-xl font-bold uppercase text-[9px] tracking-widest hover:scale-105 transition-all shadow-inner" x-text="p_cta || 'Explore Now'">
                        </a>
                    </div>
                </div>
            </div>
        </template>



        <template x-if="p_template === 'dark-gold'">
            <!-- Dark Gold Template -->
            <div class="grid grid-cols-1 md:grid-cols-2 min-h-[400px] md:min-h-[550px] bg-[#0f0f0f] overflow-hidden">
                <div class="relative min-h-[300px] md:min-h-[400px] order-1 md:order-2">
                    <img :src="p_image" x-show="p_image" class="absolute inset-0 w-full h-full object-cover grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition-all duration-700">
                    <div class="absolute inset-0 shadow-[inset_0_-100px_100px_-50px_#0f0f0f] md:shadow-[inset_100px_0_100px_-50px_#0f0f0f]"></div>
                </div>
                <div class="relative order-2 md:order-1 flex flex-col justify-center p-10 md:p-24 text-white">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,#222_0%,#0f0f0f_100%)] opacity-50"></div>
                    <div class="relative z-10">
                        <span class="text-[#c5a059] text-[10px] uppercase tracking-[0.5em] mb-6 md:mb-10 block font-bold" x-text="p_subtitle"></span>
                        <h2 :class="getFontClass()" class="text-3xl md:text-7xl mb-8 md:mb-10 leading-tight border-l-4 border-[#c5a059] pl-6 md:pl-8 text-white" x-text="p_title"></h2>
                        <p class="text-white/60 mb-10 md:mb-14 text-sm md:text-lg italic font-light leading-relaxed" x-text="p_description"></p>
                        
                        <div x-show="p_show_newsletter" class="space-y-6">
                            <div class="flex gap-2">
                                <input type="email" x-model="email" placeholder="Your essence (email)" class="flex-1 bg-transparent border-b-2 border-[#c5a059]/30 py-3 md:py-4 focus:border-[#c5a059] outline-none transition-all text-white placeholder:text-white/20 text-sm">
                                <button @click="subscribe()" :disabled="loading" class="px-6 md:px-8 bg-[#c5a059] text-white font-bold uppercase text-[10px] tracking-widest hover:bg-[#b08d4a] transition-all">
                                    <i x-show="!loading" class="ri-arrow-right-line text-xl"></i>
                                    <i x-show="loading" class="ri-loader-4-line animate-spin"></i>
                                </button>
                            </div>
                            <p x-show="message" :class="status === 'success' ? 'text-[#c5a059]' : 'text-rose-500'" class="text-[10px] font-bold uppercase tracking-widest" x-text="message"></p>
                        </div>
                        <div x-show="!p_show_newsletter && p_link">
                            <a :href="p_link" style="color: #c5a059 !important;" class="inline-block px-10 md:px-12 py-4 md:py-5 border-2 border-[#c5a059] text-[#c5a059] font-bold uppercase text-[10px] tracking-[0.3em] hover:bg-[#c5a059] hover:text-[#0f0f0f] transition-all" x-text="p_cta || 'Reveal More'">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>



        <template x-if="p_template === 'vintage-classic'">
            <!-- Vintage Classic Template -->
            <div class="relative min-h-[400px] md:min-h-[500px] bg-[#fdfaf5] p-8 md:p-20 text-center flex items-center justify-center">
                <div class="absolute inset-4 border border-[#d4af37]/30 pointer-events-none"></div>
                <div class="absolute inset-6 border-2 border-[#d4af37]/10 pointer-events-none"></div>
                
                <div class="relative z-10 max-w-2xl px-4">
                    <div class="mb-6 md:mb-8 flex justify-center opacity-30">
                        <svg width="30" height="30" md:width="40" md:height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 0L24.4903 15.5097L40 20L24.4903 24.4903L20 40L15.5097 24.4903L0 20L15.5097 15.5097L20 0Z" fill="#D4AF37"/>
                        </svg>
                    </div>
                    
                    <span class="text-[#8b7355] text-[10px] md:text-xs uppercase tracking-[0.4em] mb-4 block font-serif italic" x-text="p_subtitle"></span>
                    <h2 :class="getFontClass()" class="text-3xl md:text-7xl text-[#4a3728] mb-6 md:mb-8 leading-tight italic" x-text="p_title"></h2>
                    <p class="text-[#6d5b4b] text-sm md:text-lg mb-8 md:mb-12 font-serif leading-relaxed italic" x-text="p_description"></p>
                    
                    <div x-show="p_show_newsletter" class="max-w-md mx-auto space-y-6">
                        <div class="relative border-b border-[#d4af37]">
                            <input type="email" x-model="email" placeholder="Address of residence" class="w-full bg-transparent py-3 md:py-4 px-2 outline-none transition-all text-[#4a3728] placeholder:text-[#d4af37]/40 text-sm font-serif italic">
                            <button @click="subscribe()" :disabled="loading" class="absolute right-0 bottom-3 text-[#8b7355] hover:text-[#4a3728] transition-colors">
                                <i x-show="!loading" class="ri-quill-pen-line text-xl md:text-2xl"></i>
                                <i x-show="loading" class="ri-loader-4-line animate-spin"></i>
                            </button>
                        </div>
                        <p x-show="message" :class="status === 'success' ? 'text-emerald-700' : 'text-rose-700'" class="text-[10px] font-bold uppercase tracking-widest font-serif" x-text="message"></p>
                    </div>
                    
                    <div x-show="!p_show_newsletter && p_link">
                        <a :href="p_link" style="color: white !important;" class="inline-block px-10 md:px-14 py-4 md:py-5 bg-[#4a3728] text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-[#5d4633] transition-all shadow-xl" x-text="p_cta || 'Enter Library'">
                        </a>
                    </div>
                </div>
            </div>
        </template>



        <template x-if="p_template === 'floating-minimalist'">
            <!-- Floating Minimalist Template -->
            <div class="min-h-[400px] md:min-h-[450px] flex items-center justify-center p-4 md:p-8">
                <div class="relative w-full max-w-md bg-white p-8 md:p-12 rounded-[40px] md:rounded-[50px] shadow-[0_40px_100px_-20px_rgba(0,0,0,0.2)] text-center group border border-slate-100">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-20 h-20 bg-white rounded-full p-2 shadow-2xl border border-slate-100/50">
                        <div class="w-full h-full bg-slate-900 rounded-full flex items-center justify-center overflow-hidden">
                            <i :class="p_image ? 'hidden' : 'ri-leaf-line'" class="text-white text-3xl"></i>
                            <img :src="p_image" x-show="p_image" class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <h2 :class="getFontClass()" class="text-2xl md:text-4xl text-slate-900 mt-6 md:mt-8 mb-4 font-bold tracking-tight leading-tight" x-text="p_title"></h2>
                    <p class="text-slate-400 text-[10px] uppercase tracking-[0.3em] mb-4 md:mb-6 font-bold" x-text="p_subtitle || 'Exclusive Offer'"></p>
                    <p class="text-slate-500 text-xs md:text-sm mb-8 md:mb-10 leading-relaxed font-medium px-2" x-text="p_description"></p>
                    
                    <div x-show="p_show_newsletter" class="space-y-4">
                        <input type="email" x-model="email" placeholder="Your essence (email)" class="w-full bg-slate-50 border-none px-6 md:px-8 py-4 md:py-5 rounded-2xl md:rounded-3xl focus:ring-2 focus:ring-slate-900/5 outline-none transition-all text-sm font-bold text-slate-900 placeholder:text-slate-300">
                        <button @click="subscribe()" :disabled="loading" style="color: white !important;" class="w-full py-4 md:py-5 bg-slate-900 text-white rounded-2xl md:rounded-3xl font-bold uppercase text-[10px] tracking-widest hover:shadow-2xl hover:shadow-slate-900/40 transition-all">
                            <span x-show="!loading" x-text="p_cta || 'Stay Connected'"></span>
                            <i x-show="loading" class="ri-loader-4-line animate-spin"></i>
                        </button>
                        <p x-show="message" :class="status === 'success' ? 'text-emerald-600' : 'text-rose-600'" class="text-[10px] font-bold uppercase tracking-widest" x-text="message"></p>
                    </div>
                    
                    <div x-show="!p_show_newsletter && p_link">
                        <a :href="p_link" style="color: white !important;" class="inline-block w-full py-4 md:py-5 bg-slate-900 text-white rounded-2xl md:rounded-3xl font-bold uppercase text-[10px] tracking-widest hover:shadow-2xl hover:shadow-slate-900/40 transition-all shadow-xl" x-text="p_cta || 'Explore Now'">
                        </a>
                    </div>
                </div>
            </div>
        </template>


    </div>
</div>
@endif
