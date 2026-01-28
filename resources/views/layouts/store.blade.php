<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "L'ESSENCE NYC | Fragrance & Objects Atelier")</title>

    <!-- Google Analytics -->
    @php $gaId = \App\Models\Setting::get('google_analytics_id'); @endphp
    @if($gaId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $gaId }}');
            
            @if(\App\Models\Setting::get('google_ads_id'))
                gtag('config', '{{ \App\Models\Setting::get('google_ads_id') }}');
            @endif
        </script>
    @elseif(\App\Models\Setting::get('google_ads_id'))
        <!-- Google Ads (Standalone if no GA4) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ \App\Models\Setting::get('google_ads_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ \App\Models\Setting::get('google_ads_id') }}');
        </script>
    @endif

    <!-- Meta Pixel Code -->
    @php $pixelId = \App\Models\Setting::get('facebook_pixel_id'); @endphp
    @if($pixelId)
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $pixelId }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ $pixelId }}&ev=PageView&noscript=1"
        /></noscript>
    @endif

    <!-- Google reCAPTCHA -->
    @php $recaptchaKey = \App\Models\Setting::get('recaptcha_site_key'); @endphp
    @if($recaptchaKey)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,500;0,600;1,300&family=Montserrat:wght@300;400;500;600&family=Space+Mono&display=swap" rel="stylesheet">
    <!-- Global Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --black: #0A0A0A;
            --white: #ffffff;
            --cream: #fbf9f4;
            --accent: #D4AF37;
            --accent-hover: #b8962e; /* Matching darker shade for hover */
            --page-bg: #ffffff;
            --accent-bg-soft: #FBEACD;
            --border: rgba(0, 0, 0, 0.08);
            --accent-border: #d4af37;
            --transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .bg-accent-soft { background-color: var(--accent-bg-soft); }

        /* Modern Luxury Utilities */
        .glass-panel { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .glass-panel-dark { background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.05); }
        
        #scroll-progress { position: fixed; top: 0; left: 0; width: 0%; height: 2px; background: var(--accent); z-index: 9999; transition: width 0.1s ease; }

        /* Custom Toastr Branding */
        #toast-container > .toast {
            border-radius: 0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            font-family: 'Montserrat', sans-serif;
        }

        #toast-container > .toast-success {
            background-image: linear-gradient(135deg, #d4af37 0%, #b8962e 100%) !important;
            background-color: #d4af37 !important;
            color: #000 !important;
            opacity: 1 !important;
        }

        #toast-container > .toast-success .toast-message {
            font-weight: 500;
        }

        #toast-container > .toast-success .toast-progress {
            background-color: #000 !important;
            opacity: 0.2 !important;
        }

        #toast-container > .toast-success .toast-close-button {
            color: #000 !important;
            text-shadow: none;
        }

        /* Cart Drawer Styles from Static Template */
        .cart-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .cart-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .cart-drawer {
            position: fixed;
            top: 0;
            right: -500px;
            width: 500px;
            height: 100vh;
            background: var(--white);
            z-index: 2001;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            box-shadow: -10px 0 50px rgba(0, 0, 0, 0.05);
        }

        .cart-drawer.active {
            right: 0;
        }

        .cart-drw-header {
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }

        .cart-drw-header h2 {
            font-size: 1.8rem;
        }

        .close-cart {
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
        }

        .cart-drw-body {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            gap: 20px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .item-img {
            width: 90px;
            aspect-ratio: 1/1.2;
            background: var(--cream);
            overflow: hidden;
        }

        .item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-info {
            flex: 1;
        }

        .item-info h4 {
            font-family: 'Cormorant Garamond';
            font-size: 1.2rem;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .item-info p {
            font-size: 11px;
            opacity: 0.5;
            text-transform: uppercase;
        }

        .item-qty-price {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 15px;
        }

        .qty-controls {
            display: flex;
            gap: 15px;
            font-size: 12px;
            border: 1px solid var(--border);
            padding: 5px 12px;
        }

        .qty-controls span {
            cursor: pointer;
        }

        .cart-drw-footer {
            padding: 30px;
            background: var(--cream);
        }

        .subtotal-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 15px;
        }

        .checkout-btn {
            width: 100%;
            padding: 20px;
            background: var(--accent);
            color: var(--white);
            border: none;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 11px;
            cursor: pointer;
            transition: var(--transition);
        }

        .checkout-btn:hover {
            background: var(--accent-hover);
            opacity: 1;
        }

        @media (max-width: 768px) {
            .cart-drawer {
                width: 100%;
                right: -100%;
            }
        }


        /* Reset & Base */
        body { font-family: 'Montserrat', sans-serif; background: var(--page-bg); color: var(--black); line-height: 1.6; overflow-x: hidden; -webkit-font-smoothing: antialiased; font-size: 16px; }
       
        .mono { font-family: 'Space Mono', monospace; font-size: 14px; text-transform: uppercase; letter-spacing: 2px; font-weight: 400; }
        a { text-decoration: none; color: inherit; transition: var(--transition); }
        ul { list-style: none; }

        /* Navigation */
        #navbar { position: fixed; top: var(--topbar-height, 0); width: 100%; z-index: 1000; display: flex; justify-content: space-between; align-items: center; padding: 0 6%; background: rgba(10, 10, 10, 0.85); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.4s ease; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);}
        nav.scrolled { padding: 10px 6%; background: rgba(10, 10, 10, 0.98); }
        .logo { font-size: clamp(20px, 4vw, 26px); font-weight: 600; letter-spacing: 5px; font-family: 'Cormorant Garamond'; background: linear-gradient(135deg, #ffffff 0%, #d4af37 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: flex; align-items: center; }
        .logo img { max-height: 90px; width: auto; }
        
        /* Desktop Menu (UL/LI) */
        .nav-desktop { display: flex; gap: 40px; align-items: center; list-style: none; margin: 0; padding: 0; }
        .nav-item { position: relative; height: 100%; display: flex; align-items: center; }
        .nav-link { 
            position: relative; 
            font-size: 13px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 4px;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }
        .nav-link::after { 
            content: ''; 
            position: absolute; 
            bottom: 5px; 
            left: 0; 
            width: 0; 
            height: 1px; 
            background: var(--accent); 
            transition: width 0.3s cubic-bezier(0.16, 1, 0.3, 1); 
        }
        .nav-item:hover .nav-link::after { width: 100%; }
        .nav-link:hover { color: var(--accent); }

        /* Dropdown Menu */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: -20px;
            background: #1a1a1a;
            backdrop-filter: blur(20px);
            min-width: 260px;
            padding: 25px 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            z-index: 1001;
            margin-top: 10px;
        }
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 30px;
            width: 12px;
            height: 12px;
            background: #1a1a1a;
            transform: rotate(45deg);
            border-top: 1px solid rgba(255,255,255,0.05);
            border-left: 1px solid rgba(255,255,255,0.05);
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-item {
            display: block;
            padding: 12px 30px;
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            transition: all 0.3s ease;
            position: relative;
            text-transform: none;
            font-weight: 500;
        }
        .dropdown-item:hover {
            color: var(--accent);
            padding-left: 35px;
            background: rgba(255,255,255,0.05);
        }

        /* Mobile Menu & Toggle */
        .menu-toggle { display: none; cursor: pointer; flex-direction: column; gap: 6px; z-index: 1002; width: 25px; }
        .menu-toggle span { display: block; width: 100%; height: 1px; background: #d4af37; transition: var(--transition); }
        .menu-toggle.active span:nth-child(1) { transform: translateY(10px) rotate(45deg); }
        .menu-toggle.active span:nth-child(2) { opacity: 0; }
        .menu-toggle.active span:nth-child(3) { transform: translateY(-10px) rotate(-45deg); }

        /* Mobile Offcanvas Menu */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu { 
            position: fixed; 
            top: 0; 
            right: -100%; 
            width: 100%; 
            max-width: 380px;
            height: 100vh; 
            background: #111111; 
            display: flex; 
            flex-direction: column; 
            padding: 40px;
            padding-bottom: env(safe-area-inset-bottom, 20px);
            transition: right 0.6s cubic-bezier(0.16, 1, 0.3, 1); 
            z-index: 2000; 
            overflow-y: auto;
            box-shadow: -10px 0 50px rgba(0, 0, 0, 0.5);
            color: white;
        }
        .mobile-menu.active { right: 0; }
        
        .mobile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .mobile-search {
            position: relative;
            margin-bottom: 40px;
        }
        .mobile-search input {
            width: 100%;
            padding: 12px 15px;
            padding-left: 0;
            border: none;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size: 13px;
            letter-spacing: 1px;
            background: transparent;
            outline: none;
            color: white;
        }
        .mobile-search button {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            opacity: 0.8;
            color: white;
        }

        .mobile-nav-link { 
            font-family: 'Cormorant Garamond', serif; 
            font-size: 28px; 
            line-height: 1.2;
            color: rgba(255,255,255,0.9);
            transition: 0.4s cubic-bezier(0.16, 1, 0.3, 1); 
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding: 18px 0;
            cursor: pointer;
            opacity: 0;
            transform: translateX(20px);
        }
        .mobile-menu.active .mobile-nav-link {
            opacity: 1;
            transform: translateX(0);
        }
        .mobile-nav-link:hover { color: var(--accent); padding-left: 5px; border-color: var(--accent); }
        
        /* Staggered Animations */
        .mobile-menu.active .mobile-nav-link:nth-child(1) { transition-delay: 0.1s; }
        .mobile-menu.active .mobile-nav-link:nth-child(2) { transition-delay: 0.15s; }
        .mobile-menu.active .mobile-nav-link:nth-child(3) { transition-delay: 0.2s; }
        .mobile-menu.active .mobile-nav-link:nth-child(4) { transition-delay: 0.25s; }
        .mobile-menu.active .mobile-nav-link:nth-child(5) { transition-delay: 0.3s; }
        .mobile-menu.active .mobile-nav-link:nth-child(6) { transition-delay: 0.35s; }
        .mobile-menu.active .mobile-nav-link:nth-child(7) { transition-delay: 0.4s; }

        .mobile-submenu {
            padding-left: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            overflow: hidden;
            border-left: 1px solid rgba(255,255,255,0.05);
        }
        
        .mobile-sub-link {
            font-family: 'Montserrat', sans-serif;
            font-size: 13px; 
            opacity: 0.5;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            padding: 6px 0;
            transition: all 0.3s;
            color: white;
        }
        .mobile-sub-link:hover { opacity: 1; color: var(--accent); transform: translateX(5px); }

        .mobile-footer {
            margin-top: auto;
            padding-top: 50px;
            display: flex;
            flex-direction: column;
            gap: 30px;
            opacity: 0;
            transform: translateY(20px);
            transition: 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.5s;
        }
        .mobile-menu.active .mobile-footer {
            opacity: 1;
            transform: translateY(0);
        }

        .mobile-secondary-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .mobile-sec-link {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.6;
            transition: 0.3s;
        }
        .mobile-sec-link:hover { opacity: 1; color: var(--accent); }

        .mobile-socials {
            display: flex;
            gap: 20px;
            font-size: 18px;
            color: var(--black);
        }
        .mobile-socials a { opacity: 0.6; transition: 0.3s; }
        .mobile-socials a:hover { opacity: 1; color: var(--accent); transform: translateY(-3px); }

        /* Hero */
        .hero { height: 100vh; width: 100%; background: url('https://images.unsplash.com/photo-1523293182086-7651a899d37f?q=80&w=2000') center/cover; display: flex; align-items: center; justify-content: center; text-align: center; color: white; position: relative; }
        .hero::after { content: ''; position: absolute; inset: 0; background: rgba(0, 0, 0, 0.2); }
        .hero-content { z-index: 10; padding: 0 5%; }
        .hero h1 { font-size: clamp(3rem, 10vw, 7rem); line-height: 0.9; margin: 20px 0; }

        /* Bento */
        .bento { display: grid; padding: 20px; gap: 20px; grid-template-columns: repeat(4, 1fr); grid-auto-rows: 350px; }
        .bento-item { position: relative; overflow: hidden; }
        .bento-item img { width: 100%; height: 100%; object-fit: cover; transition: var(--transition); }
        .bento-item:hover img { transform: scale(1.05); }
        .bento-overlay { position: absolute; bottom: 30px; left: 30px; color: white; text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); }
        .bento-1 { grid-column: span 2; grid-row: span 2; }
        .bento-2 { grid-column: span 2; grid-row: span 1; }

        /* Product Grid */
        .product-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 40px 20px; }
        .p-card { text-decoration: none; position: relative; display: flex; flex-direction: column; }
        .p-img { position: relative; aspect-ratio: 1/1.3; background: #f8f8f8; overflow: hidden; margin-bottom: 15px; }
        .p-img img { width: 100%; height: 100%; object-fit: cover; transition: var(--transition); }
        .p-badge { position: absolute; top: 15px; left: 15px; background: var(--black); color: var(--white); padding: 4px 10px; font-size: 9px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; z-index: 10; }
        .p-actions { position: absolute; bottom: 0; left: 0; width: 100%; padding: 15px; display: flex; justify-content: center; gap: 10px; background: linear-gradient(to top, rgba(255, 255, 255, 0.95), transparent); transform: translateY(100%); transition: var(--transition); opacity: 0; }
        .p-card:hover .p-actions { transform: translateY(0); opacity: 1; }
        .p-card:hover .p-img img { transform: scale(1.05); }
        .action-btn { width: 35px; height: 35px; background: var(--white); border: 1px solid var(--accent-border); display: flex; align-items: center; justify-content: center; border-radius: 50%; color: var(--accent-border); font-size: 16px; transition: all 0.3s ease; }
        .action-btn:hover { background: var(--accent); color: var(--white); border-color: var(--accent-border); }
        .p-title { font-family: 'Inter', sans-serif; font-size: 14px; margin-top: 5px; letter-spacing: 0.5px; font-weight: 400; color: var(--black); opacity: 0.9; }
        .p-price-container { display: flex; align-items: center; gap: 10px; margin-top: 5px; }
        .p-price { font-size: 13px; opacity: 0.6; }

        /* Flex Sections */
        .split-section { display: flex; align-items: center; gap: 80px; }
        .split-section > div { flex: 1; }
        .discovery { background: var(--cream); }
        .split-img img { width: 100%; max-height: 600px; object-fit: cover; display: block; }

        /* Footer */
        footer { 
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('{{ asset('images/footer-bg.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; 
            padding: 80px 5% 40px; 
            display: grid; 
            grid-template-columns: 2fr 1fr 1fr 1fr; 
            gap: 60px; 
            position: relative; 
        }
        footer::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(181, 164, 139, 0.3), transparent); }
        .footer-logo { font-family: 'Cormorant Garamond'; font-size: 36px; letter-spacing: 6px; margin-bottom: 25px; background: linear-gradient(135deg, #ffffff 0%, #b5a48b 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .footer-col h4 { font-size: 18px;font-weight: 600; text-transform: uppercase; letter-spacing: 2.5px; margin-bottom: 30px; color: var(--accent); position: relative; padding-bottom: 12px; }
        .footer-col h4::after { content: ''; position: absolute; bottom: 0; left: 0; width: 30px; height: 1px; background: var(--accent); }
        .footer-col ul li { margin-bottom: 14px; font-size: 15px; opacity: 0.7; transition: all 0.3s ease; display: flex; align-items: start; gap: 10px; }
        .footer-col ul li i { color: var(--accent); font-size: 14px; opacity: 0.8; }
        .footer-col ul li a:hover { opacity: 1; color: var(--accent); transform: translateX(5px); }
        .footer-bottom { grid-column: span 4; display: flex; justify-content: space-between; align-items: center; padding-top: 30px; border-top: 1px solid rgba(255, 255, 255, 0.05); font-size: 14px; opacity: 0.6; }

        /* Social Icons Refinement */
        .social-links { display: flex; gap: 15px; margin-top: 30px; }
        .social-link { 
            width: 40px; 
            height: 40px; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            transition: all 0.4s ease;
            color: white;
            opacity: 0.7;
        }
        .social-link:hover { 
            border-color: var(--accent); 
            color: var(--black); 
            opacity: 1; 
            transform: translateY(-5px);
            background: rgba(212, 175, 55, 0.05);
        }
        .social-link i { font-size: 18px; }

        /* Utility */
        .section-padding { padding: 100px 8%; }
        .btn-luxe { display: inline-block; padding: 18px 45px; border: 1px solid var(--accent); background: var(--accent); color: var(--white); font-size: 11px; text-transform: uppercase; letter-spacing: 2px; }
        .btn-luxe:hover { background: var(--accent-hover); border-color: var(--accent-hover); color: var(--white); }

        /* Hide Mobile Nav on Desktop */
        .mobile-bottom-nav { display: none; }
        
        @media (max-width: 1024px) {
            .bento { grid-template-columns: repeat(2, 1fr); grid-auto-rows: 300px; }
            .product-grid { grid-template-columns: repeat(2, 1fr); }
            .split-section { flex-direction: column; text-align: center; gap: 40px; }
            footer { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-desktop { display: none; }
            .menu-toggle { display: flex; }
            .bento { grid-template-columns: 1fr; grid-auto-rows: 400px; padding: 10px; }
            .bento-1, .bento-2 { grid-column: span 1; grid-row: span 1; }
            footer { grid-template-columns: 1fr; text-align: center; }
            .footer-bottom { grid-column: span 1; flex-direction: column; gap: 20px; }
            .section-padding { padding: 60px 5%; }
            
            /* --- Mobile Bottom Nav Styles --- */
            .mobile-bottom-nav {
                display: none;
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 70px;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border-top: 1px solid var(--border);
                z-index: 1000;
                justify-content: space-around;
                align-items: center;
                padding-bottom: env(safe-area-inset-bottom);
            }

            .nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: var(--black);
                flex: 1;
                gap: 5px;
                transition: opacity 0.3s ease;
            }

            .nav-item svg {
                width: 22px;
                height: 22px;
                opacity: 0.7;
            }

            .nav-item span {
                font-family: 'Space Mono', monospace;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 1px;
                opacity: 0.6;
            }

            .nav-item.active svg,
            .nav-item.active span {
                opacity: 1;
            }

            /* Cart Badge in Bottom Nav */
            .cart-icon-wrapper {
                position: relative;
            }

            .cart-badge {
                position: absolute;
                top: -5px;
                right: -8px;
                background: var(--accent);
                color: white;
                font-family: 'Inter';
                font-size: 8px;
                width: 14px;
                height: 14px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
            }

            .mobile-bottom-nav { display: flex; padding-top: 10px;}
            body { padding-bottom: 70px; }
        }

        .footer-brand .social-links { margin-top: 20px; }

        /* Search Overlay Styles */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 10, 0.98);
            backdrop-filter: blur(20px);
            z-index: 2000;
            display: flex;
            flex-direction: column;
            padding: 100px 10%;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            color: white;
        }
        .search-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .search-close {
            position: absolute;
            top: 40px;
            right: 6%;
            font-size: 30px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .search-close:hover { transform: rotate(90deg); }
        .search-input-wrapper {
            position: relative;
            margin-bottom: 50px;
        }
        .search-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 2px solid rgba(255,255,255,0.1);
            font-size: 40px;
            font-family: 'Cormorant Garamond';
            padding: 20px 0;
            outline: none;
            transition: border-color 0.3s ease;
            color: white;
        }
        .search-input:focus { border-color: var(--accent); }
        .search-results {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 40px;
            overflow-y: auto;
            padding-bottom: 50px;
        }
        .search-result-item {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 15px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .search-result-item:hover {
            background: rgba(0,0,0,0.03);
            transform: translateY(-2px);
        }
        .search-result-img {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 4px;
        }
        .search-result-info h3 {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
            color: var(--black);
        }
        .search-result-info p {
            font-size: 14px;
            color: var(--accent);
            font-weight: 600;
        }
        .no-results {
            text-align: center;
            font-family: 'Cormorant Garamond';
            font-size: 24px;
            opacity: 0.5;
            grid-column: 1 / -1;
            padding: 50px 0;
        }
    </style>
    @yield('styles')
    @stack('styles')
</head>
<body class="bg-white overflow-x-hidden antialiased">
    <div id="scroll-progress"></div>
    @include('partials.topbar')
    <nav id="navbar">
        @php
            $cartCount = 0;
            if(auth()->check()) {
                $cartCount = \App\Models\CartItem::where('user_id', '=', auth()->id(), 'and')->count();
            } else {
                $cartCount = count(session('cart', []));
            }
        @endphp
        <div class="logo">
            @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
            <a href="{{ url('/') }}">
                @if($siteLogo)
                    <img src="{{ asset($siteLogo) }}" alt="{{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}">
                @else
                    {{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}
                @endif
            </a>
        </div>
        
        <!-- Desktop Menu -->
        <ul class="nav-desktop">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('shop') }}" class="nav-link">Shop</a>
            </li>
            @php
                $navMenu = \App\Models\Setting::get('nav_menu_json', []);
            @endphp
            @foreach($navMenu as $link)
                <li class="nav-item group">
                    <a href="{{ $link['url'] }}" class="nav-link flex items-center gap-1">
                        {{ $link['label'] }}
                        @if(isset($link['children']) && count($link['children']) > 0)
                            <i class="ri-arrow-down-s-line text-sm opacity-50"></i>
                        @endif
                    </a>
                    @if(isset($link['children']) && count($link['children']) > 0)
                        <div class="dropdown-menu">
                            @foreach($link['children'] as $child)
                                <a href="{{ $child['url'] }}" class="dropdown-item">{{ $child['label'] }}</a>
                            @endforeach
                        </div>
                    @endif
                </li>
            @endforeach
            <li class="nav-item">
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
            </li>
        </ul>

        <div class="nav-actions flex gap-4 items-center text-[#d4af37]" x-data="{}">
            <a href="javascript:void(0)" @click="$dispatch('open-search')" class="text-xl hover:text-accent transition-colors"><i class="ri-search-line"></i></a>
            <a href="{{ Auth::check() ? route('wishlist.index') : route('login') }}" class="text-xl relative hover:text-accent transition-colors">
                <i class="ri-heart-line"></i>
                @auth
                <span class="wishlist-count-display absolute -top-1 -right-2 bg-accent text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-black">{{ auth()->user()->wishlists()->count() }}</span>
                @endauth
            </a>
            <a href="{{ Auth::check() ? route('account.index') : route('login') }}" class="text-xl hover:text-accent transition-colors"><i class="ri-user-line"></i></a>
            <button class="hover:text-accent transition-colors relative" onclick="toggleCart()">
                <i class="ri-shopping-bag-line text-2xl"></i>
                <span class="cart-count-badge absolute -top-1 -right-2 bg-accent text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-black">{{ $cartCount }}</span>
            </button>
            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu / Offcanvas -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay" onclick="toggleMenu()"></div>
    <div class="mobile-menu" id="mobileMenu" x-data="{ openSub: null }">
        <div class="mobile-header">
            <div class="logo">MENU</div>
            <button onclick="toggleMenu()" class="text-3xl text-[#d4af37]"><i class="ri-close-line"></i></button>
        </div>

        <div class="mobile-search">
            <form action="{{ route('shop') }}" method="GET">
                <input type="text" name="search" placeholder="SEARCH OUR ATELIER..." value="{{ request('search') }}">
                <button type="submit"><i class="ri-search-line"></i></button>
            </form>
        </div>
        
        <div class="mobile-nav-links">
            <a href="{{ url('/') }}" class="mobile-nav-link">Home <i class="ri-arrow-right-line text-lg opacity-30"></i></a>
            <a href="{{ route('shop') }}" class="mobile-nav-link">Shop <i class="ri-arrow-right-line text-lg opacity-30"></i></a>
            
            @foreach(\App\Models\Setting::get('nav_menu_json', []) as $index => $link)
                <div class="w-full">
                    <div class="mobile-nav-link cursor-pointer" @click="openSub === {{ $index }} ? openSub = null : openSub = {{ $index }}">
                        <span>{{ $link['label'] }}</span>
                        @if(isset($link['children']) && count($link['children']) > 0)
                        <i class="ri-add-line transition-transform duration-300" :class="{'rotate-45': openSub === {{ $index }}}"></i>
                        @else
                        <i class="ri-arrow-right-line text-lg opacity-30"></i>
                        @endif
                    </div>
                    @if(isset($link['children']) && count($link['children']) > 0)
                        <div x-show="openSub === {{ $index }}" x-collapse class="mobile-submenu">
                            @foreach($link['children'] as $child)
                                <a href="{{ $child['url'] }}" class="mobile-sub-link">{{ $child['label'] }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            
            <a href="{{ route('contact') }}" class="mobile-nav-link">Contact <i class="ri-arrow-right-line text-lg opacity-30"></i></a>
        </div>

        <div class="mobile-footer">
            <div class="mobile-secondary-links">
                <a href="{{ route('account.index') }}" class="mobile-sec-link">Account</a>
                <a href="{{ route('wishlist.index') }}" class="mobile-sec-link">Wishlist</a>
                <a href="#" class="mobile-sec-link">Track Order</a>
                <a href="#" class="mobile-sec-link">Store Locator</a>
            </div>

            <div class="mobile-socials">
                @if($fb = \App\Models\Setting::get('social_facebook')) <a href="{{ $fb }}" target="_blank"><i class="ri-facebook-fill"></i></a> @endif
                @if($ig = \App\Models\Setting::get('social_instagram')) <a href="{{ $ig }}" target="_blank"><i class="ri-instagram-line"></i></a> @endif
                @if($tw = \App\Models\Setting::get('social_twitter')) <a href="{{ $tw }}" target="_blank"><i class="ri-twitter-x-line"></i></a> @endif
                @if($pt = \App\Models\Setting::get('social_pinterest')) <a href="{{ $pt }}" target="_blank"><i class="ri-pinterest-line"></i></a> @endif
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <!-- Search Overlay -->
    <div 
        class="search-overlay" 
        x-data="searchComponent()" 
        :class="{ 'active': isOpen }"
        @open-search.window="openSearch()"
        @keydown.escape.window="closeSearch()"
    >
        <div class="search-close text-[#d4af37]" @click="closeSearch()">
            <i class="ri-close-line"></i>
        </div>

        <div class="search-input-wrapper">
            <input 
                type="text" 
                class="search-input" 
                placeholder="Search our atelier..." 
                x-model.debounce.300ms="query"
                x-ref="searchInput"
                @input="fetchResults()"
            >
            <div x-show="loading" class="absolute right-0 top-1/2 -translate-y-1/2">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-black"></div>
            </div>
        </div>

        <div class="search-results" x-show="query.length > 0">
            <template x-for="product in results" :key="product.id">
                <a :href="product.url" class="search-result-item">
                    <img :src="product.image" :alt="product.name" class="search-result-img">
                    <div class="search-result-info">
                        <h3 x-text="product.name"></h3>
                        <p x-text="'$' + product.price"></p>
                    </div>
                </a>
            </template>
            <div class="no-results" x-show="!loading && results.length === 0 && query.length > 0">
                No exquisite matches found for "<span x-text="query"></span>"
            </div>
        </div>
        
        <div class="popular-searches" x-show="query.length === 0">
            <h4 class="text-xs uppercase tracking-widest opacity-40 mb-6">Popular Highlights</h4>
            <div class="flex flex-wrap gap-4">
                <button @click="query = 'Niche'; fetchResults()" class="px-6 py-2 border border-gray-100 rounded-full text-sm hover:bg-black hover:text-white transition-all duration-300">Niche</button>
                <button @click="query = 'Oud'; fetchResults()" class="px-6 py-2 border border-gray-100 rounded-full text-sm hover:bg-black hover:text-white transition-all duration-300">Oud</button>
                <button @click="query = 'Floral'; fetchResults()" class="px-6 py-2 border border-gray-100 rounded-full text-sm hover:bg-black hover:text-white transition-all duration-300">Floral</button>
                <button @click="query = 'New Arrival'; fetchResults()" class="px-6 py-2 border border-gray-100 rounded-full text-sm hover:bg-black hover:text-white transition-all duration-300">New Arrival</button>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-brand">
            <div class="footer-logo">{{ \App\Models\Setting::get('site_name', 'L\'ESSENCE') }}</div>
            <p class="text-sm opacity-60">{{ \App\Models\Setting::get('site_description', 'Curating the world\'s finest olfactory experiences.') }}</p>
            <div class="social-links mt-8">
                @if($fb = \App\Models\Setting::get('social_facebook')) <a href="{{ $fb }}" target="_blank" class="social-link" title="Facebook"><i class="ri-facebook-fill"></i></a> @endif
                @if($ig = \App\Models\Setting::get('social_instagram')) <a href="{{ $ig }}" target="_blank" class="social-link" title="Instagram"><i class="ri-instagram-line"></i></a> @endif
                @if($tw = \App\Models\Setting::get('social_twitter')) <a href="{{ $tw }}" target="_blank" class="social-link" title="Twitter"><i class="ri-twitter-x-line"></i></a> @endif
                @if($pt = \App\Models\Setting::get('social_pinterest')) <a href="{{ $pt }}" target="_blank" class="social-link" title="Pinterest"><i class="ri-pinterest-line"></i></a> @endif
            </div>
        </div>
        <div class="footer-col">
            <h4>Shop</h4>
            <ul>
                <li><a href="#">All Perfumes</a></li>
                <li><a href="#">Attar / Oils</a></li>
                <li><a href="#">Home Fragrance</a></li>
                <li><a href="#">Gift Sets</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Atelier</h4>
            <ul>
                @foreach(\App\Models\Setting::get('nav_menu_json', []) as $link)
                <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
                @endforeach
                <li><a href="#">Our Story</a></li>
                <li><a href="#">Journal</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Client Care</h4>
            <ul>
                <li><i class="ri-message-line"></i> <a href="#">Contact Us</a></li>
                @if($phone = \App\Models\Setting::get('contact_phone')) 
                    <li><i class="ri-phone-line"></i> <a href="tel:{{ $phone }}">{{ $phone }}</a></li> 
                @endif
                @if($email = \App\Models\Setting::get('contact_email')) 
                    <li><i class="ri-mail-line"></i> <a href="mailto:{{ $email }}">{{ $email }}</a></li> 
                @endif
                @if($addr = \App\Models\Setting::get('contact_address')) 
                    <li>
                        <i class="ri-map-pin-line"></i>
                        <span class="text-xs opacity-70 leading-relaxed">{{ $addr }}</span>
                    </li> 
                @endif
            </ul>
        </div>
        <div class="footer-bottom">
            <div class="copyright-text">{{ \App\Models\Setting::get('footer_copyright', '© 2026 L\'ESSENCE NYC. All rights reserved.') }}</div>
            <div class="footer-legal-links">
                <a href="{{ route('privacy') }}">Privacy Policy</a>
                <a href="{{ route('terms') }}">Terms & Conditions</a>
            </div>
        </div>
    </footer>

    <div class="mobile-bottom-nav">
        <a href="javascript:void(0)" class="nav-item" onclick="toggleMenu()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
            <span>Menu</span>
        </a>
        <a href="{{ route('shop') }}" class="nav-item {{ request()->routeIs('shop') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="3" y="3" width="7" height="7" />
                <rect x="14" y="3" width="7" height="7" />
                <rect x="14" y="14" width="7" height="7" />
                <rect x="3" y="14" width="7" height="7" />
            </svg>
            <span>Shop</span>
        </a>
        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            </svg>
            <span>Home</span>
        </a>
        <a href="#" class="nav-item" onclick="toggleCart()">
            <div class="cart-icon-wrapper">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 0 1-8 0" />
                </svg>
                <span class="cart-badge cart-count-badge">{{ $cartCount }}</span>
            </div>
            <span>Bag</span>
        </a>
        <a href="{{ Auth::check() ? route('account.index') : route('login') }}" class="nav-item {{ request()->routeIs('account.*') || request()->routeIs('login') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            <span>Account</span>
        </a>
    </div>

    <!-- Quick View Modal -->
    <div id="quickViewModal" class="fixed inset-0 z-[2000] hidden items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeQuickView()"></div>
        
        <!-- Modal Content -->
        <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto relative m-4 shadow-2xl animate-fade-in-up p-8">
            <button onclick="closeQuickView()" class="absolute top-4 right-4 text-2xl opacity-50 hover:opacity-100 transition-opacity">&times;</button>
            <div id="quickViewContent">
                <!-- Content loaded via AJAX -->
                <div class="flex items-center justify-center py-20">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-black"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Cart Drawer -->
    <div class="cart-overlay" id="cartOverlay"></div>

    <div class="cart-drawer" id="cartDrawer">
        <div class="cart-drw-header">
            <h2 class="serif">Shopping Bag</h2>
            <button class="close-cart" onclick="toggleCart()">&times;</button>
        </div>

        <div class="cart-drw-body" id="cart-drawer-body">
             <div class="h-full flex flex-col items-center justify-center text-center opacity-50">
                <p>Loading...</p>
            </div>
        </div>

        <div class="cart-drw-footer">
            <div class="subtotal-row">
                <span>Subtotal</span>
                <span id="cart-subtotal">$0.00</span>
            </div>
            <p style="font-size: 11px; opacity: 0.5; margin-bottom: 20px;">Shipping & taxes calculated at checkout. Complimentary gift wrapping included.</p>
            <button class="checkout-btn" onclick="location.href='{{ route('checkout') }}'">Continue to Checkout</button>
        </div>
    </div>

    <!-- Scripting -->
    <script>
        // Use Toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "timeOut": "3000",
        };

        // Global State & Navigation
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            const toggle = document.querySelector('.menu-toggle');
            
            menu.classList.toggle('active');
            overlay.classList.toggle('active');
            toggle.classList.toggle('active');
            
            if (menu.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

        // Quick View Initialization
        const modal = document.getElementById('quickViewModal');
        const content = document.getElementById('quickViewContent');

        function openQuickView(productSlug) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            content.innerHTML = '<div class="h-96 flex items-center justify-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-black"></div></div>';

            fetch(`/product/${productSlug}/quick-view`)
                .then(response => response.text())
                .then(html => {
                    content.innerHTML = html;
                    
                    // Initialize Swipers
                    var swiperThumbs = new Swiper(".mySwiper", {
                        spaceBetween: 10,
                        slidesPerView: 4,
                        freeMode: true,
                        watchSlidesProgress: true,
                    });

                    new Swiper(".mySwiper2", {
                        loop: true,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        thumbs: {
                            swiper: swiperThumbs,
                        },
                    });

                    // Initialize Logic
                    initQuickView();
                    
                    // Bind Cart Form
                    const form = document.getElementById('add-to-cart-form');
                    if(form){
                        form.addEventListener('submit', function(e){
                            e.preventDefault();
                            addToCart(new FormData(this));
                        });
                        
                        const btn = document.getElementById('add-to-cart-btn');
                        if(btn){
                            btn.addEventListener('click', function(e){
                                e.preventDefault();
                                if(!this.disabled) addToCart(new FormData(form));
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    content.innerHTML = '<div class="p-8 text-center text-red-500">Failed to load product.</div>';
                });
        }

        function closeQuickView() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // --- Cart Functions ---

        function toggleCart() {
            const drawer = document.getElementById('cartDrawer');
            const overlay = document.getElementById('cartOverlay');
            
            if (drawer.classList.contains('active')) {
                drawer.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            } else {
                drawer.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
                refreshCart();
            }
        }

        function refreshCart() {
            fetch('{{ route("cart.get") }}')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('cart-drawer-body').innerHTML = data.html;
                    document.getElementById('cart-subtotal').innerText = '$' + data.subtotal;
                    updateCartCount(data.count);
                });
        }

        function updateCartCount(count) {
             document.querySelectorAll('.cart-count-badge').forEach(el => el.innerText = count);
        }

        function quickAdd(productId) {
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            addToCart(formData);
        }

        function addToCart(formData) {
            const btn = document.querySelector('#add-to-cart-btn');
            const originalText = btn ? btn.innerText : '';
            if(btn) btn.innerText = 'Adding...';

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    if(!document.getElementById('quickViewModal').classList.contains('hidden')) {
                        closeQuickView();
                    }
                    toastr.success(data.message);
                    refreshCart();
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                if(btn) btn.innerText = originalText;
            });
        }

        function removeFromCart(key) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ key: key })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('cart-drawer-body').innerHTML = data.html;
                document.getElementById('cart-subtotal').innerText = '$' + data.subtotal;
                updateCartCount(data.count);
            });
        }

        function updateCartQty(key, quantity) {
             fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ key: key, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('cart-drawer-body').innerHTML = data.html;
                document.getElementById('cart-subtotal').innerText = '$' + data.subtotal;
                updateCartCount(data.count);
            });
        }

        // --- Attribute Logic ---

        function initQuickView() {
            const groups = document.querySelectorAll('.attribute-group');
            if (groups.length === 0) return;

            groups.forEach(group => {
                 const firstInput = group.querySelector('input');
                 if(firstInput) firstInput.checked = true;
            });
            handleAttributeChange();
        }

        function handleAttributeChange() {
            const form = document.getElementById('add-to-cart-form');
            if(!form) return;

            const variantsData = form.getAttribute('data-variants');
            if(!variantsData) return;
            
            const variants = JSON.parse(variantsData);
            const selected = {};
            let allSelected = true;

            document.querySelectorAll('.attribute-group').forEach(group => {
                const name = group.getAttribute('data-attribute');
                const checked = group.querySelector('input:checked');
                if(checked) {
                    selected[name] = parseInt(checked.value);
                } else {
                    allSelected = false;
                }
            });

            const btn = document.getElementById('add-to-cart-btn');
            const priceDisplay = document.getElementById('main-price-display');
            const hiddenInput = document.getElementById('selected-variant-id');
            const errorMsg = document.getElementById('variant-error');

            if(!allSelected) {
                if(btn) { btn.disabled = true; btn.innerText = 'Select Options'; }
                return;
            }

            const match = variants.find(variant => {
                return Object.entries(selected).every(([key, value]) => {
                    return variant.attributes[key] === value;
                });
            });

            if(match) {
                if(priceDisplay) priceDisplay.innerText = '$' + parseFloat(match.price).toFixed(2);
                if(hiddenInput) hiddenInput.value = match.id;
                if(btn) { btn.disabled = false; btn.innerText = 'Add to Bag'; }
                if(errorMsg) errorMsg.classList.add('hidden');
            } else {
                if(priceDisplay) priceDisplay.innerText = 'Unavailable';
                if(hiddenInput) hiddenInput.value = '';
                if(btn) { btn.disabled = true; btn.innerText = 'Unavailable'; }
                if(errorMsg) { errorMsg.innerText = 'Unavailable'; errorMsg.classList.remove('hidden'); }
            }
        }

        function qvIncrement() {
            const input = document.getElementById('qv-qty');
            if(input) input.value = parseInt(input.value) + 1;
        }

        function qvDecrement() {
            const input = document.getElementById('qv-qty');
            if(input && parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        }
    </script>

    @include('components.popup')
    
    @yield('scripts')
    @stack('scripts')

    <script>
        function searchComponent() {
            return {
                isOpen: false,
                query: '',
                results: [],
                loading: false,
                openSearch() {
                    this.isOpen = true;
                    document.body.style.overflow = 'hidden';
                    setTimeout(() => this.$refs.searchInput.focus(), 100);
                },
                closeSearch() {
                    this.isOpen = false;
                    document.body.style.overflow = '';
                },
                async fetchResults() {
                    if (this.query.length < 2) {
                        this.results = [];
                        return;
                    }
                    this.loading = true;
                    try {
                        const response = await fetch(`{{ route('api.search') }}?query=${encodeURIComponent(this.query)}`);
                        this.results = await response.json();
                    } catch (error) {
                        console.error('Search error:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }

        // Initialize AOS & Scroll Progress
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                easing: 'ease-out-cubic',
                offset: 50
            });

            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                const progressBar = document.getElementById("scroll-progress");
                if(progressBar) progressBar.style.width = scrolled + "%";
            });
        });

        // Force a refresh after all assets (images, sliders) are fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                AOS.refresh();
                // Force a layout recalculation for libraries like Swiper & AOS
                window.dispatchEvent(new Event('resize'));
            }, 800);
        });
    </script>
</body>
</html>
