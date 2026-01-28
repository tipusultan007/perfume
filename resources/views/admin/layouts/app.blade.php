<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | {{ \App\Models\Setting::get('site_name', "L'ESSENCE") }} Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Inter:wght@300;400;500;600&family=Space+Mono&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
</head>
<body class="bg-[#F8FAFC] font-sans text-slate-900 antialiased">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-[#0F172A] z-50 flex flex-col shadow-xl border-r border-slate-800">

        <div class="p-8 border-b border-slate-800 bg-slate-900/50">
            <a href="{{ route('admin.dashboard') }}" class="block">
                <span class="font-serif text-xl tracking-[0.25em] font-bold bg-gradient-to-r from-[#BF953F] via-[#FCF6BA] to-[#B38728] text-transparent bg-clip-text uppercase">
                    {{ \App\Models\Setting::get('site_name', "L'ESSENCE") }}
                </span>
            </a>
        </div>

        
        <nav class="flex-1 p-6 overflow-y-auto space-y-1 custom-scrollbar">
            <span class="block px-3 text-[10px] uppercase tracking-widest text-slate-500 mt-6 mb-2 font-semibold">General</span>
            <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-dashboard-line mr-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Dashboard
            </a>
            <a href="{{ route('admin.home-settings.index') }}" 
                class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.home-settings.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-home-7-line mr-3 text-lg {{ request()->routeIs('admin.home-settings.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Home Settings
            </a>
            <a href="{{ route('admin.sliders.index') }}" 
                class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.sliders.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-gallery-line mr-3 text-lg {{ request()->routeIs('admin.sliders.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Hero Sliders
            </a>
            <a href="{{ route('admin.popups.index') }}" 
                class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.popups.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-window-line mr-3 text-lg {{ request()->routeIs('admin.popups.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Offers Popups
            </a>
            
            <span class="block px-3 text-[10px] uppercase tracking-widest text-slate-500 mt-8 mb-2 font-semibold">Catalog</span>
            <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.products.index') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-archive-line mr-3 text-lg {{ request()->routeIs('admin.products.index') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Products
            </a>
            <a href="{{ route('admin.products.import') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.products.import') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-file-upload-line mr-3 text-lg {{ request()->routeIs('admin.products.import') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Import Products
            </a>
            <a href="{{ route('admin.categories.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-stack-line mr-3 text-lg {{ request()->routeIs('admin.categories.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Categories
            </a>
            <a href="{{ route('admin.brands.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.brands.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-medal-line mr-3 text-lg {{ request()->routeIs('admin.brands.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Brands
            </a>
            <a href="{{ route('admin.attributes.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.attributes.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-list-settings-line mr-3 text-lg {{ request()->routeIs('admin.attributes.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Attributes
            </a>

            <span class="block px-3 text-[10px] uppercase tracking-widest text-slate-500 mt-8 mb-2 font-semibold">Sales</span>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.orders.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-shopping-bag-3-line mr-3 text-lg {{ request()->routeIs('admin.orders.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Orders
            </a>
            <a href="{{ route('admin.customers.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.customers.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-luxury-cream font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-user-heart-line mr-3 text-lg {{ request()->routeIs('admin.customers.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Customers
            </a>
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.coupons.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-ticket-line mr-3 text-lg {{ request()->routeIs('admin.coupons.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Coupons
            </a>
            <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.reports.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-bar-chart-2-line mr-3 text-lg {{ request()->routeIs('admin.reports.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Reports
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.newsletter.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-mail-send-line mr-3 text-lg {{ request()->routeIs('admin.newsletter.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Newsletter
            </a>
            <a href="{{ route('admin.contact-submissions.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.contact-submissions.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-question-answer-line mr-3 text-lg {{ request()->routeIs('admin.contact-submissions.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Contact Inquiries
            </a>
            <span class="block px-3 text-[10px] uppercase tracking-widest text-slate-500 mt-8 mb-2 font-semibold">Configuration</span>
            <a href="{{ route('admin.taxes.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.taxes.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-percent-line mr-3 text-lg {{ request()->routeIs('admin.taxes.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Tax Rates
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.settings.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-settings-4-line mr-3 text-lg {{ request()->routeIs('admin.settings.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Global Settings
            </a>
            <a href="{{ route('admin.announcements.index') }}" class="flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.announcements.*') ? 'bg-luxury-accent text-luxury-black font-bold' : '!text-slate-300 font-medium hover:bg-white/5' }} rounded-lg transition-all group">
                <i class="ri-notification-badge-line mr-3 text-lg {{ request()->routeIs('admin.announcements.*') ? 'text-luxury-black' : 'text-slate-400 group-hover:text-white' }}"></i> Announcements
            </a>
        </nav>

    </aside>

    <div class="pl-64 flex-1">
        <!-- Header -->
        <header class="sticky top-0 h-20 bg-white/95 backdrop-blur-md border-b border-slate-200 z-40 flex items-center justify-between px-10">
            <h2 class="font-sans font-semibold text-xl">@yield('page_title', 'Overview')</h2>

            
            <div class="flex items-center gap-6">
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="relative p-2 text-xl hover:text-luxury-accent transition-colors">
                        <i class="ri-notification-3-line"></i>
                        @if(auth('admin')->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-2 right-2 w-4 h-4 bg-red-500 text-white flex items-center justify-center text-[8px] font-bold rounded-full border-2 border-white">
                                {{ auth('admin')->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    <!-- Dropdown Panel -->
                    <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-4 w-80 bg-white border border-slate-200 shadow-xl rounded-xl overflow-hidden z-50 animate-in fade-in slide-in-from-top-2 duration-200">
                        <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h4 class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Alerts</h4>
                            @if(auth('admin')->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] text-luxury-accent hover:underline font-bold uppercase tracking-widest">Mark All Read</button>
                                </form>
                            @endif
                        </div>
                        <div class="max-h-80 overflow-y-auto">
                            @forelse(auth('admin')->user()->unreadNotifications->take(5) as $notif)
                                <div class="p-4 border-b border-slate-50 hover:bg-slate-50 transition-all cursor-pointer flex gap-4 items-start group">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0 group-hover:bg-luxury-accent group-hover:text-black transition-colors">
                                        <i class="ri-{{ $notif->data['type'] == 'order_success' ? 'shopping-cart-2-line' : 'notification-3-line' }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-[11px] font-bold text-slate-900 leading-snug">{{ $notif->data['message'] }}</p>
                                        <span class="text-[9px] text-slate-400 mt-1 block uppercase font-mono">{{ $notif->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    <form action="{{ route('admin.notifications.read', $notif->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        @csrf
                                        <button type="submit" title="Mark as Read" class="p-1 hover:text-luxury-accent">
                                            <i class="ri-check-line"></i>
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="p-8 text-center bg-white">
                                    <i class="ri-notification-off-line text-2xl text-slate-200 mb-2 block"></i>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Zen Garden: All Clear</p>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.notifications.index') }}" class="block p-3 text-center text-[10px] font-bold uppercase tracking-widest text-slate-500 hover:bg-slate-50 border-t border-slate-100">
                            View All Notifications
                        </a>
                    </div>
                </div>

                <!-- Profile -->
                <div class="relative dropdown" id="profileDropdown">
                    <div onclick="toggleDropdown('profileDropdown')" class="flex items-center gap-3 cursor-pointer group">
                        <div class="w-9 h-9 bg-luxury-cream rounded-full flex items-center justify-center text-luxury-accent font-semibold text-xs border border-luxury-accent/10 transition-all group-hover:border-luxury-accent">
                            SA
                        </div>
                        <div class="text-right hidden sm:block">
                            <p class="text-[13px] font-semibold leading-none">{{ auth('admin')->user()->name }}</p>
                            <span class="text-[10px] opacity-40">Super Admin</span>
                        </div>
                        <i class="ri-arrow-down-s-line opacity-30"></i>
                    </div>
                    <!-- Dropdown Panel -->
                    <div class="hidden absolute right-0 mt-4 w-48 bg-white border border-black/5 shadow-xl dropdown-panel">
                        <div class="p-2">
                            <a href="#" class="flex items-center px-4 py-2 text-xs text-black/70 hover:bg-gray-50 rounded-md">
                                <i class="ri-user-line mr-3 text-sm opacity-60"></i> Profile
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-xs text-black/70 hover:bg-gray-50 rounded-md">
                                <i class="ri-settings-line mr-3 text-sm opacity-60"></i> Settings
                            </a>
                            <div class="my-2 border-t border-black/5"></div>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-xs text-red-600 hover:bg-red-50 rounded-md transition-colors">
                                    <i class="ri-logout-box-line mr-3 text-sm opacity-60"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-10">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            const panel = el.querySelector('.dropdown-panel');
            
            // Close others
            document.querySelectorAll('.dropdown-panel').forEach(p => {
                if (p !== panel) p.classList.add('hidden');
            });
            
            panel.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-panel').forEach(p => p.classList.add('hidden'));
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
