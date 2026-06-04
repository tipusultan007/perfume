@extends('shop.account.layout')

@section('account_content')
    <h3>Edit {{ $typeName }}</h3>

    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            height: 48px;
            border: none;
            border-bottom: 1px solid var(--border);
            border-radius: 0;
            background: transparent;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            display: flex;
            align-items: center;
            padding: 0;
            transition: border-color 0.3s;
        }
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--black);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: inherit;
            padding-left: 0;
            line-height: normal;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
            right: 0;
        }
        .select2-dropdown {
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 0;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
        }
        .select2-results__option {
            padding: 10px 12px;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: var(--black);
            color: white;
        }
    </style>

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
                <select name="city" id="address_city" class="form-control" style="width: 100%; padding: 12px; border: none; border-bottom: 1px solid var(--border); background: transparent; font-family: 'Montserrat'; font-size: 15px;" required>
                    <option value="">Select City</option>
                </select>
                @error('city')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>State</label>
                <select name="state" id="address_state" class="form-control" style="width: 100%; padding: 12px; border: none; border-bottom: 1px solid var(--border); background: transparent; font-family: 'Montserrat'; font-size: 15px;" required>
                    <option value="">Select State</option>
                </select>
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
                    <option value="US" selected>United States</option>
                </select>
                @error('country')<span style="color: red; font-size: 12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="display: flex; gap: 20px; margin-top: 30px;">
            <button type="submit" class="btn-save">Update Address</button>
            <a href="{{ route('account.addresses') }}" class="btn-save" style="background: transparent; color: var(--black); border: 1px solid var(--black); display: flex; align-items: center; justify-content: center; text-decoration: none;">Cancel</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('#address_state, #address_city').select2({
                width: '100%'
            });

            const savedState = "{{ old('state', $address['state'] ?? '') }}";
            const savedCity = "{{ old('city', $address['city'] ?? '') }}";

            function loadStates(selectedState = '') {
                fetch('/api/states')
                    .then(r => r.json())
                    .then(data => {
                        const select = $('#address_state');
                        select.empty().append('<option value="">Select State</option>');
                        data.forEach(state => {
                            const isSelected = (state.name === selectedState || state.state_code === selectedState);
                            const option = new Option(state.name, state.name, isSelected, isSelected);
                            option.dataset.id = state.id;
                            select.append(option);
                        });
                        select.trigger('change');
                        
                        if (selectedState) {
                            const stateId = select.find('option:selected').data('id');
                            if(stateId) {
                                loadCities(stateId, savedCity);
                            }
                        }
                    });
            }

            function loadCities(stateId, selectedCity = '') {
                fetch(`/api/cities/${stateId}`)
                    .then(r => r.json())
                    .then(data => {
                        const select = $('#address_city');
                        select.empty().append('<option value="">Select City</option>');
                        data.forEach(city => {
                            const isSelected = city.name === selectedCity;
                            select.append(new Option(city.name, city.name, isSelected, isSelected));
                        });
                        select.trigger('change');
                    });
            }

            loadStates(savedState);

            $('#address_state').on('change', function() {
                const stateId = $(this).find('option:selected').data('id');
                if(stateId) {
                    loadCities(stateId);
                } else {
                    $('#address_city').empty().append('<option value="">Select City</option>').trigger('change');
                }
            });
        });
    </script>
@endsection
