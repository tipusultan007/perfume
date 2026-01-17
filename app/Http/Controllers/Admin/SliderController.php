<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('display_order', 'asc')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $slider = Slider::create($request->only([
            'title', 'subtitle', 'description', 'button_text', 'button_link', 'display_order', 'is_active'
        ]) + ['image_path' => 'placeholder']); // image_path is temporary since we use MediaLibrary

        if ($request->hasFile('image')) {
            $slider->addMediaFromRequest('image')->toMediaCollection('slider');
            $slider->update(['image_path' => $slider->getFirstMediaUrl('slider')]);
        }

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $slider->update($request->only([
            'title', 'subtitle', 'description', 'button_text', 'button_link', 'display_order', 'is_active'
        ]));

        if ($request->hasFile('image')) {
            $slider->clearMediaCollection('slider');
            $slider->addMediaFromRequest('image')->toMediaCollection('slider');
            $slider->update(['image_path' => $slider->getFirstMediaUrl('slider')]);
        }

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
