@extends('emails.orders.layout')

@section('content')
    <div style="text-align: center;">
        <h1 style="font-size: 32px; letter-spacing: -0.5px; margin-bottom: 24px;">Welcome to the Atelier</h1>
        
        <p style="font-style: italic; color: #111827; margin-bottom: 30px;">Bonjour, {{ explode(' ', $user->name)[0] }}.</p>
        
        <p style="margin-bottom: 30px;">
            It is a pleasure to welcome you to the {{ \App\Models\Setting::get('site_name', "L'ESSENCE NYC") }} community. 
            At our atelier, we believe a fragrance is more than a scent—it is a signature of identity and a companion to memory.
        </p>
        
        <p style="margin-bottom: 40px;">
            Your account has been successfully curated. You may now explore our collection of signature objects, track your personal orders, and manage your preferences through your private dashboard.
        </p>
        
        <div style="margin: 45px 0;">
            <a href="{{ url('/account/dashboard') }}" class="btn">Explore the Collection</a>
        </div>
        
        <p style="font-size: 13px; opacity: 0.8; margin-top: 50px;">
            Should you require personal assistance or have inquiries regarding our olfactory creations, our team is always at your service.
        </p>
        
        <p style="margin-top: 30px; font-family: 'Georgia', serif; color: #111827;">
            With appreciation,<br>
            <strong>The {{ \App\Models\Setting::get('site_name', "L'ESSENCE NYC") }} Team</strong>
        </p>
    </div>
@endsection
