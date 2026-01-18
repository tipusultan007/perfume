@php
    $showTopbar = \App\Models\Setting::get('topbar_visible', false);
    $announcements = \App\Models\Announcement::where('is_active', '=', 1)->orderBy('display_order', 'asc')->get();
    $topbarBg = \App\Models\Setting::get('topbar_bg', '#D4AF37');
    $topbarText = \App\Models\Setting::get('topbar_text_color', '#000000');
@endphp

@if($showTopbar && $announcements->count() > 0)
<div id="top-announcement-bar" class="fixed top-0 left-0 w-full z-[1001] py-2 overflow-hidden transition-all duration-400 ease-in-out" style="background-color: {{ $topbarBg }}; color: {{ $topbarText }}; box-shadow: 0 1px 10px rgba(0,0,0,0.05);">
    <div class="flex items-center whitespace-nowrap animate-marquee">
        <div class="flex shrink-0 gap-12 items-center px-4">
            @foreach($announcements as $announcement)
                <span class="text-[10px] uppercase tracking-[0.2em] font-bold">
                    {{ $announcement->content }}
                </span>
                <span class="w-1.5 h-1.5 rounded-full opacity-30" style="background-color: {{ $topbarText }};"></span>
            @endforeach
        </div>
        <!-- Duplicate for Infinite Loop -->
        <div class="flex shrink-0 gap-12 items-center px-4" aria-hidden="true">
            @foreach($announcements as $announcement)
                <span class="text-[10px] uppercase tracking-[0.2em] font-bold">
                    {{ $announcement->content }}
                </span>
                <span class="w-1.5 h-1.5 rounded-full opacity-30" style="background-color: {{ $topbarText }};"></span>
            @endforeach
        </div>
    </div>
</div>

<style>
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        display: flex;
        width: fit-content;
        animation: marquee 30s linear infinite;
    }
    .animate-marquee:hover {
        animation-play-state: paused;
    }
    .topbar-hidden {
        transform: translateY(-100%);
        opacity: 0;
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const topBar = document.getElementById('top-announcement-bar');
        const navbar = document.getElementById('navbar');
        if (!topBar || !navbar) return;

        function updateLayout() {
            const isHidden = topBar.classList.contains('topbar-hidden');
            const h = topBar.offsetHeight;
            
            if (isHidden) {
                document.documentElement.style.setProperty('--topbar-height', '0px');
            } else {
                document.documentElement.style.setProperty('--topbar-height', h + 'px');
            }
        }

        // Initial setup
        updateLayout();
        window.addEventListener('resize', updateLayout);

        let lastScrollTop = 0;
        const scrollThreshold = 100;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
                // Scrolling down
                if (!topBar.classList.contains('topbar-hidden')) {
                    topBar.classList.add('topbar-hidden');
                    updateLayout();
                }
            } else if (scrollTop < lastScrollTop) {
                // Scrolling up
                if (topBar.classList.contains('topbar-hidden')) {
                    topBar.classList.remove('topbar-hidden');
                    updateLayout();
                }
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; 
        }, { passive: true });
    });
</script>
@else
<script>
    document.documentElement.style.setProperty('--topbar-height', '0px');
</script>
@endif
