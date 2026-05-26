@extends('layouts.store')

@section('title', "Accessibility Statement | NewKirk NYC")

@section('content')
<div class="container legal-page">
    <div class="legal-header">
        <h1 class="serif">Accessibility Statement</h1>
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
                    <li><a href="{{ route('authenticity') }}">Authenticity Guarantee</a></li>
                    <li><a href="{{ route('accessibility') }}" class="active-link">Accessibility Statement</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Document Body -->
        <div class="legal-content">
            <section id="commitment">
                <div class="legal-warning" style="border-left-color: #0056b3; background-color: rgba(0, 86, 179, 0.03);">
                    <strong>Accessibility Commitment:</strong> NewKirk NYC is dedicated to making our digital offerings accessible to all. We are actively working to align our website (newkirkperfumesusa.com) with the Web Content Accessibility Guidelines (WCAG) 2.1 Level AA standards to provide an inclusive shopping experience.
                </div>
            </section>

            <section id="measures">
                <h2>1. Measures to Support Accessibility</h2>
                <p>We implement the following measures across our digital design and development workflows to maintain accessibility:</p>
                <ul>
                    <li><strong>Contrast Auditing:</strong> Ensuring text elements and icons meet contrast ratios against background fills to support users with low vision.</li>
                    <li><strong>Semantic HTML:</strong> Implementing semantic layout elements (headers, navigation, sidebars) and structured heading hierarchies to facilitate screen reader navigation.</li>
                    <li><strong>Keyboard Navigation:</strong> Structuring links, form fields, and shopping cart triggers to allow complete browsing and checkout capabilities using a keyboard only.</li>
                    <li><strong>Descriptive Alt Tags:</strong> Providing clear, descriptive text alternatives for product images and media files.</li>
                </ul>
            </section>

            <section id="testing">
                <h2>2. Web Standards & Testing</h2>
                <p>Our website is designed to be compatible with modern web browsers and assistive technologies, including screen readers (NVDA, JAWS, VoiceOver) and magnifying tools. We perform regular audits and manual keyboard walkthroughs to identify and remediate potential accessibility barriers.</p>
            </section>

            <section id="assistance">
                <h2>3. Contact & Checkout Assistance</h2>
                <p>If you encounter any difficulty navigating our website, viewing content, or completing a transaction, we are here to assist you:</p>
                <ul>
                    <li>Please email us at <a href="mailto:info@newkirkperfumesusa.com">info@newkirkperfumesusa.com</a> describing the issue.</li>
                    <li>Our team is trained to assist users with disabilities. If you need help placing an order or finding a product, we can walk you through the checkout process or manage your order manually via email or telephone.</li>
                    <li>We welcome your feedback. If you have suggestions on how we can improve our website's accessibility, please reach out.</li>
                </ul>
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
        background: rgba(0, 86, 179, 0.03);
        border-left: 3px solid #0056b3;
        padding: 15px 20px;
        font-weight: 500;
        color: rgba(0, 0, 0, 0.9);
        margin-bottom: 30px;
    }
</style>
@endsection
