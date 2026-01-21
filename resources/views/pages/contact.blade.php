@extends('layouts.store')

@section('title', "Contact | L'ESSENCE NYC")

@section('styles')
<style>
    .contact-page {
        padding-top: 150px;
        padding-bottom: 100px;
    }
    .contact-header {
        text-align: center;
        margin-bottom: 80px;
    }
    .contact-header h1 {
        font-size: clamp(2.5rem, 5vw, 4rem);
        margin-bottom: 20px;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .contact-info-item {
        margin-bottom: 40px;
    }
    .contact-info-item h3 {
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--accent);
        margin-bottom: 15px;
        font-weight: 600;
    }
    .contact-info-item p {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        line-height: 1.4;
    }
    .contact-form {
        background: var(--cream);
        padding: 50px;
    }
    .form-group {
        margin-bottom: 30px;
    }
    .form-group label {
        display: block;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        opacity: 0.6;
    }
    .form-control {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding: 10px 0;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color 0.3s;
    }
    .form-control:focus {
        border-color: var(--black);
    }
    .submit-btn {
        width: 100%;
        padding: 20px;
        background: var(--black);
        color: var(--white);
        border: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        cursor: pointer;
        transition: 0.3s;
    }
    .submit-btn:hover {
        opacity: 0.9;
    }
    .map-container {
        margin-top: 100px;
        height: 500px;
        background: #f0f0f0;
    }
    @media (max-width: 991px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 50px;
        }
    }
</style>
@endsection

@section('content')
<div class="container contact-page">
    <div class="contact-header">
        <h1 class="serif">Get in Touch</h1>
        <p class="text-sm opacity-60">Whether you seek a bespoke olfactive creation or have an inquiry, our atelier is here to assist.</p>
    </div>

    <div class="contact-grid">
        <div class="contact-info">
            <div class="contact-info-item">
                <h3>Our Atelier</h3>
                <p>123 Fifth Avenue, Manhattan<br>New York, NY 10001, USA</p>
            </div>
            <div class="contact-info-item">
                <h3>Collaborations</h3>
                <p>atelier@lessence.nyc</p>
            </div>
            <div class="contact-info-item">
                <h3>Concierge</h3>
                <p>+1 (212) 555-0123<br>Available Mon-Fri, 9am - 6pm EST</p>
            </div>
            <div class="contact-info-item">
                <h3>Socials</h3>
                <div class="flex gap-4 mt-2">
                    <a href="#" class="text-lg"><i class="ri-instagram-line"></i></a>
                    <a href="#" class="text-lg"><i class="ri-facebook-fill"></i></a>
                    <a href="#" class="text-lg"><i class="ri-pinterest-line"></i></a>
                </div>
            </div>
        </div>

        <div class="contact-form-wrapper">
            @if(session('success'))
                <div class="bg-green-50 text-green-800 p-4 mb-8 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                @csrf
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label>Subject (Optional)</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                </div>
                <div class="form-group">
                    <label>Your Message</label>
                    <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</div>

<div class="map-container">
    <!-- Placeholder for Map -->
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.6173590513926!2d-73.9877477!3d40.7484405!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1737380000000!5m2!1sen!2sus" 
        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
@endsection
