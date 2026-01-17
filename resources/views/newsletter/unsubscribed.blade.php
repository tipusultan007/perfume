@extends('layouts.store')

@section('title', 'Unsubscribed')

@section('content')
<div class="container py-20 text-center" style="min-height: 50vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <h1 class="font-serif text-3xl mb-4">You have been unsubscribed</h1>
    <p class="mb-8 opacity-60">We are sorry to see you go. You will no longer receive emails from us.</p>
    <a href="{{ route('home') }}" class="btn-shop">Return to Home</a>
</div>
@endsection
