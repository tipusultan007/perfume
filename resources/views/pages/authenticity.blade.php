@extends('layouts.store')

@section('title', "Authenticity Guarantee | NewKirk NYC")

@section('content')
<div class="container legal-page">
    <div class="legal-header">
        <h1 class="serif">Authenticity Guarantee</h1>
        <p class="text-sm opacity-60">Last updated: May 26, 2026</p>
    </div>

    <div class="legal-layout">
        <!-- Sticky Sidebar Navigation -->
        <aside class="legal-sidebar">
            <nav class="sticky-nav">
                <h3>Policy Center</h3>
                <ul>
                    <li><a href="{{ route('shipping') }}">Shipping & Delivery</a></li>
                    <li><a href="{{ route('refunds') }}">Returns & Refunds</a></li>
                    <li><a href="{{ route('authenticity') }}" class="active-link">Authenticity Guarantee</a></li>
                    <li><a href="{{ route('accessibility') }}">Accessibility Statement</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Document Body -->
        <div class="legal-content">
            <section id="guarantee-statement">
                <div class="legal-warning">
                    <strong>🛡️ OUR PROMISE:</strong> Every single item sold on newkirkperfumesusa.com is guaranteed to be 100% authentic, original, and brand-new. We do not sell knock-offs, imitations, testers, or grey-market perfumes that have been tampered with.
                </div>
            </section>

            <section id="sourcing">
                <h2>1. Direct Sourcing & Supply Chain</h2>
                <p>Authenticity is the foundation of NewKirk NYC. To maintain complete control over our product quality, we enforce strict standards on where our luxury scents are acquired:</p>
                <ul>
                    <li>We source our collections directly from the luxury design houses or their authorized, vetted distributors.</li>
                    <li>Every shipment arriving at our facility undergoes a rigorous quality check to confirm packaging integrity, cellophane weight, wrap folds, and designer labels.</li>
                    <li>All products are delivered to you in their original manufacturer packaging, complete with seals, inserts, and luxury boxing.</li>
                </ul>
            </section>

            <section id="batch-codes">
                <h2>2. Original Manufacturer Batch Codes</h2>
                <p>To verify the production details of your fragrance, you can check its unique batch code:</p>
                <ul>
                    <li>Every perfume bottle we sell features the original manufacturer's **batch code** engraved or stamped on the bottom of the glass bottle.</li>
                    <li>This exact same code is also stamped or printed on the bottom of the outer designer box. These numbers will always match.</li>
                    <li>We never scratch, alter, or remove batch codes. Altered codes are a common indicator of unauthorized grey-market products or counterfeits. With NewKirk NYC, you can cross-reference our batch codes on independent verification portals to confirm the fragrance’s production year and authenticity.</li>
                </ul>
            </section>

            <section id="storage">
                <h2>3. Climate-Controlled Storage</h2>
                <p>Fragrance notes are delicate chemical formulations that can break down if exposed to light, heat, or humidity. To ensure that your perfume arrives in perfect, factory-fresh condition:</p>
                <ul>
                    <li>All stock is housed in our dark, dust-free warehouse facility.</li>
                    <li>We maintain a constant temperature of **60°F - 65°F (15°C - 18°C)** year-round, which is the optimal storage temperature for preservation.</li>
                    <li>We protect our warehouse from direct sunlight and ultraviolet exposure, ensuring the top, middle, and base notes of your fragrance remain fully intact.</li>
                </ul>
            </section>

            <section id="disclaimer">
                <h2>4. Trademark and Affiliation Disclaimer</h2>
                <p>NewKirk NYC, LLC is an independent boutique retailer. While we sell authentic luxury products from globally recognized design houses, we do not claim direct affiliation, partnership, or sponsorship with the luxury brands showcased on our store unless explicitly stated. All brand names, trademarks, logos, and copyrights remain the sole property of their respective design houses.</p>
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
        background: rgba(40, 167, 69, 0.03);
        border-left: 3px solid #28a745;
        padding: 15px 20px;
        font-weight: 500;
        color: rgba(0, 0, 0, 0.9);
        margin-bottom: 30px;
    }
</style>
@endsection
