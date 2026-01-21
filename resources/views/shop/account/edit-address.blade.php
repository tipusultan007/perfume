@extends('shop.account.layout')

@section('account_content')
    <h3>Edit {{ $typeName }}</h3>

    <form action="{{ route('account.addresses.edit', $type) }}" method="POST" class="account-form">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $address['first_name'] ?? '') }}" required>
                @error('first_name')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $address['last_name'] ?? '') }}" required>
                @error('last_name')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" value="{{ old('address', $address['address'] ?? '') }}" required>
            @error('address')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Apartment, suite, etc. (optional)</label>
            <input type="text" name="apartment" value="{{ old('apartment', $address['apartment'] ?? '') }}">
            @error('apartment')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="{{ old('city', $address['city'] ?? '') }}" required>
                @error('city')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" value="{{ old('state', $address['state'] ?? '') }}" required>
                @error('state')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>ZIP Code</label>
                <input type="text" name="zip" value="{{ old('zip', $address['zip'] ?? '') }}" required>
                @error('zip')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Country</label>
                <select name="country" class="form-control" style="width: 100%; padding: 12px; border: none; border-bottom: 1px solid var(--border); background: transparent; font-family: 'Montserrat'; font-size: 15px;">
                    <option value="US" {{ (old('country', $address['country'] ?? '') == 'US') ? 'selected' : '' }}>United States</option>
                    <option value="GB" {{ (old('country', $address['country'] ?? '') == 'GB') ? 'selected' : '' }}>United Kingdom</option>
                    <option value="CA" {{ (old('country', $address['country'] ?? '') == 'CA') ? 'selected' : '' }}>Canada</option>
                    <option value="FR" {{ (old('country', $address['country'] ?? '') == 'FR') ? 'selected' : '' }}>France</option>
                </select>
                @error('country')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-top: 30px;">
            <button type="submit" class="btn-save">Update Address</button>
            <a href="{{ route('account.addresses') }}" class="btn-save" style="background: transparent; color: var(--black); border: 1px solid var(--black); display: flex; align-items: center; justify-content: center; text-decoration: none;">Cancel</a>
        </div>
    </form>
@endsection
