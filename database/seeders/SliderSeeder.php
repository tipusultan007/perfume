<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Atlantis Extrait by French Avenue',
                'subtitle' => 'SUMMER COMPLIMENT MAGNET',
                'description' => 'Dive into tropical paradise with juicy watermelon and creamy coconut – an addictive summer compliment magnet!',
                'top_notes' => 'Orange, Mandarin Orange, Lemon',
                'image_path' => 'images/sliders/Atlantis Extrait by French Avenue.png',
                'button_text' => 'SHOP NOW',
                'button_link' => '/shop',
                'display_order' => 1,
                'ui_theme' => 'light',
                'bg_color' => '#f0f4f8',
            ],
            [
                'title' => 'Vulcan Feu by French Avenue',
                'subtitle' => 'BOLD GOD-LIKE INTENSITY',
                'description' => 'Ignite your senses with explosive mango, fiery ginger, and praline sweetness – a bold, god-like intensity!',
                'top_notes' => 'Mango, Lemon, Ginger, Rhubarb',
                'image_path' => 'images/sliders/Vulcan Feu by French Avenue.png',
                'button_text' => 'EXPLORE BOLDNESS',
                'button_link' => '/shop',
                'display_order' => 2,
                'ui_theme' => 'dark',
                'bg_color' => '#1a1a1a',
            ],
            [
                'title' => 'Marwa by Arabiyat Prestige',
                'subtitle' => 'BEAST-MODE COMPLIMENT-GETTER',
                'description' => 'Radiant citrus freshness meets spicy black tea elegance – a modern, beast-mode compliment-getter!',
                'top_notes' => 'Citrus accords, Chinese Black Tea',
                'image_path' => 'images/sliders/Marwa by Arabiyat Prestige.png',
                'button_text' => 'GET THE BEAST',
                'button_link' => '/shop',
                'display_order' => 3,
                'ui_theme' => 'light',
                'bg_color' => '#ffffff',
            ],
            [
                'title' => 'Mahd al Dhahab by Arabiyat Prestige',
                'subtitle' => 'REGAL ORIENTAL WARMTH',
                'description' => 'Luxurious golden cradle of bright citrus, spices, and deep oriental warmth – regal and profoundly sophisticated!',
                'top_notes' => 'Grapefruit, Bergamot, Lemon, Red Fruits/Berries, Spices',
                'image_path' => 'images/sliders/Mahd al Dhahab by Arabiyat Prestige.png',
                'button_text' => 'DISCOVER ROYALTY',
                'button_link' => '/shop',
                'display_order' => 4,
                'ui_theme' => 'light',
                'bg_color' => '#fffdf2',
            ],
            [
                'title' => 'Nyla by Arabiyat Prestige',
                'subtitle' => 'DREAMY TROPICAL ESCAPE',
                'description' => 'Dreamy tropical escape with creamy coconut, juicy peach, and exotic tiare – sunny beach relaxation in a bottle!',
                'top_notes' => 'Coconut, Peach, Fruity accords',
                'image_path' => 'images/sliders/Nyla by Arabiyat Prestige.png',
                'button_text' => 'ESCAPE NOW',
                'button_link' => '/shop',
                'display_order' => 5,
                'ui_theme' => 'light',
                'bg_color' => '#fdf6f0',
            ],
        ];

        foreach ($sliders as $slider) {
            $isDark = $slider['ui_theme'] === 'dark';
            $sliderModel = Slider::updateOrCreate(
                ['title' => $slider['title']],
                array_merge($slider, [
                    'is_active' => true,
                    'title_color' => $isDark ? '#ffffff' : '#111827',
                    'description_color' => $isDark ? '#9ca3af' : '#4b5563',
                    'accent_color' => '#D4AF37', // Default Gold
                    'price_color' => $isDark ? '#ffffff' : '#111827',
                    'social_color' => $isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)',
                    'social_hover_color' => '#D4AF37',
                    'social_icon_color' => $isDark ? '#ffffff' : '#111827',
                    'social_icon_hover_color' => '#111827',
                    'nav_color' => $isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.05)',
                    'nav_hover_color' => '#D4AF37',
                    'nav_icon_color' => $isDark ? '#ffffff' : '#111827',
                    'nav_icon_hover_color' => '#111827',
                    'line_color' => '#D4AF37',
                ])
            );

            // Add media using Spatie
            $imagePath = public_path($slider['image_path']);
            if (file_exists($imagePath)) {
                $sliderModel->clearMediaCollection('slider');
                $sliderModel->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('slider');
                
                // Update image_path with the media URL for compatibility
                $sliderModel->update(['image_path' => $sliderModel->getFirstMediaUrl('slider')]);
            }
        }
    }
}
