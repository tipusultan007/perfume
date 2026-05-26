@extends('layouts.store')

@section('title', "Shipping & Delivery Policy | NewKirk NYC")

@section('content')
<div class="container legal-page">
    <div class="legal-header">
        <h1 class="serif">Shipping & Delivery</h1>
        <p class="text-sm opacity-60">Last updated: May 26, 2026</p>
    </div>

    <div class="legal-layout">
        <!-- Sticky Sidebar Navigation -->
        <aside class="legal-sidebar">
            <nav class="sticky-nav">
                <h3>Policy Center</h3>
                <ul>
                    <li><a href="{{ route('shipping') }}" class="active-link">Shipping & Delivery</a></li>
                    <li><a href="{{ route('refunds') }}">Returns & Refunds</a></li>
                    <li><a href="{{ route('authenticity') }}">Authenticity Guarantee</a></li>
                    <li><a href="{{ route('accessibility') }}">Accessibility Statement</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Document Body -->
        <div class="legal-content">
            <section id="hazmat-warning">
                <div class="legal-warning">
                    <strong>⚠️ HAZMAT SHIPPING REGULATION:</strong> Perfumes and colognes contain alcohol and are classified as flammable liquids (Hazardous Materials) by the U.S. Department of Transportation. Because of this regulation, all fragrance shipments must be shipped via ground transport only. Expedited, overnight, or air shipping is not available for fragrances.
                </div>
            </section>

            <section id="rates">
                <h2>1. Shipping Rates & Processing Times</h2>
                <p>We work to process and dispatch all orders as quickly as possible. Please review our processing and delivery timelines below:</p>
                <ul>
                    <li><strong>Order Processing:</strong> Orders are processed within 1-2 business days (excluding weekends and major holidays). You will receive a notification email once your shipping label has been generated.</li>
                    <li><strong>Standard Ground Shipping:</strong> Free shipping is provided for all orders over $150. For orders under $150, a flat shipping rate of $9.95 applies.</li>
                    <li><strong>Delivery Times:</strong> Once shipped, standard ground deliveries typically take 3-7 business days depending on your distance from our warehouse in New York.</li>
                </ul>
            </section>

            <section id="carriers">
                <h2>2. Shipping Carriers & Tracking</h2>
                <p>We partner with leading domestic carriers to ensure your package arrives safely:</p>
                <ul>
                    <li>Our primary carriers for ground transport are <strong>UPS Ground</strong> and <strong>USPS Ground Advantage</strong>.</li>
                    <li>A tracking link will be emailed to you as soon as your package is scanned by the carrier. You can also track your orders directly inside your NewKirk NYC account dashboard under the "Orders" section.</li>
                    <li>Please allow up to 24 hours for the tracking information to update on the carrier's network.</li>
                </ul>
            </section>

            <section id="restrictions">
                <h2>3. Delivery Restrictions</h2>
                <p>Due to safety regulations, our deliveries are subject to the following geographical constraints:</p>
                <ul>
                    <li>We ship strictly to addresses within the <strong>Continental United States</strong> (Lower 48 states).</li>
                    <li>We cannot ship fragrances to Alaska, Hawaii, Puerto Rico, Guam, or U.S. Virgin Islands.</li>
                    <li>We cannot ship to P.O. Boxes or military APO/FPO/DPO addresses.</li>
                    <li>International shipping is currently unavailable.</li>
                </ul>
            </section>

            <section id="damage">
                <h2>4. Damaged or Broken Items in Transit</h2>
                <p>Luxury perfume bottles are made of glass and require careful handling. We package all bottles securely in custom foam inserts, but breaks can occasionally occur during transit.</p>
                <p>If your fragrance bottle arrives damaged or broken, please take the following steps within <strong>48 hours</strong> of delivery:</p>
                <ol style="padding-left: 20px; margin-bottom: 20px;">
                    <li>Keep the original box and packaging materials.</li>
                    <li>Take clear photos of the damaged bottle, packaging, and the shipping label.</li>
                    <li>Email the photos and your order number to <a href="mailto:info@newkirkperfumesusa.com">info@newkirkperfumesusa.com</a>.</li>
                </ol>
                <p>Once verified, we will arrange for a replacement bottle to be shipped to you immediately at no additional cost.</p>
            </section>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .legal-page {
        padding-top: 150px;
        padding-bottom: 100px;
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .legal-header {
        text-align: center;
        margin-bottom: 60px;
    }
    .legal-header h1 {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        margin-bottom: 20px;
    }
    
    .legal-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 60px;
        align-items: start;
    }
    
    @media (max-width: 991px) {
        .legal-layout {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        .legal-sidebar {
            display: none;
        }
    }
    
    .legal-sidebar {
        position: sticky;
        top: 100px;
        align-self: start;
        border-right: 1px solid rgba(0, 0, 0, 0.08);
        padding-right: 20px;
    }
    .sticky-nav h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .sticky-nav ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }
    .sticky-nav li {
        margin-bottom: 12px;
    }
    .sticky-nav a {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: rgba(0, 0, 0, 0.6);
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .sticky-nav a:hover, .sticky-nav .active-link {
        color: #000;
        font-weight: 600;
    }

    .legal-content {
        font-family: 'Inter', sans-serif;
        line-height: 1.8;
        color: rgba(0, 0, 0, 0.8);
    }
    .legal-content h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        color: #000;
        margin-top: 30px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding-bottom: 10px;
    }
    .legal-content p {
        margin-bottom: 20px;
    }
    .legal-content ul {
        margin-bottom: 20px;
        list-style: disc;
        padding-left: 20px;
    }
    .legal-content li {
        margin-bottom: 10px;
    }
    .legal-warning {
        background: rgba(220, 53, 69, 0.03);
        border-left: 3px solid #dc3545;
        padding: 15px 20px;
        font-weight: 500;
        color: rgba(0, 0, 0, 0.9);
        margin-bottom: 30px;
    }
</style>
@endsection
