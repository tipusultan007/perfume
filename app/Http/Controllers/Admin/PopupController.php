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
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'template_id' => 'required|string',
            'font_family' => 'required|string',
        ]);

        $data = $request->only('title', 'subtitle', 'description', 'link', 'cta_text', 'template_id', 'font_family', 'start_date', 'end_date', 'is_active');
        $data['show_newsletter'] = $request->has('show_newsletter');
        
        $popup = Popup::create($data);

        if ($request->hasFile('image')) {
            $popup->addMediaFromRequest('image')->toMediaCollection('popup');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Popup created successfully.',
                'redirect' => route('admin.popups.index')
            ]);
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
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'cta_text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'template_id' => 'required|string',
            'font_family' => 'required|string',
        ]);

        $data = $request->only('title', 'subtitle', 'description', 'link', 'cta_text', 'template_id', 'font_family', 'start_date', 'end_date', 'is_active');
        $data['show_newsletter'] = $request->has('show_newsletter');
        $data['is_active'] = $request->has('is_active');

        $popup->update($data);

        if ($request->hasFile('image')) {
            $popup->clearMediaCollection('popup');
            $popup->addMediaFromRequest('image')->toMediaCollection('popup');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Popup updated successfully.',
                'redirect' => route('admin.popups.index')
            ]);
        }

        return redirect()->route('admin.popups.index')->with('success', 'Popup updated successfully.');
    }

    public function destroy(Popup $popup)
    {
        $popup->delete();
        return redirect()->route('admin.popups.index')->with('success', 'Popup deleted successfully.');
    }

    public function toggleStatus(Popup $popup)
    {
        $popup->update(['is_active' => !$popup->is_active]);

        return response()->json([
            'status' => 'success',
            'message' => 'Popup status updated successfully.',
            'is_active' => $popup->is_active
        ]);
    }
}
