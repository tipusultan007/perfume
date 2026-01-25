<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function index()
    {
        $popups = Popup::orderBy('created_at', 'desc')->get();
        return view('admin.popups.index', compact('popups'));
    }

    public function create()
    {
        return view('admin.popups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $popup = Popup::create($request->only('title', 'link', 'start_date', 'end_date', 'is_active'));

        if ($request->hasFile('image')) {
            $popup->addMediaFromRequest('image')->toMediaCollection('popup');
        }

        return redirect()->route('admin.popups.index')->with('success', 'Popup created successfully.');
    }

    public function edit(Popup $popup)
    {
        return view('admin.popups.edit', compact('popup'));
    }

    public function update(Request $request, Popup $popup)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $popup->update($request->only('title', 'link', 'start_date', 'end_date', 'is_active'));
        
        // Handle checkbox logic for is_active matching typical Laravel behavior if it's not in the request
        if (!$request->has('is_active')) {
            $popup->is_active = false;
            $popup->save();
        }

        if ($request->hasFile('image')) {
            $popup->clearMediaCollection('popup');
            $popup->addMediaFromRequest('image')->toMediaCollection('popup');
        }

        return redirect()->route('admin.popups.index')->with('success', 'Popup updated successfully.');
    }

    public function destroy(Popup $popup)
    {
        $popup->delete();
        return redirect()->route('admin.popups.index')->with('success', 'Popup deleted successfully.');
    }
}
