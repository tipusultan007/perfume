@extends('layouts.store')

@section('title', "Terms & Conditions | L'ESSENCE NYC")

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
        <h1 class="serif">Terms & Conditions</h1>
        <p class="text-sm opacity-60">Last updated: January 20, 2026</p>
    </div>

    <div class="legal-content">
        <p>Welcome to L'ESSENCE. By accessing or using our website, you agree to comply with and be bound by the following terms and conditions.</p>

        <h2>1. Use of the Website</h2>
        <p>You agree to use our website for lawful purposes only and in a manner that does not infringe upon the rights of others.</p>

        <h2>2. Intellectual Property</h2>
        <p>All content on this website, including text, images, and logos, is the property of L'ESSENCE and is protected by copyright laws.</p>

        <h2>3. Product Information</h2>
        <p>We strive to provide accurate information about our products; however, we do not warrant that product descriptions or other content are error-free.</p>

        <h2>4. Limitation of Liability</h2>
        <p>L'ESSENCE shall not be liable for any direct, indirect, incidental, or consequential damages arising from the use of our website or products.</p>

        <h2>5. Governing Law</h2>
        <p>These terms and conditions are governed by the laws of the State of New York, without regard to its conflict of law principles.</p>

        <h2>6. Changes to Terms</h2>
        <p>We reserve the right to update these terms and conditions at any time. Your continued use of the website signifies your acceptance of the revised terms.</p>
    </div>
</div>
@endsection
