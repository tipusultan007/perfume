<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeSettingsController extends Controller
{
    public function index()
    {
        $hero = HomeSection::where('key', 'hero')->first();
        $heritage = HomeSection::where('key', 'heritage')->first();
        $categories = Category::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $heroStyle = Setting::where('key', 'home_hero_style')->value('value') ?? 'default';

        return view('admin.home-settings.index', compact('hero', 'heritage', 'categories', 'products', 'heroStyle'));
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:1000',
            'hero_style' => 'nullable|in:default,modern',
        ]);

        HomeSection::updateOrCreate(
            ['key' => 'hero'],
            $request->only(['title', 'subtitle', 'button_text', 'button_link', 'image_path'])
        );

        if ($request->has('hero_style')) {
            Setting::updateOrCreate(
                ['key' => 'home_hero_style'],
                ['value' => $request->hero_style, 'group' => 'home', 'type' => 'string']
            );
        }

        return back()->with('success', 'Hero section updated successfully.');
    }

    public function updateHeritage(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:1000',
        ]);

        HomeSection::updateOrCreate(
            ['key' => 'heritage'],
            $request->only(['title', 'subtitle', 'content', 'button_text', 'button_link', 'image_path'])
        );

        return back()->with('success', 'Heritage section updated successfully.');
    }

    public function updateCuration(Request $request)
    {
        // Reset all
        Category::query()->update(['show_on_home' => false]);
        Product::query()->update(['is_featured' => false]);

        // Set selected
        if ($request->has('categories')) {
            Category::whereIn('id', $request->categories)->update(['show_on_home' => true]);
        }

        if ($request->has('products')) {
            Product::whereIn('id', $request->products)->update(['is_featured' => true]);
        }

        return back()->with('success', 'Home page curation updated successfully.');
    }
}
