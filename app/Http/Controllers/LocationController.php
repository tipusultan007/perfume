<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
    public function states()
    {
        return response()->json(State::orderBy('name')->get(['id', 'name', 'state_code']));
    }

    public function cities($stateId)
    {
        // Can also pass state name if needed, but ID is safer
        $cities = City::where('state_id', $stateId)->orderBy('name')->get(['id', 'name']);
        return response()->json($cities);
    }
}
