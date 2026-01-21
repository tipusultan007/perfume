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
        font-family: 'Montserrat';
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
    <h2 class="serif">Register</h2>
    <p>Join the inner circle. Create your account.</p>

    <form action="{{ route('register') }}" method="POST" class="auth-form">
        @csrf

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn-login">Create Account</button>
    </form>

    <div class="auth-switch">
        Already have an account? <a href="{{ route('login') }}">Sign In</a>
    </div>
</div>
@endsection
