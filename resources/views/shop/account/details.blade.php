@extends('shop.account.layout')

@section('account_content')
    <h3>Account Details</h3>

    <form action="{{ route('account.details') }}" method="POST" class="account-form">
        @csrf
        
        @if(session('success'))
            <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; margin-bottom: 30px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-group">
            <label>Display Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
        </div>

        <h4 class="serif" style="font-size: 20px; margin: 50px 0 25px;">Password Change</h4>

        <div class="form-group">
            <label>Current Password (leave blank to leave unchanged)</label>
            <input type="password" name="current_password">
            @error('current_password')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>New Password (leave blank to leave unchanged)</label>
            <input type="password" name="new_password">
            @error('new_password')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="new_password_confirmation">
        </div>

        <button type="submit" class="btn-save">Save Changes</button>
    </form>
@endsection
