<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $taxRates = TaxRate::orderBy('priority')->get();
        return view('admin.taxes.index', compact('taxRates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'state_code' => 'nullable|string|size:2',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_compounded'] = $request->has('is_compounded');
        $validated['is_shipping_taxable'] = $request->has('is_shipping_taxable');

        TaxRate::create($validated);

        return redirect()->route('admin.taxes.index')->with('success', 'Tax Rate created successfully');
    }

    public function update(Request $request, TaxRate $taxRate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'state_code' => 'nullable|string|size:2',
            'priority' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_compounded'] = $request->has('is_compounded');
        $validated['is_shipping_taxable'] = $request->has('is_shipping_taxable');

        $taxRate->update($validated);

        return redirect()->route('admin.taxes.index')->with('success', 'Tax Rate updated successfully');
    }

    public function destroy(TaxRate $taxRate)
    {
        $taxRate->delete();
        return redirect()->route('admin.taxes.index')->with('success', 'Tax Rate deleted successfully');
    }
}
