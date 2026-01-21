@extends('layouts.store')

@section('title', "Privacy Policy | L'ESSENCE NYC")

@section('styles')
<style>
    .legal-page {
        padding-top: 150px;
        padding-bottom: 100px;
        max-width: 900px;
        margin: 0 auto;
    }
    .legal-header {
        text-align: center;
        margin-bottom: 60px;
    }
    .legal-header h1 {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        margin-bottom: 20px;
    }
    .legal-content {
        font-family: 'Inter', sans-serif;
        line-height: 1.8;
        color: rgba(0, 0, 0, 0.8);
    }
    .legal-content h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px;
        color: var(--black);
        margin-top: 40px;
        margin-bottom: 20px;
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
</style>
@endsection

@section('content')
<div class="container legal-page">
    <div class="legal-header">
        <h1 class="serif">Privacy Policy</h1>
        <p class="text-sm opacity-60">Last updated: January 20, 2026</p>
    </div>

    <div class="legal-content">
        <p>At L'ESSENCE, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy outlines how we collect, use, and safeguard the data you provide to us through our website.</p>

        <h2>1. Information We Collect</h2>
        <p>We may collect personal information such as your name, email address, shipping address, and payment details when you make a purchase or subscribe to our newsletter.</p>

        <h2>2. How We Use Your Information</h2>
        <p>Your information is used to process your orders, provide customer support, and send you updates about our latest collections and events (with your consent).</p>

        <h2>3. Data Security</h2>
        <p>We implement industry-standard security measures to protect your personal information from unauthorized access, disclosure, or alteration.</p>

        <h2>4. Your Rights</h2>
        <p>You have the right to access, correct, or delete your personal information at any time. Please contact our atelier for assistance.</p>

        <h2>5. Cookies</h2>
        <p>Our website uses cookies to enhance your browsing experience and provide personalized content. You can manage your cookie preferences through your browser settings.</p>

        <h2>6. Contact Us</h2>
        <p>If you have any questions about our Privacy Policy, please reach out to us at atelier@lessence.nyc.</p>
    </div>
</div>
@endsection
