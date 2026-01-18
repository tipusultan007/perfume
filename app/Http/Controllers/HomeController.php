<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = \App\Models\Slider::where('is_active', '=', true, 'and')->orderBy('display_order', 'asc')->get();
        $hero = \App\Models\HomeSection::where('key', '=', 'hero', 'and')->first();
        $heritage = \App\Models\HomeSection::where('key', '=', 'heritage', 'and')->first();
        $heroStyle = Setting::where('key', 'home_hero_style')->value('value') ?? 'default';
        
        $categories = Category::where('show_on_home', '=', true, 'and')
            ->orderBy('home_order', 'asc')
            ->take(4)
            ->get();

            
        $recentProducts = Product::with('media')
            ->latest()
            ->take(8)
            ->get();
            
        $bestSellers = Product::with('media')
            ->where('is_featured', '=', true, 'and')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('sliders', 'hero', 'heritage', 'categories', 'recentProducts', 'bestSellers', 'heroStyle'));


    }
}
