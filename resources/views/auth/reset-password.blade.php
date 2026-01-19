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
    <h2 class="serif uppercase tracking-widest">Reset Password</h2>
    <p>Please enter your new password below.</p>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            @error('email')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" />
            @error('password')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')<span class="error-msg">{{ $message }}</span>@enderror
        </div>

        <button type="submit" class="btn-login">
            Reset Password
        </button>
    </form>
</div>
@endsection
