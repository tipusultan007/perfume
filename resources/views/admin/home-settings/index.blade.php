@extends('admin.layouts.app')

@section('title', 'Home Page Settings')
@section('page_title', 'Home Page Settings')

@section('content')
<div class="space-y-10">
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-lg text-sm border border-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- Section Visibility Control -->
        <div class="lg:col-span-3">
             <div class="bg-white p-8 border border-black/5 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="font-serif text-xl">Home Page Sections</h3>
                        <p class="text-xs text-slate-400 mt-1">Toggle which sections are visible on your live homepage.</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.home-settings.visibility') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php
                            $sections = [
                                'hero' => 'Hero Slider',
                                'categories' => 'Category Collection',
                                'promo_banners' => 'Promo Banners (Top)',
                                'banner_signature' => 'Banner: Signature Scents',
                                'recent_arrivals' => 'Recent Arrivals',
                                'cta' => 'CTA Section (Confidence)',
                                'featured' => 'Featured Highlights',
                                'banner_seasonal' => 'Banner: Seasonal Picks',
                                'special_offers' => 'Special Offers',
                                'banner_engraving' => 'Banner: Exclusive Engraving',
                                'clearance' => 'Limited/Clearance',
                                'banner_final' => 'Banner: Final Call',
                                'testimonials' => 'Testimonials',
                                'banner_elite' => 'Banner: Elite Collection',
                                'services' => 'Services (Footer)',
                                'newsletter' => 'Newsletter Form'
                            ];
                        @endphp

                        @foreach($sections as $key => $label)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <span class="text-xs font-bold uppercase tracking-widest text-slate-600">{{ $label }}</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="show_{{ $key }}" value="1" {{ \App\Models\Setting::get('home_show_'.$key, 1) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none ring-0 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-luxury-accent"></div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-luxury-black text-white px-8 py-3 rounded-lg text-xs uppercase tracking-widest hover:opacity-90 transition-all shadow-lg">Save Visibility Settings</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-8 border border-black/5 rounded-2xl shadow-sm">
                <h3 class="font-serif text-xl mb-6">Hero Section</h3>
                <form action="{{ route('admin.home-settings.hero') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Style Selector -->
                    <div class="space-y-2 pb-4 border-b border-gray-100">
                         <label class="text-[10px] uppercase tracking-widest opacity-40">Slider Design</label>
                         <div class="flex space-x-4">
                             <label class="flex items-center space-x-2 cursor-pointer">
                                 <input type="radio" name="hero_style" value="default" {{ ($heroStyle ?? 'default') == 'default' ? 'checked' : '' }} class="text-luxury-accent focus:ring-luxury-accent">
                                 <span class="text-sm">Default Slider</span>
                             </label>
                             <label class="flex items-center space-x-2 cursor-pointer">
                                 <input type="radio" name="hero_style" value="modern" {{ ($heroStyle ?? 'default') == 'modern' ? 'checked' : '' }} class="text-luxury-accent focus:ring-luxury-accent">
                                 <span class="text-sm font-semibold text-luxury-accent">Modern 3D Concept (New)</span>
                             </label>
                         </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Main Title</label>
                            <input type="text" name="title" value="{{ $hero->title ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Subtitle</label>
                            <input type="text" name="subtitle" value="{{ $hero->subtitle ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Button Text</label>
                            <input type="text" name="button_text" value="{{ $hero->button_text ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Button Link</label>
                            <input type="text" name="button_link" value="{{ $hero->button_link ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest opacity-40">Background Image URL</label>
                        <input type="text" name="image_path" value="{{ $hero->image_path ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all placeholder:opacity-30" placeholder="https://images.unsplash.com/...">
                    </div>
                    <button type="submit" class="bg-luxury-black text-white px-8 py-3 rounded-lg text-xs uppercase tracking-widest hover:opacity-90 transition-all">Save Hero Section</button>
                </form>
            </div>

            <!-- Heritage Section -->
            <div class="bg-white p-8 border border-black/5 rounded-2xl shadow-sm">
                <h3 class="font-serif text-xl mb-6">Heritage Section</h3>
                <form action="{{ route('admin.home-settings.heritage') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Section Title</label>
                            <input type="text" name="title" value="{{ $heritage->title ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Badge/Subtitle</label>
                            <input type="text" name="subtitle" value="{{ $heritage->subtitle ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest opacity-40">Content Text</label>
                        <textarea name="content" rows="3" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">{{ $heritage->content ?? '' }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Button Text</label>
                            <input type="text" name="button_text" value="{{ $heritage->button_text ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] uppercase tracking-widest opacity-40">Button Link</label>
                            <input type="text" name="button_link" value="{{ $heritage->button_link ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest opacity-40">Section Image URL</label>
                        <input type="text" name="image_path" value="{{ $heritage->image_path ?? '' }}" class="w-full px-4 py-3 bg-gray-50 border-none rounded-lg text-sm focus:ring-1 focus:ring-luxury-accent focus:bg-white transition-all placeholder:opacity-30" placeholder="https://images.unsplash.com/...">
                    </div>
                    <button type="submit" class="bg-luxury-black text-white px-8 py-3 rounded-lg text-xs uppercase tracking-widest hover:opacity-90 transition-all">Save Heritage Section</button>
                </form>
            </div>
        </div>

        <!-- Curation Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-8 border border-black/5 rounded-2xl shadow-sm sticky top-28">
                <h3 class="font-serif text-xl mb-6">Home Page Curation</h3>
                <form action="{{ route('admin.home-settings.curation') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="space-y-4">
                        <h4 class="text-[10px] uppercase tracking-widest font-semibold border-b border-black/5 pb-2">Categories (Max 4)</h4>
                        <div class="max-h-60 overflow-y-auto space-y-2 pr-2">
                            @foreach($categories as $category)
                            <label class="flex items-center justify-between p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-luxury-cream transition-colors group">
                                <span class="text-xs">{{ $category->name }}</span>
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ $category->show_on_home ? 'checked' : '' }} class="rounded border-gray-300 text-luxury-accent focus:ring-luxury-accent">
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="text-[10px] uppercase tracking-widest font-semibold border-b border-black/5 pb-2">Featured Products</h4>
                        <div class="max-h-60 overflow-y-auto space-y-2 pr-2">
                            @foreach($products as $product)
                            <label class="flex items-center justify-between p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-luxury-cream transition-colors group">
                                <span class="text-xs truncate mr-4">{{ $product->name }}</span>
                                <input type="checkbox" name="products[]" value="{{ $product->id }}" {{ $product->is_featured ? 'checked' : '' }} class="rounded border-gray-300 text-luxury-accent focus:ring-luxury-accent">
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-luxury-accent text-white px-8 py-4 rounded-lg text-xs uppercase tracking-widest hover:opacity-90 shadow-lg shadow-luxury-accent/20 transition-all">Apply Curation</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
