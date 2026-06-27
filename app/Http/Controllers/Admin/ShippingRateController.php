<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $shippingRates = ShippingRate::orderBy('state_code')->get();
        return view('admin.shipping_rates.index', compact('shippingRates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'state_code' => 'nullable|string|size:2',
            'zip_code' => 'nullable|string|max:10',
        ]);

        $validated['is_active'] = $request->has('is_active');

        ShippingRate::create($validated);

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Shipping Rate created successfully');
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'state_code' => 'nullable|string|size:2',
            'zip_code' => 'nullable|string|max:10',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $shippingRate->update($validated);

        return redirect()->route('admin.shipping-rates.index')->with('success', 'Shipping Rate updated successfully');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();
        return redirect()->route('admin.shipping-rates.index')->with('success', 'Shipping Rate deleted successfully');
    }
}
