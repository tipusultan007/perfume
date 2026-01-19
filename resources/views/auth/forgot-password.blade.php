@extends('layouts.store')

@section('styles')
<style>
    .auth-container {
        max-width: 450px;
        margin: 175px auto 100px auto;
        padding: 0 20px;
        text-align: center;
    }

    .auth-container h2 {
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .auth-container p {
        opacity: 0.6;
        margin-bottom: 30px;
        font-size: 14px;
        line-height: 1.6;
    }

    .auth-form {
        text-align: left;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        opacity: 0.7;
    }

    .form-group input {
        width: 100%;
        padding: 15px;
        border: 1px solid var(--border);
        background: transparent;
        font-family: 'Inter';
        font-size: 14px;
        outline: none;
        transition: var(--transition);
    }

    .form-group input:focus {
        border-color: var(--black);
    }

    .btn-login {
        width: 100%;
        padding: 18px;
        background: var(--accent);
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        margin-top: 10px;
        transition: var(--transition);
    }

    .btn-login:hover {
        opacity: 0.9;
    }

    .error-msg {
        color: #c62828;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <h2 class="serif uppercase tracking-widest">Forgot Password?</h2>
    <p>Enter your email address and we will send you a link to reset your password.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-sm text-green-600" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-login">
            Email Password Reset Link
        </button>
    </form>
    
    <div class="auth-switch mt-8 text-xs opacity-60">
        <a href="{{ route('login') }}" class="uppercase tracking-widest underline">Back to Login</a>
    </div>
</div>
@endsection
