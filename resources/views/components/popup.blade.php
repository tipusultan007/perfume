@if(isset($activePopup) && $activePopup)
<div x-data="{
    show: false,
    id: {{ $activePopup->id }},
    init() {
        const closed = localStorage.getItem('popup_closed_' + this.id);
        if (!closed) {
            setTimeout(() => {
                this.show = true;
            }, 3000); // Show after 3 seconds
        }
    },
    close() {
        this.show = false;
        // Expires after session or set a fixed time? The user said 'popup can set between date period'. 
        // Let's store a timestamp and maybe check if it's been viewed recently? 
        // For now, simple 'closed forever' for this specific popup ID is safe.
        localStorage.setItem('popup_closed_' + this.id, 'true');
    }
}"
x-show="show"
x-transition:enter="transition ease-out duration-500"
x-transition:enter-start="opacity-0 translate-y-10 scale-95"
x-transition:enter-end="opacity-100 translate-y-0 scale-100"
x-transition:leave="transition ease-in duration-300"
x-transition:leave-start="opacity-100 translate-y-0 scale-100"
x-transition:leave-end="opacity-0 translate-y-10 scale-95"
style="display: none;"
class="fixed inset-0 z-[9999] flex items-center justify-center px-4 sm:px-0">
    
    <!-- Backdrop -->
    <div @click="close()" class="absolute inset-0 bg-slate-900/20 backdrop-blur-sm transition-opacity"></div>
    
    <!-- Modal -->
    <div class="relative w-full max-w-lg bg-white shadow-2xl overflow-hidden transform transition-all rounded-2xl">
        <!-- Close Button -->
        <button @click="close()" class="absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center bg-white text-slate-900 rounded-full shadow-lg hover:bg-slate-50 transition-all">
            <i class="ri-close-line text-xl"></i>
        </button>

        <!-- Content -->
        <div class="relative aspect-[4/5] sm:aspect-[4/3] w-full group">
            @if($activePopup->hasMedia('popup'))
                <img src="{{ $activePopup->getFirstMediaUrl('popup') }}" alt="{{ $activePopup->title }}" class="absolute inset-0 w-full h-full object-cover">
            @else
                <div class="absolute inset-0 bg-slate-100 flex items-center justify-center text-slate-300">
                    <span class="uppercase tracking-widest text-xs font-bold">No Image</span>
                </div>
            @endif
            
            <!-- Overlay and Text -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-10 text-center text-white">
                <h3 class="font-serif text-3xl md:text-4xl italic mb-3 drop-shadow-md">{{ $activePopup->title }}</h3>
                @if($activePopup->link)
                    <div class="mt-6">
                        <a href="{{ $activePopup->link }}" @click="close()" class="inline-block px-8 py-3 bg-white text-slate-900 text-[11px] font-bold uppercase tracking-widest hover:bg-slate-100 transition-colors shadow-lg">
                            Discover More
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
