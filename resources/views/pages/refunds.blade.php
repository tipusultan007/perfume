@extends('layouts.store')

@section('title', "Returns & Refunds Policy | NewKirk NYC")

@section('content')
<div class="container legal-page">
    <div class="legal-header">
        <h1 class="serif">Returns & Refunds</h1>
        <p class="text-sm opacity-60">Last updated: May 26, 2026</p>
    </div>

    <div class="legal-layout">
        <!-- Sticky Sidebar Navigation -->
        <aside class="legal-sidebar">
            <nav class="sticky-nav">
                <h3>Policy Center</h3>
                <ul>
                    <li><a href="{{ route('shipping') }}">Shipping & Delivery</a></li>
                    <li><a href="{{ route('refunds') }}" class="active-link">Returns & Refunds</a></li>
                    <li><a href="{{ route('authenticity') }}">Authenticity Guarantee</a></li>
                    <li><a href="{{ route('accessibility') }}">Accessibility Statement</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Document Body -->
        <div class="legal-content">
            <section id="policy-overview">
                <p>We want you to be completely satisfied with your luxury purchase. However, because fragrances are personal care items, we must enforce strict guidelines regarding returns and exchanges to ensure hygiene, safety, and brand integrity.</p>
                <div class="legal-warning">
                    <strong>⚠️ RETURN ELIGIBILITY POLICY:</strong> We only accept returns on items that are **unopened, unused, and in their original sealed packaging** (original box with cellophane wrap intact). If a fragrance bottle has been opened, unsealed, or sprayed, it is strictly non-returnable and non-refundable.
                </div>
            </section>

            <section id="windows-fees">
                <h2>1. Return Windows & Restocking Fees</h2>
                <ul>
                    <li><strong>Return Window:</strong> You must request a return within <strong>30 days</strong> of the order delivery date. Requests made after 30 days will not be accepted.</li>
                    <li><strong>Restocking Fee:</strong> A 10% restocking fee is applied to all returns to cover inspection and warehouse processing costs. This fee will be deducted directly from your final refund amount.</li>
                    <li><strong>Exchanges:</strong> We do not offer direct exchanges. If you wish to swap a product, please return your unopened item for a refund and place a new order on our site.</li>
                </ul>
            </section>

            <section id="process">
                <h2>2. How to Request a Return</h2>
                <p>To initiate a return, please follow these steps:</p>
                <ol style="padding-left: 20px; margin-bottom: 20px;">
                    <li>Email us at <a href="mailto:info@newkirkperfumesusa.com">info@newkirkperfumesusa.com</a> with your order number, name, and the reason for the return.</li>
                    <li>Our team will verify eligibility and issue a **Return Authorization (RA) number** along with return instructions. Do not ship packages back without an RA number, as they will be rejected at our warehouse.</li>
                    <li>Pack the item securely to prevent breakage. Write the RA number clearly on the outside of the box.</li>
                    <li>Ship the package back using a tracked ground shipping service. **Do not ship via air transport**, as shipping fragrances via air violates federal law. We recommend UPS Ground or USPS Ground Advantage.</li>
                </ol>
            </section>

            <section id="shipping-costs">
                <h2>3. Return Shipping Costs</h2>
                <p>Customers are responsible for paying all return shipping fees. NewKirk NYC does not cover return shipping costs or provide pre-paid return labels, unless the return is due to our error (e.g. shipping the wrong item or a bottle arriving damaged).</p>
            </section>

            <section id="refund-methods">
                <h2>4. Refund Issuance</h2>
                <p>Once your return package is received at our facility, it will undergo a inspection process to ensure the cellophane wrap and bottle seals are fully intact.</p>
                <ul>
                    <li>If approved, the refund will be processed back to the original payment method used during checkout (processed via the Clover payment gateway).</li>
                    <li>Please allow **5-10 business days** for the refund credit to show up on your card statement.</li>
                    <li>Original shipping charges are non-refundable.</li>
                </ul>
            </section>

            <section id="gifts-samples">
                <h2>5. Gift Sets & Promotional Items</h2>
                <p>Please note the following restrictions for promotional orders:</p>
                <ul>
                    <li><strong>Gift Sets:</strong> Gift sets and sampler packs must be returned in their entirety. Individual bottles or items from a set cannot be returned separately.</li>
                    <li><strong>Free Gifts/Samples:</strong> If your order included a free promotional gift or sample, these items must also be returned in their original packaging. If they are not returned, their retail value will be deducted from your refund.</li>
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
        background: rgba(220, 53, 69, 0.03);
        border-left: 3px solid #dc3545;
        padding: 15px 20px;
        font-weight: 500;
        color: rgba(0, 0, 0, 0.9);
        margin-bottom: 30px;
    }
</style>
@endsection
