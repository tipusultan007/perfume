@extends('layouts.store')

@section('styles')
<style>
    .auth-container {
        max-width: 450px;
        margin: 100px auto;
        padding: 0 20px;
        text-align: center;
    }

    .auth-container h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .auth-container p {
        opacity: 0.6;
        margin-bottom: 40px;
        font-size: 14px;
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
        background: var(--black);
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        margin-top: 20px;
        transition: var(--transition);
    }

    .btn-login:hover {
        opacity: 0.9;
    }

    .auth-switch {
        margin-top: 30px;
        font-size: 13px;
        opacity: 0.7;
    }

    .auth-switch a {
        text-decoration: underline;
        color: var(--black);
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    <h2 class="serif">Login</h2>
    <p>Welcome back. Please enter your details.</p>

    <form action="{{ route('login') }}" method="POST" class="auth-form">
        @csrf
        
        @if($errors->any())
            <div style="background: #ffebee; color: #c62828; padding: 15px; margin-bottom: 20px; font-size: 14px; border-radius: 4px;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 12px; cursor: pointer;">
                <input type="checkbox" name="remember"> Remember Me
            </label>
            <a href="#" style="font-size: 12px; opacity: 0.6;">Forgot Password?</a>
        </div>

        <button type="submit" class="btn-login">Sign In</button>
    </form>

    <div class="auth-switch">
        New to L'Essence? <a href="{{ route('register') }}">Create an account</a>
    </div>
</div>
@endsection
